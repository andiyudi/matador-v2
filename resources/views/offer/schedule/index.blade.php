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
                @if ($scheduleCount > 0)
                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label">Jenis Schedule</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="schedule_type" id="schedule_type_0" value="0" {{ $tender->schedule_type == 0 ? 'checked' : '' }} disabled>
                                <label class="form-check-label" for="schedule_type_0">Schedule Normal</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="schedule_type" id="schedule_type_1" value="1" {{ $tender->schedule_type == 1 ? 'checked' : '' }} disabled>
                                <label class="form-check-label" for="schedule_type_1">Schedule Aanwijzing & Nego</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="schedule_type" id="schedule_type_2" value="2" {{ $tender->schedule_type == 2 ? 'checked' : '' }} disabled>
                                <label class="form-check-label" for="schedule_type_2">Schedule IKP</label>
                            </div>
                        </div>
                    </div>
                </div>
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
                            <td class="text-center">{{ $loop->iteration }}.</td>
                            <td>{{ $schedule->activity }}</td>
                            <td>{{ $schedule->start_date }}</td>
                            <td>{{ $schedule->end_date }}</td>
                            <td class="text-center">{{ $schedule->duration }}</td>
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
                            <td class="text-center">{{ $loop->iteration }}.</td>
                            <td>{{ $businessPartner->partner->name }}</td>
                            <td>
                                {{ date('H:i', strtotime($businessPartner->pivot->start_hour)) }}
                            </td>
                            <td>
                                {{ date('H:i', strtotime($businessPartner->pivot->end_hour)) }}
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
            @endif
            </div>
        </div>
    </div>
</div>
@include('offer.schedule.modal')
@include('offer.schedule.script')
@endsection
@push('page-action')
@if ($scheduleCount == 0)
    <a href="{{ route('schedule.create', $tender->id) }}" class="btn btn-primary mb-3">Add Schedule Data</a>
@else
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-info mb-3 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            Print
        </button>
        <ul class="dropdown-menu">
            <li><button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#printSchedule" data-tender="{{ json_encode($tender) }}">Schedule</button></li>
            <li><button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#printAanwijzing" data-tender="{{ json_encode($tender) }}">Berita Acara Aanwijzing</button></li>
            <li><button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#printTinjau" data-tender="{{ json_encode($tender) }}">Berita Acara Peninjauan Lapangan</button></li>
            <li><button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#printBanego" data-tender="{{ json_encode($tender) }}">Berita Acara Negosiasi</button></li>
        </ul>
    </div>
    <a href="{{ route('schedule.edit', $tender->id) }}" class="btn btn-warning mb-3">Edit Schedule Data</a>
@endif
@endpush

