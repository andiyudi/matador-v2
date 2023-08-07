<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class ClassificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $classifications = Business::whereNotNull('parent_id');

            return DataTables::eloquent($classifications)
                ->addColumn('core_business_name', function (Business $classification) {
                    return $classification->parent->name;
                })
                ->addColumn('action', 'classification.action')
                ->toJson();
        }

        $coreBusinesses = Business::where('parent_id', null)->get();
        return view('master-data.classification', compact('coreBusinesses'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'core_business_id' => 'required|exists:businesses,id',
            'name' => 'required|string|max:255',
        ]);

        Business::create([
            'name' => $request->name,
            'parent_id' => $request->core_business_id,
        ]);

        return redirect()->route('classification.index')
            ->with('success', 'Classification data created successfully.');
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
