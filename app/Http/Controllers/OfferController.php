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
        ->orderByDesc('created_at')
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
            $businessPartners = BusinessPartner::where('business_id', $procurement->business_id)->get();

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
            // $hasSchedules = $tender->schedules()->exists();
            // if ($hasSchedules) {
            //     Alert::error('error', 'Tender has associated schedules and cannot be updated. Delete schedules first.');
            // } else {
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
        // }
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

            return view('offer.view', compact('tender'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return redirect()->back()->with('error', 'Failed to fetch tender data: ' . $e->getMessage());
        }
    }

    public function decision(Request $request, $id)
    {
        // dd($request->all());
        try {
            $tender = Tender::findOrFail($id);

            $request->validate([
                'decision' => 'required|in:1,2,3',
            ]);

            $decision = $request->input('decision');

            if ($decision == 1) {
                $request->validate([
                    'pick_vendor' => 'required',
                    'file' => 'required|file',
                    'notes' => 'required',
                ]);

                // Ambil ID dari vendor yang dipilih
                $selectedVendorId = $request->input('pick_vendor');

                // Update tabel business_partner_tender, set kolom is_selected menjadi 1 untuk vendor yang dipilih
                $tender->businessPartners()->where('business_partner_id', $selectedVendorId)->update(['is_selected' => '1']);

                // Update model Tender, set kolom status menjadi 1
                $tender->status = '1';
                $tender->save();

                // Update model Procurement, set kolom status menjadi 1
                $tender->procurement->status = '1';
                $tender->procurement->save();

                // Update semua partner yang terkait dengan tender
                foreach ($tender->businessPartners as $businessPartner) {
                    $partner = $businessPartner->partner;
                    $partner->status = '1';
                    $partner->expired_at = date('Y') . '-12-31';
                    $partner->save();
                }

                if ($request->hasFile('file')){
                    $file = $request->file('file');
                    $name = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('tender_partner', $name, 'public');

                    $fileTender = new TenderFile();

                    $fileTender->tender_id   = $id;
                    $fileTender->name        = $name;
                    $fileTender->path        = $path;
                    $fileTender->type        = 0;
                    $fileTender->notes       = $request->notes;

                    $fileTender->save();
                }

                Alert::success('Success', 'Decision saved successfully');
                return redirect()->route('offer.index');
            } elseif ($decision == 2) {
                $request->validate([
                    'file' => 'required|file',
                    'notes' => 'required',
                ]);
                // Handle logika jika keputusan adalah 'Cancel Tender'
                // Update model Tender, set kolom status menjadi 1
                $tender->status = '2';
                $tender->save();

                // Update model Procurement, set kolom status menjadi 1
                $tender->procurement->status = '2';
                $tender->procurement->save();

                // Update semua partner yang terkait dengan tender
                foreach ($tender->businessPartners as $businessPartner) {
                    $partner = $businessPartner->partner;
                    $partner->status = '1';
                    $partner->expired_at = date('Y') . '-12-31';
                    $partner->save();
                }

                if ($request->hasFile('file')){
                    $file = $request->file('file');
                    $name = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('tender_partner', $name, 'public');

                    $fileTender = new TenderFile();

                    $fileTender->tender_id   = $id;
                    $fileTender->name        = $name;
                    $fileTender->path        = $path;
                    $fileTender->type        = 1;
                    $fileTender->notes       = $request->notes;

                    $fileTender->save();
                }

                Alert::success('Success', 'Decision saved successfully');
                return redirect()->route('offer.index');
                // Anda dapat mengakses file yang diunggah dengan $request->file('file')
            } elseif ($decision == 3) {
                $request->validate([
                    'file' => 'required|file',
                    'notes' => 'required',
                ]);
                // Handle logika jika keputusan adalah 'Repeat Tender'
                // Update model Tender, set kolom status menjadi 1
                $tender->status = '3';
                $tender->save();

                // Update semua partner yang terkait dengan tender
                foreach ($tender->businessPartners as $businessPartner) {
                    $partner = $businessPartner->partner;
                    $partner->status = '1';
                    $partner->expired_at = date('Y') . '-12-31';
                    $partner->save();
                }

                if ($request->hasFile('file')){
                    $file = $request->file('file');
                    $name = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('tender_partner', $name, 'public');

                    $fileTender = new TenderFile();

                    $fileTender->tender_id   = $id;
                    $fileTender->name        = $name;
                    $fileTender->path        = $path;
                    $fileTender->type        = 2;
                    $fileTender->notes       = $request->notes;

                    $fileTender->save();
                }

                $dataLama = Tender::find($id);
                $dataBaru = new Tender;
                $dataBaru->procurement_id = $dataLama->procurement_id;
                // Lanjutkan dengan mengisi semua kolom lain yang perlu disalin.
                $dataBaru->status = '0'; // Misalnya, mengganti nilai fieldX dengan nilai baru.
                $dataBaru->save();

                Alert::success('Success', 'Decision saved successfully');
                return redirect()->route('offer.index');
                // Anda dapat mengakses file yang diunggah dengan $request->file('file')
            }

            // Selain logika yang di atas, Anda juga dapat melakukan operasi lain yang diperlukan.

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
            $tender = Tender::with(['procurement', 'businessPartners.partner'])->findOrFail($id);

            return view('offer.detail', compact('tender'));
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return redirect()->back()->with('error', 'Failed to fetch tender data: ' . $e->getMessage());
        }
    }

    public function company(Request $request, $id)
    {
        dd($request->all());
    }


}
