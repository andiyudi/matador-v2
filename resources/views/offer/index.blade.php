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
                <table class="table table-responsive table-bordered table-striped table-hover" id="offer-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No. PP</th>
                            <th>Job Name</th>
                            <th>Division</th>
                            <th>Estimation</th>
                            <th>PIC User</th>
                            <th>Vendors</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--data displayed here-->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#offer-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('offer.index') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'procurement', name: 'procurement' },
                { data: 'job_name', name: 'job_name' },
                { data: 'division', name: 'division' },
                { data: 'estimation', name: 'estimation' },
                { data: 'pic_user', name: 'pic_user' },
                { data: 'vendors', name: 'vendors' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection
@push('page-action')
<a href="{{ route('offer.create') }}" class="btn btn-primary mb-3">Add Tender Data</a>
@endpush
