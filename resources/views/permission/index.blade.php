@extends('layouts.template')
@section('content')
@php
$pretitle = 'Data';
$title    = 'Permissions'
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
@include('permission.modal')
@endsection
@push('page-action')
@can('permission-create')
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPermissionModal">
        Add Permission Data
</button>
@endcan
@endpush
@push('after-script')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush

