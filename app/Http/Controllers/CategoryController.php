<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Business;
use Illuminate\Http\Request;
use App\Models\BusinessPartner;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $businessPartners = BusinessPartner::with(['partner', 'business'])->get();

            return datatables()->of($businessPartners)
                ->editColumn('partner_name', function ($businessPartner) {
                    return $businessPartner->partner->name;
                })
                ->editColumn('business_name', function ($businessPartner) {
                    return $businessPartner->business->name;
                })
                ->addColumn('core_business_name', function ($businessPartner) {
                    return $businessPartner->business->parent->name;
                })
                ->editColumn('status', function ($businessPartner){
                    if ($businessPartner->is_blacklist == 0) {
                        return '<span class="badge text-bg-success">Available</span>';
                    } elseif ($businessPartner->is_blacklist == 1) {
                        return '<span class="badge text-bg-danger">Blacklist</span>';
                    }
                })
                ->addColumn('action', function($data){
                    $button = '<button type="button" class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#blacklist-modal" data-category-id="'.$data->id.'">
                    Blacklist
                </button> ';
                    $button .= ' <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#whitelist-modal" data-category-id="'.$data->id.'">
                    Whitelist
                </button>';
                    return $button;
                })
                ->rawColumns(['status', 'action'])
                ->toJson();
        }
        return view('partner.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $partner = Partner::all();
        $business = Business::all();
        return view('partner.category.create', compact('partner', 'business'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'partner' => 'required|exists:partners,id',
                'business' => 'required|exists:businesses,id'
            ]);

            $partnerId = $request->input('partner');
            $businessId = $request->input('business');

            if (!Partner::whereHas('businesses', function ($query) use ($businessId) {
                $query->where('business_id', $businessId);
            })->where('id', $partnerId)->exists()) {
                Partner::find($partnerId)->businesses()->attach($businessId);
                Alert::success('Success', 'Vendor with selected classification created successfully.');
            } else {
                Alert::error('Error', 'Vendor with selected classification already exists.');
            }

            return redirect()->route('category.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to create category vendor: ' . $e->getMessage());
            return redirect()->back();
        }
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
