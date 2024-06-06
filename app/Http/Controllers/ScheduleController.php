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
        $schedules->transform(function ($schedule) {
            $schedule->start_date = $schedule->start_date ? Carbon::parse($schedule->start_date)->format('d-m-Y') : '';
            $schedule->end_date = $schedule->end_date ? Carbon::parse($schedule->end_date)->format('d-m-Y') : '';
            return $schedule;
        });
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
            for ($i = 1; $i <= 11; $i++) {
                if ($i === 4) {
                    $rules['start_date_' . $i] = 'nullable';
                    $rules['end_date_' . $i] = 'nullable|date|after_or_equal:start_date.*';
                } else {
                    $rules['start_date_' . $i] = 'required';
                    $rules['end_date_' . $i] = 'required|date|after_or_equal:start_date.*';
                }
            }
        } elseif ($data['schedule_type'] == 1) {
            for ($i = 1; $i <= 9; $i++) {
                $rules['start_date_' . $i] = 'required';
                $rules['end_date_' . $i] = 'required|date|after_or_equal:start_date.*';
            }
        } elseif ($data['schedule_type'] == 2) {
            for ($i = 1; $i <= 12; $i++) {
                if ($i === 4) {
                    $rules['start_date_' . $i] = 'nullable';
                    $rules['end_date_' . $i] = 'nullable|date|after_or_equal:start_date.*';
                } else {
                    $rules['start_date_' . $i] = 'required';
                    $rules['end_date_' . $i] = 'required|date|after_or_equal:start_date.*';
                }
            }
        }

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            Alert::error('Validation Error', 'Terjadi kesalahan dalam validasi form. Mohon periksa kembali input Anda.')->persistent(true);
            return redirect()->back()->withErrors($validator)->withInput();
        }
       // Simpan data ke dalam tabel schedules sesuai dengan schedule_type
        $countData = ($data['schedule_type'] == 0) ? 11 : (($data['schedule_type'] == 1) ? 9 : 12);

        for ($i = 1; $i <= $countData; $i++) {
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

        Alert::success('Success', 'Schedule Tender Successfully Saved');
        return to_route('schedule.index', $data['tender_id']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //aanwijzing
        $tender = Tender::findOrFail($id);
        $leadAanwijzingName = request()->query('leadAanwijzingName');
        $leadAanwijzingPosition = request()->query('leadAanwijzingPosition');
        $secretaryAanwijzingName = request()->query('secretaryAanwijzingName');
        $secretaryAanwijzingPosition = request()->query('secretaryAanwijzingPosition');
        $aanwijzingNumber = request()->query('aanwijzingNumber');

        $dateString = request()->query('aanwijzingDate');
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
        $location = request()->query('aanwijzingLocation');

        return view('offer.schedule.show', compact(
            'tender', 'leadAanwijzingName', 'leadAanwijzingPosition', 'secretaryAanwijzingName',
            'secretaryAanwijzingPosition', 'aanwijzingNumber', 'formattedDate', 'day',
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
            // 'start_date.*' => 'required|date',
            // 'end_date.*' => 'required|date|after_or_equal:start_date.*',
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
        $schedules->transform(function ($schedule) {
            $schedule->start_date = $schedule->start_date ? Carbon::parse($schedule->start_date)->format('d-m-Y') : '';
            $schedule->end_date = $schedule->end_date ? Carbon::parse($schedule->end_date)->format('d-m-Y') : '';
            return $schedule;
        });
        $logoPath = public_path('assets/logo/cmnplogo.png');
        $logoData = file_get_contents($logoPath);
        $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        $leadName = request()->query('leadName');
        $leadPosition = request()->query('leadPosition');
        $secretaryName = request()->query('secretaryName');
        $secretaryPosition = request()->query('secretaryPosition');
        return view ('offer.schedule.print', compact('logoBase64', 'tender', 'leadName', 'leadPosition','secretaryName', 'secretaryPosition', 'schedules'));
    }


    public function detail($id)
    {
        //ba nego
        $tender = Tender::findOrFail($id);
        $banegoNumber = request()->query('banegoNumber');
        $dateString = request()->query('banegoDate');
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
        $location = request()->query('banegoLocation');

        $leadBanegoName = request()->query('leadBanegoName');
        $leadBanegoPosition = request()->query('leadBanegoPosition');
        $secretaryBanegoName = request()->query('secretaryBanegoName');
        $secretaryBanegoPosition = request()->query('secretaryBanegoPosition');

        if ($tender->schedule_type === 0 || $tender->schedule_type === 1) {
            return view('offer.schedule.detail-non-ikp', compact('tender','banegoNumber', 'day', 'tanggal', 'bulan', 'tahun', 'formattedDate', 'location', 'leadBanegoName', 'leadBanegoPosition', 'secretaryBanegoName', 'secretaryBanegoPosition'));
        } else {
            return view('offer.schedule.detail-ikp', compact('tender','banegoNumber', 'day', 'tanggal', 'bulan', 'tahun', 'formattedDate', 'location', 'leadBanegoName', 'leadBanegoPosition', 'secretaryBanegoName', 'secretaryBanegoPosition'));
        }
    }

    public function view($id)
    {
        //peninjauan lapangan
        $tender = Tender::findOrFail($id);
        $leadTinjauName = request()->query('leadTinjauName');
        $leadTinjauPosition = request()->query('leadTinjauPosition');
        $secretaryTinjauName = request()->query('secretaryTinjauName');
        $secretaryTinjauPosition = request()->query('secretaryTinjauPosition');

        $dateString = request()->query('tinjauDate');
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

        $jumlahVendor = count($tender->businessPartners);
        $terbilangVendor = Terbilang::make($jumlahVendor);

        return view('offer.schedule.view', compact(
            'tender', 'leadTinjauName', 'leadTinjauPosition', 'secretaryTinjauName',
            'secretaryTinjauPosition', 'formattedDate', 'day', 'tgl', 'thn',
            'location', 'tanggal', 'bulan', 'tahun','jumlahVendor', 'terbilangVendor'
        ));
    }

    public function invitation($id)
    {
        $tender = Tender::findOrFail($id);

        $invitationNumber = request()->query('invitationNumber');
        $invitationDate = request()->query('invitationDate');
        $meetingDate = request()->query('meetingDate');
        $meetingTime = request()->query('meetingTime');
        $meetingLocation = request()->query('meetingLocation');
        $zoomId = request()->query('zoomId');
        $zoomPass = request()->query('zoomPass');
        $leadInvitationName = request()->query('leadInvitationName');
        $leadInvitationPosition = request()->query('leadInvitationPosition');

        $invitationDateCarbon = Carbon::parse($invitationDate);
        $day = $invitationDateCarbon->format('d');
        $month = $invitationDateCarbon->getTranslatedMonthName();
        $year = $invitationDateCarbon->format('Y');

        $formattedDate = $day . " " . $month . " " . $year;

        $carbonMeetingDate = Carbon::parse($meetingDate);
        $hari = $carbonMeetingDate->translatedFormat('l');
        $tanggal = $carbonMeetingDate->format('d');
        $bulan = $carbonMeetingDate->getTranslatedMonthName();
        $tahun = $carbonMeetingDate->format('Y');

        $meetDate = $hari . ", " . $tanggal . " " . $bulan . " " . $tahun;


        return view('offer.schedule.invitation', compact('tender', 'invitationNumber', 'formattedDate', 'meetDate', 'meetingTime', 'meetingLocation', 'zoomId', 'zoomPass', 'leadInvitationName', 'leadInvitationPosition'));
    }
}
