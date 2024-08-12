<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use App\Models\Partner;
use App\Models\Business;
use App\Models\Official;
use App\Models\TenderFile;
use App\Models\Procurement;
use Illuminate\Http\Request;
use App\Models\BusinessPartner;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
        $tenders = Tender::with(['procurement','businessPartners.partner'])
        ->orderBy('procurement_id', 'desc')
        ->orderBy('created_at', 'desc')
        ->get();

        return DataTables::of($tenders)
        ->addColumn('number', function ($tender) {
            return $tender->procurement->number;
        })
        ->addColumn('job_name', function ($tender) {
            return $tender->procurement->name;
        })
        ->addColumn('division', function ($tender) {
            return $tender->procurement->division->code;
        })
        ->addColumn('estimation', function ($tender) {
            return $tender->procurement->estimation;
        })
        ->addColumn('official', function ($tender) {
            return $tender->procurement->official->initials;
        })
        ->addColumn('pic_user', function ($tender) {
            return $tender->procurement->pic_user;
        })
        ->addColumn('vendors', function ($tender) {
            $vendors = $tender->businessPartners->map(function ($businessPartner, $index) {
                return ($index + 1) . '. ' . $businessPartner->partner->name;
            })->implode("<br>");
            return $vendors;
        })
        ->addColumn('status', function ($data) {
            if ($data->status == '0') {
                return '<span class="badge text-bg-info">Process</span>';
            } elseif ($data->status == '1') {
                return '<span class="badge text-bg-success">Success</span>';
            } elseif ($data->status == '2') {
                return '<span class="badge text-bg-danger">Canceled</span>';
            } elseif ($data->status == '3') {
                return '<span class="badge text-bg-warning">Repeated</span>';
            }
            return '<span class="badge text-bg-dark">Unknown</span>';
        })
        ->addColumn('action', function ($tender) {
            $route = 'offer';
            return view('offer.action', compact('route', 'tender'));
        })
        ->addIndexColumn()
        ->rawColumns(['vendors', 'status'])
        ->make(true);
        }
        return view('offer.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $procurements = Procurement::where('status','0')
        ->whereDoesntHave('tenders')
        ->get();
        $business = Business::all();
        return view('offer.create', compact('procurements', 'business'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'procurement_id' => 'required|exists:procurements,id',
                'selected_partners' => 'required|array',
                'estimation' => 'required',
                'pic_user' => 'required',
                'business' => 'required',
            ]);

            $procurementId = $request->input('procurement_id');
            $selectedPartners = $request->input('selected_partners');

            $procurement = Procurement::findOrFail($procurementId);
            $procurement->update([
                'estimation' => $request->input('estimation'),
                'pic_user' => $request->input('pic_user'),
                'business_id' => $request->input('business'),
            ]);

            $tender = new Tender();
            $tender->procurement_id = $procurementId;
            $tender->save();

            $tender->businessPartners()->attach($selectedPartners);

            Alert::success('Success', 'Process tender created successfully');
            return redirect()->route('offer.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return redirect()->back()->with('error', 'Failed to save data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $tender = Tender::with(['procurement', 'businessPartners.partner'])->findOrFail($id);

            return view('offer.show', compact('tender'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return redirect()->back()->with('error', 'Failed to fetch tender data: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $tender = Tender::findOrFail($id);

            // Dapatkan informasi Procurement terkait
            $procurement = $tender->procurement;
            $procurement_id = $tender->procurement->id;
            $selected_procurement = Procurement::findOrFail($procurement_id);

            // Dapatkan daftar Business Partners yang terkait dengan Tender
            $selected_business_partners = $tender->businessPartners->pluck('id')->toArray();

            // Ambil semua Procurements yang belum terhubung dengan Tender (untuk dropdown)
            $available_procurements = Procurement::whereDoesntHave('tenders')->get();
            $available_procurements->push($selected_procurement);

            // Ambil semua Business Partners yang memiliki business_id sesuai dengan procurement
            $businessPartners = BusinessPartner::where('business_id', $procurement->business_id)
            ->where('is_blacklist', '!=', '1')
            ->get();

            // Ambil semua Business untuk dropdown
            $business = Business::all();

            return view('offer.edit', compact('procurement', 'selected_business_partners', 'available_procurements', 'businessPartners', 'tender', 'business'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return redirect()->back()->with('error', 'Failed to fetch data for editing: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $tender = Tender::findOrFail($id);
            $hasSchedules = $tender->schedules()->exists();
            if ($hasSchedules) {
                Alert::error('error', 'Tender has associated schedules and cannot be updated. Delete schedules first.');
            } else {
            $request->validate([
                'procurement_id' => 'required|exists:procurements,id',
                'selected_partners' => 'required|array',
                'estimation' => 'required',
                'pic_user' => 'required',
                'business' => 'required',
            ]);
            $procurementId = $request->input('procurement_id');
            $selectedPartners = $request->input('selected_partners');

            $procurement = Procurement::findOrFail($procurementId);
            $procurement->update([
                'estimation' => $request->input('estimation'),
                'pic_user' => $request->input('pic_user'),
                'business_id' => $request->input('business'),
            ]);

            $tender->procurement_id = $procurementId;
            $tender->save();

            $tender->businessPartners()->sync($selectedPartners);

            Alert::success('Success', 'Process tender updated successfully');
        }
            return redirect()->route('offer.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return redirect()->back()->with('error', 'Failed to save data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $tender = Tender::findOrFail($id);

            $hasSchedules = $tender->schedules()->exists();

            if ($hasSchedules) {
                Alert::error('error', 'Tender has associated schedules and cannot be deleted.');
            } else {
                $tender->businessPartners()->detach();
                $tender->delete();
                Alert::success('success', 'Tender deleted successfully!');
            }

            return redirect()->route('offer.index');
        } catch (\Exception $e) {
            Alert::error('error', 'Failed to delete tender: ' . $e->getMessage());
            return redirect()->route('offer.index');
        }
    }


    public function print($id)
    {
        $tender = Tender::findOrFail($id);
        $logoPath = public_path('assets/logo/cmnplogo.png');
        $logoData = file_get_contents($logoPath);
        $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        $creatorName = request()->query('creatorName');
        $creatorPosition = request()->query('creatorPosition');
        $supervisorName = request()->query('supervisorName');
        $supervisorPosition = request()->query('supervisorPosition');
        return view ('offer.print', compact('logoBase64', 'tender', 'creatorName', 'creatorPosition','supervisorName', 'supervisorPosition'));
    }

    public function official()
    {
        $officials = Official::where('status', '1')->get(['id', 'name']);
        return response()->json(['data' => $officials]);
    }

    public function view($id)
    {
        try {
            $tender = Tender::with(['procurement', 'businessPartners.partner'])->findOrFail($id);

            $procurementId = $tender->procurement->id;

            $previousTenders = [];
                foreach (Tender::where('procurement_id', $procurementId)
                ->where('status', '3')
                ->where('id', '<>', $id) // Exclude current tender
                ->get() as $previousTender) {
                // Dapatkan business_partner_ids dari businessPartnerTender
                $previousTenders[] = $previousTender;
                }

            return view('offer.view', compact('tender', 'previousTenders'));

        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return redirect()->back()->with('error', 'Failed to fetch tender data: ' . $e->getMessage());
        }
    }

    public function decision(Request $request, $id)
    {
        try {
            $tender = Tender::findOrFail($id);

            $request->validate([
                'decision' => 'required|in:0,1,2,3',
                'file' => $request->has('decision') ? 'required|file' : '',
                'notes' => $request->has('decision') ? 'required' : '',
                'pick_vendor' => $request->has('decision') && $request->input('decision') == "0" ? 'required' : '',
                'pick_vendor_old' => $request->has('decision') && $request->input('decision') == "3" ? 'required' : '',
            ]);

            $decision = $request->input('decision');
            //tender success
            if ($decision == 0) {

                $selectedVendorId = $request->input('pick_vendor');

                $tender->businessPartners()->where('business_partner_id', $selectedVendorId)->update(['is_selected' => '1']);

                $tender->status = '1';
                $tender->save();

                $tender->procurement->status = '1';
                $tender->procurement->save();

            //tender cancel
            } elseif ($decision == 1) {

                $tender->status = '2';
                $tender->save();

                $tender->procurement->status = '2';
                $tender->procurement->save();

            //tender repeat
            } elseif ($decision == 2) {
                // Update model Tender, set kolom status menjadi 3
                $tender->status = '3';
                $tender->save();

                $oldTender = Tender::find($id);
                $newTender = new Tender;
                $newTender->procurement_id = $oldTender->procurement_id;
                $newTender->status = '0';
                $newTender->save();
                $newTenderId = $newTender->id;
            //tender success from past tender
            } elseif ($decision == 3) {

                $pickVendorOld = $request->input('pick_vendor_old');

                list($previousTenderId, $businessPartnerId) = explode('_', $pickVendorOld);

                DB::table('business_partner_tender')
                    ->where('tender_id', $previousTenderId)
                    ->where('business_partner_id', $businessPartnerId)
                    ->update(['is_selected' => '1']);

                $previousTender = Tender::find($previousTenderId);
                $previousTender->status='1';
                $previousTender->save();

                $tender->status = '3';
                $tender->save();

                $tender->procurement->status = '1';
                $tender->procurement->save();

            }

            if ($request->hasFile('file')){
                $file = $request->file('file');
                $name = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('tender_partner', $name, 'public');

                $fileTender = new TenderFile();

                $fileTender->tender_id   = $id;
                $fileTender->name        = $name;
                $fileTender->path        = $path;
                $fileTender->type        = $decision;
                $fileTender->notes       = $request->notes;

                $fileTender->save();
            }

            foreach ($tender->businessPartners as $businessPartner) {
                $partner = $businessPartner->partner;
                $partner->status = '1';
                $partner->expired_at = date('Y') . '-12-31';
                $partner->save();
            }

            Alert::success('Success', 'Decision saved successfully');
            return redirect()->route('offer.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return redirect()->back()->with('error', 'Failed to save decision: ' . $e->getMessage());
        }
    }

    public function detail($id)
    {
        try {
            $tender = Tender::with(['procurement', 'businessPartners.partner'])
            ->findOrFail($id)
            ->load(['tenderFile' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }]);

            return view('offer.detail', compact('tender'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return redirect()->back()->with('error', 'Failed to fetch tender data: ' . $e->getMessage());
        }
    }

    public function change(Request $request)
    {
        try {
            // Validasi request
            $request->validate([
                'newDocument' => 'required|file', // Sesuaikan ukuran file maksimum dengan kebutuhan Anda
                'tender_file_id' => 'required|exists:tender_files,id' // Pastikan tender_file_id yang diberikan ada dalam database
            ]);

            // Mendapatkan ID dokumen tender dari request
            $tenderFileId = $request->input('tender_file_id');

            // Mengambil data dokumen tender dari database
            $tenderFile = TenderFile::findOrFail($tenderFileId);

            // Simpan dokumen baru
            $file = $request->file('newDocument');
            $name = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('tender_partner', $name, 'public');

            // Hapus dokumen sebelumnya dari penyimpanan
            Storage::delete($tenderFile->path);

            // Memperbarui data dokumen tender dengan dokumen baru
            $tenderFile->name = $name;
            $tenderFile->path = $path;
            $tenderFile->save();

            // Memberikan respons sukses
            Alert::success('Success', 'Document updated successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, tangani di sini
            Alert::error('Error', 'Failed to update document: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function rollback(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'rollbackDocument' => 'required|file', // Sesuaikan ukuran file maksimum dengan kebutuhan Anda
            'rollbackNotes' => 'required',
        ]);
        try {
            // Simpan file upload
            if ($request->hasFile('rollbackDocument')) {
                $file = $request->file('rollbackDocument');
                $name = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('tender_partner', $name, 'public');
                // Logika tambahan untuk menyimpan data terkait rollback
                // Misalnya menyimpan informasi file di database
                $rollback = new TenderFile();
                $rollback->tender_id = $id;
                $rollback->name = $name;
                $rollback->type = 6;
                $rollback->path = $path;
                $rollback->notes = $request->input('rollbackNotes');
                $rollback->save();

                //jika file berhasil diupload ubah tender dan procurement menjadi proses
                $tender = Tender::find($id);
                $tender->status = '0';
                $tender->save();

                $procurement = Procurement::find($tender->procurement_id);
                $procurement->status = '0';
                $procurement->save();

                Alert::success('Success', 'Rollback document uploaded successfully.');
                return to_route('offer.index');
            } else {
                Alert::Error('Error', 'No file was uploaded.');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Alert::Error('Error', 'Failed to upload rollback document: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
