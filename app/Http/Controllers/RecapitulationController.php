<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Division;
use App\Models\Procurement;
use Illuminate\Http\Request;
use App\Exports\ProcessNegoExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EfficiencyCostExport;
use App\Exports\ComparisonMatrixExport;
use App\Exports\RequestCancelledExport;

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

    public function getProcessNegoExcel()
    {
        $dateTime = Carbon::now()->format('dmYHis');
        $fileName = 'recap-process-nego-excel-' . $dateTime . '.xlsx';

        return Excel::download(new ProcessNegoExport, $fileName);
    }
    private function getMonthsArray()
    {
        return [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
    }
    private function getMonthsName($months)
    {
        $allMonths = $this->getMonthsArray(); // Ensure this function returns an array with month names indexed from '01' to '12'
        $monthsName = [];
        foreach ($months as $month) {
            $monthsName[$month] = $allMonths[sprintf('%02d', $month)];
        }
        return $monthsName;
    }
    public function getComparisonMatrix ()
    {
        $bulan = $this->getMonthsArray();
        $currentMonth = date('n'); // Current month as a number without leading zero
        $currentYear = Carbon::now()->year;
        $years = Procurement::where('status', '1')
            ->pluck(DB::raw('YEAR(receipt) as year'))
            ->merge([$currentYear]) // Menambahkan tahun saat ini ke dalam koleksi
            ->unique();
        return view ('recapitulation.matrix.index', compact('currentYear', 'years', 'bulan', 'currentMonth'));
    }

    public function getComparisonMatrixData(Request $request)
    {
        // dd($request->all());
        $year = $request->input('year');
        $start_month = $request->input('start_month');
        $end_month = $request->input('end_month');
        $months = range($start_month, $end_month);
        $monthsName = $this->getMonthsName($months);
        // dd($monthsName);
        // $months = [];
        // for ($i = 1; $i <= 12; $i++) {
        //     $months[] = $i; // Menggunakan angka bulan
        //     $monthsName[]=Carbon::create($year, $i)->translatedFormat('F');
        // }

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
        $managerName = request()->query('managerName');
        $managerPosition = request()->query('managerPosition');

        return view('recapitulation.matrix.data', compact('start_month', 'end_month', 'year', 'logoBase64', 'months', 'procurementsByMonth', 'isSelectedArrayByMonth', 'monthsName', 'documentsPic', 'stafName', 'stafPosition', 'managerName', 'managerPosition'));
    }

    public function getComparisonMatrixExcel(Request $request)
    {
        $dateTime = Carbon::now()->format('dmYHis');
        $fileName = 'recap-comparison-matrix-excel-' . $dateTime . '.xlsx';

        return Excel::download(new ComparisonMatrixExport, $fileName);
    }

    public function getEfficiencyCost ()
    {
        $bulan = $this->getMonthsArray();
        $currentMonth = date('n'); // Current month as a number without leading zero
        $currentYear = Carbon::now()->year;
        $years = Procurement::where('status', '1')
            ->pluck(DB::raw('YEAR(receipt) as year'))
            ->merge([$currentYear]) // Menambahkan tahun saat ini ke dalam koleksi
            ->unique();
        return view ('recapitulation.efficiency.index', compact('currentYear', 'years', 'bulan', 'currentMonth'));
    }

    public function getEfficiencyCostData(Request $request)
    {
        // Mengambil semua data dari request
        // dd($request->all());

        // Mengambil logo dan mengkonversinya ke base64
        $logoPath = public_path('assets/logo/cmnplogo.png');
        $logoData = file_get_contents($logoPath);
        $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);

        // Mengambil input tahun, start month dan end month dari request
        $year = $request->input('year');
        $start_month = $request->input('start_month');
        $end_month = $request->input('end_month');

        // Membuat range bulan berdasarkan start month dan end month
        $months = range($start_month, $end_month);

        // Mendapatkan nama bulan dalam bahasa Indonesia menggunakan fungsi getMonthsName
        $monthsName = $this->getMonthsName($months);

        $procurementData = [];

        // Iterasi melalui rentang bulan untuk mendapatkan data procurement
        foreach ($months as $month) {
            // Filter procurement berdasarkan tahun dan bulan
            $procurementData[$month] = Procurement::whereYear('receipt', $year)
                ->whereMonth('receipt', $month)
                ->where('status', '1')
                ->selectRaw('SUM(user_estimate) as total_user_estimate, SUM(deal_nego) as total_deal_nego')
                ->first();
        }

        // Mengambil data staf dan manager dari query string
        $stafName = $request->query('stafName');
        $stafPosition = $request->query('stafPosition');
        $managerName = $request->query('managerName');
        $managerPosition = $request->query('managerPosition');

        // Membuat array data untuk view
        $data = [
            'stafName' => $stafName,
            'stafPosition' => $stafPosition,
            'managerName' => $managerName,
            'managerPosition' => $managerPosition,
        ];

        // Mengembalikan view dengan data yang telah di-compact
        return view('recapitulation.efficiency.data', compact('logoBase64', 'year', 'months', 'monthsName', 'procurementData', 'data', 'start_month', 'end_month'));
    }

    public function getEfficiencyCostExcel (Request $request)
    {
        $dateTime = Carbon::now()->format('dmYHis');
        $fileName = 'recap-efficiency-cost-excel-' . $dateTime . '.xlsx';

        return Excel::download(new EfficiencyCostExport, $fileName);
    }
    public function getRequestCancelled ()
    {
        $bulan = $this->getMonthsArray();
        $currentMonth = date('n'); // Current month as a number without leading zero
        $currentYear = Carbon::now()->year;
        $years = Procurement::where('status', '2')
            ->pluck(DB::raw('YEAR(receipt) as year'))
            ->merge([$currentYear]) // Menambahkan tahun saat ini ke dalam koleksi
            ->unique();
        return view ('recapitulation.cancel.index', compact('currentYear', 'years', 'bulan', 'currentMonth'));
    }
    public function getRequestCancelledData(Request $request)
    {
        // Mengambil logo dan mengkonversinya ke base64
        $logoPath = public_path('assets/logo/cmnplogo.png');
        $logoData = file_get_contents($logoPath);
        $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);

        // Mengambil input filter dari request
        $year = $request->input('year');
        $start_month = $request->input('start_month');
        $end_month = $request->input('end_month');
        $number = $request->input('number');
        $name = $request->input('name');
        $valueCost = $request->input('valueCost');
        $returnToUser = $request->input('returnToUser');
        $cancellationMemo = $request->input('cancellationMemo');
        $months = range($start_month, $end_month);
        $monthsName = $this->getMonthsName($months);
        $startMonthName = $monthsName[$months[0]];
        $endMonthName = $monthsName[$months[count($months) - 1]];
        // Query untuk mengambil data procurement dengan filter
        $procurements = Procurement::where('status', '2')
            ->when($year, function ($query) use ($year) {
                $query->whereYear('receipt', $year);
            })
            ->when($start_month && $end_month, function ($query) use ($start_month, $end_month) {
                $query->whereBetween(\DB::raw('MONTH(receipt)'), [$start_month, $end_month]);
            })
            ->when($number, function ($query) use ($number) {
                $query->where('number', 'like', '%' . $number . '%');
            })
            ->when($name, function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            })
            ->when($valueCost === '0', function ($query) {
                $query->whereBetween('user_estimate', [0, 99999999]); // 0 s.d < 100 Juta
            })
            ->when($valueCost === '1', function ($query) {
                $query->whereBetween('user_estimate', [100000000, 999999999]); // >= 100 Juta s.d < 1 Miliar
            })
            ->when($valueCost === '2', function ($query) {
                $query->where('user_estimate', '>=', 1000000000); // >= 1 Miliar
            })
            ->when($returnToUser, function ($query) use ($returnToUser) {
                $query->where('return_to_user', $returnToUser);
            })
            ->when($cancellationMemo, function ($query) use ($cancellationMemo) {
                $query->where('cancellation_memo', 'like', '%' . $cancellationMemo . '%');
            })
            ->get();

        // Menghitung jumlah procurement per official ID
        $documentsPic = [];
        foreach ($procurements as $procurement) {
            $officialId = $procurement->official->initials;
            if (!isset($documentsPic[$officialId])) {
                $documentsPic[$officialId] = 1;
            } else {
                $documentsPic[$officialId]++;
            }
        }

        // Mengambil data staf dan manager dari query string
        $stafName = $request->query('stafName');
        $stafPosition = $request->query('stafPosition');
        $managerName = $request->query('managerName');
        $managerPosition = $request->query('managerPosition');

        // Membuat array data untuk view
        $data = [
            'stafName' => $stafName,
            'stafPosition' => $stafPosition,
            'managerName' => $managerName,
            'managerPosition' => $managerPosition,
        ];

        // Mengembalikan view dengan data yang telah di-compact
        return view('recapitulation.cancel.data', compact('logoBase64', 'year', 'procurements', 'documentsPic', 'data', 'startMonthName', 'endMonthName'));
    }

    public function getRequestCancelledExcel (Request $request)
    {
        $dateTime = Carbon::now()->format('dmYHis');
        $fileName = 'recap-request-cancelled-excel-' . $dateTime . '.xlsx';

        return Excel::download(new RequestCancelledExport, $fileName);
    }
}
