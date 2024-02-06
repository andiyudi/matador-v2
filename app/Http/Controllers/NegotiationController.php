<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use App\Models\Negotiation;
use Illuminate\Http\Request;

class NegotiationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $tender = Tender::findOrFail($id);
        return view ('offer.negotiation.index', compact('tender'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $tender = Tender::findOrFail($id);
        return view('offer.negotiation.create', compact('tender'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Negotiation $negotiation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Negotiation $negotiation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Negotiation $negotiation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Negotiation $negotiation)
    {
        //
    }
}
