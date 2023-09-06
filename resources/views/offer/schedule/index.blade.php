@extends('layouts.template')
@section('content')
@php
$pretitle = 'Data PP'. $tender->procurement->number;
$title    = 'Schedule '. $tender->procurement->name;
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
                                <input class="form-check-input" type="radio" name="schedule_type" id="schedule_type_1" value="1">
                                <label class="form-check-label" for="schedule_type_1">Schedule Normal</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="schedule_type" id="schedule_type_2" value="2">
                                <label class="form-check-label" for="schedule_type_2">Schedule Aanwijzing & Nego</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="schedule_type" id="schedule_type_3" value="3">
                                <label class="form-check-label" for="schedule_type_3">Schedule IKP</label>
                            </div>
                        </div>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @include('offer.schedule.normal')
                @include('offer.schedule.nego')
                @include('offer.schedule.ikp')
            </div>
        </div>
    </div>
</div>
@endsection
@push('after-script')
@include('offer.schedule.js')
@endpush
