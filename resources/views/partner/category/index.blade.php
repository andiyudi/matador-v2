@extends('layouts.template')
@section('content')
@php
$pretitle = 'Data';
$title    = 'Category Vendors';
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-responsive table-bordered table-striped table-hover" id="category-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Vendor Name</th>
                            <th>Core Business</th>
                            <th>Classification</th>
                            <th>Status Vendor</th>
                            <th>Blacklist At</th>
                            <th>Can Whitelist At</th>
                            <th>Whitelist At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('partner.category.js')
@endsection
@push('page-action')
<a href="{{ route('category.create') }}" class="btn btn-primary mb-3">Add Vendor Categories</a>
@endpush
