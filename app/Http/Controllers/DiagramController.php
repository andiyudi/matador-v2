<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\Division;
use App\Models\Official;
use App\Models\Procurement;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DiagramController extends Controller
{
    public function index()
    {
        $divisions = Division::where('status', '1')->get();
        $officials = Official::where('status', '1')->get();
        $currentYear = Carbon::now()->year;
        $years = Procurement::pluck(DB::raw('YEAR(receipt) as year'))
            ->merge([$currentYear]) // Menambahkan tahun saat ini ke dalam koleksi
            ->unique();
        // Mengambil path file logo
        $logoPath = public_path('assets/logo/cmnplogo.jpg');

        // Membaca file logo dan mengonversi menjadi base64
        $logoData = file_get_contents($logoPath);
        $logoBase64 = 'data:image/jpeg;base64,' . base64_encode($logoData);

        return view('procurement.diagram.index', compact('divisions', 'officials', 'years', 'currentYear', 'logoBase64'));
    }

    public function procurementsData(Request $request)
    {
        $procurements = Procurement::orderByDesc('number');

        return DataTables::eloquent($procurements)
            ->editColumn('division', function ($procurement) {
                return $procurement->division->name;
            })
            ->editColumn('official', function ($procurement) {
                return $procurement->official->name;
            })
            ->editColumn('status', function ($data) {
                if ($data->status == 0) {
                    return '<span class="badge text-bg-info">Process</span>';
                } elseif ($data->status == 1) {
                    return '<span class="badge text-bg-success">Success</span>';
                } elseif ($data->status == 2) {
                    return '<span class="badge text-bg-danger">Canceled</span>';
                }
                return '<span class="badge text-bg-dark">Unknown</span>';
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
            ->rawColumns(['status'])
            ->toJson();
    }

    public function pieDiagram(Request $request)
    {
        $procurements = Procurement::orderByDesc('number');

        // Terapkan filter yang sama seperti dalam procurementsData()
        if ($request->filled('division')) {
            $procurements->where('division_id', $request->division);
        }

        if ($request->filled('official')) {
            $procurements->where('official_id', $request->official);
        }

        if ($request->filled('year')) {
            $year = $request->year;
            $procurements->whereRaw('YEAR(receipt) = ?', [$year]);
        }

        // Sekarang, dapatkan semua data yang sesuai setelah menerapkan filter
        $filteredProcurements = $procurements->get();

        // Menghitung jumlah data untuk setiap status
        $statusCounts = $filteredProcurements->groupBy('status')->map->count();

        // Mendefinisikan label dan warna untuk setiap status
        $labels = [
            'Procurements In Process',
            'Successfully Procurements',
            'Cancelled Procurements',
        ];

        $colors = [
            'rgba(54, 162, 235, 0.6)', // Process
            'rgba(75, 192, 102, 0.6)', // Success
            'rgba(255, 99, 132, 0.6)', // Canceled
        ];

        // Menghitung total data
        $total = $statusCounts->sum();

        // Mengonversi jumlah data ke dalam bentuk yang dapat digunakan oleh diagram pie
        $data = [];
        foreach ($labels as $index => $label) {
            $count = $statusCounts->get($index, 0);
            $percentage = $total > 0 ? round(($count / $total) * 100, 2) : 0; // Menghitung persentase
            $data[] = [
                'label' => $label,
                'value' => $count,
                'percentage' => $percentage, // Menambahkan persentase ke data
                'color' => $colors[$index]
            ];
        }

        // Jika tidak ada data yang cocok, kembalikan data default
        if (empty($data)) {
            $data = [
                [
                    'label' => 'No Data Available',
                    'value' => 0,
                    'percentage' => 0,
                    'color' => 'rgba(169, 169, 169, 0.6)', // Warna abu-abu
                ]
            ];
        }

        return response()->json($data);
    }

}
