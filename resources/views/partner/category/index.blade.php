@extends('layouts.template')
@section('content')
@php
$pretitle = 'Data';
$title    = 'Category Vendors'
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
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#category-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('category.index') }}',
            columns: [
                {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
                name: 'row_number',
                searchable: false,
                orderable: false,
                },
                { data: 'partner_name', name: 'partner_name' },
                { data: 'core_business_name', name: 'core_business_name' },
                { data: 'business_name', name: 'business_name' },
                { data: 'status', name: 'status' },
            ]
        });
    });
</script>
@endsection
@push('page-action')
<a href="{{ route('category.create') }}" class="btn btn-primary mb-3">Add Vendor Categories</a>
@endpush
