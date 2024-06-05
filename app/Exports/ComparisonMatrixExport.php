<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Procurement;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromView;

class ComparisonMatrixExport implements FromView
{
    public function view():View
    {
        // Ambil tahun dari request
        $year = Request::input('year');
        $start_month = Request::input('start_month');
        $end_month = Request::input('end_month');
        $months_name = [
            1 => "Januari",
            2 => "Februari",
            3 => "Maret",
            4 => "April",
            5 => "Mei",
            6 => "Juni",
            7 => "Juli",
            8 => "Agustus",
            9 => "September",
            10 => "Oktober",
            11 => "November",
            12 => "Desember"
        ];
        $months = range($start_month, $end_month);
        $selectedStartMonthName = Carbon::create($year, $start_month)->translatedFormat('F');
        $selectedEndMonthName = Carbon::create($year, $end_month)->translatedFormat('F');
        // $months = [];
        // for ($i = 1; $i <= 12; $i++) {
        //     $months[] = $i; // Menggunakan angka bulan
        //     $monthsName[]=Carbon::create($year, $i)->translatedFormat('F');
        // }

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
        return view('recapitulation.matrix.result', compact('year', 'months', 'procurementsByMonth', 'isSelectedArrayByMonth', 'selectedStartMonthName', 'selectedEndMonthName', 'documentsPic'));
    }
}
