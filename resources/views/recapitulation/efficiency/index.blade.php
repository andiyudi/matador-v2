@extends('layouts.template')
@section('content')
@php
$pretitle = 'Efisiensi Biaya';
$title    = 'Perseroan';
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="start_month" class="form-label required">Pilih Bulan Awal</label>
                            <select class="form-select" name="start_month" id="start_month">
                                <option value="">Start Month</option>
                                @foreach ($bulan as $key => $name)
                                    <option value="{{ $key }}" {{ $key == 1 ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="end_month" class="form-label required">Pilih Bulan Akhir</label>
                            <select class="form-select" name="end_month" id="end_month">
                                <option value="">End Month</option>
                                @foreach ($bulan as $key => $name)
                                    <option value="{{ $key }}" {{ $key == $currentMonth ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="year" class="form-label required">Pilih Periode</label>
                            <select id="year" class="form-select" name="year">
                                @foreach ($years as $year)
                                    <option value="{{ $year }}" @if ($year == $currentYear) selected @endif>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3 mt-4">
                        <button class="btn btn-secondary me-md-2" type="button" id="searchBtn">Search</button>
                        <button class="btn btn-primary me-md-2" type="button" id="printBtn" data-toggle="modal" data-target="#printModal">Print</button>
                        <a href="{{ route('recap.efficiency-cost-excel') }}" class="btn btn-success">Export</a>
                    </div>
                <iframe id="searchEfficiencyCost" src="" style="width: 100%; height: 500px; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>
@include('recapitulation.efficiency.modal')
@include('recapitulation.efficiency.script')
@endsection
