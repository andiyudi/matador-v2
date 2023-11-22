<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use RealRashid\SweetAlert\Facades\Alert;
use App\DataTables\LogActivitiesDataTable;

class LogActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LogActivitiesDataTable $dataTable)
    {
        return $dataTable->render('logactivity.index');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($encryptid)
    {
        $id = decrypt($encryptid);
        try {
            $log = Activity::findOrFail($id);
            return view('logactivity.show', compact('log'));
        } catch (\Throwable $th) {
            Alert::error($th->getMessage());
            return redirect()->back()->with('error', 'Failed to fetch log data: ' . $th->getMessage());
        }
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
