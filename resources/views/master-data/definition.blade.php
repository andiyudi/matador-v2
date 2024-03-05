@extends('layouts.template')
@section('content')
@php
$pretitle = 'Data';
$title    = 'Definition';
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table id="table-definition" class="table table-responsive table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Definition</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($definitions as $definition)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $definition->name }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editDefinitionModal" data-definition-id="{{ $definition->id }}" data-definition-name="{{ $definition->name }}">
                                    Edit
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteDefinitionModal" data-definition-id="{{ $definition->id }}">
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
<div class="modal fade" id="createDefinitionModal" tabindex="-1" aria-labelledby="createDefinitionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('definitions.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createDefinitionModalLabel">Create Definition Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="form-label required">Definition Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Input Definition Name" required>
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
<div class="modal fade" id="editDefinitionModal" tabindex="-1" aria-labelledby="editDefinitionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="editDefinitionModalLabel">Edit Definition Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="editDefinitionForm" method="POST">
        <div class="modal-body">
            @csrf
            @method('PUT')
            <div class="form-group">
            <label for="editDefinitionName">Definition Name</label>
            <input type="text" class="form-control" id="editDefinitionName" name="name" required>
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
<div class="modal fade" id="deleteDefinitionModal" tabindex="-1" aria-labelledby="deleteDefinitionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteDefinitionModalLabel">Delete Definition</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteDefinitionForm" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('DELETE')
                    <p>Are you sure you want to delete this Definition Data?</p>
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
        $('#table-definition').DataTable({
            lengthMenu: [5, 10, 25, 50] // Pilihan jumlah data per halaman
        });
    });
</script>
<script>
    $('#editDefinitionModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('definition-id')
        var name = button.data('definition-name')

        var modal = $(this)
        modal.find('.modal-body #editDefinitionName').val(name)

        var form = $('#editDefinitionForm')
        form.attr('action', route('definitions.update', {definition: id}))
    })
</script>
<script>
    $('#deleteDefinitionModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('definition-id')

        var modal = $(this)

        var form = $('#deleteDefinitionForm')
        form.attr('action', route('definitions.destroy', {definition: id}))
    })
</script>
@endsection
@push('page-action')
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDefinitionModal">
    Add Definition Data
</button>
@endpush
