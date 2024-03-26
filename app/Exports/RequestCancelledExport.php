<?php

namespace App\Exports;

use App\Models\Procurement;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromView;

class RequestCancelledExport implements FromView
{
    public function view():View
    {
        //filter data
        $year = Request::input('year');
        $number = Request::input('number');
        $name = Request::input('name');
        $valueCost = Request::input('valueCost');
        $returnToUser = Request::input('returnToUser');
        $cancellationMemo = Request::input('cancellationMemo');
        //take data
        $procurements = Procurement::where('status', '2')
            ->when($year, function ($query) use ($year) {
                $query->whereYear('receipt', $year);
            })
            ->when($number, function ($query) use ($number) {
                $query->where('number', 'like', '%' . $number . '%');
            })
            ->when($name, function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            })
            ->when($valueCost === '0', function ($query) {
                $query->whereBetween('user_estimate', [0, 100000000]); // 0 s.d < 100 Juta
            })
            ->when($valueCost === '1', function ($query) {
                $query->whereBetween('user_estimate', [100000000, 1000000000]); // >= 100 Juta s.d < 1 Miliar
            })
            ->when($valueCost === '2', function ($query) {
                $query->where('user_estimate', '>', 1000000000); // >= 1 Miliar
            })
            ->when($returnToUser, function ($query) use ($returnToUser) {
                $query->where('return_to_user', $returnToUser);
            })
            ->when($cancellationMemo, function ($query) use ($cancellationMemo) {
                $query->where('cancellation_memo', 'like', '%' . $cancellationMemo . '%');
            })
            ->get();
            // dd($procurements);
            return view ('recapitulation.cancel.result', compact ('year', 'procurements'));
        }
    }
