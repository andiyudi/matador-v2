<?php

namespace App\Exports;

use App\Models\Procurement;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class BasedOnDivisionMonthlyDataExport implements FromView
{
    public function view():View
    {
        $period = Request::input('period');
        $official = Request::input('official');
        $number = Request::input('number');
        $divisions = Request::input('division');
        if (is_null($divisions) || $divisions === '') {
            $divisions = [];
        } elseif (!is_array($divisions)) {
            $divisions = explode(',', $divisions);
        }
        $bulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];
        // Pemisahan bulan dan tahun dari input periode
        list($month, $year) = explode('-', $period);
        // Konversi angka bulan menjadi nama bulan dalam bahasa Indonesia
        $monthName = $bulan[$month];
        // Format objek DateTime sesuai dengan format yang diinginkan
        $periodFormatted = $monthName . ' ' . $year;
        // Mulai dengan query dasar dari model procurement
        $query = Procurement::query()->orderBy('division_id');
        // Tambahkan kondisi-kondisi tambahan berdasarkan nilai yang diterima
        if ($month && $year) {
            $query->whereMonth('receipt', $month)
                ->whereYear('receipt', $year);
        }
        if (count($divisions) > 0) {
            // Tambahkan filter untuk division jika $divisions tidak kosong
            $query->whereIn('division_id', $divisions); // Sesuaikan dengan kolom yang menyimpan ID divisi
        }
        if ($official && $official!== 'null') {
            $query->where('official_id', $official);
        }
        if ($number) {
            $query->where(function ($query) use ($number) {
                $query->where('number', 'LIKE', '%' . $number . '%');
            });
        }
        $procurements = $query->get();
        // dd($procurements);
        return view ('documentation.division.monthly-result', compact('procurements', 'periodFormatted', 'monthName'));
    }
}
