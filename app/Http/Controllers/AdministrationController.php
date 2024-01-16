<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Division;
use App\Models\Official;
use App\Models\Procurement;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class AdministrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $procurements = Procurement::with('tenders.businessPartners.partner')
            ->where('status', '!=', '0')
            ->orderByDesc('number')
            ->get();
            return DataTables::of($procurements)
            ->editColumn('receipt', function ($procurement) {
                return Carbon::parse($procurement->receipt)->format('d-M-Y');
            })
            ->editColumn('division', function ($procurement) {
                return $procurement->division->name;
            })
            ->editColumn('official', function ($procurement) {
                return $procurement->official->name;
            })
            ->editColumn('user_estimate', function ($procurement) {
                return 'Rp. ' . number_format($procurement->user_estimate, 0, ',', '.');
            })
            ->editColumn('technique_estimate', function ($procurement) {
                return 'Rp. ' . number_format($procurement->technique_estimate, 0, ',', '.');
            })
            ->editColumn('deal_nego', function ($procurement) {
                return 'Rp. ' . number_format($procurement->deal_nego, 0, ',', '.');
            })
            ->addColumn('is_selected', function ($procurement) {
                foreach ($procurement->tenders as $tender) {
                    $selectedVendor = $tender->businessPartners->first(function ($businessPartner) {
                        return $businessPartner->pivot->is_selected === '1';
                    });

                    if ($selectedVendor) {
                        return $selectedVendor->partner->name;
                    }
                }

                return '<span class="badge text-bg-danger">Procurement<br>Canceled</span>'; // Jika tidak ada businessPartner dengan is_selected '1'
            })
            ->addColumn('action', function ($procurement) {
                $url = route('administration.edit', ['administration' => $procurement->id]);
                return '<a href="' . $url . '" class="btn btn-sm btn-primary">Administration</a>';
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'is_selected'])
            ->make(true);
            }
        return view('procurement.administration.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $procurement = Procurement::findOrFail($id);
        $divisions = Division::where('status', '1')->get();
        $officials = Official::where('status', '1')->get();

        $tendersCount = $procurement->tendersCount();
        $procurementStatus = $procurement->status;

        return view('procurement.administration.edit', compact('procurement', 'divisions', 'officials', 'tendersCount', 'procurementStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'user_estimate' => 'required',
                'technique_estimate' => 'required',
                'deal_nego' => 'required',
            ]);

            $procurement = Procurement::find($id);

            $procurement->user_estimate = str_replace('.', '', $request->user_estimate);
            $procurement->technique_estimate = str_replace('.', '', $request->technique_estimate);
            $procurement->deal_nego = str_replace('.', '', $request->deal_nego);

            $procurement->save();

            Alert::success('Success', 'Procurement data has been updated.');
            return redirect()->route('administration.index');
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->back(); // Cetak pesan kesalahan untuk mendiagnosis
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
