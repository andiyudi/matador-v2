@extends('layouts.template')
@section('content')
@php
$pretitle = 'Perbandingan';
$title    = 'Nilai RKAP vs Verifikasi Teknik vs Negosiasi';
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-justified" id="compareTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="matrixTab" data-bs-toggle="tab" data-bs-target="#matrixContent" type="button" role="tab" aria-controls="matrixContent" aria-selected="true">15.1</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="recapTab" data-bs-toggle="tab" data-bs-target="#recapContent" type="button" role="tab" aria-controls="recapContent" aria-selected="false">15.2</button>
                    </li>
                </ul>
                <div class="tab-content mt-3" id="compareTabsContent">
                    @include('documentation.compare.matrix')
                    @include('documentation.compare.recap')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
