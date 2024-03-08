@extends('layouts.template')
@section('content')
@php
$pretitle = 'Procurement Data';
$title    = 'Diagrams';
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
                        <th>Procurement</th>
                        <th>Nama Pekerjaan</th>
                        <th>Divisi</th>
                        <th>PIC Pengadaan</th>
                        <th>Status</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @can('dashboard-administration')
    <div class="col-md-12 mt-3">
        <div class="card">
            <div class="card-body">
                <h3>Diagrams</h3>
                <div class="row mb-3">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="chartCard">
                                <div class="chartBox">
                                    <canvas id="pieDiagram"></canvas>
                                    <input type="hidden" id="logoBase64" value="{{ $logoBase64 }}">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                        <button class="btn btn-pill btn-sm btn-outline-cyan" type="button" onclick="downloadPDF()">Download Diagram To PDF</button>
                                    </div>
                                </div>
                            </div>
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
@include('procurement.diagram.table')
@include('procurement.diagram.pie-diagram')
@endpush
