<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Division;
use App\Models\Official;
use App\Models\Procurement;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ChartController extends Controller
{
    public function index()
    {
        $divisions = Division::where('status', '1')->get();
        $officials = Official::where('status', '1')->get();
        return view('procurement.chart.index', compact('divisions', 'officials'));
    }

    public function procurementsData(Request $request)
    {
        $procurements = Procurement::with('tenders.businessPartners.partner')
        ->orderByDesc('number')
        ->where('status', '1');

        return DataTables::eloquent($procurements)
            ->editColumn('division', function ($procurement) {
                return $procurement->division->code;
            })
            ->editColumn('official', function ($procurement) {
                return $procurement->official->initials;
            })
            ->editColumn('user_estimate', function ($procurement) {
                return 'Rp. ' . number_format($procurement->user_estimate, 0, ',', '.');
            })
            ->editColumn('deal_nego', function ($procurement) {
                return 'Rp. ' . number_format($procurement->deal_nego, 0, ',', '.');
            })
            ->editColumn('user_percentage', function ($procurement) {
                if ($procurement->user_percentage !== null) {
                    return number_format($procurement->user_percentage, 2, ',', '.') . '%';
                } else {
                    return '';
                }
            })
            ->editColumn('technique_estimate', function ($procurement) {
                return 'Rp. ' . number_format($procurement->technique_estimate, 0, ',', '.');
            })
            ->addColumn('technique_difference', function ($procurement) {
                $techniqueEstimate = $procurement->technique_estimate;
                $dealNego = $procurement->deal_nego;

                // Calculate the difference and format it as needed
                $difference = $techniqueEstimate - $dealNego;

                // return number_format($difference, 2);
                return 'Rp. ' . number_format($difference, 0, ',', '.');
            })
            ->editColumn('technique_percentage', function ($procurement) {
                // Pastikan bahwa technique_percentage tidak null sebelum memformat
                if ($procurement->technique_percentage !== null) {
                    return number_format($procurement->technique_percentage, 2, ',', '.') . '%';
                } else {
                    return '';
                }
            })
            ->addColumn('is_selected', function ($procurement) {
                if ($procurement->status == "2") {
                    return '<span class="badge rounded-pill text-bg-danger">Canceled</span>';
                } elseif ($procurement->status == "0") {
                    return '<span class="badge rounded-pill text-bg-info">Process</span>';
                }

                // Pengecekan is_selected pada tender
                foreach ($procurement->tenders as $tender) {
                    $selectedVendor = $tender->businessPartners->first(function ($businessPartner) {
                        return $businessPartner->pivot->is_selected === '1';
                    });

                    if ($selectedVendor) {
                        return $selectedVendor->partner->name;
                    }
                }

                return '<span class="badge text-bg-dark">Unknown</span>'; // Jika tidak ada businessPartner dengan is_selected '1'
            })
            ->filter(function ($query) use ($request) {
                if ($request->filled('division')) {
                    $query->where('division_id', $request->division);
                }

                if ($request->filled('official')) {
                    $query->where('official_id', $request->official);
                }
            })
            ->addIndexColumn()
            ->rawColumns(['is_selected'])
            ->toJson();
    }

    public function barChart(Request $request)
    {
        $procurements = Procurement::with('tenders.businessPartners.partner')
            ->orderByDesc('number')
            ->where('status', '1');

        // Filter by division
        if ($request->filled('division')) {
            $procurements->where('division_id', $request->division);
        }

        // Filter by official
        if ($request->filled('official')) {
            $procurements->where('official_id', $request->official);
        }

        $chartData = $procurements->get()->groupBy(function ($item) {
            return Carbon::parse($item->receipt)->format('M Y');
        })->map(function ($groupedItems) {
            return [
                'labels' => $groupedItems->pluck('receipt')->first(),
                'userValues' => $groupedItems->sum(fn($item) => (float) str_replace(['Rp. ', '.', ','], '', $item['user_estimate'])),
                'dealNegoValues' => $groupedItems->sum(fn($item) => (float) str_replace(['Rp. ', '.', ','], '', $item['deal_nego'])),
            ];
        });

        return response()->json(['chartData' => $chartData]);
    }


}
