<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Business;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $partner = Partner::with('businesses:name')
                ->orderByDesc('created_at')
                ->get();
            return DataTables::of($partner)->make(true);
        }

        $partner = Partner::all();

        return view('partner.index', compact('partner'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $core_businesses = Business::whereNull('parent_id')->get(); // Data businesses yang tidak memiliki parent_id
        $classifications = Business::whereNotNull('parent_id')->get(); // Data businesses yang memiliki parent_id

        return view('partner.create', compact('core_businesses', 'classifications'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       // validasi input
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'domicility' => 'required',
            'area' => 'required',
            'director' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:partners',
            'capital' => 'required',
            'grade' => 'required',
            'join_date' => 'required',
            'reference' => 'required',
            'classification_id' => 'required|array'
        ]);

        // simpan data vendor
        $vendor = new Partner;
        $vendor->name = $request->name;
        $vendor->address = $request->address;
        $vendor->domicility = $request->domicility;
        $vendor->area = $request->area;
        $vendor->director = $request->director;
        $vendor->phone = $request->phone;
        $vendor->email = $request->email;
        $vendor->capital = $request->capital;
        $vendor->grade = $request->grade;
        $vendor->join_date = $request->join_date;
        $vendor->reference = $request->reference;
        $vendor->save();

        // hubungkan vendor dengan classification yang dipilih
        $vendor->businesses()->attach($request->classification_id);

        Alert::success('Success', 'Vendor data successfully stored');

        // return redirect()->route('vendors.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Partner $partner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partner $partner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partner $partner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $partner)
    {
        //
    }

    public function getClassificationsByCoreBusiness(Request $request)
    {
        $coreBusinessId = $request->input('core_business_id');

        $classifications = Business::whereIn('parent_id', $coreBusinessId)->get();

        return response()->json($classifications);
    }
}
