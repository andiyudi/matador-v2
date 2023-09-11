@extends('layouts.template')
@section('content')
@php
$pretitle = 'Data PP'. $tender->procurement->number;
$title    = 'Create Schedule '. $tender->procurement->name;
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
                                <input class="form-check-input" type="radio" name="schedule_type" id="schedule_type_0" value="0">
                                <label class="form-check-label" for="schedule_type_0">Schedule Normal</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="schedule_type" id="schedule_type_1" value="1">
                                <label class="form-check-label" for="schedule_type_1">Schedule Aanwijzing & Nego</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="schedule_type" id="schedule_type_2" value="2">
                                <label class="form-check-label" for="schedule_type_2">Schedule IKP</label>
                            </div>
                        </div>
                    </div>
                </div>
                @include('offer.schedule.create.normal')
                @include('offer.schedule.create.nego')
                @include('offer.schedule.create.ikp')
            </div>
        </div>
    </div>
</div>
@endsection
@push('after-script')
@include('offer.schedule.create.js')
@endpush
