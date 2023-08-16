<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Business;
use Illuminate\Http\Request;
use App\Models\CategoryFiles;
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
                ->editColumn('blacklist_at', function ($businessPartner) {
                    return $businessPartner->blacklist_at;
                })
                ->editColumn('can_whitelist_at', function ($businessPartner) {
                    return $businessPartner->can_whitelist_at;
                })
                ->editColumn('whitelist_at', function ($businessPartner) {
                    return $businessPartner->whitelist_at;
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
    public function show(string $id)
    {
        //
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
        // dd($request->all());
        try {
            $this->validate($request, [
                'file' => 'required',
                'id_category' => 'required',
                'is_blacklist' => 'required',
                'type' => 'required',
                'notes' => 'required',
            ]);
            $category_id = BusinessPartner::findOrFail($request->id_category);

            if ($request->hasFile('file')){
                $file = $request->file('file');
                $name = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('category_files', $name, 'public');

                $fileCategory = new CategoryFiles();

                $fileCategory->category_id = $category_id->id;
                $fileCategory->name        = $name;
                $fileCategory->path        = $path;
                $fileCategory->type        = $request->type;
                $fileCategory->notes       = $request->notes;

                $fileCategory->save();

                if ($request->type == 0) {
                    $category_id->update([
                        'is_blacklist' => $request->type,
                        'whitelist_at' => now(),
                    ]);
                } else if ($request->type == 1) {
                    $category_id->update([
                        'is_blacklist' => $request->type,
                        'blacklist_at' => now(),
                        'can_whitelist_at' => now()->addYears(2),
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
    public function destroy(string $id)
    {
        //
    }
}
