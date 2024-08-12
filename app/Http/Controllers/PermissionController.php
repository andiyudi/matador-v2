<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\PermissionDataTable;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:permission-index');
        $this->middleware('permission:permission-create');
        $this->middleware('permission:permission-edit');
        $this->middleware('permission:permission-delete');
    }
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
        // Validasi input dari form jika diperlukan
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
            'guard_name' => 'required',
        ]);

        // Perbarui data permission
        $permission->name = $request->input('name');
        $permission->guard_name = $request->input('guard_name');

        // Simpan perubahan ke dalam database
        $permission->save();

        // Redirect ke halaman lain atau tampilkan pesan sukses
        Alert::success('Success', 'Permission updated successfully');
        return redirect()->route('permission.index');
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
