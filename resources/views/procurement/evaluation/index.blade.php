@extends('layouts.template')
@section('content')
@php
$pretitle = 'Data';
$title    = 'Evaluation'
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-responsive table-bordered table-striped table-hover" id="evaluation-table" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Procurement</th>
                            <th>Job Name</th>
                            <th>Division</th>
                            <th>Estimation</th>
                            <th>PIC User</th>
                            <th>Vendors</th>
                            <th>Pick Vendor</th>
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
        $('#evaluation-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('evaluation.index') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'number', name: 'number' },
                { data: 'name', name: 'name' },
                { data: 'division', name: 'division' },
                { data: 'estimation', name: 'estimation' },
                { data: 'pic_user', name: 'pic_user' },
                { data: 'vendors', name: 'vendors' },
                { data: 'is_selected', name: 'is_selected' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection
