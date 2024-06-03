<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Procurement;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromView;

class BasedOnCompareAnnualDataExport implements FromView
{
    public function view(): View
    {
        $year = Request::input('year');
        $start_month = Request::input('start_month');
        $end_month = Request::input('end_month');

        $months = range($start_month, $end_month);
        $monthsName = [];
        $userEstimates = [];
        $techniqueEstimates = [];
        $dealNegos = [];
        $userEstimateDiffs = [];
        $techniqueEstimateDiffs = [];
        $userEstimatePercentages = [];
        $techniqueEstimatePercentages = [];
        $totalUserEstimate = 0;
        $totalDealNego = 0;
        $totalUserEstimateDiff = 0;
        $totalTechniqueEstimate = 0;
        $totalTechniqueEstimateDiff = 0;

        foreach ($months as $month) {
            $monthsName[$month] = Carbon::create($year, $month)->translatedFormat('F');
            $procurements = Procurement::whereYear('receipt', $year)
                ->whereMonth('receipt', $month)
                ->get();

            $userEstimateSum = $procurements->sum('user_estimate');
            $techniqueEstimateSum = $procurements->sum('technique_estimate');
            $dealNegoSum = $procurements->sum('deal_nego');

            $userEstimateDiff = $userEstimateSum - $dealNegoSum;
            $techniqueEstimateDiff = $techniqueEstimateSum - $dealNegoSum;

            $userEstimatePercentage = $userEstimateSum != 0 ? ($userEstimateDiff / $userEstimateSum) * 100 : 0;
            $techniqueEstimatePercentage = $techniqueEstimateSum != 0 ? ($techniqueEstimateDiff / $techniqueEstimateSum) * 100 : 0;

            $userEstimates[$month] = $userEstimateSum;
            $techniqueEstimates[$month] = $techniqueEstimateSum;
            $dealNegos[$month] = $dealNegoSum;
            $userEstimateDiffs[$month] = $userEstimateDiff;
            $techniqueEstimateDiffs[$month] = $techniqueEstimateDiff;
            $userEstimatePercentages[$month] = $userEstimatePercentage;
            $techniqueEstimatePercentages[$month] = $techniqueEstimatePercentage;

            $totalUserEstimate += $userEstimateSum;
            $totalDealNego += $dealNegoSum;
            $totalUserEstimateDiff += $userEstimateDiff;
            $totalTechniqueEstimate += $techniqueEstimateSum;
            $totalTechniqueEstimateDiff += $techniqueEstimateDiff;
        }

        $totalUserEstimatePercentage = $totalUserEstimate != 0 ? ($totalUserEstimateDiff / $totalUserEstimate) * 100 : 0;
        $totalTechniqueEstimatePercentage = $totalTechniqueEstimate != 0 ? ($totalTechniqueEstimateDiff / $totalTechniqueEstimate) * 100 : 0;

        return view('documentation.compare.annual-result', compact(
            'year', 'months', 'monthsName',
            'userEstimates', 'techniqueEstimates', 'dealNegos',
            'userEstimateDiffs', 'techniqueEstimateDiffs',
            'userEstimatePercentages', 'techniqueEstimatePercentages',
            'totalUserEstimate', 'totalDealNego', 'totalUserEstimateDiff',
            'totalTechniqueEstimate', 'totalTechniqueEstimateDiff',
            'totalUserEstimatePercentage', 'totalTechniqueEstimatePercentage',
            'start_month', 'end_month'
        ));
    }
}
