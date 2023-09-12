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
                                @foreach(['Normal', 'Aanwijzing & Nego', 'IKP'] as $index => $scheduleType)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="schedule_type" id="schedule_type_{{ $index }}" value="{{ $index }}" {{ $tender->schedule_type == $index ? 'checked' : '' }} onchange="showHideScheduleTables()">
                                    <label class="form-check-label" for="schedule_type_{{ $index }}">Schedule {{ $scheduleType }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div id="schedule_tables">
                        @foreach(['Normal', 'Aanwijzing & Nego', 'IKP'] as $index => $scheduleType)
                        <div id="schedule_type_{{ $index }}_content" style="display: {{ $tender->schedule_type == $index ? 'block' : 'none' }};">
                            @php
                            if ($scheduleType == 'Normal') {
                                $template = 'Pengiriman Dokumen Tender Via Email';
                            } elseif ($scheduleType == 'Aanwijzing & Nego') {
                                $template = 'Pengiriman Dokumen Tender (Mitra Kerja Terseleksi)';
                            } elseif ($scheduleType == 'IKP') {
                                $template = 'Pengiriman Dokumen Tender';
                            }
                            @endphp
                            @if ($schedules->where('schedule_type', $index)->isNotEmpty())
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
                                @foreach(['Normal', 'Aanwijzing & Nego', 'IKP'] as $index => $scheduleType)
                                    @foreach($schedules->where('schedule_type', $index) as $schedule)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}.</td>
                                        <td>
                                            <input type="text" class="form-control" name="{{ $tender->schedule_type == $index ? 'data' : 'template' }}_{{ strtolower(str_replace(' ', '_', $scheduleType)) }}_activity_{{ $loop->iteration }}" id="{{ $tender->schedule_type == $index ? 'data' : 'template' }}_{{ strtolower(str_replace(' ', '_', $scheduleType)) }}_activity_{{ $loop->iteration }}" value="{{ $tender->schedule_type == $index ? $schedule->activity : $template }}" readonly>
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="{{ $tender->schedule_type == $index ? 'data' : 'template' }}_{{ strtolower(str_replace(' ', '_', $scheduleType)) }}_start_date_{{ $loop->iteration }}" id="{{ $tender->schedule_type == $index ? 'data' : 'template' }}_{{ strtolower(str_replace(' ', '_', $scheduleType)) }}_start_date_{{ $loop->iteration }}" value="{{ $tender->schedule_type == $index ? $schedule->start_date : '' }}" onchange="calculateDuration('{{ $tender->schedule_type == $index ? 'data' : 'template' }}_{{ strtolower(str_replace(' ', '_', $scheduleType)) }}', {{ $loop->iteration }})">
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="{{ $tender->schedule_type == $index ? 'data' : 'template' }}_{{ strtolower(str_replace(' ', '_', $scheduleType)) }}_end_date_{{ $loop->iteration }}" id="{{ $tender->schedule_type == $index ? 'data' : 'template' }}_{{ strtolower(str_replace(' ', '_', $scheduleType)) }}_end_date_{{ $loop->iteration }}" value="{{ $tender->schedule_type == $index ? $schedule->end_date : '' }}" onchange="calculateDuration('{{ $tender->schedule_type == $index ? 'data' : 'template' }}_{{ strtolower(str_replace(' ', '_', $scheduleType)) }}', {{ $loop->iteration }})">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="{{ $tender->schedule_type == $index ? 'data' : 'template' }}_{{ strtolower(str_replace(' ', '_', $scheduleType)) }}_duration_{{ $loop->iteration }}" id="{{ $tender->schedule_type == $index ? 'data' : 'template' }}_{{ strtolower(str_replace(' ', '_', $scheduleType)) }}_duration_{{ $loop->iteration }}" value="{{ $tender->schedule_type == $index ? $schedule->duration : '0' }}" readonly>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                            @else
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
                                    <tr>
                                        <td class="text-center">1.</td>
                                        <td>
                                            <input type="text" class="form-control" name="template_{{ strtolower(str_replace(' ', '_', $scheduleType)) }}_activity_1" id="template_{{ strtolower(str_replace(' ', '_', $scheduleType)) }}_activity_1" value="{{ $template }}" readonly>
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="template_{{ strtolower(str_replace(' ', '_', $scheduleType)) }}_start_date_1" id="template_{{ strtolower(str_replace(' ', '_', $scheduleType)) }}_start_date_1" onchange="calculateDuration('template_{{ strtolower(str_replace(' ', '_', $scheduleType)) }}', 1)">
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="template_{{ strtolower(str_replace(' ', '_', $scheduleType)) }}_end_date_1" id="template_{{ strtolower(str_replace(' ', '_', $scheduleType)) }}_end_date_1" onchange="calculateDuration('template_{{ strtolower(str_replace(' ', '_', $scheduleType)) }}', 1)">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="template_{{ strtolower(str_replace(' ', '_', $scheduleType)) }}_duration_1" id="template_{{ strtolower(str_replace(' ', '_', $scheduleType)) }}_duration_1" value="0" readonly>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Leave a comment here" name="note" id="note" style="height:100px">{{ $tender->note }}</textarea>
                        <label for="note">Keterangan</label>
                    </div>
                    <table class="table table-responsive table-bordered table-striped table-hover">
                        <thead class="text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th width="60%">Nama Vendor</th>
                                <th width="15%">Start Hour</th>
                                <th width="15%">End Hour</th>
                            </tr>
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
        var durationField = document.getElementById(scheduleType + '_duration_' + index);
        if (startDate && endDate) {
            var startDateObj = new Date(startDate);
            var endDateObj = new Date(endDate);
            var timeDiff = endDateObj - startDateObj;
            var durationDays = timeDiff / (1000 * 60 * 60 * 24) + 1;
            durationField.value = durationDays.toFixed(0);
        } else {
            durationField.value = '0';
        }
    }
    function showHideScheduleTables() {
        var selectedType = $('input[name="schedule_type"]:checked').val();
        $('#schedule_tables div').hide();
        $('#schedule_type_' + selectedType + '_content').show();
    }
    $(document).ready(function() {
        showHideScheduleTables();
    });
    $('input[name="schedule_type"]').change(showHideScheduleTables);
    $('input[type="date"]').change(function() {
        var inputId = $(this).attr('id');
        var parts = inputId.split('_');
        var scheduleType = parts[1];
        var index = parts[3];
        calculateDuration(scheduleType, index);
    });
</script>
@endsection
