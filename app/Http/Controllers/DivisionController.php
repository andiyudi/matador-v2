<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;
use App\DataTables\DivisionDataTable;
use RealRashid\SweetAlert\Facades\Alert;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DivisionDataTable $dataTable)
    {
        return $dataTable->render('master-data.division');
        // $divisions = Division::all();
        // return view('master-data.division', compact('divisions'));
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
                'name' => 'required|unique:divisions',
            ]);

            $status = $request->has('status') ? '1' : '0';

            $division = new Division([
                'name' => $request->get('name'),
                'status' => $status,
            ]);

            $division->save();

            Alert::success('Success', 'Division added successfully!');
            return redirect('/divisions');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Alert::error('Error', 'Failed to add Division: ' . $e->errors()['name'][0]);
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to add Division: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Division $division)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Division $division)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Division $division)
    {
        try {
            $status = $request->input('status') ? '1' : '0';

            // Cek apakah input 'name' ada atau tidak
            $name = $request->has('name') ? $request->input('name') : $division->name;

            $division->name = $name;
            $division->status = $status;

            $division->save();

            Alert::success('Success', 'Division updated successfully!');
            return redirect('/divisions');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Alert::error('Error', 'Failed to update Division: ' . $e->getMessage());
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to update Division: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Division $division)
    {
        $division->delete();

        Alert::success('Success', 'Division deleted successfully!');
        return redirect()->route('divisions.index');
    }
}
