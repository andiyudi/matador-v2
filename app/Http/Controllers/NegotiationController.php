<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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

    $minNegoPrice = Negotiation::where('tender_id', $tender->id)
        ->where('nego_price', '>', 0)
        ->min('nego_price');

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

    $multipleBusinessPartners = count($businessPartnersNames) > 1;

    // Retrieve business partners associated with this tender and eager load the pivot data
    $businessPartners = $tender->businessPartners()->withPivot(['document_pickup', 'aanwijzing_date', 'quotation'])
        ->with(['negotiations' => function ($query) use ($id) {
            $query->where('tender_id', $id);
        }])
        ->get();

    // Sort business partners based on their negotiation prices
    $businessPartners = $businessPartners->sortBy(function($businessPartner) {
        return $businessPartner->negotiations->where('nego_price', '>', 0)->min('nego_price');
    });

    // Separate and handle business partners with a zero negotiation price
    $businessPartnersWithZeroPrice = $businessPartners->filter(function ($businessPartner) {
        return $businessPartner->negotiations->where('nego_price', 0)->count() > 0;
    });

    $businessPartners = $businessPartners->reject(function ($businessPartner) {
        return $businessPartner->negotiations->where('nego_price', 0)->count() > 0;
    });

    $businessPartners = $businessPartners->concat($businessPartnersWithZeroPrice);

    // Return the view with the data
    return view('offer.negotiation.index', compact('tender', 'minNegoPrice', 'businessPartnersNames', 'negotiationCount', 'multipleBusinessPartners', 'businessPartners'));
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
                // Validasi document_pickup dan aanwijzing_date
                if (empty($request->input('document_pickup_' . $businessPartnerId)) || empty($request->input('aanwijzing_date_' . $businessPartnerId))) {
                    Alert::error('Error', 'Please fill in all required fields.');
                    return redirect()->back()->withInput();
                }
                foreach ($negoPrices as $negoPrice) {
                    // Ubah format currency menjadi double
                    $negoPrice = str_replace('.', '', $negoPrice); // Menghapus koma dari format currency

                    // Ubah format currency quotation menjadi double
                    $quotation = str_replace('.', '', $request->input('quotation_' . $businessPartnerId));

                    // Validasi
                    if ($quotation == 0 && $negoPrice != 0) {
                        Alert::error('Error', 'Negotiation price can only be 0 if the quotation is 0.');
                        return redirect()->back()->withInput();
                    }

                    if ($quotation != 0) {
                        if ($negoPrice > $quotation) {
                            Alert::error('Error', 'Negotiation price cannot be greater than quotation.');
                            return redirect()->back()->withInput();
                        }

                        if ($negoPrice == 0) {
                            Alert::error('Error', 'Negotiation price cannot be 0 if the quotation is not 0.');
                            return redirect()->back()->withInput();
                        }
                    }

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
        $tender = Tender::with(['businessPartners' => function ($query) use ($id) {
            $query->with(['negotiations' => function ($query) use ($id) {
                $query->where('tender_id', $id);
            }])->whereHas('tenders', function ($query) use ($id) {
                $query->where('tender_id', $id);
            });
        }])->findOrFail($id);

        $leadName = request()->query('leadName');
        $leadPosition = request()->query('leadPosition');
        $date = request()->query('date');
        $negoDate = Carbon::parse($date);
        $day = $negoDate->format('d');
        $month = $negoDate->getTranslatedMonthName();
        $year = $negoDate->format('Y');
        $formattedDate = $day . " " . $month . " " . $year;

        $businessPartners = $tender->businessPartners;

        foreach ($businessPartners as $businessPartner) {
            // Set nilai nego_price pada setiap BusinessPartner
            $businessPartner->nego_price = Negotiation::where('tender_id', $tender->id)
                                                        ->where('business_partner_id', $businessPartner->id)
                                                        ->min('nego_price');
        }

        // Urutkan $businessPartners berdasarkan nilai nego_price terendah
        $businessPartners = $businessPartners->sortBy('nego_price');

        // Filter dan kelompokkan $businessPartners berdasarkan nilai nego_price
        $businessPartnersWithZeroPrice = $businessPartners->filter(function ($businessPartner) {
            return $businessPartner->nego_price == 0;
        });

        $businessPartners = $businessPartners->reject(function ($businessPartner) {
            return $businessPartner->nego_price == 0;
        });

        // Gabungkan dan atur ulang indeks
        $businessPartners = $businessPartners->concat($businessPartnersWithZeroPrice)->values();

        // Mendapatkan nilai nego_price terkecil yang bukan 0
        $minNegoPrice = $businessPartners->where('nego_price', '>', 0)->min('nego_price');

        // Mendapatkan nama business partner yang memiliki nilai nego_price terkecil yang bukan 0
        $businessPartnerWithMinNegoPrice = $businessPartners->first(function ($businessPartner) use ($minNegoPrice) {
            return $businessPartner->nego_price == $minNegoPrice;
        })->partner->name;

        // Konversi kembali ke koleksi objek model
        $businessPartnersCollection = collect($businessPartners);

        // dd($businessPartners, $minNegoPrice, $businessPartnerWithMinNegoPrice);

        return view('offer.negotiation.show', compact('tender', 'leadName', 'leadPosition', 'formattedDate', 'businessPartners', 'minNegoPrice', 'businessPartnerWithMinNegoPrice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tender = Tender::with(['businessPartners' => function ($query) use ($id) {
            $query->with(['negotiations' => function ($query) use ($id) {
                $query->where('tender_id', $id);
            }])->whereHas('tenders', function ($query) use ($id) {
                $query->where('tender_id', $id);
            });
        }])->findOrFail($id);

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
                if (empty($request->input('document_pickup_' . $businessPartnerId)) || empty($request->input('aanwijzing_date_' . $businessPartnerId))) {
                    Alert::error('Error', 'Please fill in all required fields.');
                    return redirect()->back()->withInput();
                }
                // Ubah format currency quotation menjadi double
                $quotation = str_replace('.', '', $request->input('quotation_' . $businessPartnerId));
                // Mendapatkan ID semua negosiasi yang terkait dengan business partner ini
                $existingNegotiationIds = $businessPartnerTender->negotiations->pluck('id')->toArray();

                foreach ($negoPrices as $negotiationId => $negoPrice) {
                    // Ubah format currency menjadi double
                    $negoPrice = str_replace('.', '', $negoPrice);

                    if ($quotation != 0) {
                        // Validasi nego_price yang tidak boleh lebih besar dari quotation
                        if ($negoPrice > $quotation) {
                            Alert::error('Error', 'Negotiation price cannot be greater than quotation.');
                            return redirect()->back()->withInput();
                        }

                        // Validasi nego_price yang tidak boleh 0 jika quotation tidak sama dengan 0
                        if ($negoPrice == 0) {
                            Alert::error('Error', 'Negotiation price cannot be 0 if the quotation is not 0.');
                            return redirect()->back()->withInput();
                        }
                    } else {
                        // Validasi nego_price yang boleh 0 jika quotation = 0
                        if ($negoPrice != 0) {
                            Alert::error('Error', 'Negotiation price can only be 0 if the quotation is 0.');
                            return redirect()->back()->withInput();
                        }
                    }

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

                // Atur nilai kolom aanwijzing, document_pickup, dan quotation pada business_partner_tender
            $businessPartnerTender->aanwijzing_date = $request->input('aanwijzing_date_' . $businessPartnerId);
            $businessPartnerTender->document_pickup = $request->input('document_pickup_' . $businessPartnerId);

            $businessPartnerTender->quotation = $quotation;
            $businessPartnerTender->save();
            }
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
