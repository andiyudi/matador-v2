<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Procurement;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class BasedOnValueAnnualDataExport implements FromView
{
    public function view(): View
    {
        $year = Request::input('year');
        $month = Request::input('month');
        $work_value = Request::input('work_value');
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
                                        ->whereMonth('receipt', $month);

            // Filter berdasarkan work value jika diberikan
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
            $grandTotal += array_sum($procurementsCount[$month]);
        } else {
            // Hitung untuk setiap bulan dalam setahun
            foreach ($months as $month) {
                $procurementsBase = Procurement::whereYear('receipt', $year)
                                            ->whereMonth('receipt', $month);

                // Filter berdasarkan work value jika diberikan
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
                $grandTotal += array_sum($procurementsCount[$month]);
            }
        }

        return view('documentation.value.annual-result', compact('months', 'monthsName', 'year', 'procurementsCount', 'totalLessThan100M', 'totalBetween100MAnd1B', 'totalMoreThan1B', 'grandTotal'));
    }

}
