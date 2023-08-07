<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CoreBusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coreBusinesses = Business::where('parent_id', null)->get();
        return view('master-data.core-business', compact('coreBusinesses'));
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
                'name' => 'required|unique:businesses',
            ]);

            $core_business = new Business([
                'name' => $request->get('name'),
            ]);

            $core_business->save();

            Alert::success('Success', 'Core Business added successfully!');
            return redirect('/core-business');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Alert::error('Error','Failed to add Core Business: ' . $e->errors()['name'][0]);
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            Alert::error('Error','Failed to add Core Business: ' . $e->getMessage());
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Business $core_business)
    {
        $request->validate([
            'name' => 'required|max:255'
        ]);

        $core_business->update($request->all());
        Alert::success('Success', 'Core Business updated successfully!');
        return redirect()->route('core-business.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Business $core_business)
    {
        $core_business->delete();
        Alert::success('Success', 'Core Business deleted successfully!');
        return redirect()->route('core-business.index');
    }
}
