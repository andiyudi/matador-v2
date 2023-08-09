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
                            <th>Core Business</th>
                            <th>Classification</th>
                            <th>Director</th>
                            <th>Phone</th>
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
                {
                    data: 'businesses',
                    render: function (data) {
                        var displayedParents = {};
                        var counter = 1;
                        return data.map(function (item, index) {
                            var businessName = item.parent ? item.parent.name : item.name;
                            if (!displayedParents[businessName]) {
                                displayedParents[businessName] = true;
                                var displayedIndex = counter;
                                counter++;
                                return displayedIndex + ". " + businessName + "<br>";
                            } else {
                                return "";
                            }
                        }).join("");
                    },
                    name: 'businesses',
                },
                {
                data: 'businesses',
                    render: function (data) {
                        return data.map(function (item, index) {
                            return (index+1) + "." + item.name +"<br>";
                        }).join("");
                        },
                name: 'businesses.name'
                },
                { data: 'director', name: 'director' },
                { data: 'phone', name: 'phone' },
                { data: 'grade', name: 'grade',
                render: function (data) {
                        if (data === '0') {
                            return 'Kecil';
                        } else if (data === '1') {
                            return 'Menengah';
                        } else if (data === '2') {
                            return 'Besar';
                        } else  {
                            return '-';
                        }
                    }
                },
                {
                data: 'status', name: 'status',
                    render: function (data) {
                        if (data === '0') {
                            return '<span class="badge bg-info">Registered</span>';
                        } else if (data === '1') {
                            return '<span class="badge bg-success">Active</span>';
                        } else if (data === '2') {
                            return '<span class="badge bg-warning">InActive</span>';
                        } else {
                            return '<span class="badge bg-secondary">Unknown</span>';
                        }
                    }
                },
                { data: 'expired_at', name: 'expired_at' },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        return `
                                    <a href="${route('partner.edit', {partner: row.id})}" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="${route('partner.show', {partner: row.id})}" class="btn btn-sm btn-info">Show</a>
                                    <button type="button" class="btn btn-sm btn-danger delete-partner" data-id="${row.id}">Delete</button>
                                `;
                    }
                },
            ]
        });
        $(document).on('click', '.delete-partner', function () {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Delete Vendor',
                text: 'Are you sure you want to delete this vendor?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim permintaan penghapusan ke URL yang sesuai
                    $.ajax({
                        url: route('partner.destroy', {partner: id}),
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Vendor deleted successfully'
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function (xhr) {
                            Swal.fire('Error deleting vendor', '', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
@push('page-action')
<a href="{{ route('partner.create') }}" class="btn btn-primary mb-3">Add Vendor Data</a>
@endpush
