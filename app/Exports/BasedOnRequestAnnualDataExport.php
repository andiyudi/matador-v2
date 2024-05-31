<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Procurement;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class BasedOnRequestAnnualDataExport implements FromView
{
    public function view(): View
    {
        $year = Request::input('year');
        $start_month = Request::input('start_month');
        $end_month = Request::input('end_month');

        $months = range($start_month, $end_month);
        $monthsName = [];
        $totalPerBulan = [];

        foreach ($months as $month) {
            $monthsName[$month] = Carbon::create($year, $month)->translatedFormat('F');

            // Mengumpulkan data procurement per bulan
            $totalPerBulan[$month] = Procurement::whereYear('receipt', $year)
                ->whereMonth('receipt', $month)
                ->count();
        }

        $grandTotal = array_sum($totalPerBulan);

        return view('documentation.request.annual-result', compact(
            'year', 'months', 'monthsName', 'totalPerBulan', 'grandTotal', 'start_month', 'end_month'
        ));
    }
}
