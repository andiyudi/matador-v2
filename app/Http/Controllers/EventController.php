<?php

namespace App\Http\Controllers;

use DateTime;
use DateInterval;
use App\Models\Schedule;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('offer.event.index');
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
    public function show(Request $request)
    {
        $start = date('Y-m-d', strtotime($request->start));
        $end = date('Y-m-d', strtotime($request->end));

        $schedules = Schedule::with(['tender.procurement.official'])
                        ->where('start_date', '>=', $start)
                        ->where('end_date', '<=', $end)
                        ->get();

        $events = $schedules->map(function ($item) {
            $officialName = $item->tender->procurement->official->initials ?? 'N/A';
            $procurementNumber = $item->tender->procurement->number ?? 'N/A';
            return [
                'id' => $item->id,
                'title' => $officialName . ' - ' . $procurementNumber,
                'extendedProps' => [
                    'activity' => $item->activity,
                ],
                'start' => $item->start_date,
                'end' => $item->end_date,
            ];
        })->toArray();

        $filteredEvents = $this->filterEvents($events);

        return response()->json($filteredEvents);
    }
    private function filterEvents($events)
    {
        $filteredEvents = [];

        foreach ($events as $event) {
            $start = new DateTime($event['start']);
            $end = new DateTime($event['end']);

            // Loop dari tanggal mulai ke tanggal akhir
            while ($start <= $end) {
                $dayOfWeek = $start->format('N'); // N: 1 (Senin) sampai 7 (Minggu)

                // Pastikan hanya hari Senin hingga Jumat yang dimasukkan
                if ($dayOfWeek >= 1 && $dayOfWeek <= 5) { // 1: Senin, 5: Jumat
                    $newEvent = [
                        'id' => $event['id'],
                        'title' => $event['title'],
                        'extendedProps' => $event['extendedProps'],
                        'start' => $start->format('Y-m-d'),
                        'end' => $start->format('Y-m-d'), // Perlu diklarasikan ulang
                    ];

                    $filteredEvents[] = $newEvent;
                }

                $start->add(new DateInterval('P1D'));
            }
        }

        return $filteredEvents;
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
