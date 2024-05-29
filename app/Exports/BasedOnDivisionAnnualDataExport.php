<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Division;
use App\Models\Procurement;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class BasedOnDivisionAnnualDataExport implements FromView
{
    public function view(): View
    {
        $year = Request::input('year');
        $start_month = Request::input('start_month');
        $end_month = Request::input('end_month');

        $divisions = Division::all();

        // Filter bulan sesuai dengan start_month dan end_month
        $months = range($start_month, $end_month);
        $monthsName = [];
        foreach ($months as $month) {
            $monthsName[] = Carbon::create($year, $month)->translatedFormat('M');
        }

        // Menyesuaikan query berdasarkan filterType dan filterValue
        $procurementQuery = Procurement::select(
            'division_id',
            DB::raw('MONTH(receipt) as bulan'),
            DB::raw('COUNT(*) as total_procurement') // Menggunakan COUNT untuk menghitung jumlah data
        )
        ->whereYear('receipt', $year)
        ->whereMonth('receipt', '>=', $start_month)
        ->whereMonth('receipt', '<=', $end_month)
        ->groupBy('division_id', 'bulan');

        $procurements = $procurementQuery->get();

        // Buat array terstruktur untuk memudahkan pengolahan di view
        $procurementData = [];
        foreach ($divisions as $division) {
            $procurementData[$division->id] = [];
            foreach ($months as $month) {
                $procurementData[$division->id][$month] = 0; // Inisialisasi dengan 0
            }
        }

        // Isi array terstruktur dengan data procurement yang diambil dari database
        foreach ($procurements as $procurement) {
            $procurementData[$procurement->division_id][$procurement->bulan] = $procurement->total_procurement;
        }

        // Hitung total per divisi per tahun dan total per bulan untuk semua divisi
        $totalPerDivisi = [];
        $totalPerBulan = array_fill($start_month, $end_month - $start_month + 1, 0); // Inisialisasi total per bulan dengan 0
        foreach ($divisions as $division) {
            $totalPerDivisi[$division->id] = array_sum($procurementData[$division->id]);
            foreach ($months as $month) {
                $totalPerBulan[$month] += $procurementData[$division->id][$month];
            }
        }

        // Hitung grand total untuk semua divisi dan semua bulan
        $grandTotal = array_sum($totalPerBulan);
        return view('documentation.division.annual-result', compact('year', 'months', 'divisions', 'procurementData', 'monthsName', 'totalPerDivisi', 'totalPerBulan', 'grandTotal', 'start_month', 'end_month'));
    }
}
