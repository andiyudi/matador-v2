<?php

namespace App\Http\Controllers;

use App\Models\Official;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class OfficialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $officials = Official::all();
        return view('master-data.official', compact('officials'));
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
                'name' => 'required|unique:officials',
                'initials' => 'required|unique:officials',
            ]);

            $status = $request->has('status') ? '1' : '0';

            $official = new Official([
                'name' => $request->get('name'),
                'initials' => $request->get('initials'),
                'status' => $status,
            ]);

            $official->save();

            Alert::success('Success', 'Official added successfully!');
            return redirect('/officials');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->errors();
            if (isset($errorMessages['initials'])) {
                Alert::error('Error', 'Failed to add Official: ' . $errorMessages['initials'][0]);
            } elseif (isset($errorMessages['name'])) {
                Alert::error('Error', 'Failed to add Official: ' . $errorMessages['name'][0]);
            } else {
                Alert::error('Error', 'Failed to add Official');
            }
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to add Official: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Official $official)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Official $official)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Official $official)
    {
        try {
            $status = $request->input('status') ? '1' : '0';

            // Cek apakah input 'name' ada atau tidak
            $name = $request->has('name') ? $request->input('name') : $official->name;
            $initials = $request->has('initials') ? $request->input('initials') : $official->initials;

            $official->name = $name;
            $official->initials = $initials;
            $official->status = $status;

            $official->save();

            Alert::success('Success', 'Official updated successfully!');
            return redirect('/officials');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Alert::error('Error', 'Failed to update Official: ' . $e->getMessage());
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to update Official: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Official $official)
    {
        $official->delete();

        Alert::success('Success', 'Official deleted successfully!');
        return redirect()->route('officials.index');
    }
}
