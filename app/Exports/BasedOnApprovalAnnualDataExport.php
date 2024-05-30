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

class BasedOnApprovalAnnualDataExport implements FromView
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

        // Fungsi untuk mengumpulkan data procurement berdasarkan status
        $collectProcurementData = function ($status = null) use ($year, $start_month, $end_month) {
            $query = Procurement::select(
                'division_id',
                DB::raw('MONTH(receipt) as bulan'),
                DB::raw('COUNT(*) as total_procurement')
            )
            ->whereYear('receipt', $year)
            ->whereMonth('receipt', '>=', $start_month)
            ->whereMonth('receipt', '<=', $end_month)
            ->groupBy('division_id', 'bulan');

            if (!is_null($status)) {
                $query->where('status', $status);
            }

            return $query->get();
        };

        // Mendapatkan data procurement untuk semua status dan setiap status
        $allProcurements = $collectProcurementData();
        $procurementsStatus1 = $collectProcurementData('1');
        $procurementsStatus0 = $collectProcurementData('0');
        $procurementsStatus2 = $collectProcurementData('2');

        // Fungsi untuk menginisialisasi array terstruktur
        $initializeProcurementData = function ($divisions, $months) {
            $data = [];
            foreach ($divisions as $division) {
                $data[$division->id] = [];
                foreach ($months as $month) {
                    $data[$division->id][$month] = 0;
                }
            }
            return $data;
        };

        // Inisialisasi array terstruktur untuk semua data procurement dan setiap status
        $procurementDataAll = $initializeProcurementData($divisions, $months);
        $procurementDataStatus1 = $initializeProcurementData($divisions, $months);
        $procurementDataStatus0 = $initializeProcurementData($divisions, $months);
        $procurementDataStatus2 = $initializeProcurementData($divisions, $months);

        // Fungsi untuk mengisi array terstruktur dengan data procurement dari query
        $fillProcurementData = function ($procurements, &$data) {
            foreach ($procurements as $procurement) {
                $data[$procurement->division_id][$procurement->bulan] = $procurement->total_procurement;
            }
        };

        // Isi array terstruktur dengan data yang diambil dari database
        $fillProcurementData($allProcurements, $procurementDataAll);
        $fillProcurementData($procurementsStatus1, $procurementDataStatus1);
        $fillProcurementData($procurementsStatus0, $procurementDataStatus0);
        $fillProcurementData($procurementsStatus2, $procurementDataStatus2);

        // Fungsi untuk menghitung total per divisi dan total per bulan
        $calculateTotals = function ($divisions, $months, $data) {
            $totalPerDivisi = [];
            $totalPerBulan = array_fill($months[0], end($months) - $months[0] + 1, 0);

            foreach ($divisions as $division) {
                $totalPerDivisi[$division->id] = array_sum($data[$division->id]);
                foreach ($months as $month) {
                    $totalPerBulan[$month] += $data[$division->id][$month];
                }
            }

            $grandTotal = array_sum($totalPerBulan);
            return compact('totalPerDivisi', 'totalPerBulan', 'grandTotal');
        };

        // Hitung total untuk semua data procurement dan setiap status
        $totalsAll = $calculateTotals($divisions, $months, $procurementDataAll);
        $totalsStatus1 = $calculateTotals($divisions, $months, $procurementDataStatus1);
        $totalsStatus0 = $calculateTotals($divisions, $months, $procurementDataStatus0);
        $totalsStatus2 = $calculateTotals($divisions, $months, $procurementDataStatus2);

        return view('documentation.approval.annual-result', compact('year', 'months', 'divisions',  'procurementDataAll', 'procurementDataStatus1', 'procurementDataStatus0',  'procurementDataStatus2', 'monthsName',  'totalsAll', 'totalsStatus1', 'totalsStatus0', 'totalsStatus2', 'start_month', 'end_month'));
    }
}
