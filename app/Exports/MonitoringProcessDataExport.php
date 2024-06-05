<?php

namespace App\Exports;

use App\Models\Procurement;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class MonitoringProcessDataExport implements FromView
{
    public function view(): View
    {
        $period = Request::input('period');
        $number = Request::input('number');
        $official = Request::input('official');
        $divisions = Request::input('division'); // Menggunakan 'divisions' untuk menampung lebih dari satu division

        if (is_null($divisions) || $divisions === '') {
            $divisions = [];
        } elseif (!is_array($divisions)) {
            $divisions = explode(',', $divisions);
        }
        list($month, $year) = explode('-', $period);
        // Mulai query Procurement dengan relasi yang diperlukan
        $procurementQuery = Procurement::with('tenders.businessPartners.partner')
            ->whereMonth('receipt', $month)
            ->whereYear('receipt', $year);;
        if ($number) {
            $procurementQuery->where('number', 'like', '%' . $number . '%');
        }
        if ($official !== null) {
            $procurementQuery->where('official_id', $official);
        }
        if (count($divisions) > 0) {
            $procurementQuery->whereIn('division_id', $divisions);
        }
        $procurements = $procurementQuery->get();
        // dd($procurements);
        return view('monitoring.result', compact(
            'procurements'
        ));
    }
}
