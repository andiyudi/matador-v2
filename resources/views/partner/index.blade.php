@extends('layouts.template')
@section('content')
@php
$pretitle = 'Data';
$title    = 'Vendors'
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-responsive table-bordered table-striped table-hover" id="partner-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Director</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Grade</th>
                            <th>Status</th>
                            <th>Expired At</th>
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
<script>
    $(document).ready(function () {
        $('#partner-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('partner.index') }}',
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
                { data: 'name', name: 'name' },
                { data: 'address', name: 'address' },
                { data: 'director', name: 'director' },
                { data: 'phone', name: 'phone' },
                { data: 'email', name: 'email' },
                { data: 'grade', name: 'grade' },
                { data: 'status', name: 'email' },
                { data: 'expired_at', name: 'expired_at' },
                { data: 'action', name: 'action' },
            ]
        });
    });
</script>
@endsection
@push('page-action')
<a href="{{ route('partner.create') }}" class="btn btn-primary mb-3">Add Vendor Data</a>
@endpush
