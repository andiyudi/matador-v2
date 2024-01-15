@extends('layouts.template')
@section('content')
@php
$pretitle = 'Procurement';
$title    = 'Administration'
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-responsive table-bordered table-striped table-hover" id="administration-table" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No. PP</th>
                            <th>Detail</th>
                            <th>Pick Vendor</th>
                            <th>EE User</th>
                            <th>EE Teknik</th>
                            <th>Hasil Negosiasi</th>
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
<script src="https://twitter.github.io/typeahead.js/js/handlebars.js"></script>
<script id="details-template" type="text/x-handlebars-template">
    <table class="table">
        <tr>
            <td>TTPP</td>
            <td>:</td>
            <td>@{{receipt}}</td>
        </tr>
        <tr>
            <td>Job Name</td>
            <td>:</td>
            <td>@{{name}}</td>
        </tr>
        <tr>
            <td>Division</td>
            <td>:</td>
            <td>@{{division}}</td>
        </tr>
        <tr>
            <td>PIC PP</td>
            <td>:</td>
            <td>@{{official}}</td>
        </tr>
    </table>
</script>
<script>
    $(document).ready(function () {
        var template = Handlebars.compile($("#details-template").html());
        var table = $('#administration-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('administration.index') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'number', name: 'number' },
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "searchable":     false,
                    "data":           null,
                    "defaultContent": '<button class="btn btn-sm btn-info">Detail</button>'
                },
                { data: 'is_selected', name: 'is_selected' },
                { data: 'user_estimate', name: 'user_estimate' },
                { data: 'technique_estimate', name: 'technique_estimate' },
                { data: 'deal_nego', name: 'deal_nego' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
        // Add event listener for opening and closing details
        $('#administration-table tbody').on('click', 'td.details-control', function () {
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
