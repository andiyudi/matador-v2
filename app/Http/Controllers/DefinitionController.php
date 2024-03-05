<?php

namespace App\Http\Controllers;

use App\Models\Definition;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DefinitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $definitions = Definition::all();
        return view ('master-data.definition', compact('definitions'));
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
                'name' => 'required|unique:definitions',
            ]);

            $definition = new Definition([
                'name' => $request->get('name'),
            ]);

            $definition->save();

            Alert::success('Success', 'Definition added successfully!');
            return redirect('/definitions');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Alert::error('Error','Failed to add Definition: ' . $e->errors()['name'][0]);
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            Alert::error('Error','Failed to add Definition: ' . $e->getMessage());
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
    public function update(Request $request, Definition $definition)
    {
        try {
            $request->validate([
                'name' => 'required|unique:definitions,name,$definition->id'
            ]);
            $definition->name = $request->input('name');
            $definition->save();
            Alert::success('Success', 'Definition updated successfully!');
            return redirect()->route('definitions.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Alert::error('Error', 'Failed to update Definition: ' . $e->getMessage());
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to update Definition: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Definition $definition)
    {
        // Periksa apakah definisi digunakan di procurementFile
        if ($definition->definition_procurement_files()->exists()) {
            // Definisi digunakan dalam file procurement, kembalikan pesan error atau lakukan tindakan lain yang sesuai
            Alert::error('Error', 'Definition is currently in use and cannot be deleted.');
            return redirect()->back();
        }

        // Jika definisi tidak digunakan dalam file procurement, hapus
        $definition->delete();

        // Redirect atau berikan pesan sukses jika diperlukan
        Alert::success('Success','Definition deleted successfully');
        return redirect()->route('definitions.index');
    }
}
