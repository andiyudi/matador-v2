@extends('layouts.template')
@section('content')
@php
$pretitle = 'Data';
$title    = 'Tender'
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

            </div>
        </div>
    </div>
</div>
@endsection
@push('page-action')
<a href="{{ route('offer.create') }}" class="btn btn-primary mb-3">Add Tender Data</a>
@endpush
