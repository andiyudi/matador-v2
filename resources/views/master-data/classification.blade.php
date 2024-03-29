@extends('layouts.template')
@section('content')
@php
$pretitle = 'Data';
$title    = 'Classification';
@endphp
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-responsive table-bordered table-striped table-hover" id="classification-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Core Business</th>
                                <th>Classification</th>
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
<!-- Create Classification Modal -->
<div class="modal fade" id="classificationModal" tabindex="-1" aria-labelledby="classificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="createClassificationForm" method="POST" action="{{ route('classification.store') }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="classificationModalLabel">Add Classification Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="core_business_id">Core Business</label>
                        <select class="form-control" id="core_business_id" name="core_business_id" required>
                            <option value="" selected disabled>-- Select Core Business --</option>
                            @foreach($coreBusinesses as $coreBusiness)
                                <option value="{{ $coreBusiness->id }}">{{ $coreBusiness->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Classification Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Input Classification Name" required>
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
<!-- Edit Classification Modal -->
<div class="modal fade" id="editClassificationModal" tabindex="-1" aria-labelledby="editClassificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="editClassificationModalLabel">Edit Classification Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="editClassificationForm" method="POST" action="">
        @csrf
        @method('PUT')
        <div class="modal-body">
            <div class="mb-3">
            <label for="editClassificationCoreBusiness" class="form-label">Core Business</label>
            <select class="form-select" aria-label="Select Core Business" id="editClassificationCoreBusiness" name="core_business_id">
                <!-- Options will be populated using JavaScript -->
            </select>
            </div>
            <div class="mb-3">
                <label for="editClassificationName" class="form-label">Name</label>
                <input type="text" class="form-control" id="editClassificationName" name="name" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Update</button>
        </div>
        </form>
    </div>
    </div>
</div>
<!-- Modal Delete Classification -->
<div class="modal fade" id="deleteClassificationModal" tabindex="-1" aria-labelledby="deleteClassificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="" method="POST" id="deleteClassificationForm">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteClassificationModalLabel">Delete Classification Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this classification data?</p>
                    <p id="deleteClassificationName"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#classification-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('classification.index') }}",
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
                { data: 'core_business_name', name: 'core_business_name' },
                { data: 'name', name: 'name' },
                {
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return '<button class="btn btn-warning btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#editClassificationModal" data-id="' + data + '">Edit</button> <button class="btn btn-danger btn-sm delete-btn" data-bs-toggle="modal" data-bs-target="#deleteClassificationModal" data-id="' + data + '">Delete</button>';
                    }
                },
            ]
        });
        $(document).on('click', '.delete-btn', function() {
            var classificationId = $(this).data('id');
            var deleteUrl = "{{ route('classification.index') }}" + '/' + classificationId;

            // Get the classification name for display
            var classificationName = $(this).data('name');
            $('#deleteClassificationName').text(classificationName);

            $('#deleteClassificationForm').attr('action', deleteUrl);
            $('#deleteClassificationModal').modal('show');
        });

        $(document).on('submit', '#deleteClassificationForm', function(e) {
            e.preventDefault();

            var form = $(this);
            var url = form.attr('action');

            $.ajax({
                url: url,
                type: 'DELETE',
                data: form.serialize(),
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Classification deleted successfully'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Refresh or update the DataTable if needed
                            $('#classification-table').DataTable().ajax.reload();
                            // Close the modal
                            $('#deleteClassificationModal').modal('hide');
                        }
                    });
                },
                error: function(error) {
                    console.log('Error deleting data');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Classification data can\'t be deleted, it is associated with procurement(s)'
                    })
                }
            });
        });
        $(document).on('click', '.edit-btn', function() {
            var classificationId = $(this).data('id');
            var editUrl = "{{ route('classification.index') }}" + '/' + classificationId + '/edit';

            $.ajax({
                url: editUrl,
                type: 'GET',
                success: function(response) {
                    // Populate the modal form fields with response data
                    $('#editClassificationName').val(response.name);
                    $('#editClassificationForm').attr('action', "{{ route('classification.index') }}" + '/' + classificationId);

                    // Populate core business select options
                    var coreBusinessSelect = $('#editClassificationCoreBusiness');
                    coreBusinessSelect.empty(); // Clear previous options

                    var options = '';
                    if (response.coreBusinesses.length > 0) {
                        options += '<option value="" disabled>-- Select Core Business --</option>';
                        response.coreBusinesses.forEach(function(coreBusiness) {
                            var isSelected = (coreBusiness.id == response.core_business_id) ? 'selected' : '';
                            options += '<option value="' + coreBusiness.id + '" ' + isSelected + '>' + coreBusiness.name + '</option>';
                        });
                    } else {
                        options += '<option value="" disabled>No Core Business available</option>';
                    }

                    coreBusinessSelect.append(options);
                }
            });
        });
        $(document).on('submit', '#editClassificationForm', function(e) {
            e.preventDefault();

            var form = $(this);
            var url = form.attr('action');

            $.ajax({
                url: url,
                type: 'PUT',
                data: form.serialize(),
                success: function(response) {
                    // Show success SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Refresh or update the DataTable if needed
                            $('#classification-table').DataTable().ajax.reload();
                            // Close the modal
                            $('#editClassificationModal').modal('hide');
                        }
                    });
                },
                error: function(xhr) {
                    var response = xhr.responseJSON;

                    // Show validation error SweetAlert if status code is 422
                    if (xhr.status === 422) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            html: response.error
                        });
                    } else {
                        // Show general error SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error updating classification: ' + response.error
                        });
                    }
                }
            });
        });
    });
</script>
@endsection
@push('page-action')
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#classificationModal" data-bs-action="create">
        Add Classification Data
    </button>
@endpush
