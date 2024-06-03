<?php

namespace App\Exports;

use App\Models\Procurement;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class MonitoringSelectedDataExport implements FromView
{
    public function view(): View
    {
        // dd(Request::all());
        $year = Request::input('year');
        $start_month = Request::input('start_month');
        $end_month = Request::input('end_month');
        $number = Request::input('number');
        $divisions = Request::input('division'); // Menggunakan 'divisions' untuk menampung lebih dari satu division

        if (is_null($divisions) || $divisions === '') {
            $divisions = [];
        } elseif (!is_array($divisions)) {
            $divisions = explode(',', $divisions);
        }
        // Mulai query Procurement dengan relasi yang diperlukan
        $procurementQuery = Procurement::with('tenders.businessPartners.partner')
        ->where('status', '1');

        // Terapkan filter tahun dan bulan sesuai input yang diberikan
        if ($year && ($start_month || $end_month)) {
            // Membangun kondisi rentang tanggal
            $procurementQuery->where(function ($query) use ($year, $start_month, $end_month) {
                $query->whereYear('receipt', $year);

                if ($start_month && $end_month) {
                    $query->whereMonth('receipt', '>=', $start_month)
                        ->whereMonth('receipt', '<=', $end_month);
                } elseif ($start_month) {
                    $query->whereMonth('receipt', '>=', $start_month);
                } elseif ($end_month) {
                    $query->whereMonth('receipt', '<=', $end_month);
                }
            });
        }

        // Terapkan filter nomor PP jika ada
        if ($number) {
            $procurementQuery->where('number', 'like', '%' . $number . '%');
        }

        // Terapkan filter divisi jika ada
        if (count($divisions) > 0) {
            $procurementQuery->whereIn('division_id', $divisions);
        }

        // Eksekusi query dan dapatkan hasilnya
        $procurements = $procurementQuery->get();
        // dd($procurements);

        // Kirim data ke view
        return view('selected.result', compact(
            'procurements'
        ));
    }
}
