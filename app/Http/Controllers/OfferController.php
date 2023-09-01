<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\Tender;
use App\Models\Business;
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

            return view('offer.edit', [
                'procurement' => $tender->procurement,
                'selected_business_partners' => $tender->businessPartners->pluck('id')->toArray(),
                'available_procurements' => Procurement::whereDoesntHave('tenders')->get()->push($tender->procurement),
                'businessPartners' => BusinessPartner::all(),
                'business' => Business::all(),
                'tender' => $tender,
            ]);
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
            $tender->businessPartners()->detach();
            $tender->delete();
            Alert::success('success', 'Tender deleted successfully!');
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
        $html = view ('offer.print', compact('logoBase64', 'tender', 'creatorName', 'creatorPosition','supervisorName', 'supervisorPosition'))->render();
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
        return $dompdf->stream('calon-usulan-vendor.pdf');
    }

}
