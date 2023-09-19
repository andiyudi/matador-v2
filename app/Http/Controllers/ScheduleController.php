<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tender;
use App\Models\Schedule;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Riskihajar\Terbilang\Facades\Terbilang;


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
            'is_holiday' => 'required',
            'schedule_type' => 'required|in:0,1,2',
            'secretary' => 'required',
            'note' => 'required',
        ];

        if ($data['schedule_type'] == 0) {
            for ($i = 1; $i <= 10; $i++) {
                $rules['start_date_' . $i] = 'required';
                $rules['end_date_' . $i] = 'required|date|after_or_equal:start_date.*';
            }
        } elseif ($data['schedule_type'] == 1) {
            for ($i = 1; $i <= 9; $i++) {
                $rules['start_date_' . $i] = 'required';
                $rules['end_date_' . $i] = 'required|date|after_or_equal:start_date.*';
            }
        } elseif ($data['schedule_type'] == 2) {
            for ($i = 1; $i <= 12; $i++) {
                $rules['start_date_' . $i] = 'required';
                $rules['end_date_' . $i] = 'required|date|after_or_equal:start_date.*';
            }
        }

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            Alert::error('Validation Error', 'Terjadi kesalahan dalam validasi form. Mohon periksa kembali input Anda.')->persistent(true);
            return redirect()->back()->withErrors($validator)->withInput();
        }
       // Simpan data ke dalam tabel schedules sesuai dengan schedule_type
        $loopCount = ($data['schedule_type'] == 0) ? 10 : (($data['schedule_type'] == 1) ? 9 : 12);

        for ($i = 1; $i <= $loopCount; $i++) {
            $schedule = new Schedule();
            $schedule->tender_id = $data['tender_id'];
            $schedule->is_holiday = $data['is_holiday'];
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
    public function show($id)
    {
        $tender = Tender::findOrFail($id);
        $leadName = request()->query('leadName');
        $leadPosition = request()->query('leadPosition');
        $secretaryName = request()->query('secretaryName');
        $secretaryPosition = request()->query('secretaryPosition');
        $number = request()->query('number');

        $dateString = request()->query('date');
        $date = Carbon::createFromFormat('Y-m-d', $dateString);
        $formattedDate = $date->format('d-m-Y');
        $date->locale('id');

        // Pisahkan tanggal, bulan, dan tahun
        $tgl = $date->day;
        $tanggal = Terbilang::make($tgl);
        $bulan = $date->translatedFormat('F');
        $thn = $date->year;
        $tahun = Terbilang::make($thn);

        $day = $date->translatedFormat('l');
        $location = request()->query('location');

        return view('offer.schedule.show', compact(
            'tender', 'leadName', 'leadPosition', 'secretaryName',
            'secretaryPosition', 'number', 'formattedDate', 'day',
            'location', 'tanggal', 'bulan', 'tahun',
        ));
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
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $this->validate($request, [
            'activity' => 'required|array',
            'start_date' => 'required|array',
            'end_date' => 'required|array',
            'duration' => 'required|array',
            'activity.*' => 'required|string',
            'start_date.*' => 'required|date',
            'end_date.*' => 'required|date|after_or_equal:start_date.*',
            'duration.*' => 'required|numeric',
            'note' => 'required|string',
            'secretary' => 'required|string',
            'start_hour_*' => 'required|date_format:H:i',
            'end_hour_*' => 'required|date_format:H:i',
        ]);
        try {
            $tender = Tender::findOrFail($id);
            foreach ($request->activity as $key => $activity) {
                $scheduleId = $key;
                $schedule = Schedule::findOrFail($request->id_schedule[$key]);
                $schedule->activity = $activity;
                $schedule->start_date = $request->start_date[$scheduleId];
                $schedule->end_date = $request->end_date[$scheduleId];
                $schedule->duration = $request->duration[$scheduleId];
                $schedule->save();
            }
            $tender->note = $request->input('note');
            $tender->secretary = $request->input('secretary');
            $tender->save();
             // Loop melalui business partners dan update pivot table
            foreach ($tender->businessPartners as $businessPartner) {
                $startHourName = 'start_hour_' . $businessPartner->id;
                $endHourName = 'end_hour_' . $businessPartner->id;

                // Ambil nilai start_hour dan end_hour dari request
                $startHour = $request->input($startHourName);
                $endHour = $request->input($endHourName);

                // Update pivot table dengan sync
                $businessPartner->pivot->update([
                    'start_hour' => $startHour,
                    'end_hour' => $endHour,
                ]);
            }
            Alert::success('Success', 'Schedule updated successfully.');
            return redirect()->route('schedule.index', $tender->id);
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $tender = Tender::findOrFail($id);

            // Hapus data dari tabel Schedule
            $tender->schedules()->delete();

            // Set kolom schedule_type, secretary, dan note menjadi null
            $tender->update([
                'schedule_type' => null,
                'secretary' => null,
                'note' => null,
            ]);

            // Set kolom start_hour dan end_hour pada pivot table menjadi null
            foreach ($tender->businessPartners as $businessPartner) {
                $startHourName = 'start_hour_' . $businessPartner->id;
                $endHourName = 'end_hour_' . $businessPartner->id;

                // Update pivot table dengan sync
                $businessPartner->pivot->update([
                    'start_hour' => NULL,
                    'end_hour' => NULL,
                ]);
            }

            Alert::success('Success', 'Schedule deleted successfully, Please make new schedule');
            return redirect()->route('schedule.create', $tender->id);
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function print ($id)
    {
        $tender = Tender::findOrFail($id);
        $schedules = Schedule::where('tender_id', $tender->id)->get();
        $logoPath = public_path('assets/logo/cmnplogo.png');
        $logoData = file_get_contents($logoPath);
        $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        $leadName = request()->query('leadName');
        $leadPosition = request()->query('leadPosition');
        $secretaryName = request()->query('secretaryName');
        $secretaryPosition = request()->query('secretaryPosition');
        return view ('offer.schedule.print', compact('logoBase64', 'tender', 'leadName', 'leadPosition','secretaryName', 'secretaryPosition', 'schedules'));
    }


    public function detail()
    {
        return 'hello world';
    }
}
