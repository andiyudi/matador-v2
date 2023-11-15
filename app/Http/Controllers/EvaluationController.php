<?php

namespace App\Http\Controllers;

use App\Models\TenderFile;
use App\Models\Procurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            return $procurement->division->code;
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
            return '<a href="' . $url . '" class="btn btn-sm btn-info">Evaluation</a>';
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

        // Sorting tenders dan tenderFile berdasarkan created_at secara descending
        $procurement->tenders = $procurement->tenders->sortByDesc('created_at');
        foreach ($procurement->tenders as $tender) {
            $tender->tenderFile = $tender->tenderFile->sortByDesc('created_at');
        }

        // Loop melalui tenders dan businessPartners untuk pengecekan file tender
        foreach ($procurement->tenders as $tender) {
            foreach ($tender->businessPartners as $businessPartner) {
                if ($businessPartner->pivot->is_selected == '1') {
                    // Cek apakah ada file tender dengan type 3 & 4 pada tender ini
                    $fileCompanyExists = $tender->tenderFile->where('type', 4)->isNotEmpty();
                    $fileVendorExists = $tender->tenderFile->where('type', 5)->isNotEmpty();

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

    public function company (Request $request, $id)
    {
        try {
            $request->validate([
                'file_evaluation_company' => 'required|file|mimes:pdf|max:2048', // Ubah sesuai kebutuhan
                'evaluation' => 'required|in:0,1', // Ubah sesuai kebutuhan
                'notes' => 'required',
                'tender_id' => 'required',
                'business_partner_id' => 'required',
                'type' => 'required',
            ]);

            $tender_id = $request->input('tender_id');
            $business_partner_id = $request->input('business_partner_id');

            // Unggah file ke tabel tender_files jika ada file yang diunggah
            if ($request->hasFile('file_evaluation_company')) {
                $file = $request->file('file_evaluation_company');
                $name = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('tender_partner/evaluation', $name, 'public');

                $fileTender = new TenderFile();
                $fileTender->tender_id = $tender_id;
                $fileTender->name = $name;
                $fileTender->path = $path;
                $fileTender->type = $request->input('type'); // Tipe file sesuai kebutuhan
                $fileTender->notes = $request->input('notes');

                $fileTender->save();
            }

            DB::table('business_partner_tender')
                ->where('tender_id', $tender_id)
                ->where('business_partner_id', $business_partner_id)
                ->update(['evaluation' => $request->input('evaluation')]);

            Alert::success('Success', 'File saved successfully');
            return to_route ('evaluation.show', $id);
        } catch (\Throwable $th) {
            Alert::error($th->getMessage());
            return to_route ('evaluation.show', $id);
        }
    }

    public function vendor (Request $request, $id)
    {
        try {
            $request->validate([
                'file_evaluation_vendor' => 'required|file|mimes:pdf|max:2048', // Ubah sesuai kebutuhan
                'value_cost' => 'required|in:0,1,2', // Ubah sesuai kebutuhan
                'contract_order' => 'required|in:0,1,2', // Ubah sesuai kebutuhan
                'work_implementation' => 'required|in:0,1,2', // Ubah sesuai kebutuhan
                'pre_handover' => 'required|in:0,1,2,3', // Ubah sesuai kebutuhan
                'final_handover' => 'required|in:0,1,2,3', // Ubah sesuai kebutuhan
                'invoice_payment' => 'required|in:0,1,2', // Ubah sesuai kebutuhan
                'notes' => 'required',
                'tender_id' => 'required',
                'business_partner_id' => 'required',
                'type' => 'required',
            ]);

            $tender_id = $request->input('tender_id');
            $business_partner_id = $request->input('business_partner_id');

            // Unggah file ke tabel tender_files jika ada file yang diunggah
            if ($request->hasFile('file_evaluation_vendor')) {
                $file = $request->file('file_evaluation_vendor');
                $name = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('tender_partner/evaluation', $name, 'public');

                $fileTender = new TenderFile();
                $fileTender->tender_id = $tender_id;
                $fileTender->name = $name;
                $fileTender->path = $path;
                $fileTender->type = $request->input('type'); // Tipe file sesuai kebutuhan
                $fileTender->notes = $request->input('notes');

                $fileTender->save();
            }

            DB::table('business_partner_tender')
                ->where('tender_id', $tender_id)
                ->where('business_partner_id', $business_partner_id)
                ->update([
                    'value_cost' => $request->input('value_cost'),
                    'contract_order' => $request->input('contract_order'),
                    'work_implementation' => $request->input('work_implementation'),
                    'pre_handover' => $request->input('pre_handover'),
                    'final_handover' => $request->input('final_handover'),
                    'invoice_payment' => $request->input('invoice_payment')
                ]);

            Alert::success('Success', 'File saved successfully');
            return to_route ('evaluation.show', $id);
        } catch (\Throwable $th) {
            Alert::error($th->getMessage());
            return to_route ('evaluation.show', $id);
        }
    }
}
