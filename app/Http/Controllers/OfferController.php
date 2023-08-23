<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Business;
use App\Models\Procurement;
use App\Models\BusinessPartner;
use Illuminate\Http\Request;
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
            $tenders = Offer::with(['procurement', 'category.partner'])
            ->orderByDesc('created_at')
            ->get();

            $groupedTenders = $tenders->groupBy('procurement.number');

            return DataTables::of($groupedTenders)
                ->addColumn('procurement', function ($group) {
                    return $group->first()->procurement->number;
                })
                ->addColumn('job_name', function ($group) {
                    return $group->first()->procurement->name;
                })
                ->addColumn('division', function ($group) {
                    return $group->first()->procurement->division->code;
                })
                ->addColumn('estimation', function ($group) {
                    return $group->first()->procurement->estimation;
                })
                ->addColumn('pic_user', function ($group) {
                    return $group->first()->procurement->pic_user;
                })
                ->addColumn('vendors', function ($group) {
                    $vendors = $group->map(function ($item, $index) {
                        return ($index + 1) . '. ' . $item->category->partner->name;
                    })->implode("<br>");
                    return $vendors;
                })
                ->addColumn('status', function ($group) {
                    if ($group->first()->status == '0') {
                        return '<span class="badge text-bg-info">Process</span>';
                    } elseif ($group->first()->status == '1') {
                        return '<span class="badge text-bg-success">Success</span>';
                    } elseif ($group->first()->status == '2') {
                        return '<span class="badge text-bg-secondary">Repeat</span>';
                    } elseif ($group->first()->status == '3') {
                        return '<span class="badge text-bg-danger">Cancel</span>';
                    }
                    return '<span class="badge text-bg-dark">Unknown</span>';
                })
                ->addColumn('action', function($group){
                    $route = 'offer';
                    $procurement_id = $group[0]->procurement->id;
                    return view('offer.action', compact('route', 'group', 'procurement_id'));
                })
                ->addindexcolumn()
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
        $usedProcurementIds = Offer::where('status', '!=', '2')->pluck('procurement_id');

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

            foreach ($selectedPartners as $partnerId) {
                Offer::create([
                    'procurement_id' => $procurementId,
                    'category_id' => $partnerId,
                ]);
            }

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
        $usedProcurementIds = Offer::where('status', '!=', '2')->pluck('procurement_id');

        $procurements = Procurement::where('status', '0')
            ->whereNotIn('id', $usedProcurementIds)
            ->get();
        $business = Business::all();

        $selected_procurement = Procurement::findOrFail($procurement_id);

        $procurements->push($selected_procurement);

        $selected_business_id = $selected_procurement->business_id;
        $business_partners = BusinessPartner::where('business_id', $selected_business_id)->get();

        $selected_business_partner = Offer::where('procurement_id', $procurement_id)->pluck('category_id');

        return view('offer.edit', compact('business', 'procurements', 'selected_procurement', 'business_partners', 'selected_business_partner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Offer $offer)
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

            $offer->procurement_id = $procurementId;
            $offer->save();

            $offer->category()->detach();
            $offer->category()->attach($selectedPartners);

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
