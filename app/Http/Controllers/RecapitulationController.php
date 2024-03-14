<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Division;
use App\Models\Procurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecapitulationController extends Controller
{
    public function getProcessNego ()
    {
        $divisions = Division::where('status', '1')->get();
        return view ('recapitulation.process.index', compact('divisions'));
    }

    public function getProcessNegoData(Request $request)
    {
        $logoPath = public_path('assets/logo/cmnplogo.png');
        $logoData = file_get_contents($logoPath);
        $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        $number = $request->input('number');
        $name = $request->input('name');
        $division = $request->input('division');
        $startDateTtpp = $request->input('startDateTtpp');
        $endDateTtpp = $request->input('endDateTtpp');
        // dd($startDateTtpp, $endDateTtpp);

        $startDateTtpp = Carbon::createFromFormat('!m-Y', $startDateTtpp)->startOfMonth();
        $endDateTtpp = Carbon::createFromFormat('m-Y', $endDateTtpp)->endOfMonth();

        $startDateCarbon = Carbon::parse($startDateTtpp);
        $endDateCarbon = Carbon::parse($endDateTtpp);

        $formattedStartDate = $startDateCarbon->translatedFormat('F Y');
        $formattedEndDate = $endDateCarbon->translatedFormat('F Y');

        $today = Carbon::now();
        $formattedDate = $today->translatedFormat('d F Y');

        $procurements = Procurement::with('tenders.businessPartners.partner')
        ->where(function ($query) use ($number, $name, $division, $startDateTtpp, $endDateTtpp) {
            if (!empty($number)) {
                $query->where('number', 'LIKE', '%' . $number . '%');
            }

            if (!empty($name)) {
                $query->where('name', 'LIKE', '%' . $name . '%');
            }

            if (!empty($division)) {
                $query->where('division_id', $division);
            }

            if (!empty($startDateTtpp) && !empty($endDateTtpp)) {
                $query->whereBetween('receipt', [$startDateTtpp, $endDateTtpp]);
            }
        })
        ->where('status', '0')
        ->get();

        $reportNegoResults = [];
        $emptyDealNegos = 0;
        $dealNegos = 0;
        $documentsPic = []; //isi dengan data official id yg sudah di group by pada procurement

        $stafName = request()->query('stafName');
        $stafPosition = request()->query('stafPosition');
        $managerName = request()->query('managerName');
        $managerPosition = request()->query('managerPosition');

        foreach ($procurements as $procurement) {
            // Ambil ID resmi dari procurement
            $officialId = $procurement->official->initials;

            // Jika ID resmi belum ada di array, tambahkan dan inisialisasi jumlah procurement menjadi 1
            if (!isset($documentsPic[$officialId])) {
                $documentsPic[$officialId] = 1;
            } else {
                // Jika sudah ada, tambahkan jumlah procurement
                $documentsPic[$officialId]++;
            }
            if ($procurement->deal_nego == null){
                $emptyDealNegos++;
            } else {
                $dealNegos++;
            }
            foreach ($procurement->tenders as $tender) {
                $reportNegoResult = $tender->report_nego_result;
                // Check if $reportNegoResult is not null
                if ($reportNegoResult !== null) {
                    // Add $reportNegoResult to the array using procurement_id as key
                    $reportNegoResults[$procurement->id][] = $reportNegoResult;
                    // Store the latest report_nego_result in the $procurement object
                    $procurement->latest_report_nego_result = $reportNegoResult;
                }
            }

            if ($procurement->status == "2") {
                $procurement->is_selected = 'Canceled';
            } elseif ($procurement->status == "0") {
                $procurement->is_selected = '';
            } else {
                $isSelected = false;
                foreach ($procurement->tenders as $tender) {
                    $selectedVendor = $tender->businessPartners->first(function ($businessPartner) {
                        return $businessPartner->pivot->is_selected === '1';
                    });

                    if ($selectedVendor) {
                        $procurement->is_selected = $selectedVendor->partner->name;
                        $isSelected = true;
                        break;
                    }
                }
                if (!$isSelected) {
                    $procurement->is_selected = 'Unknown';
                }
            }
        }

        return view('recapitulation.process.data', compact('logoBase64', 'procurements', 'formattedStartDate', 'formattedEndDate', 'formattedDate','emptyDealNegos', 'dealNegos', 'documentsPic', 'stafName', 'stafPosition', 'managerName', 'managerPosition'));
    }

    public function getComparisonMatrix ()
    {
        $currentYear = Carbon::now()->year;
        $years = Procurement::where('status', '1')
            ->pluck(DB::raw('YEAR(receipt) as year'))
            ->merge([$currentYear]) // Menambahkan tahun saat ini ke dalam koleksi
            ->unique();
        return view ('recapitulation.matrix.index', compact('currentYear', 'years'));
    }

    public function getComparisonMatrixData(Request $request)
    {
        // Ambil tahun dari request
        $year = $request->input('year');

        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = $i; // Menggunakan angka bulan
            $monthsName[]=Carbon::create($year, $i)->translatedFormat('F');
        }

        $logoPath = public_path('assets/logo/cmnplogo.png');
        $logoData = file_get_contents($logoPath);
        $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);

        // Mengumpulkan procurement untuk setiap bulan dalam months
        $procurementsByMonth = [];
        foreach ($months as $month) {
            $procurementsByMonth[$month] = Procurement::with('tenders.businessPartners.partner')
                ->whereYear('receipt', $year)
                ->whereMonth('receipt', $month) // Menggunakan angka bulan
                ->where('status', '1')
                ->orderBy('number')
                ->get();
        }

        // Membuat array untuk menyimpan isSelectedArray untuk setiap bulan
        $isSelectedArrayByMonth = [];
        $documentsPic = [];
        foreach ($procurementsByMonth as $month => $procurements) {
            $isSelectedArray = [];

            foreach ($procurements as $procurement) {
                $selectedPartnerName = null; // Default is_selected to null
                $reportNegoResults = []; // Inisialisasi array untuk menyimpan hasil negosiasi
                $officialId = $procurement->official->initials;

                // Jika ID resmi belum ada di array, tambahkan dan inisialisasi jumlah procurement menjadi 1
                if (!isset($documentsPic[$officialId])) {
                    $documentsPic[$officialId] = 1;
                } else {
                    // Jika sudah ada, tambahkan jumlah procurement
                    $documentsPic[$officialId]++;
                }

                foreach ($procurement->tenders as $tender) {
                    $reportNegoResult = $tender->report_nego_result;
                    if ($reportNegoResult !== null) {
                        $reportNegoResults[] = $reportNegoResult;
                    }

                    foreach ($tender->businessPartners as $businessPartner) {
                        if ($businessPartner->pivot->is_selected === '1') {
                            $selectedPartnerName = $businessPartner->partner->name;
                        }
                    }
                }

                $isSelectedArray[$procurement->id] = [
                    'selected_partner' => $selectedPartnerName,
                    'report_nego_results' => $reportNegoResults, // Menyimpan semua hasil negosiasi dalam array
                ];
            }
            $isSelectedArrayByMonth[$month] = $isSelectedArray;
        }
        $stafName = request()->query('stafName');
        $stafPosition = request()->query('stafPosition');

        return view('recapitulation.matrix.data', compact('year', 'logoBase64', 'months', 'procurementsByMonth', 'isSelectedArrayByMonth', 'monthsName', 'documentsPic', 'stafName', 'stafPosition'));
    }

    public function getEfficiencyCost ()
    {
        return view ('recapitulation.efficiency.index');
    }

    public function getRequestCancelled ()
    {
        return view ('recapitulation.cancel.index');
    }
}
