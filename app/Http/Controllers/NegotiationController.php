<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use App\Models\Negotiation;
use Illuminate\Http\Request;
use App\Models\BusinessPartner;
use App\Models\BusinessPartnerTender;
use RealRashid\SweetAlert\Facades\Alert;

class NegotiationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $tender = Tender::findOrFail($id);
        $negotiationCount = Negotiation::where('tender_id', $tender->id)->count();
        // Mengambil nilai nego_price terendah untuk tender ini
        $minNegoPrice = Negotiation::where('tender_id', $tender->id)
        ->where('nego_price', '>', 0) // Memastikan nego_price lebih dari 0
        ->min('nego_price');

        // Mendapatkan business partner yang memiliki nego_price terendah
        $businessPartnersWithMinNegoPrice = Negotiation::where('tender_id', $tender->id)
            ->where('nego_price', $minNegoPrice)
            ->get();

        $businessPartnersNames = [];
        foreach ($businessPartnersWithMinNegoPrice as $negotiation) {
            $businessPartner = BusinessPartner::find($negotiation->business_partner_id);
            if ($businessPartner) {
                $businessPartnersNames[] = $businessPartner->partner->name;
            }
        }

        $multipleBusinessPartners = count($businessPartnersNames) > 1; // Check if more than one business partner

        return view('offer.negotiation.index', compact('tender', 'minNegoPrice', 'businessPartnersNames', 'negotiationCount', 'multipleBusinessPartners'));
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
                    $negotiation->tender_id = $id;
                    $negotiation->business_partner_id = $businessPartnerId;
                    $negotiation->business_partner_tender_id = $businessPartnerTender->id;
                    $negotiation->nego_price = $negoPrice;
                    $negotiation->save();
                }
            }
            // Atur nilai kolom aanwijzing, document_pickup, dan quotation pada business_partner_tender
            $businessPartnerTender->aanwijzing_date = $request->input('aanwijzing_date_' . $businessPartnerId);
            $businessPartnerTender->document_pickup = $request->input('document_pickup_' . $businessPartnerId);
            // Ubah format currency quotation menjadi double
            $quotation = str_replace('.', '', $request->input('quotation_' . $businessPartnerId));
            $businessPartnerTender->quotation = $quotation;
            $businessPartnerTender->save();
        }

        Alert::success('Success', 'Negotiations saved successfully.');
        return redirect()->route('negotiation.index', $id);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        dd($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tender = Tender::findOrFail($id);
        return view('offer.negotiation.edit', compact('tender'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Loop through business partners to update negotiations
        foreach ($request->nego_price as $businessPartnerId => $negoPrices) {
            // Ubah $negoPrices menjadi array jika tidak array
            $negoPrices = is_array($negoPrices) ? $negoPrices : [$negoPrices];

            // Cari business_partner_tender_id berdasarkan tender_id dan business_partner_id
            $businessPartnerTender = BusinessPartnerTender::where('tender_id', $id)
                ->where('business_partner_id', $businessPartnerId)
                ->first();

            if ($businessPartnerTender) {
                // Mendapatkan ID semua negosiasi yang terkait dengan business partner ini
                $existingNegotiationIds = $businessPartnerTender->negotiations->pluck('id')->toArray();

                foreach ($negoPrices as $negotiationId => $negoPrice) {
                    // Ubah format currency menjadi double
                    $negoPrice = str_replace('.', '', $negoPrice);

                    if (in_array($negotiationId, $existingNegotiationIds)) {
                        // Jika negosiasi dengan ID ini sudah ada, update nilainya
                        $negotiation = Negotiation::find($negotiationId);
                        $negotiation->nego_price = $negoPrice;
                        $negotiation->save();

                        // Hapus ID negosiasi ini dari array existingNegotiationIds
                        $existingNegotiationIds = array_diff($existingNegotiationIds, [$negotiationId]);
                    } else {
                        // Jika negosiasi dengan ID ini belum ada, buat baru
                        $negotiation = new Negotiation();
                        $negotiation->tender_id = $id;
                        $negotiation->business_partner_id = $businessPartnerId;
                        $negotiation->business_partner_tender_id = $businessPartnerTender->id;
                        $negotiation->nego_price = $negoPrice;
                        $negotiation->save();
                    }
                }

                // Hapus negosiasi yang sudah tidak ada dalam permintaan dari database
                Negotiation::whereIn('id', $existingNegotiationIds)->delete();
            }

            // Atur nilai kolom aanwijzing, document_pickup, dan quotation pada business_partner_tender
            $businessPartnerTender->aanwijzing_date = $request->input('aanwijzing_date_' . $businessPartnerId);
            $businessPartnerTender->document_pickup = $request->input('document_pickup_' . $businessPartnerId);

            // Ubah format currency quotation menjadi double
            $quotation = str_replace('.', '', $request->input('quotation_' . $businessPartnerId));
            $businessPartnerTender->quotation = $quotation;
            $businessPartnerTender->save();
        }

        Alert::success('Success', 'Negotiations updated successfully.');
        return redirect()->route('negotiation.index', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         // Hapus semua entitas dari model Negotiation yang terkait dengan Tender yang dihapus
        Negotiation::where('tender_id', $id)->delete();

        // Atur kolom yang sesuai menjadi null pada model BusinessPartnerTender
        BusinessPartnerTender::where('tender_id', $id)->update([
            'document_pickup' => null,
            'aanwijzing_date' => null,
            'quotation' => null
        ]);

        Alert::success('Success', 'Negotiations deleted successfully.');
        return redirect()->route('negotiation.index', $id);

    }
}
