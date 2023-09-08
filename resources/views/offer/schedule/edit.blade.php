@extends('layouts.template')
@section('content')
@php
$pretitle = 'Data PP'. $tender->procurement->number;
$title    = 'Edit Schedule '. $tender->procurement->name;
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label required">Pilih Jenis Schedule</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="schedule_type" id="schedule_type_1" value="1" {{ $tender->schedule_type == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="schedule_type_1">Schedule Normal</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="schedule_type" id="schedule_type_2" value="2" {{ $tender->schedule_type == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="schedule_type_2">Schedule Aanwijzing & Nego</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="schedule_type" id="schedule_type_3" value="3" {{ $tender->schedule_type == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="schedule_type_3">Schedule IKP</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="schedule_type_1_content" style="display: {{ $tender->schedule_type == 0 ? 'block' : 'none' }};">
                    <!-- Formulir untuk Schedule Normal -->
                    <table class="table table-responsive table-bordered table-striped table-hover">
                        <thead class="text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th width="60%">Activity</th>
                                <th width="15%">Start Date</th>
                                <th width="15%">End Date</th>
                                <th width="5%">Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedules as $schedule)
                            @if ($schedule->schedule_type == 0)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <input type="text" class="form-control" name="activity" id="activity" readonly value="{{ $schedule->activity }}">
                                </td>
                                <td>
                                    <input type="date" class="form-control" name="start_date" id="start_date" value="{{ $schedule->start_date }}">
                                </td>
                                <td>
                                    <input type="date" class="form-control" name="end_date" id="end_date" value="{{ $schedule->end_date }}">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="duration" id="duration" value="{{ $schedule->duration }}" readonly>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="schedule_type_2_content" style="display: {{ $tender->schedule_type == 1 ? 'block' : 'none' }};">
                    <!-- Formulir untuk Schedule Aanwijzing & Nego -->
                    <table class="table table-responsive table-bordered table-striped table-hover">
                        <thead class="text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th width="60%">Activity</th>
                                <th width="15%">Start Date</th>
                                <th width="15%">End Date</th>
                                <th width="5%">Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedules as $schedule)
                            @if ($schedule->schedule_type == 1)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <input type="text" class="form-control" name="activity" id="activity" readonly value="{{ $schedule->activity }}">
                                </td>
                                <td>
                                    <input type="date" class="form-control" name="start_date" id="start_date" value="{{ $schedule->start_date }}">
                                </td>
                                <td>
                                    <input type="date" class="form-control" name="end_date" id="end_date" value="{{ $schedule->end_date }}">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="duration" id="duration" value="{{ $schedule->duration }}" readonly>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="schedule_type_3_content" style="display: {{ $tender->schedule_type == 2 ? 'block' : 'none' }};">
                    <!-- Formulir untuk Schedule IKP -->
                    <table class="table table-responsive table-bordered table-striped table-hover">
                        <thead class="text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th width="60%">Activity</th>
                                <th width="15%">Start Date</th>
                                <th width="15%">End Date</th>
                                <th width="5%">Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedules as $schedule)
                            @if ($schedule->schedule_type == 2)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <input type="text" class="form-control" name="activity" id="activity" readonly value="{{ $schedule->activity }}">
                                </td>
                                <td>
                                    <input type="date" class="form-control" name="start_date" id="start_date" value="{{ $schedule->start_date }}">
                                </td>
                                <td>
                                    <input type="date" class="form-control" name="end_date" id="end_date" value="{{ $schedule->end_date }}">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="duration" id="duration" value="{{ $schedule->duration }}" readonly>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('after-script')
@include('offer.schedule.js')
@endpush
