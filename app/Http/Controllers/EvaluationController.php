<?php

namespace App\Http\Controllers;

use App\Models\Procurement;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
        $procurements = Procurement::with('tenders.businessPartners.partner')
        ->where('status', '1')
        ->get();
        return DataTables::of($procurements)
        ->editColumn('division', function ($procurement) {
            return $procurement->division->name;
        })
        ->addColumn('vendors', function ($procurement) {
            // Inisialisasi nomor urut
            $vendorCount = 1;

            // Inisialisasi string untuk menyimpan nama vendor dengan nomor urut dan HTML <br>
            $vendorList = '';

            foreach ($procurement->tenders as $tender) {
                foreach ($tender->businessPartners as $businessPartner) {
                    // Tambahkan nama vendor dengan nomor urut ke daftar vendor
                    $vendorList .= $vendorCount . '. ' . $businessPartner->partner->name . '<br>';
                    $vendorCount++;
                }
            }

            return $vendorList;
        })
        ->addColumn('is_selected', function ($procurement) {
            foreach ($procurement->tenders as $tender) {
                $selectedVendor = $tender->businessPartners->first(function ($businessPartner) {
                    return $businessPartner->pivot->is_selected === '1';
                });

                if ($selectedVendor) {
                    return $selectedVendor->partner->name;
                }
            }

            return 'Ada Kesalahan, Data Tidak Ditemukan'; // Jika tidak ada businessPartner dengan is_selected '1'
        })
        ->addColumn('action', function ($procurement) {
            $url = route('evaluation.show', ['evaluation' => $procurement->id]);
            return '<a href="' . $url . '" class="btn btn-sm btn-primary">Evaluation</a>';
        })
        ->addIndexColumn()
        ->rawColumns(['vendors', 'action'])
        ->make(true);
        }
        return view('procurement.evaluation.index');
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
    public function show($id)
    {
        // Ambil data procurement berdasarkan ID
        $procurement = Procurement::with('tenders.businessPartners.partner')->find($id);

        if (!$procurement) {
            // Lakukan penanganan jika procurement tidak ditemukan
            Alert::error('Error', 'Procurement not found');
            return redirect()->route('procurement.evaluation.index');
        }
        $fileCompanyExist = false;
        $fileVendorExist = false;

        // Loop melalui tenders dan businessPartners untuk pengecekan file tender
        foreach ($procurement->tenders as $tender) {
            foreach ($tender->businessPartners as $businessPartner) {
                if ($businessPartner->pivot->is_selected == '1') {
                    // Cek apakah ada file tender dengan type 3 & 4 pada tender ini
                    $fileCompanyExists = $tender->tenderFile->where('type', 3)->isNotEmpty();
                    $fileVendorExists = $tender->tenderFile->where('type', 4)->isNotEmpty();

                    if ($fileCompanyExists) {
                        // Jika ada file tender dengan type 3, maka set $fileCompanyExist menjadi false
                        $fileCompanyExist = false;
                    } else {
                        // Jika tidak ada file tender dengan type 3, maka set $fileCompanyExist menjadi true
                        $fileCompanyExist = true;
                    }

                    if ($fileVendorExists) {
                        // Jika ada file tender dengan type 4, maka set $fileVendorExist menjadi false
                        $fileVendorExist = false;
                    } else {
                        // Jika tidak ada file tender dengan type 4, maka set $fileVendorExist menjadi true
                        $fileVendorExist = true;
                    }
                }
            }
        }

        return view('procurement.evaluation.show', compact('procurement', 'fileCompanyExist', 'fileVendorExist'));
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
