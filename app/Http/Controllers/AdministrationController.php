<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tender;
use App\Models\Division;
use App\Models\Official;
use App\Models\Definition;
use App\Models\Procurement;
use Illuminate\Http\Request;
use App\Models\ProcurementFile;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class AdministrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $procurements = Procurement::with('tenders.businessPartners.partner')
            ->orderByDesc('number')
            ->get();
            return DataTables::of($procurements)
            ->editColumn('receipt', function ($procurement) {
                return Carbon::parse($procurement->receipt)->format('d-M-Y');
            })
            ->editColumn('division', function ($procurement) {
                return $procurement->division->name;
            })
            ->editColumn('official', function ($procurement) {
                return $procurement->official->name;
            })
            ->editColumn('user_estimate', function ($procurement) {
                return 'Rp. ' . number_format($procurement->user_estimate, 0, ',', '.');
            })
            ->editColumn('technique_estimate', function ($procurement) {
                return 'Rp. ' . number_format($procurement->technique_estimate, 0, ',', '.');
            })
            ->editColumn('deal_nego', function ($procurement) {
                return 'Rp. ' . number_format($procurement->deal_nego, 0, ',', '.');
            })
            ->editColumn('user_percentage', function ($procurement) {
                // Pastikan bahwa user_percentage tidak null sebelum memformat
                if ($procurement->user_percentage !== null) {
                    return number_format($procurement->user_percentage, 2, ',', '.') . '%';
                } else {
                    return '';
                }
            })
            ->editColumn('technique_percentage', function ($procurement) {
                // Pastikan bahwa technique_percentage tidak null sebelum memformat
                if ($procurement->technique_percentage !== null) {
                    return number_format($procurement->technique_percentage, 2, ',', '.') . '%';
                } else {
                    return '';
                }
            })
            ->addColumn('is_selected', function ($procurement) {
                if ($procurement->status == "2") {
                    return '<span class="badge rounded-pill text-bg-danger">Canceled</span>';
                } elseif ($procurement->status == "0") {
                    return '<span class="badge rounded-pill text-bg-info">Process</span>';
                }

                // Pengecekan is_selected pada tender
                foreach ($procurement->tenders as $tender) {
                    $selectedVendor = $tender->businessPartners->first(function ($businessPartner) {
                        return $businessPartner->pivot->is_selected === '1';
                    });

                    if ($selectedVendor) {
                        return $selectedVendor->partner->name;
                    }
                }

                return '<span class="badge text-bg-dark">Unknown</span>'; // Jika tidak ada businessPartner dengan is_selected '1'
            })
            ->addColumn('action', function ($procurement){
                $route = 'administration';
                return view('procurement.administration.action', compact('route', 'procurement'));
            })
            ->addIndexColumn()
            ->rawColumns(['is_selected'])
            ->make(true);
            }
        return view('procurement.administration.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $definitionFileProcurements = Definition::all();
        $procurement= Procurement::find($id);
        return view('procurement.administration.create', compact('definitionFileProcurements','procurement'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'file' => 'required',
                'id_procurement' => 'required',
                'definition_id' => 'required',
            ]);

            $procurement_id = Procurement::findOrFail($request->id_procurement);
            if ($request->hasFile('file')){
                $file = $request->file('file');
                $name = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('procurement_files', $name, 'public');

                $filePartner = new ProcurementFile();

                $filePartner->procurement_id    = $procurement_id->id;
                $filePartner->name              = $name;
                $filePartner->path              = $path;
                $filePartner->definition_id     = $request->definition_id;
                $filePartner->notes             = $request->notes;

                $filePartner->save();
                Alert::success('Success','File added successfully');
                return redirect()->route('administration.show', $procurement_id);
            } else {
                Alert::error('Error', 'No file uploaded.');
            }

        } catch (\Throwable $th) {
            Alert::error('Error', 'Failed to add File: ' . $th->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $procurement = Procurement::find($id);
        $files = ProcurementFile::where('procurement_id', $id)
        ->orderByDesc('created_at')
        ->get();

        $definitions = [];
        foreach ($files as $file) {
            $definitions[$file->id] = Definition::find($file->definition_id);
        }
        return view('procurement.administration.show', compact('procurement', 'files', 'definitions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $procurement = Procurement::findOrFail($id);
        $divisions = Division::where('status', '1')->get();
        $officials = Official::where('status', '1')->get();

        $tendersCount = $procurement->tendersCount();
        $procurementStatus = $procurement->status;
        $tenderIds = $procurement->tenders->pluck('id')->toArray();

        $tenderData = Tender::whereIn('id', $tenderIds)
            ->get(['id', 'report_nego_result', 'negotiation_result'])
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'report_nego_result' => $item->report_nego_result,
                    'negotiation_result' => $item->negotiation_result,
                ];
            })
            ->toArray();

        return view('procurement.administration.edit', compact('procurement', 'divisions', 'officials', 'tendersCount', 'procurementStatus', 'tenderData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        try {
            $request->validate([
                'user_estimate' => 'required',
                'technique_estimate' => 'required',
            ]);

            $procurement = Procurement::find($id);

            $procurement->user_estimate = str_replace('.', '', $request->user_estimate);
            $procurement->technique_estimate = str_replace('.', '', $request->technique_estimate);
            if ($request->has('deal_nego')) {
                $procurement->deal_nego = str_replace('.', '', $request->deal_nego);
            }
            $procurement->information = $request->information;
            $procurement->return_to_user = $request->return_to_user;
            $procurement->cancellation_memo = $request->cancellation_memo;
            $procurement->director_approval = $request->director_approval;
            $procurement->target_day = $request->target_day;
            $procurement->finish_day = $request->finish_day;
            $procurement->off_day = $request->off_day;
            $procurement->difference_day = $request->difference_day;
            $procurement->op_number = $request->op_number;
            $procurement->contract_number = $request->contract_number;
            if ($request->has('contract_value')) {
                $procurement->contract_value = str_replace('.', '', $request->contract_value);
            }
            $procurement->contract_date = $request->contract_date;

            // Menghitung persentase perbedaan antara user_estimate dan deal_nego
            if ($request->has('deal_nego')) {
                $userEstimate = floatval(str_replace('.', '', $request->user_estimate));
                $dealNego = floatval(str_replace('.', '', $request->deal_nego));

                $userEstimatePercentage = number_format(($userEstimate - $dealNego) / $userEstimate * 100, 2);
                $procurement->user_percentage = $userEstimatePercentage;
            } else {
                $procurement->user_percentage = null; // Atau berikan nilai default jika tidak diperlukan
            }

            // Menghitung persentase perbedaan antara technique_estimate dan deal_nego
            if ($request->has('deal_nego')) {
                $techniqueEstimate = floatval(str_replace('.', '', $request->technique_estimate));
                $dealNego = floatval(str_replace('.', '', $request->deal_nego));

                $techniqueEstimatePercentage = number_format(($techniqueEstimate - $dealNego) / $techniqueEstimate * 100, 2);
                $procurement->technique_percentage = $techniqueEstimatePercentage;
            } else {
                $procurement->technique_percentage = null; // Atau berikan nilai default jika tidak diperlukan
            }

            $procurement->save();

            // Update data di tabel Tender jika $request->tender_ids ada
            if ($request->has('tender_ids')) {
                foreach ($request->tender_ids as $tenderId) {
                    $tender = Tender::find($tenderId);

                    if ($tender) {
                        $negotiationResult = str_replace('.', '', $request->input('negotiation_result_' . $tenderId));

                        // Sesuaikan ini dengan kolom-kolom yang ingin Anda update pada tabel Tender
                        $tender->report_nego_result = $request->input('report_nego_result_' . $tenderId);
                        $tender->negotiation_result = $negotiationResult;

                        $tender->save();
                    } else {
                        return response()->json(['message' => 'Tender not found'], 404);// Handle jika $tender tidak ditemukan
                    }
                }
            }

            Alert::success('Success', 'Procurement data has been updated.');
            return redirect()->route('administration.index');
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->back(); // Cetak pesan kesalahan untuk mendiagnosis
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($file_id)
    {
        $file = ProcurementFile::findOrFail($file_id);

        // Delete the file from storage
        Storage::disk('public')->delete($file->path);

        // Delete the file record from the database
        $file->delete();

        Alert::success('Success','File deleted successfully');
        return redirect()->back();
    }

    public function change($id)
    {
        $procurement = Procurement::findOrFail($id);
        $divisions = Division::where('status', '1')->get();
        $officials = Official::where('status', '1')->get();

        $tendersCount = $procurement->tendersCount();
        $statusProcurement = $procurement->status;
        $tenderIds = $procurement->tenders->pluck('id')->toArray();

        $tenderData = Tender::whereIn('id', $tenderIds)
            ->get(['id', 'aanwijzing', 'open_tender', 'review_technique_in', 'review_technique_out'])
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'aanwijzing' => $item->aanwijzing,
                    'open_tender' => $item->open_tender,
                    'review_technique_in' => $item->review_technique_in,
                    'review_technique_out' => $item->review_technique_out,
                ];
            })
            ->toArray();

        return view('procurement.administration.change', compact('procurement', 'divisions', 'officials', 'tendersCount', 'statusProcurement', 'tenderData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function save(Request $request, $id)
    {
        // dd($id);
        try {
            $procurement = Procurement::find($id);

            $procurement->ppoe_accepted = $request->ppoe_accepted;
            $procurement->division_disposition = $request->division_disposition;
            $procurement->departement_disposition = $request->departement_disposition;
            $procurement->vendor_offer = $request->vendor_offer;
            $procurement->disposition_second_tender = $request->disposition_second_tender;
            $procurement->renegotiation_result = $request->renegotiation_result;
            $procurement->tender_result = $request->tender_result;
            $procurement->director_agreement = $request->director_agreement;
            $procurement->legal_accept = $request->legal_accept;
            $procurement->general_accept = $request->general_accept;
            $procurement->user_accept = $request->user_accept;
            $procurement->vendor_accept = $request->vendor_accept;
            $procurement->director_accept = $request->director_accept;
            $procurement->contract_from_legal = $request->contract_from_legal;
            $procurement->contract_to_vendor = $request->contract_to_vendor;
            $procurement->contract_to_user = $request->contract_to_user;
            $procurement->input_sap = $request->input_sap;

            $procurement->save();

            // Update data di tabel Tender jika $request->tender_ids ada
            if ($request->has('tender_ids')) {
                foreach ($request->tender_ids as $tenderId) {
                    $tender = Tender::find($tenderId);

                    if ($tender) {
                        // Sesuaikan ini dengan kolom-kolom yang ingin Anda update pada tabel Tender
                        $tender->aanwijzing = $request->input('aanwijzing_' . $tenderId);
                        $tender->open_tender = $request->input('open_tender_' . $tenderId);
                        $tender->review_technique_in = $request->input('review_technique_in_' . $tenderId);
                        $tender->review_technique_out = $request->input('review_technique_out_' . $tenderId);

                        $tender->save();
                    } else {
                        return response()->json(['message' => 'Tender not found'], 404);// Handle jika $tender tidak ditemukan
                    }
                }
            }

            Alert::success('Success', 'Procurement data has been updated.');
            return redirect()->route('administration.index');
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->back(); // Cetak pesan kesalahan untuk mendiagnosis
        }
    }

    public function done($id)
    {
        try {
            $procurement = Procurement::find($id);
            $procurement->is_done = 1;
            $procurement->save();
            Alert::success('Success', 'Procurement data has been done.');
            return to_route ('administration.index');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
        }
    }

    public function back($id)
    {
        try {
            $procurement = Procurement::find($id);
            $procurement->is_done = 0;
            $procurement->save();
            Alert::success('Success', 'Procurement data has been rollback.');
            return to_route ('administration.index');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
        }
    }

    public function view($id)
    {
        $procurement = Procurement::findOrFail($id);
        $procurementStatus = $procurement->status;
        $tendersCount = $procurement->tendersCount();
        $tenderIds = $procurement->tenders->pluck('id')->toArray();

        $tenderData = Tender::whereIn('id', $tenderIds)
            ->get(['id', 'report_nego_result', 'negotiation_result'])
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'report_nego_result' => $item->report_nego_result,
                    'negotiation_result' => $item->negotiation_result,
                ];
            })
            ->toArray();

            $files = ProcurementFile::where('procurement_id', $id)
            ->orderByDesc('created_at')
            ->get();

            $definitions = [];
            foreach ($files as $file) {
                $definitions[$file->id] = Definition::find($file->definition_id);
            }

        return view ('procurement.administration.view', compact('procurement', 'procurementStatus', 'tenderData', 'tendersCount', 'files', 'definitions'));
    }
}
