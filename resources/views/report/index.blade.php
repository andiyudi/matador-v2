@extends('layouts.template')
@section('content')
@php
$pretitle = 'Data Vendor';
$title    = 'ISO Report';
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-justified" id="reportTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="vendorTab" data-bs-toggle="tab" data-bs-target="#vendorContent" type="button" role="tab" aria-controls="vendorContent" aria-selected="true">Rekap Vendor</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="blacklistTab" data-bs-toggle="tab" data-bs-target="#blacklistContent" type="button" role="tab" aria-controls="blacklistContent" aria-selected="false">Rekap Blacklist Category Vendor</button>
                    </li>
                </ul>
                <div class="tab-content mt-3" id="reportTabsContent">
                    @include('report.vendor')
                    @include('report.blacklist')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
