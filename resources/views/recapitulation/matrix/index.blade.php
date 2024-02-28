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
                            <label class="form-label required" for="">Pilih Periode</label>
                            <div class="input-group input-daterange">
                                <select class="form-select" id="" name="">
                                    <option value="">2024</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3 mt-4">
                                <button class="btn btn-secondary me-md-2" type="button" id="">Search</button>
                                <button class="btn btn-primary me-md-2" type="button" id="" data-toggle="modal" data-target="#">Print</button>
                                <button type="reset" class="btn btn-success">Export</button>
                            </div>
                        </div>
                    </div>
                </div>
                <iframe id="" src="" style="width: 100%; height: 500px; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection
