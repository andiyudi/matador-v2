<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Business;
use Illuminate\Http\Request;
use App\Models\BusinessPartner;
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
            $partner = Partner::orderByDesc('created_at')
                ->get();
            return DataTables::of($partner)
            ->editColumn('grade', function ($partner_grade){
                if ($partner_grade->grade==0){
                    return 'Kecil';
                } else if ($partner_grade->grade==1){
                    return 'Menengah';
                } else if ($partner_grade->grade==2){
                    return 'Besar';
                } else {
                    return 'Error';
                }
            })
            ->editColumn('status', function ($partner_status){
                if ($partner_status->status==0){
                    return '<span class="badge bg-info">Registered</span>';
                } else if ($partner_status->status==1){
                    return '<span class="badge bg-success">Active</span>';
                } else if ($partner_status->status==2){
                    return '<span class="badge bg-warning">InActive</span>';
                } else {
                    return '<span class="badge bg-danger">Error</span>';
                }
            })
            ->addColumn('action', function($data){
                $route = 'partner';
                return view ('partner.action', compact ('route', 'data'));
            })
            ->rawColumns(['status'])
            ->make(true);
        }

        $partner = Partner::all();

        return view('partner.index', compact('partner'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('partner.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       // validasi input
        $validatedData = $request->validate([
            'name' => 'required|unique:partners',
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

        Alert::success('Success', 'Vendor data successfully stored');

        return redirect()->route('partner.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Partner $partner)
    {
        return view('partner.show', compact('partner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partner $partner)
    {
        return view('partner.edit', compact('partner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partner $partner)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:partners,name,'.$partner->id,
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
        ]);

        Alert::success('Success', 'Vendor data successfully updated');

        return redirect()->route('partner.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $partner)
    {
        $partner->delete();

        Alert::success('Success', 'Vendor data successfully deleted');

        return redirect()->route('partner.index');
    }

    public function getPartnersByBusiness($business_id)
    {
        $partners = BusinessPartner::where('business_id', $business_id)
            ->where('is_blacklist', '!=', '1')
            ->with('partner')
            ->get();
        return response()->json($partners);
    }

}
