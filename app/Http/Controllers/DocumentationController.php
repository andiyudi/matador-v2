<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Division;
use App\Models\Official;
use App\Models\Procurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BasedOnValueAnnualDataExport;
use App\Exports\BasedOnValueMonthlyDataExport;
use App\Exports\BasedOnDivisionMonthlyDataExport;

class DocumentationController extends Controller
{
    public function basedOnValue ()
    {
        $currentYear = Carbon::now()->year;
        $years = Procurement::pluck(DB::raw('YEAR(receipt) as year'))
                ->merge([$currentYear]) // Menambahkan tahun saat ini ke dalam koleksi
                ->unique();
        return view ('documentation.value.index', compact('years', 'currentYear'));
    }

    public function basedOnValueMonthlyData(Request $request)
    {
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
        $stafName = request()->query('stafName');
        $stafPosition = request()->query('stafPosition');
        $managerName = request()->query('managerName');
        $managerPosition = request()->query('managerPosition');
        return view ('documentation.value.matrix-monthly', compact('procurements', 'periodFormatted', 'monthName', 'stafName', 'stafPosition', 'managerName', 'managerPosition'));
    }

    public function basedOnValueMonthlyExcel()
    {
        $dateTime = Carbon::now()->format('dmYHis');
        $fileName = 'basedOn-valueMonthly-excel-' . $dateTime . '.xlsx';

        return Excel::download(new BasedOnValueMonthlyDataExport, $fileName);
    }
    public function basedOnValueAnnualData(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');
        $work_value = $request->input('work_value');
        $nameStaf = request()->query('nameStaf');
        $positionStaf = request()->query('positionStaf');
        $nameManager = request()->query('nameManager');
        $positionManager = request()->query('positionManager');
        $months = [];
        $monthsName = [];
        $totalLessThan100M = 0;
        $totalBetween100MAnd1B = 0;
        $totalMoreThan1B = 0;
        $grandTotal = 0;
        for ($i = 1; $i <= 12; $i++) {
            $months[] = $i; // Menggunakan angka bulan
            $monthsName[] = Carbon::create($year, $i)->translatedFormat('M');
        }
        $procurementsCount = [];

        if ($month !== 'null') {
            // Filter berdasarkan bulan yang diberikan
            $procurementsBase = Procurement::whereYear('receipt', $year)
                                        ->whereMonth('receipt', $month)
                                        ->whereNotNull('user_estimate');

            // Filter berdasarkan work value jika diberikan
            if ($work_value === '0') {
                $procurementsCount[$month]['less_than_100M'] = (clone $procurementsBase)->where('user_estimate', '<', 100000000)->count();
                $totalLessThan100M += $procurementsCount[$month]['less_than_100M'];
            } elseif ($work_value === '1') {
                $procurementsCount[$month]['between_100M_and_1B'] = (clone $procurementsBase)->whereBetween('user_estimate', [100000000, 999999999])->count();
                $totalBetween100MAnd1B += $procurementsCount[$month]['between_100M_and_1B'];
            } elseif ($work_value === '2') {
                $procurementsCount[$month]['more_than_1B'] = (clone $procurementsBase)->where('user_estimate', '>=', 1000000000)->count();
                $totalMoreThan1B += $procurementsCount[$month]['more_than_1B'];
            } else {
                $procurementsCount[$month]['less_than_100M'] = (clone $procurementsBase)->where('user_estimate', '<', 100000000)->count();
                $procurementsCount[$month]['between_100M_and_1B'] = (clone $procurementsBase)->whereBetween('user_estimate', [100000000, 999999999])->count();
                $procurementsCount[$month]['more_than_1B'] = (clone $procurementsBase)->where('user_estimate', '>=', 1000000000)->count();
                $totalLessThan100M += $procurementsCount[$month]['less_than_100M'];
                $totalBetween100MAnd1B += $procurementsCount[$month]['between_100M_and_1B'];
                $totalMoreThan1B += $procurementsCount[$month]['more_than_1B'];
            }
            $grandTotal += array_sum($procurementsCount[$month]);
        } else {
            // Hitung untuk setiap bulan dalam setahun
            foreach ($months as $month) {
                $procurementsBase = Procurement::whereYear('receipt', $year)
                                            ->whereMonth('receipt', $month)
                                            ->whereNotNull('user_estimate');

                // Filter berdasarkan work value jika diberikan
                if ($work_value === '0') {
                    $procurementsCount[$month]['less_than_100M'] = (clone $procurementsBase)->where('user_estimate', '<', 100000000)->count();
                    $totalLessThan100M += $procurementsCount[$month]['less_than_100M'];
                } elseif ($work_value === '1') {
                    $procurementsCount[$month]['between_100M_and_1B'] = (clone $procurementsBase)->whereBetween('user_estimate', [100000000, 999999999])->count();
                    $totalBetween100MAnd1B += $procurementsCount[$month]['between_100M_and_1B'];
                } elseif ($work_value === '2') {
                    $procurementsCount[$month]['more_than_1B'] = (clone $procurementsBase)->where('user_estimate', '>=', 1000000000)->count();
                    $totalMoreThan1B += $procurementsCount[$month]['more_than_1B'];
                } else {
                    $procurementsCount[$month]['less_than_100M'] = (clone $procurementsBase)->where('user_estimate', '<', 100000000)->count();
                    $procurementsCount[$month]['between_100M_and_1B'] = (clone $procurementsBase)->whereBetween('user_estimate', [100000000, 999999999])->count();
                    $procurementsCount[$month]['more_than_1B'] = (clone $procurementsBase)->where('user_estimate', '>=', 1000000000)->count();
                    $totalLessThan100M += $procurementsCount[$month]['less_than_100M'];
                    $totalBetween100MAnd1B += $procurementsCount[$month]['between_100M_and_1B'];
                    $totalMoreThan1B += $procurementsCount[$month]['more_than_1B'];
                }
                $grandTotal += array_sum($procurementsCount[$month]);
            }
        }
        return view('documentation.value.recap-annual', compact('months', 'monthsName', 'year', 'procurementsCount', 'totalLessThan100M', 'totalBetween100MAnd1B', 'totalMoreThan1B', 'grandTotal', 'nameStaf', 'positionStaf', 'nameManager', 'positionManager'));
    }
    public function basedOnValueAnnualExcel()
    {
        $dateTime = Carbon::now()->format('dmYHis');
        $fileName = 'basedOn-valueAnnual-excel-' . $dateTime . '.xlsx';

        return Excel::download(new BasedOnValueAnnualDataExport, $fileName);
    }
    public function basedOnDivision ()
    {
        $currentYear = Carbon::now()->year;
        $years = Procurement::pluck(DB::raw('YEAR(receipt) as year'))
                ->merge([$currentYear]) // Menambahkan tahun saat ini ke dalam koleksi
                ->unique();
        $divisions = Division::all();
        $officials = Official::all();
        return view ('documentation.division.index', compact('divisions', 'officials', 'years', 'currentYear'));
    }

    public function basedOnDivisionMonthlyData(Request $request)
    {
        $period = $request->input('period');
        $number = $request->input('number');
        $division = $request->input('division');
        $official = $request->input('official');
        $stafName = request()->query('stafName');
        $stafPosition = request()->query('stafPosition');
        $managerName = request()->query('managerName');
        $managerPosition = request()->query('managerPosition');

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
        if ($division && $division !== 'null') {
            $query->where('division_id', $division);
        }
        if ($official && $official!== 'null') {
            $query->where('official_id', $official);
        }
        if ($number) {
            $query->where(function ($query) use ($number) {
                $query->where('number', 'LIKE', '%' . $number . '%');
            });
        }
        // Eksekusi query untuk mendapatkan hasilnya
        $procurements = $query->get();
        // dd($procurements);
        return view ('documentation.division.matrix-monthly', compact('procurements', 'periodFormatted', 'monthName', 'stafName', 'stafPosition', 'managerName', 'managerPosition'));
    }
    public function basedOnDivisionMonthlyExcel()
    {
        $dateTime = Carbon::now()->format('dmYHis');
        $fileName = 'basedOn-divisionMonthly-excel-' . $dateTime . '.xlsx';

        return Excel::download(new BasedOnDivisionMonthlyDataExport, $fileName);
    }
    public function basedOnDivisionAnnualData(Request $request)
    {
        // dd($request->all());
        $year = $request->input('year');
        $filterType = $request->input('filterType');
        $filterValue = $request->input('filterValue');
        // dd($year, $filterType, $filterValue);
        $nameStaf = request()->query('nameStaf');
        $positionStaf = request()->query('positionStaf');
        $nameManager = request()->query('nameManager');
        $positionManager = request()->query('positionManager');
    }
    public function basedOnDivisionAnnualExcel()
    {

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
