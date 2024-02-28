@extends('layouts.template')
@section('content')
@php
$pretitle = 'Data';
$title    = 'Official';
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table id="table-officials" class="table table-responsive table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Initial</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($officials as $official)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $official->name }}</td>
                            <td>{{ $official->initials }}</td>
                            <td>
                                @if ($official->status == '1')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">InActive</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editOfficialModal" data-official-id="{{ $official->id }}" data-official-name="{{ $official->name }}" data-official-initials="{{ $official->initials }}" data-official-status="{{ $official->status }}">
                                    Edit
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteOfficialModal" data-official-id="{{ $official->id }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal Tambah Official -->
<div class="modal fade" id="createOfficialModal" tabindex="-1" aria-labelledby="createOfficialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('officials.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createOfficialModalLabel">Create Official Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="name" class="form-label required">Official Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Input Official Name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="initials" class="form-label required">Initials</label>
                        <input type="text" class="form-control" id="initials" name="initials" placeholder="Input Official Initials" required>
                    </div>
                    <div class="form-group mb-3">
                        <div class="form-label">Status</div>
                        <label class="form-check form-switch">
                            <input class="form-check-input" name="status" id="status" type="checkbox" value="1" checked>
                            <span class="form-check-label">Active</span>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Official -->
<div class="modal fade" id="editOfficialModal" tabindex="-1" aria-labelledby="editOfficialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOfficialModalLabel">Edit Official Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editOfficialForm" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="editOfficialName" class="form-label required">Official Name</label>
                        <input type="text" class="form-control" id="editOfficialName" name="name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="editInitials" class="form-label required">Initials</label>
                        <input type="text" class="form-control" id="editInitials" name="initials" required>
                    </div>
                    <div class="form-group mb-3">
                        <div class="form-label">Status</div>
                        <label class="form-check form-switch">
                            <input class="form-check-input" name="status" id="editStatus" type="checkbox">
                            <span class="form-check-label">Active</span>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Delete Official -->
<div class="modal fade" id="deleteOfficialModal" tabindex="-1" aria-labelledby="deleteOfficialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteOfficialModalLabel">Delete Official</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteOfficialForm" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('DELETE')
                    <p>Are you sure you want to delete this Official Data?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#table-officials').DataTable({
            lengthMenu: [5, 10, 25, 50] // Pilihan jumlah data per halaman
        });
    });
</script>
<script>
    $('#deleteOfficialModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('official-id')

        var modal = $(this)

        var form = $('#deleteOfficialForm')
        form.attr('action', route('officials.destroy', {official: id}))
    })
</script>
<script>
    $('#editOfficialModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('official-id');
        var name = button.data('official-name');
        var initials = button.data('official-initials');
        var status = button.data('official-status');

        var modal = $(this);
        modal.find('.modal-body #editOfficialName').val(name);
        modal.find('.modal-body #editInitials').val(initials);

        var form = $('#editOfficialForm');
        form.attr('action', route('officials.update', { official: id })); // Perbaikan pada parameter official

        // Perbaikan pada pengecekan status dan set nilai toggle
        if (status == '1') {
            modal.find('.modal-body #editStatus').prop('checked', true);
        } else {
            modal.find('.modal-body #editStatus').prop('checked', false);
        }
    });
</script>

@endsection
@push('page-action')
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createOfficialModal">
        Add Official Data
    </button>
@endpush
