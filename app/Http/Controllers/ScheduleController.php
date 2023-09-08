<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use App\Models\Schedule;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;


class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $tender = Tender::findOrFail($id);
        $scheduleCount = Schedule::where('tender_id', $tender->id)->count();
        $schedules = Schedule::where('tender_id', $tender->id)->get();
        return view('offer.schedule.index', compact('tender', 'schedules', 'scheduleCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $tender = Tender::findOrFail($id);
        return view('offer.schedule.create', compact('tender'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->all();

        // Lakukan validasi data sesuai kebutuhan
        $rules = [
            // Definisikan aturan validasi yang sesuai dengan kebutuhan Anda
            'tender_id' => 'required|exists:tenders,id',
            'category' => 'required',
            'schedule_type' => 'required|in:0,1,2',
            'secretary' => 'required',
            'note' => 'required',
        ];

        if ($data['schedule_type'] == 0) {
            for ($i = 1; $i <= 1; $i++) {
                $rules['start_date_' . $i] = 'required';
                $rules['end_date_' . $i] = 'required';
            }
        } elseif ($data['schedule_type'] == 1) {
            for ($i = 1; $i <= 2; $i++) {
                $rules['start_date_' . $i] = 'required';
                $rules['end_date_' . $i] = 'required';
            }
        } elseif ($data['schedule_type'] == 2) {
            for ($i = 1; $i <= 3; $i++) {
                $rules['start_date_' . $i] = 'required';
                $rules['end_date_' . $i] = 'required';
            }
        }

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            Alert::error('Validation Error', 'Terjadi kesalahan dalam validasi form. Mohon periksa kembali input Anda.')->persistent(true);
            return redirect()->back()->withErrors($validator)->withInput();
        }
       // Simpan data ke dalam tabel schedules sesuai dengan schedule_type
        $loopCount = ($data['schedule_type'] == 0) ? 1 : (($data['schedule_type'] == 1) ? 2 : 3);

        for ($i = 1; $i <= $loopCount; $i++) {
            $schedule = new Schedule();
            $schedule->tender_id = $data['tender_id'];
            $schedule->category = $data['category'];
            $schedule->activity = $data['activity_' . $i];
            $schedule->start_date = $data['start_date_' . $i];
            $schedule->end_date = $data['end_date_' . $i];
            $schedule->duration = $data['duration_' . $i];
            $schedule->save();
        }

        // Update schedule_type di dalam tabel tenders
        $tender = Tender::find($data['tender_id']);
        $tender->schedule_type = $data['schedule_type'];
        $tender->secretary = $data['secretary'];
        $tender->note = $data['note'];
        $tender->save();

        $businessPartners = $tender->businessPartners;
        foreach ($businessPartners as $businessPartner) {
            $pivotData = [
                'start_hour' => $data['start_hour_' . $businessPartner->id],
                'end_hour' => $data['end_hour_' . $businessPartner->id],
            ];

            $tender->businessPartners()->updateExistingPivot($businessPartner->id, $pivotData);
        }
        // Redirect atau berikan respons sesuai kebutuhan Anda
        // ...

        Alert::success('Success', 'Schedule Tender Successfully Saved');
        return to_route('schedule.index', $data['tender_id']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tender = Tender::findOrFail($id);
        $schedules = Schedule::where('tender_id', $tender->id)->get();
        return view('offer.schedule.edit', compact('tender', 'schedules'));
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
