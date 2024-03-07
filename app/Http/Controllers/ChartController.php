<?php

namespace App\Http\Controllers;

use DB;
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
        $currentYear = Carbon::now()->year;
        $years = Procurement::where('status', '1')
            ->pluck(DB::raw('YEAR(receipt) as year'))
            ->merge([$currentYear]) // Menambahkan tahun saat ini ke dalam koleksi
            ->unique();
        // Mengambil path file logo
        $logoPath = public_path('assets/logo/cmnplogo.jpg');

        // Membaca file logo dan mengonversi menjadi base64
        $logoData = file_get_contents($logoPath);
        $logoBase64 = 'data:image/jpeg;base64,' . base64_encode($logoData);

        return view('procurement.chart.index', compact('divisions', 'officials', 'years', 'currentYear', 'logoBase64'));
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

                if ($request->filled('year')) {
                    $year = $request->year;

                    $query->whereRaw('YEAR(receipt) = ?', [$year]);
                }
            })
            ->addIndexColumn()
            ->rawColumns(['is_selected'])
            ->toJson();
    }

    public function barChart(Request $request)
    {
        $year = $request->year ?? Carbon::now()->year;

        // Dapatkan semua nama bulan dalam satu tahun
        $allMonths = array_map(function($month) use ($year) {
            return date("F-Y", strtotime("$year-$month-01"));
        }, range(1, 12));

        // Ambil data dari database
        $procurementsData = Procurement::where('status', '1')
            ->when($request->division, function ($query) use ($request){
                return $query->where('division_id', $request->division);
            })
            ->when($request->official, function ($query) use ($request){
                return $query->where('official_id', $request->official);
            })
            ->when($request->year, function ($query) use ($request){
                $year = $request->year;
                return $query->whereRaw('YEAR(receipt) = ?', [$year]);
            })
            ->selectRaw ('SUM(user_estimate) as user_estimates, SUM(deal_nego) as deal_negos, DATE_FORMAT(receipt, "%M-%Y") as month_year')
            ->groupBy('month_year')
            ->orderBy('month_year', 'desc')
            ->get();

        // Inisialisasi array dengan nilai nol untuk semua bulan
        $result = array_fill_keys($allMonths, ['user_estimates' => 0, 'deal_negos' => 0, 'user_percentages' => 0]);

        // Isi array dengan data yang diterima dari database
        foreach ($procurementsData as $data) {
            $user_percentage = $data->user_estimates != 0 ? round((($data->user_estimates - $data->deal_negos) / $data->user_estimates) * 100, 2) : 0;
            $result[$data->month_year] = [
                'user_estimates' => $data->user_estimates,
                'deal_negos' => $data->deal_negos,
                'user_percentages' => $user_percentage,
            ];
        }

        return response()->json(['procurementsData' => $result]);
    }

}
