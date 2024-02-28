@extends('layouts.template')
@section('content')
@php
$pretitle = 'Data';
$title    = 'Division';
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
<!-- Modal Tambah Division -->
<div class="modal fade" id="createDivisionModal" tabindex="-1" aria-labelledby="createDivisionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('divisions.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createDivisionModalLabel">Create Division Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="name" class="form-label required">Division Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Input Division Name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="code" class="form-label required">Division Code</label>
                        <input type="text" class="form-control" id="code" name="code" placeholder="Input Division Code" required>
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

<!-- Modal Edit Division -->
<div class="modal fade" id="editDivisionModal" tabindex="-1" aria-labelledby="editDivisionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDivisionModalLabel">Edit Division Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editDivisionForm" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="editDivisionName" class="form-label required">Division Name</label>
                        <input type="text" class="form-control" id="editDivisionName" name="name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="editDivisionCode" class="form-label required">Division Code</label>
                        <input type="text" class="form-control" id="editDivisionCode" name="code" required>
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


<!-- Modal Delete Division -->
<div class="modal fade" id="deleteDivisionModal" tabindex="-1" aria-labelledby="deleteDivisionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteDivisionModalLabel">Delete Division</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteDivisionForm" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('DELETE')
                    <p>Are you sure you want to delete this Division Data?</p>
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
    $('#deleteDivisionModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('division-id')

        var modal = $(this)

        var form = $('#deleteDivisionForm')
        form.attr('action', route('divisions.destroy', {division: id}))
    })
</script>
<script>
    $('#editDivisionModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('division-id');
        var name = button.data('division-name');
        var code = button.data('division-code');
        var status = button.data('division-status');

        var modal = $(this);
        modal.find('.modal-body #editDivisionName').val(name);
        modal.find('.modal-body #editDivisionCode').val(code);

        var form = $('#editDivisionForm');
        form.attr('action', route('divisions.update', { division: id })); // Perbaikan pada parameter division

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
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDivisionModal">
        Add Division Data
    </button>
@endpush
@push('after-script')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
