@extends('layouts.template')
@section('content')
@php
$pretitle = 'Calendar';
$title    = 'Pengadaan';
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                @can('dashboard-calendar')
                <div class="responsive">
                    <div id='calendar'></div>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'id',
            initialView: 'dayGridMonth',
            themeSystem: 'bootstrap5',
            height: 'auto',
            weekNumbers: true,
            // businessHours: true,
            weekends:false,
            showNonCurrentDates: false,
            events: "{{ route('event.show') }}",
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'multiMonthYear,dayGridMonth,listWeek,listDay'
            },
            buttonText: {
                multiMonthYear: 'Year',
                dayGridMonth: 'Month',
                listWeek: 'Week',
                listDay: 'Day',
                today: 'Today',
            },
            eventContent: function(arg) {
                let title = arg.event.title; // Default to title (initials and number)
                let activity = arg.event.extendedProps.activity;
                let procurement_name = arg.event.extendedProps.procurement_name;

                if (arg.view.type === 'listWeek' || arg.view.type === 'listDay') {
                    title += '<br>' + procurement_name + '<br>' + activity; // Include activity for listDay view
                }

                return { html: title };
            },
        });
        calendar.render();
    });
</script>
@endsection
