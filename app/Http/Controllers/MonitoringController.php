<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Division;
use App\Models\Procurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MonitoringSelectedDataExport;

class MonitoringController extends Controller
{
    private function division()
    {
        $divisions = Division::all();
        return $divisions;
    }
    private function getMonthsArray()
    {
        return [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
    }
    private function getMonthName($month)
    {
        $months = $this->getMonthsArray();
        return $months[$month];
    }
    public function tenderVendorSelected()
    {
        $divisions = $this->division();
        $bulan = $this->getMonthsArray();
        $currentMonth = date('n');
        $currentYear = Carbon::now()->year;
        $years = Procurement::pluck(DB::raw('YEAR(receipt) as year'))->merge([$currentYear])->unique();
        return view ('selected.index', compact('divisions' , 'bulan', 'currentMonth', 'currentYear', 'years'));
    }

    public function tenderVendorSelectedData(Request $request)
    {
        // Ambil nilai filter dari request
        $year = $request->input('year');
        $start_month = $request->input('start_month');
        $end_month = $request->input('end_month');
        $number = $request->input('number');
        $divisions = $request->input('division'); // Menggunakan 'divisions' untuk menampung lebih dari satu division

        // Tanda tangan
        $stafName = $request->query('stafName');
        $stafPosition = $request->query('stafPosition');
        $managerName = $request->query('managerName');
        $managerPosition = $request->query('managerPosition');

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
        $start_month_name = $this->getMonthName($start_month);
        $end_month_name = $this->getMonthName($end_month);

        // Kirim data ke view
        return view('selected.data', compact(
            'procurements', 'year', 'start_month', 'end_month',
            'start_month_name', 'end_month_name', 'number', 'divisions',
            'stafName', 'stafPosition', 'managerName', 'managerPosition'
        ));
    }
    public function tenderVendorSelectedExcel()
    {
        $dateTime = Carbon::now()->format('dmYHis');
        $fileName = 'basedOn-monitoringSelected-excel-' . $dateTime . '.xlsx';
        return Excel::download(new MonitoringSelectedDataExport, $fileName);
    }
    public function monitoringProcess()
    {
        return view ('monitoring.index');
    }
}
