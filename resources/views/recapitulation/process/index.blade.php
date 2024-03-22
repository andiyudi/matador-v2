@extends('layouts.template')
@section('content')
@php
$pretitle = 'Rekapitulasi Permintaan';
$title    = 'Masih Dalam Proses Negosiasi';
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="vendorStatus">Masukkan No PP</label>
                            <input type="text" class="form-control" name="number" id="number">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="period">Masukkan Nama Pekerjaan</label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="vendorStatus">Pilih Divisi</label>
                            <select class="form-select" id="division-filter" name="division">
                                <option value="">All Divisions</option>
                                @foreach($divisions as $division)
                                <option value="{{ $division->id }}">{{ $division->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label required" for="period">Pilih Periode</label>
                            <div class="input-group input-daterange">
                                <input type="text" class="form-control" id="startDateTtpp" name="startDateTtpp" placeholder="Start Periode">
                                <span class="input-group-text">to</span>
                                <input type="text" class="form-control" id="endDateTtpp" name="endDateTtpp" placeholder="End Periode">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                    <button class="btn btn-secondary me-md-2" type="button" id="searchBtn">Search</button>
                    <button class="btn btn-primary me-md-2" type="button" id="printBtn" data-toggle="modal" data-target="#printModal">Print</button>
                    <a href="{{ route('recap.process-nego-excel') }}" class="btn btn-success">Export</a>
                </div>
                <iframe id="searchRecapProcessNego" src="" style="width: 100%; height: 500px; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>
@include('recapitulation.process.modal')
@include('recapitulation.process.script')
@endsection
