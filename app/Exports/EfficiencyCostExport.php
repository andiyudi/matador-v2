<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Procurement;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromView;

class EfficiencyCostExport implements FromView
{
    public function view(): View
    {
        $year = Request::input('year');
        $start_month = Request::input('start_month');
        $end_month = Request::input('end_month');

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

        return view('recapitulation.efficiency.result', compact('year', 'months', 'monthsName', 'procurementData'));
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
            $monthsName[] = $allMonths[sprintf('%02d', $month)];
        }
        return $monthsName;
    }
}
