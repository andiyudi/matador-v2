@extends('layouts.template')
@section('content')
@php
$pretitle = 'Rekapitulasi Dokumen Permintaan';
$title    = 'Berdasarkan Nilai Pekerjaan';
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-justified" id="valueTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="matrixTab" data-bs-toggle="tab" data-bs-target="#matrixContent" type="button" role="tab" aria-controls="matrixContent" aria-selected="true">11.1</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="recapTab" data-bs-toggle="tab" data-bs-target="#recapContent" type="button" role="tab" aria-controls="recapContent" aria-selected="false">11.2</button>
                    </li>
                </ul>
                <div class="tab-content mt-3" id="valueTabsContent">
                    @include('documentation.value.matrix')
                    @include('documentation.value.recap')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
