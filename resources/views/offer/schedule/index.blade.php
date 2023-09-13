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
            @endif
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="printSchedule" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="scheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="printFormSchedule">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleModalLabel">Print Schedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="secretaryName" class="form-label">Secretary Name</label>
                            <input type="text" class="form-control" id="secretaryName" value="{{ $tender->secretary }}" placeholder="Enter secretary name" required>
                        </div>
                        <div class="col mb-3">
                            <label for="selectLeadName" class="form-label">Creator Name</label>
                            <select name="selectLeadName" id="selectLeadName" class="form-select">
                                <option value=""></option>
                            </select>
                            <input type="hidden" class="form-control" id="leadName" name="leadName" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="secretaryPosition" class="form-label">Secretary Position</label>
                            <input type="text" class="form-control" value="Sekretaris PPKH" id="secretaryPosition" placeholder="Enter secretary position" required>
                        </div>
                        <div class="col mb-3">
                            <label for="leadPosition" class="form-label">Lead Position</label>
                            <input type="text" class="form-control" id="leadPosition" value="Ketua PPKH" placeholder="Enter lead position" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Print</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#printSchedule').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var tenderData = button.data('tender');
            var leadNameSelect = $('#selectLeadName');
            leadNameSelect.empty();
            $.ajax({
                url: route("offer.official"),
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $.each(response.data, function(index, official) {
                        leadNameSelect.append($('<option>', {
                            value: official.id,
                            text: official.name,
                            selected: official.id == tenderData.procurement.official_id
                        }));
                    });
                    var selectedOfficialName = leadNameSelect.find('option:selected').text();
                    $('#leadName').val(selectedOfficialName);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
            leadNameSelect.on('change', function() {
                var leadName = leadNameSelect.find('option:selected').text();
                $('#leadName').val(leadName);
            });
            $('#printFormSchedule').submit(function (e) {
            e.preventDefault();
                var leadName = $('#leadName').val();
                var leadPosition = $('#leadPosition').val();
                var secretaryName = $('#secretaryName').val();
                var secretaryPosition = $('#secretaryPosition').val();

                var button = $(event.relatedTarget);
                var id = button.data('tender');

                var printUrl = route('schedule.print', id) +
                    '?leadName=' + encodeURIComponent(leadName) +
                    '&leadPosition=' + encodeURIComponent(leadPosition) +
                    '&secretaryName=' + encodeURIComponent(secretaryName) +
                    '&secretaryPosition=' + encodeURIComponent(secretaryPosition);

                window.open(printUrl, '_blank');

                $('#printSchedule').modal('hide');

                $('#printFormSchedule')[0].reset();
            });
        });
    });
</script>
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
            <li><a type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#printSchedule" data-tender="{{ json_encode($tender) }}">Schedule</a></li>
            <li><a class="dropdown-item" href="#">Aanwijzing</a></li>
            <li><a class="dropdown-item" href="#">Berita Acara</a></li>
        </ul>
    </div>
    <a href="{{ route('schedule.edit', $tender->id) }}" class="btn btn-warning mb-3">Edit Schedule Data</a>
@endif
@endpush

