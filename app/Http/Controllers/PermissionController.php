<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\PermissionDataTable;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PermissionDataTable $dataTable)
    {
        return $dataTable->render('permission.index');
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
            'name' => 'required|unique:permissions',
            'guard_name' => 'required',
        ]);
        $permission = new Permission([
            'name' => $request->get('name'),
            'guard_name' => $request->get('guard_name'),
        ]);

        $permission->save();
        return redirect('/permission');
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
    public function edit(Permission $permission)
    {
        return view ('permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect('/permission');
    }
}
