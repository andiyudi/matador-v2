<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Business;
use App\Models\Procurement;
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
                    return $group->first()->status;
                })
                ->addColumn('action', function($group){
                    $route = 'offer';
                    $procurement_id = $group[0]->procurement->id;
                    return view('offer.action', compact('route', 'group', 'procurement_id'));
                })
                ->addindexcolumn()
                ->rawColumns(['vendors'])
                ->make(true);
        }
        return view('offer.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $procurements = Procurement::where('status', '0')->get();
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
            ]);

            $procurementId = $request->input('procurement_id');
            $selectedPartners = $request->input('selected_partners');

            $procurement = Procurement::findOrFail($procurementId);
            $procurement->update([
                'estimation' => $request->input('estimation'),
                'pic_user' => $request->input('pic_user'),
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
    public function edit(Offer $offer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Offer $offer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offer $offer)
    {
        //
    }
}
