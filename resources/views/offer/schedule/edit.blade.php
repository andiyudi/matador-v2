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
                <form action="{{ route ('schedule.update', $tender->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label required">Pilih Jenis Schedule</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="schedule_type" id="schedule_type_0" value="0" {{ $tender->schedule_type == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="schedule_type_0">Schedule Normal</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="schedule_type" id="schedule_type_1" value="1" {{ $tender->schedule_type == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="schedule_type_1">Schedule Aanwijzing & Nego</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="schedule_type" id="schedule_type_2" value="2" {{ $tender->schedule_type == 2 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="schedule_type_2">Schedule IKP</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="schedule_tables">
                        <div id="schedule_type_0_content" style="display: {{ $tender->schedule_type == 0 && $schedules->where('schedule_type', 0)->isNotEmpty() ? 'block' : 'none' }};">
                            @if ($schedules->where('schedule_type', 0)->isNotEmpty())
                            <table class="table table-responsive table-bordered table-striped table-hover">
                                <thead class="text-center">
                                    <tr>
                                        <th width="5%">Normal</th>
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
                                        <td class="text-center">{{ $loop->iteration }}.</td>
                                        <td>
                                            <input type="text" class="form-control" name="activity_{{ $loop->iteration }}" id="data_normal_activity_{{ $loop->iteration }}" value="{{ $schedule->activity }}" readonly>
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="data_start_date_{{ $loop->iteration }}" id="data_normal_start_date_{{ $loop->iteration }}" value="{{ $schedule->start_date }}" onchange="calculateDuration('data', {{ $loop->iteration }})">
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="data_end_date_{{ $loop->iteration }}" id="data_normal_end_date_{{ $loop->iteration }}" value="{{ $schedule->end_date }}" onchange="calculateDuration('data', {{ $loop->iteration }})">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="data_duration_{{ $loop->iteration }}" id="data_normal_duration_{{ $loop->iteration }}" value="{{ $schedule->duration }}" readonly>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <table class="table table-responsive table-bordered table-striped table-hover">
                                <thead class="text-center">
                                    <tr>
                                        <th width="5%">Normal</th>
                                        <th width="60%">Activity</th>
                                        <th width="15%">Start Date</th>
                                        <th width="15%">End Date</th>
                                        <th width="5%">Duration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">1.</td>
                                        <td>
                                            <input type="text" class="form-control" name="activity_1" id="template_normal_activity_1" value="Pengiriman Dokumen Tender Via Email" readonly>
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="template_start_date_1" id="template_normal_start_date_1" onchange="calculateDuration('template', 1)">
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="template_end_date_1" id="template_normal_end_date_1" onchange="calculateDuration('template', 1)">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="template_duration_1" id="template_normal_duration_1" value="0" readonly>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @endif
                        </div>
                        <div id="schedule_type_1_content" style="display: {{ $tender->schedule_type == 1 && $schedules->where('schedule_type', 1)->isNotEmpty() ? 'block' : 'none' }};">
                            @if ($schedules->where('schedule_type', 1)->isNotEmpty())
                            <table class="table table-responsive table-bordered table-striped table-hover">
                                <thead class="text-center">
                                    <tr>
                                        <th width="5%">Nego</th>
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
                                        <td class="text-center">{{ $loop->iteration }}.</td>
                                        <td>
                                            <input type="text" class="form-control" name="activity_{{ $loop->iteration }}" id="data_nego_activity_{{ $loop->iteration }}" value="{{ $schedule->activity }}" readonly>
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="data_start_date_{{ $loop->iteration }}" id="data_nego_start_date_{{ $loop->iteration }}" value="{{ $schedule->start_date }}" onchange="calculateDuration('data', {{ $loop->iteration }})">
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="data_end_date_{{ $loop->iteration }}" id="data_nego_end_date_{{ $loop->iteration }}" value="{{ $schedule->end_date }}" onchange="calculateDuration('data', {{ $loop->iteration }})">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="data_duration_{{ $loop->iteration }}" id="data_nego_duration_{{ $loop->iteration }}" value="{{ $schedule->duration }}" readonly>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <table class="table table-responsive table-bordered table-striped table-hover">
                                <thead class="text-center">
                                    <tr>
                                        <th width="5%">Nego</th>
                                        <th width="60%">Activity</th>
                                        <th width="15%">Start Date</th>
                                        <th width="15%">End Date</th>
                                        <th width="5%">Duration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">1.</td>
                                        <td>
                                            <input type="text" class="form-control" name="activity_1" id="template_nego_activity_1" value="Pengiriman Dokumen Tender Via Email (Mitra Kerja Terseleksi)" readonly>
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="template_start_date_1" id="template_nego_start_date_1" onchange="calculateDuration('template', 1)">
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="template_end_date_1" id="template_nego_end_date_1" onchange="calculateDuration('template', 1)">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="template_duration_1" id="template_nego_duration_1" value="0" readonly>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @endif
                        </div>
                        <div id="schedule_type_2_content" style="display: {{ $tender->schedule_type == 2 && $schedules->where('schedule_type', 2)->isNotEmpty() ? 'block' : 'none' }};">
                            @if ($schedules->where('schedule_type', 2)->isNotEmpty())
                            <table class="table table-responsive table-bordered table-striped table-hover">
                                <thead class="text-center">
                                    <tr>
                                        <th width="5%">Ikp</th>
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
                                        <td class="text-center">{{ $loop->iteration }}.</td>
                                        <td>
                                            <input type="text" class="form-control" name="activity_{{ $loop->iteration }}" id="data_ikp_activity_{{ $loop->iteration }}" value="{{ $schedule->activity }}" readonly>
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="data_start_date_{{ $loop->iteration }}" id="data_ikp_start_date_{{ $loop->iteration }}" value="{{ $schedule->start_date }}" onchange="calculateDuration('data', {{ $loop->iteration }})">
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="data_end_date_{{ $loop->iteration }}" id="data_ikp_end_date_{{ $loop->iteration }}" value="{{ $schedule->end_date }}" onchange="calculateDuration('data', {{ $loop->iteration }})">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="data_duration_{{ $loop->iteration }}" id="data_ikp_duration_{{ $loop->iteration }}" value="{{ $schedule->duration }}" readonly>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <table class="table table-responsive table-bordered table-striped table-hover">
                                <thead class="text-center">
                                    <tr>
                                        <th width="5%">Ikp</th>
                                        <th width="60%">Activity</th>
                                        <th width="15%">Start Date</th>
                                        <th width="15%">End Date</th>
                                        <th width="5%">Duration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">1.</td>
                                        <td>
                                            <input type="text" class="form-control" name="activity_1" id="template_ikp_activity_1" value="Pengiriman Dokumen Tender" readonly>
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="template_start_date_1" id="template_ikp_start_date_1" onchange="calculateDuration('template', 1)">
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="template_end_date_1" id="template_ikp_end_date_1" onchange="calculateDuration('template', 1)">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="template_duration_1" id="template_ikp_duration_1" value="0" readonly>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Leave a comment here" name="note" id="note" style="height:100px">{{ $tender->note }}</textarea>
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
                                    <input type="time" class="form-control" name="start_hour_{{ $businessPartner->id }}" id="start_hour_{{ $businessPartner->id }}" value="{{ $businessPartner->pivot->start_hour }}">
                                </td>
                                <td>
                                    <input type="time" class="form-control" name="end_hour_{{ $businessPartner->id }}" id="end_hour_{{ $businessPartner->id }}" value="{{ $businessPartner->pivot->end_hour }}">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row mb-3">
                        <label for="secretary" class="col-sm-2 col-form-label required">Secretary Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('secretary') is-invalid @enderror" id="secretary" name="secretary" value="{{ $tender->secretary }}" placeholder="Input Secretary Name">
                            @error('secretary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-grid gap-2 mt-3 d-md-flex justify-content-md-end">
                        <a type="button" href="{{ route('schedule.index', $tender->id) }}" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function calculateDuration(scheduleType, index) {
        var startDate = document.getElementById(scheduleType + '_start_date_' + index).value;
        var endDate = document.getElementById(scheduleType + '_end_date_' + index).value;
        if (startDate && endDate) {
            var startDateObj = new Date(startDate);
            var endDateObj = new Date(endDate);
            var timeDiff = endDateObj - startDateObj;
            var durationDays = timeDiff / (1000 * 60 * 60 * 24) + 1;
            document.getElementById(scheduleType + '_duration_' + index).value = durationDays;
        } else {
            document.getElementById(scheduleType + '_duration_' + index).value = 0;
        }
    }
    function showHideScheduleTables() {
        var selectedType = $('input[name="schedule_type"]:checked').val();
        $('#schedule_type_0_content, #schedule_type_1_content, #schedule_type_2_content').hide();
        $('#schedule_type_' + selectedType + '_content').show();
    }
    $(document).ready(function() {
        showHideScheduleTables();
    });
    $('input[name="schedule_type"]').change(showHideScheduleTables);
    $('input[type="date"]').change(function() {
        var inputId = $(this).attr('id');
        var parts = inputId.split('_');
        var scheduleType = parts[0];
        var index = parts[3];
        calculateDuration(scheduleType, index);
    });
</script>
@endsection
