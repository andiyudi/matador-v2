@extends('layouts.template')
@section('content')
@php
$pretitle = 'Data';
$title    = 'Document '. $partner->name;
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-responsive table-bordered table-striped table-hover" id="document-table">
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
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $file->name }}</td>
                            <td>
                                @if ($file->type === 0)
                                    Legalitas
                                @elseif ($file->type === 1)
                                    Compro
                                @elseif ($file->type === 2)
                                    Hasil Survey
                                @else
                                    Unknown Type
                                @endif
                            </td>
                            <td>{{ $file->notes }}</td>
                            <td>
                                <div class="d-grid gap-2 d-md-flex">
                                    <a href="{{ asset('storage/'.$file->path) }}" class="btn btn-sm btn-info" target="_blank">View</a>
                                    <form action="{{ route('document.destroy', ['file_id' => $file->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this file?')">
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
        $('#document-table').DataTable();
    });
</script>
@endsection
@push('page-action')
<a href="{{ route('document.create', ['partner_id' => $partner->id]) }}" class="btn btn-primary mb-3">Add Document Vendor</a>
@endpush
