@extends('layouts.template')
@section('content')
@php
$pretitle = 'Data Evaluation';
$title    = 'ISO Report';
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-justified" id="reviewTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="vendorTab" data-bs-toggle="tab" data-bs-target="#vendorContent" type="button" role="tab" aria-controls="vendorContent" aria-selected="true">Rekap Vendor Evaluation</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="companyTab" data-bs-toggle="tab" data-bs-target="#companyContent" type="button" role="tab" aria-controls="companyContent" aria-selected="false">Rekap Company Evaluation</button>
                    </li>
                </ul>
                <div class="tab-content mt-3" id="reviewTabsContent">
                    @include('review.vendor')
                    @include('review.company')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
