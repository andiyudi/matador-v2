@extends('layouts.template')
@section('content')
@php
$pretitle = 'Data';
$title    = 'Log Activity';
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
    <style>
        /* Word wrap for table cells */
        table.dataTable td {
            word-wrap: break-word;
            word-break: break-all;
            white-space: normal !important;
        }

        /* Specific word wrap for 'agent' column */
        table.dataTable td .agent-wrap {
            word-wrap: break-word;
            word-break: break-all;
            white-space: normal;
        }

        /* Responsive adjustments */
        @media (max-width: 767.98px) {
            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter,
            .dataTables_wrapper .dataTables_info,
            .dataTables_wrapper .dataTables_paginate {
                text-align: center;
                margin: 0 auto;
            }

            .dataTables_wrapper .dataTables_paginate {
                float: none;
            }

            table.dataTable {
                width: 100% !important;
            }
        }
    </style>
@endpush
