<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Business;
use App\Models\Procurement;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('offer.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $procurements = Procurement::where('status', '0')->get();
        $business = Business::all();
        return view('offer.create', compact('procurements', 'business'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Offer $offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Offer $offer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Offer $offer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offer $offer)
    {
        //
    }
}
