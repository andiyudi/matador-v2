<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Partner;
use App\Models\Business;
use Illuminate\Http\Request;
use App\Models\BusinessPartner;
use App\Models\BusinessPartnerFiles;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $businessPartners = BusinessPartner::with(['partner', 'business'])->get();

            return DataTables::of($businessPartners)
                ->editColumn('partner_name', function ($businessPartner) {
                    return $businessPartner->partner->name;
                })
                ->editColumn('business_name', function ($businessPartner) {
                    return $businessPartner->business->name;
                })
                ->addColumn('core_business_name', function ($businessPartner) {
                    return $businessPartner->business->parent->name;
                })
                ->editColumn('blacklist_at', function ($businessPartner) {
                    return $businessPartner->blacklist_at ? Carbon::parse($businessPartner->blacklist_at)->format('d-m-Y') : '';
                })
                ->editColumn('can_whitelist_at', function ($businessPartner) {
                    return $businessPartner->can_whitelist_at ? Carbon::parse($businessPartner->can_whitelist_at)->format('d-m-Y') : '';
                })
                ->editColumn('whitelist_at', function ($businessPartner) {
                    return $businessPartner->whitelist_at ? Carbon::parse($businessPartner->whitelist_at)->format('d-m-Y') : '';
                })
                ->editColumn('status', function ($businessPartner){
                    if ($businessPartner->is_blacklist == 0) {
                        return '<span class="badge text-bg-success">Available</span>';
                    } elseif ($businessPartner->is_blacklist == 1) {
                        return '<span class="badge text-bg-danger">Blacklist</span>';
                    }
                })
                ->addColumn('action', function($data){
                    $route = 'category';
                    return view ('partner.category.action', compact ('route', 'data'));
                })
                ->rawColumns(['status'])
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
    public function show($category_id)
    {
        $businessPartner = BusinessPartner::findOrFail($category_id);
        $partner = $businessPartner->partner->name;
        $business = $businessPartner->business->name;
        $core_business = $businessPartner->business->parent->name;
        $data = [
            'partner' => $partner,
            'business' => $business,
            'core_business' => $core_business,
        ];
        $files = BusinessPartnerFiles::where('business_partner_id', $category_id)
        ->orderByDesc('created_at')
        ->get();
        return view('partner.category.show', compact('files', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = BusinessPartner::findOrFail($id);
        return view ('partner.category.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'file' => 'required',
                'id_category' => 'required',
                'is_blacklist' => 'required',
                'type' => 'required',
                'notes' => 'required',
                'blacklist_at' => 'required',
            ]);
            $category_id = BusinessPartner::findOrFail($request->id_category);

            if ($request->hasFile('file')){
                $file = $request->file('file');
                $name = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('files_partner/category', $name, 'public');

                $fileCategory = new BusinessPartnerFiles();

                $fileCategory->business_partner_id  = $category_id->id;
                $fileCategory->name                 = $name;
                $fileCategory->path                 = $path;
                $fileCategory->type                 = $request->type;
                $fileCategory->notes                = $request->notes;

                $fileCategory->save();

                if ($request->type == 0) {
                    $category_id->update([
                        'is_blacklist' => $request->type,
                        'whitelist_at' => now(),
                    ]);
                } else if ($request->type == 1) {
                    $blacklistDate = Carbon::parse($request->blacklist_at); // Pastikan ini adalah tanggal yang valid
                    $category_id->update([
                        'is_blacklist' => $request->type,
                        'blacklist_at' => $request->blacklist_at,
                        'can_whitelist_at' => $blacklistDate->addYears(2),
                    ]);
                }

                Alert::success('Success','File added successfully');
                return redirect()->route('category.index');
            } else {
                    Alert::error('Error', 'File upload failed');
                }
        } catch (\Throwable $th) {
            Alert::error('Error', 'An error occurred' . $th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $file = BusinessPartnerFiles::findOrFail($id);
        $file->delete();

        Alert::success('Success', 'File has been deleted successfully');
        return redirect()->route('category.show', $file->business_partner_id);
    }
}
