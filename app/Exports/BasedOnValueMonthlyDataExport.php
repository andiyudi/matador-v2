<?php

namespace App\Exports;

use App\Models\Procurement;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class BasedOnValueMonthlyDataExport implements FromView
{
    public function view(): View
    {
        $period = Request::input('period');
        $number = Request::input('number');
        $value = Request::input('value');

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
        $query = Procurement::query();

        // Tambahkan kondisi-kondisi tambahan berdasarkan nilai yang diterima
        if ($month && $year) {
            $query->whereMonth('receipt', $month)
                ->whereYear('receipt', $year);
        }

        if ($number) {
            $query->where(function ($query) use ($number) {
                $query->where('number', 'LIKE', '%' . $number . '%');
            });
        }

        if ($value === '0') {
            $query->where(function ($query) {
                $query->where('user_estimate', '<', 100000000)
                    ->orWhereNull('user_estimate'); // Include null estimates
            });
        } elseif ($value === '1') {
            $query->whereBetween('user_estimate', [100000000, 999999999]);
        } elseif ($value === '2') {
            $query->where('user_estimate', '>=', 1000000000);
        }

        // Eksekusi query untuk mendapatkan hasilnya
        $procurements = $query->get();

        // Return the view with the results
        return view('documentation.value.monthly-result', compact('procurements', 'periodFormatted', 'monthName'));
    }

}
