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
                ->filterColumn('core_business_name', function($query, $keyword) {
                    $query->whereHas('parent', function($q) use ($keyword) {
                        $q->where('name', 'like', "%$keyword%");
                    });
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
        try {
            $request->validate([
                'core_business_id' => 'required|exists:businesses,id',
                'name' => 'required|string|max:255|unique:businesses,name,NULL,id,parent_id,' . $request->core_business_id,
            ], [
                'name.unique' => 'The name already exists for the selected core business.',
            ]);

            Business::create([
                'name' => $request->name,
                'parent_id' => $request->core_business_id,
            ]);

            Alert::success('Success', 'Classification data created successfully.');
            return redirect()->route('classification.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Alert::error('Error','Failed to add Classification: ' . $e->errors()['name'][0]);
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            Alert::error('Error','Failed to add Classification: ' . $e->getMessage());
            return redirect()->back()->withInput();
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
        $classification = Business::find($id);
        $coreBusinesses = Business::where('parent_id', null)->get();

        return response()->json([
            'name' => $classification->name,
            'core_business_id' => $classification->parent_id,
            'coreBusinesses' => $coreBusinesses
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $classification = Business::find($id);

            if (!$classification) {
                return response()->json(['message' => 'Classification not found'], 404);
            }

            $data = $request->validate([
                'name' => 'required|string',
                'core_business_id' => 'required|exists:businesses,id',
            ]);

            // Check if the updated core_business_id is different from the current parent_id
            if ($classification->parent_id != $data['core_business_id']) {
                // Check if the updated core_business_id and name combination already exists
                if (Business::where('name', $data['name'])
                    ->where('parent_id', $data['core_business_id'])
                    ->where('id', '!=', $id)
                    ->exists()) {
                    return response()->json(['error' => 'The combination of classification and core business already exists.'], 422);
                }
            } else {
                // Check if the name already exists for the same core_business_id
                if (Business::where('name', $data['name'])
                    ->where('parent_id', $data['core_business_id'])
                    ->where('id', '!=', $id)
                    ->exists()) {
                    return response()->json(['error' => 'Core business with the same classification already exists.'], 422);
                }
            }

            $classification->update([
                'name' => $data['name'],
                'parent_id' => $data['core_business_id']
            ]);

            return response()->json(['message' => 'Classification updated successfully']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update Classification: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $classification = Business::find($id);

        if (!$classification) {
            return response()->json(['message' => 'Classification not found'], 404);
        }

         // Cek apakah classification terkait digunakan dalam procurement
        if ($classification->procurements()->count() > 0) {
            return response()->json(['message' => 'Classification data can\'t be deleted, it is associated with procurement(s)'], 422);
        }

        $classification->delete();

        return response()->json(['message' => 'Classification deleted successfully']);
    }

}
