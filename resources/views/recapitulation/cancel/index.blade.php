@extends('layouts.template')
@section('content')
@php
$pretitle = 'Rekapitulasi Permintaan';
$title    = 'Dibatalkan';
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="">Masukkan No PP</label>
                            <input type="text" class="form-control" name="" id="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="">Masukkan Nama Pekerjaan</label>
                            <input type="text" class="form-control" name="" id="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="vendorStatus">Nilai Pekerjaan</label>
                            <input type="text" class="form-control" name="number" id="number">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="">Tanggal Pengembalian Ke User</label>
                            <input type="date" class="form-control" id="" name="" placeholder="Start Periode">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="">Tanggal Memo Pembatalan</label>
                            <input type="text" class="form-control" id="" name="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label required" for="">Pilih Periode</label>
                            <div class="input-group input-daterange">
                                <select class="form-select" id="" name="">
                                    <option value="">2024</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                    <button class="btn btn-secondary me-md-2" type="button" id="searchBtn">Search</button>
                    <button class="btn btn-primary me-md-2" type="button" id="printBtn" data-toggle="modal" data-target="#printModal">Print</button>
                    <button type="reset" class="btn btn-success">Export</button>
                </div>
                <iframe id="" src="" style="width: 100%; height: 500px; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection
