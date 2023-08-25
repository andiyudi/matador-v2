<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Procurement;
use Illuminate\Http\Request;
use App\Models\BusinessPartner;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $tenders = Procurement::with(['businessPartners.partner'])
                ->whereNotNull('estimation')
                ->whereNotNull('pic_user')
                ->whereNotNull('business_id')
                ->orderByDesc('created_at')
                ->get();

            $statusLabels = [
                '0' => '<span class="badge text-bg-info">Process</span>',
                '1' => '<span class="badge text-bg-success">Success</span>',
                '2' => '<span class="badge text-bg-secondary">Repeat</span>',
                '3' => '<span class="badge text-bg-danger">Cancel</span>',
            ];

            return DataTables::of($tenders)
                ->addColumn('number', function ($tender) {
                    return $tender->number;
                })
                ->addColumn('job_name', function ($tender) {
                    return $tender->name;
                })
                ->addColumn('division', function ($tender) {
                    return $tender->division->code;
                })
                ->addColumn('estimation', function ($tender) {
                    return $tender->estimation;
                })
                ->addColumn('pic_user', function ($tender) {
                    return $tender->pic_user;
                })
                ->addColumn('vendors', function ($tender) {
                    $vendors = $tender->businessPartners->map(function ($businessPartner, $index) {
                        return ($index + 1) . '. ' . $businessPartner->partner->name;
                    })->implode("<br>");
                    return $vendors;
                })
                ->addColumn('status', function ($tender) use ($statusLabels) {
                    $status = $tender->businessPartners->pluck('pivot.status')->first(); // Assuming status is stored in pivot table
                    return $statusLabels[$status] ?? '<span class="badge text-bg-dark">Unknown</span>';
                })
                ->addColumn('action', function ($tender) {
                    $route = 'offer';
                    $procurement_id = $tender->id;
                    return view('offer.action', compact('route', 'tender', 'procurement_id'));
                })
                ->addIndexColumn()
                ->rawColumns(['vendors', 'status'])
                ->make(true);
        }
        return view('offer.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usedProcurementIds = DB::table('business_partner_procurement')
        ->where('status', '!=', '2')
        ->pluck('procurement_id');

        $procurements = Procurement::where('status', '0')
            ->whereNotIn('id', $usedProcurementIds)
            ->get();
        $business = Business::all();
        return view('offer.create', compact('procurements', 'business'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'procurement_id' => 'required|exists:procurements,id',
                'selected_partners' => 'required|array',
                'estimation' => 'required',
                'pic_user' => 'required',
                'business' => 'required',
            ]);

            $procurementId = $request->input('procurement_id');
            $selectedPartners = $request->input('selected_partners');

            $procurement = Procurement::findOrFail($procurementId);
            $procurement->update([
                'estimation' => $request->input('estimation'),
                'pic_user' => $request->input('pic_user'),
                'business_id' => $request->input('business'),
            ]);

            $procurement->businessPartners()->attach($selectedPartners);

            Alert::success('Success', 'Process tender created successfully');
            return redirect()->route('offer.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return redirect()->back()->with('error', 'Failed to save data: ' . $e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Offer $offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($procurement_id)
    {
        $usedProcurementIds = DB::table('business_partner_procurement')
            ->where('status', '!=', '2')
            ->pluck('procurement_id');

        $procurements = Procurement::where('status', '0')
            ->whereNotIn('id', $usedProcurementIds)
            ->get();
        $business = Business::all();

        $selected_procurement = Procurement::findOrFail($procurement_id);

        $procurements->push($selected_procurement);

        $selected_business_id = $selected_procurement->business_id;
        $business_partners = BusinessPartner::where('business_id', $selected_business_id)->get();

        $selected_business_partner = DB::table('business_partner_procurement')
            ->where('procurement_id', $procurement_id)
            ->pluck('business_partner_id');

        return view('offer.edit', compact('business', 'procurements', 'selected_procurement', 'business_partners', 'selected_business_partner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $procurement_id)
    {
        // dd($procurement_id);
        try {
            $request->validate([
                'procurement_id' => 'required|exists:procurements,id',
                'selected_partners' => 'required|array',
                'estimation' => 'required',
                'pic_user' => 'required',
                'business' => 'required',
            ]);

            $procurementId = $request->input('procurement_id');
            $selectedPartners = $request->input('selected_partners');

            $procurement = Procurement::findOrFail($procurementId);
            $procurement->update([
                'estimation' => $request->input('estimation'),
                'pic_user' => $request->input('pic_user'),
                'business_id' => $request->input('business'),
            ]);

            DB::table('business_partner_procurement')
            ->where('procurement_id', $procurement_id)
            ->delete();

            foreach ($selectedPartners as $partnerId) {
                DB::table('business_partner_procurement')->insert([
                    'procurement_id' => $procurementId,
                    'business_partner_id' => $partnerId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            Alert::success('Success', 'Process tender updated successfully');
            return redirect()->route('offer.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return redirect()->back()->with('error', 'Failed to save data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offer $offer)
    {
        //
    }
}
