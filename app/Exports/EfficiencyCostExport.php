<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Procurement;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromView;

class EfficiencyCostExport implements FromView
{
    public function view():View
    {
        $year = Request::input('year');
        $months = [];
        $monthsName = [];
        $procurementData=[];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = $i; // Menggunakan angka bulan
            $monthsName[] = Carbon::create($year, $i)->translatedFormat('F');
            // Filter procurement berdasarkan tahun dan bulan
            $procurementData[$i] = Procurement::whereYear('receipt', $year)
                                                ->whereMonth('receipt', $i)
                                                ->where('status', '1')
                                                ->selectRaw('SUM(user_estimate) as total_user_estimate, SUM(deal_nego) as total_deal_nego')
                                                ->first();
        }
        return view('recapitulation.efficiency.result', compact('year', 'months', 'monthsName', 'procurementData'));
    }
}
