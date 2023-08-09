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
            $partner = Partner::with(['businesses.parent', 'businesses.children'])
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

        return redirect()->route('partner.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Partner $partner)
    {
        $core_businesses = Business::whereNull('parent_id')->get();
        $classifications = Business::whereNotNull('parent_id')->get();

        $selectedCoreBusinesses = $partner->businesses->map(function ($business) {
            return $business->parent_id ?: $business->id;
        })->toArray();
        $selectedClassifications = $partner->businesses->pluck('id')->toArray();

        return view('partner.show', compact('partner', 'core_businesses', 'classifications' , 'selectedCoreBusinesses', 'selectedClassifications'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partner $partner)
    {
        $core_businesses = Business::whereNull('parent_id')->get();
        $classifications = Business::whereNotNull('parent_id')->get();

        $selectedCoreBusinesses = $partner->businesses->map(function ($business) {
            return $business->parent_id ?: $business->id;
        })->toArray();
        $selectedClassifications = $partner->businesses->pluck('id')->toArray();

        return view('partner.edit', compact('partner', 'core_businesses', 'classifications' , 'selectedCoreBusinesses', 'selectedClassifications'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partner $partner)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'domicility' => 'required',
            'area' => 'required',
            'director' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:partners,email,' . $partner->id,
            'capital' => 'required',
            'grade' => 'required',
            'reference' => 'required',
            'join_date' => 'required',
            'classification_id' => 'required|array'
        ]);
        $partner->update([
            'name' => $validatedData['name'],
            'address' => $validatedData['address'],
            'domicility' => $validatedData['domicility'],
            'area' => $validatedData['area'],
            'director' => $validatedData['director'],
            'phone' => $validatedData['phone'],
            'email' => $validatedData['email'],
            'capital' => $validatedData['capital'],
            'grade' => $validatedData['grade'],
            'reference' => $validatedData['reference'],
            'join_date' => $validatedData['join_date'],
            'classification_id' => $validatedData['classification_id'],
        ]);

        $partner->businesses()->sync($request->classification_id);
        Alert::success('Success', 'Vendor data successfully updated');

        return redirect()->route('partner.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $partner)
    {
        $partner->delete();
        return redirect()->route('partner.index');
    }

    public function getClassificationsByCoreBusiness(Request $request)
    {
        $coreBusinessId = $request->input('core_business_id');

        $classifications = Business::whereIn('parent_id', $coreBusinessId)->get();

        return response()->json($classifications);
    }
}
