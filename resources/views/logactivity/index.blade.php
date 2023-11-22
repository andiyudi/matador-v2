@extends('layouts.template')
@section('content')
@php
$pretitle = 'Data';
$title    = 'Log Activity'
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
@push('after-script')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
