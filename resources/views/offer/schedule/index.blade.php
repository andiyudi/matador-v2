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
                <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Leave a comment here" name="note" id="note" style="height:100px" readonly>{{ $tender->note }}</textarea>
                    <label for="note">Keterangan</label>
                </div>
                <table class="table table-responsive table-bordered table-striped table-hover">
                    <thead class="text-center">
                        <th width="5%">No</th>
                        <th width="60%">Nama Vendor</th>
                        <th width="15%">Start Hour</th>
                        <th width="15%">End Hour</th>
                    </thead>
                    <tbody>
                        @foreach ($tender->businessPartners as $businessPartner)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $businessPartner->partner->name }}</td>
                            <td>
                                <input type="time" class="form-control" name="start_hour_{{ $businessPartner->id }}" id="start_hour_{{ $businessPartner->id }}" value="{{ $businessPartner->pivot->start_hour }}" readonly>
                            </td>
                            <td>
                                <input type="time" class="form-control" name="end_hour_{{ $businessPartner->id }}" id="end_hour_{{ $businessPartner->id }}" value="{{ $businessPartner->pivot->end_hour }}" readonly>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row mb-3">
                    <label for="secretary" class="col-sm-2 col-form-label required">Secretary Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('secretary') is-invalid @enderror" id="secretary" name="secretary" value="{{ $tender->secretary }}" placeholder="Input Secretary Name" readonly>
                        @error('secretary')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('page-action')
@if ($scheduleCount == 0)
    <a href="{{ route('schedule.create', $tender->id) }}" class="btn btn-primary mb-3">Add Schedule Data</a>
@else
    <a href="{{ route('schedule.edit', $tender->id) }}" class="btn btn-primary mb-3">Edit Schedule Data</a>
@endif
@endpush

