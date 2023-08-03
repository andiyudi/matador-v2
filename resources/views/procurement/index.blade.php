@extends('layouts.template')
@section('content')
@php
$pretitle = 'Data';
$title    = 'Procurements'
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table id="table-divisions" class="table table-responsive table-bordered table-striped table-hover">
                    {{ $dataTable->table() }}
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('page-action')
    <button type="button" class="btn btn-primary">
        Add Procurement Data
    </button>
@endpush
@push('after-script')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
