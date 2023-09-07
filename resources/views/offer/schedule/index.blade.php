@extends('layouts.template')
@section('content')
@php
$pretitle = 'Data PP'. $tender->procurement->number;
$title    = 'Jadwal Lelang '. $tender->procurement->name;
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-responsive table-bordered table-striped table-hover">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Activity</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schedules as $schedule)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $schedule->activity }}</td>
                            <td>{{ $schedule->start_date }}</td>
                            <td>{{ $schedule->end_date }}</td>
                            <td>{{ $schedule->duration }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('page-action')
@if ($scheduleCount == 0)
    <a href="{{ route('schedule.create', $tender->id) }}" class="btn btn-primary mb-3">Add Schedule Data</a>
@endif
@endpush

