<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Official;
use App\Models\Procurement;
use Illuminate\Http\Request;
use App\DataTables\ProcurementDataTable;

class ProcurementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProcurementDataTable $dataTable)
    {
        return $dataTable->render('procurement.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisions = Division::where('status', '1')->get();
        $officials = Official::where('status', '1')->get();
        return view('procurement.create', compact('divisions', 'officials'));
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
    public function show(Procurement $procurement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Procurement $procurement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Procurement $procurement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Procurement $procurement)
    {
        //
    }
}
