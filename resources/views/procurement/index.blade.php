@extends('layouts.template')
@section('content')
@php
$pretitle = 'Data';
$title    = 'Procurements';
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                    {{ $dataTable->table() }}
            </div>
        </div>
    </div>
</div>
@endsection
@push('page-action')
<a href="{{ route('procurements.create') }}" class="btn btn-primary mb-3">Add Procurement Data</a>
@endpush
@push('after-script')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
