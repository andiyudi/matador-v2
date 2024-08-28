<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
                    return '<span class="badge bg-warning">Inactive</span>';
                } else {
                    return '<span class="badge bg-danger">Error</span>';
                }
            })
            ->editColumn('expired_at', function ($data) {
                return Carbon::parse($data->expired_at)->format('d-m-Y');
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
            'npwp' => 'required',
            'address' => 'required',
            'domicility' => 'required',
            'area' => 'required',
            'director' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'capital' => 'required',
            'grade' => 'required',
            'join_date' => 'required',
            'reference' => 'required',
            'start_deed' => 'required',
            'end_deed' => 'required',
        ]);

        // simpan data vendor
        $vendor = new Partner;
        $vendor->name = $request->name;
        $vendor->npwp = $request->npwp;
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
        $vendor->start_deed = $request->start_deed;
        $vendor->end_deed = $request->end_deed;
        $vendor->expired_at = date('Y') . '-12-31';
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
            'npwp' => 'required',
            'address' => 'required',
            'domicility' => 'required',
            'area' => 'required',
            'director' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'capital' => 'required',
            'grade' => 'required',
            'reference' => 'required',
            'join_date' => 'required',
            'start_deed' => 'required',
            'end_deed' => 'required',
        ]);
        $partner->update([
            'name' => $validatedData['name'],
            'npwp' => $validatedData['npwp'],
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
            'start_deed' => $validatedData['start_deed'],
            'end_deed' => $validatedData['end_deed'],
        ]);

        Alert::success('Success', 'Vendor data successfully updated');

        return redirect()->route('partner.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $partner)
    {
        if ($partner->businesses()->exists()) {
            Alert::error('Error', 'Partner data can\'t be deleted, it is used in Vendor Category.');
            return redirect()->route('partner.index');
        }
        $partner->delete();

        Alert::success('Success', 'Vendor data successfully deleted');

        return redirect()->route('partner.index');
    }

    public function getPartnersByBusiness($business_id)
    {
        $partners = BusinessPartner::where('business_id', $business_id)
            ->where('is_blacklist', '!=', '1')
            ->with('partner')
            ->join('partners', 'business_partner.partner_id', '=', 'partners.id')
            ->select('business_partner.id as business_partner_id', 'partners.*') // Make sure this line is correct
            ->orderBy('partners.status', 'asc')
            ->get();

        return response()->json($partners);
    }


}
