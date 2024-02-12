<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use App\Models\Negotiation;
use Illuminate\Http\Request;
use App\Models\BusinessPartnerTender;

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
        // dd($request->all());
        // Loop through business partners to save negotiations
        foreach ($request->nego_price as $businessPartnerId => $negoPrices) {
            // Ubah $negoPrices menjadi array jika tidak array
            $negoPrices = is_array($negoPrices) ? $negoPrices : [$negoPrices];

            // Cari business_partner_tender_id berdasarkan tender_id dan business_partner_id
            $businessPartnerTender = BusinessPartnerTender::where('tender_id', $id)
                ->where('business_partner_id', $businessPartnerId)
                ->first();

            if ($businessPartnerTender) {
                foreach ($negoPrices as $negoPrice) {
                    // Ubah format currency menjadi double
                    $negoPrice = str_replace('.', '', $negoPrice); // Menghapus koma dari format currency

                    // Simpan data negosiasi untuk setiap vendor
                    $negotiation = new Negotiation();
                    $negotiation->business_partner_tender_id = $businessPartnerTender->id;
                    $negotiation->nego_price = $negoPrice;
                    $negotiation->save();
                }
            }
        }

        return redirect()->route('negotiation.index', $id)->with('success', 'Negotiations saved successfully.');
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
