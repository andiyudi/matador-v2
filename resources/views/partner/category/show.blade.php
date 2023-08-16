@extends('layouts.template')
@section('content')
@php
$pretitle = 'Data';
$title    = 'Blacklist Document'
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-responsive table-bordered table-striped table-hover" id="blacklist_category_table">
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
                        @foreach ($files as $file)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $file->name }}</td>
                            <td>
                                @if ($file->type === 0)
                                    Whitelist
                                @elseif ($file->type === 1)
                                    Blacklist
                                @else
                                    Unknown Type
                                @endif
                            </td>
                            <td>{{ $file->notes }}</td>
                            <td>
                                <a href="{{ asset('storage/'.$file->path) }}" class="btn btn-sm btn-info" target="_blank">View</a>
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
        $('#blacklist_category_table').DataTable();
    });
</script>
@endsection
