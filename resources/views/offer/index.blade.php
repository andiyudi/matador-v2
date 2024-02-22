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
                <table class="table table-responsive table-bordered table-striped table-hover" id="offer-table" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Procurement</th>
                            <th>Job Name</th>
                            <th>Division</th>
                            <th>Estimation</th>
                            <th>PIC PP</th>
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
@include('offer.modal')
<script src="https://twitter.github.io/typeahead.js/js/handlebars.js"></script>
<script id="details-template" type="text/x-handlebars-template">
    <table class="table">
        <tr>
            <td>Job Name :</td>
            <td>@{{job_name}}</td>
        </tr>
    </table>
</script>

<script>
    $(document).ready(function () {
        var template = Handlebars.compile($("#details-template").html());
        var table = $('#offer-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('offer.index') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'number', name: 'number' },
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "searchable":     false,
                    "data":           null,
                    "defaultContent": '<button class="btn btn-sm btn-info">Job Name</button>'
                },
                // { data: 'job_name', name: 'job_name' },
                { data: 'division', name: 'division' },
                { data: 'estimation', name: 'estimation' },
                { data: 'official', name: 'official' },
                { data: 'pic_user', name: 'pic_user' },
                { data: 'vendors', name: 'vendors' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
        // Add event listener for opening and closing details
        $('#offer-table tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );
                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( template(row.data()) ).show();
                    tr.addClass('shown');
                }
            });
    });
</script>
@endsection
@push('page-action')
<a href="{{ route('offer.create') }}" class="btn btn-primary mb-3">Add Tender Data</a>
@endpush
