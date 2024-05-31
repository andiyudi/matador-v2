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
use App\Exports\BasedOnApprovalAnnualDataExport;
use App\Exports\BasedOnDivisionAnnualDataExport;
use App\Exports\BasedOnApprovalMonthlyDataExport;
use App\Exports\BasedOnDivisionMonthlyDataExport;

class DocumentationController extends Controller
{
    public function basedOnValue()
    {
        $currentYear = Carbon::now()->year;
        $years = Procurement::pluck(DB::raw('YEAR(receipt) as year'))->merge([$currentYear])->unique();
        $bulan = $this->getMonthsArray();
        $currentMonth = date('n');
        $divisions = Division::all();
        return view('documentation.value.index', compact('years', 'currentYear', 'divisions', 'bulan', 'currentMonth'));
    }
    public function basedOnValueMonthlyData(Request $request)
    {
        $period = $request->input('period');
        $number = $request->input('number');
        $value = $request->input('value');
        $divisions = $this->formatDivisionsInput($request->input('division'));
        $bulan = $this->getMonthsArray();
        list($month, $year) = explode('-', $period);
        $monthName = $bulan[$month];
        $periodFormatted = "$monthName $year";
        $query = Procurement::query()->whereMonth('receipt', $month)->whereYear('receipt', $year);
        if ($number) {
            $query->where('number', 'LIKE', '%' . $number . '%');
        }
        $this->filterByValue($query, $value);
        if (!empty($divisions)) {
            $query->whereIn('division_id', $divisions);
        }
        $procurements = $query->get();
        $stafName = request()->query('stafName');
        $stafPosition = request()->query('stafPosition');
        $managerName = request()->query('managerName');
        $managerPosition = request()->query('managerPosition');
        return view('documentation.value.matrix-monthly', compact('procurements', 'periodFormatted', 'monthName', 'stafName', 'stafPosition', 'managerName', 'managerPosition'));
    }
    public function basedOnValueMonthlyExcel()
    {
        $dateTime = Carbon::now()->format('dmYHis');
        $fileName = "basedOn-valueMonthly-excel-$dateTime.xlsx";
        return Excel::download(new BasedOnValueMonthlyDataExport, $fileName);
    }
    public function basedOnValueAnnualData(Request $request)
    {
        $year = $request->input('year');
        $start_month = $request->input('start_month');
        $end_month = $request->input('end_month');
        $work_value = $request->input('work_value');
        $nameStaf = request()->query('nameStaf');
        $positionStaf = request()->query('positionStaf');
        $nameManager = request()->query('nameManager');
        $positionManager = request()->query('positionManager');
        $months = range($start_month, $end_month);
        $monthsName = [];
        foreach ($months as $month) {
            $monthsName[] = Carbon::create($year, $month)->translatedFormat('M');
        }
        $procurementsCount = [];
        $totalLessThan100M = 0;
        $totalBetween100MAnd1B = 0;
        $totalMoreThan1B = 0;
        $grandTotal = 0;
        // Hitung untuk setiap bulan dalam rentang yang diberikan
        foreach ($months as $month) {
            $procurementsBase = Procurement::whereYear('receipt', $year)
                                            ->whereMonth('receipt', $month);
            // Inisialisasi nilai default untuk setiap kategori
            $procurementsCount[$month] = [
                'less_than_100M' => 0,
                'between_100M_and_1B' => 0,
                'more_than_1B' => 0
            ];
            // Hitung berdasarkan work value
            if ($work_value === '0') {
                $procurementsCount[$month]['less_than_100M'] = (clone $procurementsBase)
                    ->where(function ($query) {
                        $query->where('user_estimate', '<', 100000000)
                            ->orWhereNull('user_estimate');
                    })->count();
                $totalLessThan100M += $procurementsCount[$month]['less_than_100M'];
            } elseif ($work_value === '1') {
                $procurementsCount[$month]['between_100M_and_1B'] = (clone $procurementsBase)
                    ->whereBetween('user_estimate', [100000000, 999999999])->count();
                $totalBetween100MAnd1B += $procurementsCount[$month]['between_100M_and_1B'];
            } elseif ($work_value === '2') {
                $procurementsCount[$month]['more_than_1B'] = (clone $procurementsBase)
                    ->where('user_estimate', '>=', 1000000000)->count();
                $totalMoreThan1B += $procurementsCount[$month]['more_than_1B'];
            } else {
                $procurementsCount[$month]['less_than_100M'] = (clone $procurementsBase)
                    ->where(function ($query) {
                        $query->where('user_estimate', '<', 100000000)
                            ->orWhereNull('user_estimate');
                    })->count();
                $procurementsCount[$month]['between_100M_and_1B'] = (clone $procurementsBase)
                    ->whereBetween('user_estimate', [100000000, 999999999])->count();
                $procurementsCount[$month]['more_than_1B'] = (clone $procurementsBase)
                    ->where('user_estimate', '>=', 1000000000)->count();
                $totalLessThan100M += $procurementsCount[$month]['less_than_100M'];
                $totalBetween100MAnd1B += $procurementsCount[$month]['between_100M_and_1B'];
                $totalMoreThan1B += $procurementsCount[$month]['more_than_1B'];
            }
            // Hitung total untuk bulan tersebut
            $grandTotal += array_sum($procurementsCount[$month]);
        }
        return view('documentation.value.recap-annual', compact('months', 'monthsName', 'year', 'procurementsCount', 'totalLessThan100M', 'totalBetween100MAnd1B', 'totalMoreThan1B', 'grandTotal', 'nameStaf', 'positionStaf', 'nameManager', 'positionManager', 'start_month', 'end_month'));
    }
    public function basedOnValueAnnualExcel()
    {
        $dateTime = Carbon::now()->format('dmYHis');
        $fileName = "basedOn-valueAnnual-excel-$dateTime.xlsx";
        return Excel::download(new BasedOnValueAnnualDataExport, $fileName);
    }
    private function getMonthsArray()
    {
        return [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
    }
    private function formatDivisionsInput($divisions)
    {
        if (is_null($divisions) || $divisions === '') {
            return [];
        }
        return is_array($divisions) ? $divisions : explode(',', $divisions);
    }
    private function filterByValue($query, $value)
    {
        if ($value === '0') {
            $query->where(function ($query) {
                $query->where('user_estimate', '<', 100000000)
                    ->orWhereNull('user_estimate');
            });
        } elseif ($value === '1') {
            $query->whereBetween('user_estimate', [100000000, 999999999]);
        } elseif ($value === '2') {
            $query->where('user_estimate', '>=', 1000000000);
        }
    }
    private function filterByWorkValue($query, $work_value, &$procurementsCount, $month)
    {
        if ($work_value === '0') {
            $procurementsCount[$month]['less_than_100M'] = (clone $query)->where(function ($query) {
                $query->where('user_estimate', '<', 100000000)
                    ->orWhereNull('user_estimate');
            })->count();
        } elseif ($work_value === '1') {
            $procurementsCount[$month]['between_100M_and_1B'] = (clone $query)->whereBetween('user_estimate', [100000000, 999999999])->count();
        } elseif ($work_value === '2') {
            $procurementsCount[$month]['more_than_1B'] = (clone $query)->where('user_estimate', '>=', 1000000000)->count();
        }
    }
    private function calculateAllWorkValues($query, &$procurementsCount, $month, &$totalLessThan100M, &$totalBetween100MAnd1B, &$totalMoreThan1B)
    {
        $procurementsCount[$month]['less_than_100M'] = (clone $query)->where(function ($query) {
            $query->where('user_estimate', '<', 100000000)
                ->orWhereNull('user_estimate');
        })->count();
        $procurementsCount[$month]['between_100M_and_1B'] = (clone $query)->whereBetween('user_estimate', [100000000, 999999999])->count();
        $procurementsCount[$month]['more_than_1B'] = (clone $query)->where('user_estimate', '>=', 1000000000)->count();
        $totalLessThan100M += $procurementsCount[$month]['less_than_100M'];
        $totalBetween100MAnd1B += $procurementsCount[$month]['between_100M_and_1B'];
        $totalMoreThan1B += $procurementsCount[$month]['more_than_1B'];
    }
    public function basedOnDivision()
    {
        $currentYear = Carbon::now()->year;
        $years = Procurement::pluck(DB::raw('YEAR(receipt) as year'))
            ->merge([$currentYear]) // Add the current year to the collection
            ->unique();
        $divisions = Division::all();
        $officials = Official::all();
        $bulan = $this->getMonthsArray();
        $currentMonth = date('n'); // Current month as a number without leading zero
        return view('documentation.division.index', compact('divisions', 'officials', 'years', 'currentYear', 'currentMonth', 'bulan'));
    }
    public function basedOnDivisionMonthlyData(Request $request)
    {
        $period = $request->input('period');
        $number = $request->input('number');
        $divisions = $this->parseInputToArray($request->input('division'));
        $official = $request->input('official');
        $stafName = request()->query('stafName');
        $stafPosition = request()->query('stafPosition');
        $managerName = request()->query('managerName');
        $managerPosition = request()->query('managerPosition');
        list($month, $year) = explode('-', $period);
        $bulan = $this->getMonthsArray();
        $monthName = $bulan[$month];
        $periodFormatted = $this->formatPeriod($month, $year);
        $procurements = $this->getProcurementsByMonthAndYear($month, $year, $divisions, $official, $number);
        return view('documentation.division.matrix-monthly', compact('procurements', 'periodFormatted', 'monthName', 'stafName', 'stafPosition', 'managerName', 'managerPosition'));
    }

    public function basedOnDivisionMonthlyExcel()
    {
        $dateTime = Carbon::now()->format('dmYHis');
        $fileName = 'basedOn-divisionMonthly-excel-' . $dateTime . '.xlsx';
        return Excel::download(new BasedOnDivisionMonthlyDataExport, $fileName);
    }
    public function basedOnDivisionAnnualData(Request $request)
    {
        $year = $request->input('year');
        $start_month = $request->input('start_month');
        $end_month = $request->input('end_month');
        $nameStaf = request()->query('nameStaf');
        $positionStaf = request()->query('positionStaf');
        $nameManager = request()->query('nameManager');
        $positionManager = request()->query('positionManager');
        $divisions = Division::all();
        $months = range($start_month, $end_month);
        $monthsName = $this->getMonthsName($months);
        $procurementData = $this->getAnnualProcurementData($year, $start_month, $end_month);
        $totalPerDivisi = $this->calculateTotalPerDivision($procurementData);
        $totalPerBulan = $this->calculateTotalPerMonth($procurementData, $months);
        $totalPerDivisionPerBulan = $this->calculateTotalPerDivisionPerBulan($procurementData, $divisions, $months);
        $grandTotal = array_sum($totalPerBulan);
        return view('documentation.division.recap-annual', compact(
            'year', 'months', 'divisions', 'procurementData', 'monthsName',
            'nameStaf', 'positionStaf', 'nameManager', 'positionManager',
            'totalPerDivisi', 'totalPerBulan', 'totalPerDivisionPerBulan', 'grandTotal', 'start_month', 'end_month'
        ));
    }
    public function basedOnDivisionAnnualExcel()
    {
        $dateTime = Carbon::now()->format('dmYHis');
        $fileName = 'basedOn-divisionAnnual-excel-' . $dateTime . '.xlsx';
        return Excel::download(new BasedOnDivisionAnnualDataExport, $fileName);
    }
    private function parseInputToArray($input)
    {
        if (is_null($input) || $input === '') {
            return [];
        } elseif (!is_array($input)) {
            return explode(',', $input);
        }
        return $input;
    }
    private function formatPeriod($month, $year)
    {
        $bulan = $this->getMonthsArray();
        $monthName = $bulan[str_pad($month, 2, '0', STR_PAD_LEFT)];
        return $monthName . ' ' . $year;
    }
    private function getProcurementsByMonthAndYear($month, $year, $divisions, $official, $number)
    {
        $query = Procurement::query()->orderBy('division_id')
            ->whereMonth('receipt', $month)
            ->whereYear('receipt', $year);
        if (count($divisions) > 0) {
            $query->whereIn('division_id', $divisions);
        }
        if ($official !== null) {
            $query->where('official_id', $official);
        }
        if ($number) {
            $query->where('number', 'LIKE', '%' . $number . '%');
        }
        return $query->get();
    }
    private function getMonthsName($months)
    {
        $allMonths = $this->getMonthsArray(); // Ensure this function returns an array with month names indexed from '01' to '12'
        $monthsName = [];
        foreach ($months as $month) {
            $monthsName[$month] = $allMonths[sprintf('%02d', $month)];
        }
        return $monthsName;
    }
    private function getAnnualProcurementData($year, $start_month, $end_month)
    {
        return Procurement::select(
                'division_id',
                DB::raw('MONTH(receipt) as bulan'),
                DB::raw('COUNT(*) as total_procurement')
            )
            ->whereYear('receipt', $year)
            ->whereMonth('receipt', '>=', $start_month)
            ->whereMonth('receipt', '<=', $end_month)
            ->groupBy('division_id', 'bulan')
            ->get();
    }
    private function calculateTotalPerDivisionPerBulan($procurementData, $divisions, $months)
    {
        $totalPerDivisionPerBulan = [];
        // Initialize the array structure
        foreach ($divisions as $division) {
            $totalPerDivisionPerBulan[$division->id] = array_fill_keys($months, 0);
        }
        // Populate the array with procurement data
        foreach ($procurementData as $procurement) {
            if (isset($totalPerDivisionPerBulan[$procurement->division_id][$procurement->bulan])) {
                $totalPerDivisionPerBulan[$procurement->division_id][$procurement->bulan] += $procurement->total_procurement;
            }
        }
        return $totalPerDivisionPerBulan;
    }
    private function calculateTotalPerDivision($procurementData)
    {
        $totalPerDivisi = [];
        foreach ($procurementData as $procurement) {
            if (!isset($totalPerDivisi[$procurement->division_id])) {
                $totalPerDivisi[$procurement->division_id] = 0;
            }
            $totalPerDivisi[$procurement->division_id] += $procurement->total_procurement;
        }
        return $totalPerDivisi;
    }
    private function calculateTotalPerMonth($procurementData,$months)
    {
        $totalPerBulan = array_fill_keys($months, 0);
        foreach ($procurementData as $procurement) {
            if (isset($totalPerBulan[$procurement->bulan])) {
                $totalPerBulan[$procurement->bulan] += $procurement->total_procurement;
            }
        }
        return $totalPerBulan;
    }
    private function initializeProcurementData($divisions, $months)
    {
        $data = [];
        foreach ($divisions as $division) {
            $data[$division->id] = array_fill_keys($months, 0);
        }
        return $data;
    }
    private function collectProcurementData($year, $start_month, $end_month, $status = null)
    {
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
    }
    private function fillProcurementData($procurements, &$data)
    {
        foreach ($procurements as $procurement) {
            $data[$procurement->division_id][$procurement->bulan] = $procurement->total_procurement;
        }
    }
    private function calculateTotals($divisions, $months, $data)
    {
        $totalPerDivisi = [];
        $totalPerBulan = array_fill_keys($months, 0);
        foreach ($divisions as $division) {
            $totalPerDivisi[$division->id] = array_sum($data[$division->id]);
            foreach ($months as $month) {
                $totalPerBulan[$month] += $data[$division->id][$month];
            }
        }
        $grandTotal = array_sum($totalPerBulan);
        return compact('totalPerDivisi', 'totalPerBulan', 'grandTotal');
    }
    public function basedOnApproval()
    {
        $currentYear = Carbon::now()->year;
        $years = Procurement::pluck(DB::raw('YEAR(receipt) as year'))
                ->merge([$currentYear])
                ->unique();
        $divisions = Division::all();
        $currentMonth = date('n');
        $bulan = $this->getMonthsArray();
        return view('documentation.approval.index', compact('years', 'divisions', 'currentMonth', 'currentYear', 'bulan'));
    }
    public function basedOnApprovalMonthlyData(Request $request)
    {
        $period = $request->input('period');
        $number = $request->input('number');
        $divisions = $request->input('division');
        $stafName = request()->query('stafName');
        $stafPosition = request()->query('stafPosition');
        $managerName = request()->query('managerName');
        $managerPosition = request()->query('managerPosition');
        if (is_null($divisions) || $divisions === '') {
            $divisions = [];
        } elseif (!is_array($divisions)) {
            $divisions = explode(',', $divisions);
        }
        list($month, $year) = explode('-', $period);
        $bulan = $this->getMonthsArray();
        $monthName = $bulan[$month];
        $periodFormatted = $monthName . ' ' . $year;
        $query = Procurement::with('tenders.businessPartners.partner');
        if ($month && $year) {
            $query->whereMonth('receipt', $month)
                ->whereYear('receipt', $year);
        }
        if (count($divisions) > 0) {
            $query->whereIn('division_id', $divisions);
        }
        if ($number) {
            $query->where('number', 'LIKE', '%' . $number . '%');
        }
        $procurements = $query->get();
        return view('documentation.approval.matrix-monthly', compact('procurements', 'periodFormatted', 'monthName', 'stafName', 'stafPosition', 'managerName', 'managerPosition'));
    }
    public function basedOnApprovalMonthlyExcel()
    {
        $dateTime = Carbon::now()->format('dmYHis');
        $fileName = 'basedOn-approvalMonthly-excel-' . $dateTime . '.xlsx';
        return Excel::download(new BasedOnApprovalMonthlyDataExport, $fileName);
    }
    public function basedOnApprovalAnnualData(Request $request)
    {
        $year = $request->input('year');
        $start_month = $request->input('start_month');
        $end_month = $request->input('end_month');
        $nameStaf = request()->query('nameStaf');
        $positionStaf = request()->query('positionStaf');
        $nameManager = request()->query('nameManager');
        $positionManager = request()->query('positionManager');
        $divisions = Division::all();
        $months = range($start_month, $end_month);
        $monthsName = array_map(function ($month) use ($year) {
            return Carbon::create($year, $month)->translatedFormat('M');
        }, $months);
        //Fungsi yang digunakan untuk mengambil semua data procurement
        $allProcurements = $this->collectProcurementData($year, $start_month, $end_month);
        $procurementsStatus1 = $this->collectProcurementData($year, $start_month, $end_month, '1');
        $procurementsStatus0 = $this->collectProcurementData($year, $start_month, $end_month, '0');
        $procurementsStatus2 = $this->collectProcurementData($year, $start_month, $end_month, '2');
        // Fungsi ini digunakan untuk menginisialisasi array yang akan digunakan untuk menampung data procurement
        $procurementDataAll = $this->initializeProcurementData($divisions, $months);
        $procurementDataStatus1 = $this->initializeProcurementData($divisions, $months);
        $procurementDataStatus0 = $this->initializeProcurementData($divisions, $months);
        $procurementDataStatus2 = $this->initializeProcurementData($divisions, $months);
        // Fungsi ini digunakan untuk memasukkan data procurement ke dalam array yang telah diinisialisasi
        $this->fillProcurementData($allProcurements, $procurementDataAll);
        $this->fillProcurementData($procurementsStatus1, $procurementDataStatus1);
        $this->fillProcurementData($procurementsStatus0, $procurementDataStatus0);
        $this->fillProcurementData($procurementsStatus2, $procurementDataStatus2);
        // Fungsi ini digunakan untuk menghitung total per divisi dan bulan
        $totalsAll = $this->calculateTotals($divisions, $months, $procurementDataAll);
        $totalsStatus1 = $this->calculateTotals($divisions, $months, $procurementDataStatus1);
        $totalsStatus0 = $this->calculateTotals($divisions, $months, $procurementDataStatus0);
        $totalsStatus2 = $this->calculateTotals($divisions, $months, $procurementDataStatus2);
        return view('documentation.approval.recap-annual', compact(
            'year', 'months', 'divisions', 'procurementDataAll', 'procurementDataStatus1',
            'procurementDataStatus0', 'procurementDataStatus2', 'monthsName', 'nameStaf',
            'positionStaf', 'nameManager', 'positionManager', 'totalsAll', 'totalsStatus1',
            'totalsStatus0', 'totalsStatus2', 'start_month', 'end_month'
        ));
    }
    public function basedOnApprovalAnnualExcel()
    {
        $dateTime = Carbon::now()->format('dmYHis');
        $fileName = 'basedOn-approvalAnnual-excel-' . $dateTime . '.xlsx';
        return Excel::download(new BasedOnApprovalAnnualDataExport, $fileName);
    }
    public function basedOnRequest ()
    {
        $currentYear = Carbon::now()->year;
        $years = Procurement::pluck(DB::raw('YEAR(receipt) as year'))
                ->merge([$currentYear])
                ->unique();
        $divisions = Division::all();
        $currentMonth = date('n');
        $bulan = $this->getMonthsArray();
        return view('documentation.request.index', compact('years', 'divisions', 'currentMonth', 'currentYear', 'bulan'));
    }
    private function getProcurementsRequestByMonthAndYear($month, $year, $divisions,$number)
    {
        $query = Procurement::query()
            ->whereMonth('receipt', $month)
            ->whereYear('receipt', $year);
        if (count($divisions) > 0) {
            $query->whereIn('division_id', $divisions);
        }
        if ($number) {
            $query->where('number', 'LIKE', '%' . $number . '%');
        }
        return $query->get();
    }
    public function basedOnRequestMonthlyData(Request $request)
    {
        $period = $request->input('period');
        $number = $request->input('number');
        $divisions = $this->parseInputToArray($request->input('division'));
        $official = $request->input('official');
        $stafName = request()->query('stafName');
        $stafPosition = request()->query('stafPosition');
        $managerName = request()->query('managerName');
        $managerPosition = request()->query('managerPosition');
        list($month, $year) = explode('-', $period);
        $bulan = $this->getMonthsArray();
        $monthName = $bulan[$month];
        $periodFormatted = $this->formatPeriod($month, $year);
        $procurements = $this->getProcurementsRequestByMonthAndYear($month, $year, $divisions, $number);
        return view('documentation.request.matrix-monthly', compact('procurements', 'periodFormatted', 'monthName', 'stafName', 'stafPosition', 'managerName', 'managerPosition'));
    }
    public function basedOnRequestAnnualData(Request $request)
    {
        $year = $request->input('year');
        $start_month = $request->input('start_month');
        $end_month = $request->input('end_month');
        $nameStaf = request()->query('nameStaf');
        $positionStaf = request()->query('positionStaf');
        $nameManager = request()->query('nameManager');
        $positionManager = request()->query('positionManager');
        $months = range($start_month, $end_month);
        $monthsName = $this->getMonthsName($months);
        $procurementData = $this->getAnnualProcurementData($year, $start_month, $end_month);
        $totalPerBulan = $this->calculateTotalPerMonth($procurementData, $months);
        $grandTotal = array_sum($totalPerBulan);
        return view('documentation.request.recap-annual', compact(
            'year', 'months', 'procurementData', 'monthsName',
            'nameStaf', 'positionStaf', 'nameManager', 'positionManager',
            'totalPerBulan', 'grandTotal', 'start_month', 'end_month'
        ));
    }


    public function basedOnCompare ()
    {
        return view ('documentation.compare.index');
    }
}
