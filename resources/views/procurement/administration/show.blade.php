@extends('layouts.template')
@section('content')
@php
$pretitle = 'Procurement';
$title    = 'Documentation '. $procurement->number;
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-responsive table-bordered table-striped table-hover" id="procurement-file-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama File</th>
                            <th>Type File</th>
                            <th>Catatan File</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($files as $index => $file)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $file->name }}</td>
                            <td>
                                @if (isset($definitions[$file->id]))
                                    {{ $definitions[$file->id]->name }}
                                @else
                                    Unknown Type
                                @endif
                            </td>
                            <td>{{ $file->notes }}</td>
                            <td>
                                <div class="d-grid gap-2 d-md-flex">
                                    <a href="{{ asset('storage/'.$file->path) }}" class="btn btn-sm btn-info" target="_blank">View</a>
                                    <form action="{{ route('administration.destroy', ['file_id' => $file->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this file?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#procurement-file-table').DataTable();
    });
</script>
@endsection
@push('page-action')
<a href="{{ route('administration.create', ['procurement_id' => $procurement->id]) }}" class="btn btn-primary mb-3">Add Procurement Document</a>
@endpush
