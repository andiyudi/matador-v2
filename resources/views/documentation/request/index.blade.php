@extends('layouts.template')
@section('content')
@php
$pretitle = 'Rekapitulasi Dokumen';
$title    = 'Permintaan Masuk';
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-justified" id="requestTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="matrixTab" data-bs-toggle="tab" data-bs-target="#matrixContent" type="button" role="tab" aria-controls="matrixContent" aria-selected="true">Monthly Recapitulation</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="recapTab" data-bs-toggle="tab" data-bs-target="#recapContent" type="button" role="tab" aria-controls="recapContent" aria-selected="false">Annual Recapitulation</button>
                    </li>
                </ul>
                <div class="tab-content mt-3" id="requestTabsContent">
                    @include('documentation.request.matrix')
                    @include('documentation.request.recap')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
