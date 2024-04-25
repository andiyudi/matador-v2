<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
// use App\Models\Division;
use App\Models\Procurement;
use Illuminate\Http\Request;

class DocumentationController extends Controller
{
    public function basedOnValue ()
    {
        // $divisions = Division::where('status', '1')->get();
        return view ('documentation.value.index');
    }

    public function basedOnValueMonthlyData(Request $request)
    {
        $logoPath = public_path('assets/logo/cmnplogo.png');
        $logoData = file_get_contents($logoPath);
        $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        $period = $request->input('period');
        $number = $request->input('number');
        $value = $request->input('value');
        // $divisi = $request->input('divisi');
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
            $query->where('user_estimate', '<', 100000000); // Kurang dari 100 juta
        } elseif ($value === '1') {
            $query->whereBetween('user_estimate', [100000000, 999999999]); // Antara 100 juta dan 1 miliar
        } elseif ($value === '2') {
            $query->where('user_estimate', '>=', 1000000000); // Lebih dari 1 miliar
        }
        $query->whereNotNull('user_estimate');
        // Eksekusi query untuk mendapatkan hasilnya
        $procurements = $query->get();
        // dd($procurements);
        return view ('documentation.value.matrix-monthly', compact('logoBase64', 'procurements', 'periodFormatted', 'monthName'));
    }


    public function basedOnDivision ()
    {
        return view ('documentation.division.index');
    }

    public function basedOnApproval ()
    {
        return view ('documentation.approval.index');
    }

    public function basedOnRequest ()
    {
        return view ('documentation.request.index');
    }

    public function basedOnCompare ()
    {
        return view ('documentation.compare.index');
    }
}
