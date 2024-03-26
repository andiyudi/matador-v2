@extends('layouts.template')
@section('content')
@php
$pretitle = 'Matriks';
$title    = 'Perbandingan';
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label required" for="year">Pilih Periode</label>
                            <div class="input-group">
                                <select id="year" class="form-select" name="year">
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}" @if ($year == $currentYear) selected @endif>{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3 mt-4">
                                <button class="btn btn-secondary me-md-2" type="button" id="searchBtn">Search</button>
                                <button class="btn btn-primary me-md-2" type="button" id="printBtn" data-toggle="modal" data-target="#printModal">Print</button>
                                <a href="{{ route('recap.comparison-matrix-excel') }}" class="btn btn-success">Export</a>
                            </div>
                        </div>
                    </div>
                </div>
                <iframe id="searchComparisonMatrix" src="" style="width: 100%; height: 500px; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>
@include('recapitulation.matrix.modal')
@include('recapitulation.matrix.script')
@endsection
