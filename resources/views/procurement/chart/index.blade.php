@extends('layouts.template')
@section('content')
@php
$pretitle = 'Procurement Data';
$title    = 'Charts';
@endphp

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="division" class="col-sm-3 form-label">Division:</label>
                        <select id="division" class="form-select" name="division">
                            <option value="">All Divisions</option>
                            @foreach ($divisions as $division)
                            <option value="{{ $division->id }}">{{ $division->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="official" class="col-sm-3 form-label">Official:</label>
                        <select id="official" class="form-select" name="official">
                            <option value="">All Officials</option>
                            @foreach ($officials as $official)
                            <option value="{{ $official->id }}">{{ $official->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="year" class="col-sm-3 form-label">Tahun:</label>
                        <select id="year" class="form-select" name="year">
                            @foreach ($years as $year)
                                <option value="{{ $year }}" @if ($year == $currentYear) selected @endif>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <table id="dashboard-table" class="table table-responsive table-bordered table-striped table-hover" width="100%">
                    <thead>
                        <th>No</th>
                        <th>Nama Pekerjaan</th>
                        <th>Vendor</th>
                        <th>EE User</th>
                        <th>Hasil</th>
                        <th>% User</th>
                        <th>EE Teknik</th>
                        <th>Selisih</th>
                        <th>% Teknik</th>
                        <th>Jumlah</th>
                        <th>Selesai</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @can('dashboard-administration')
    <div class="col-md-12 mt-3">
        <div class="card">
            <div class="card-body">
                <h3>Charts</h3>
                <div class="row mb-3">
                    <div class="row">
                        <div class="col-lg-12">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan
</div>
@endsection
@push('after-script')
@include('procurement.chart.table')
@include('procurement.chart.bar-chart')
@endpush
