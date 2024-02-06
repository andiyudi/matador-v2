@extends('layouts.template')
@section('content')
@php
$pretitle = 'Tender '. $tender->procurement->name;
$title    = 'Negotiation '. $tender->procurement->number;
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
<a href="{{ route('negotiation.create', $tender->id) }}" class="btn btn-primary mb-3">Add Negotiation Data</a>
@endpush
