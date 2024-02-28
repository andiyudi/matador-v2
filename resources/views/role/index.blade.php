@extends('layouts.template')
@section('content')
@php
$pretitle = 'Data';
$title    = 'Roles';
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped table-responsive">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Roles</th>
                            <th>Permissions</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $item)
                        <tr class="text-left">
                            <td>{{  $loop->iteration }}</td>
                            <td>{{  $item->name }}</td>
                            <td>
                                @if(!empty($item->getPermissionNames()))
                                @foreach ($item->getPermissionNames() as $role)
                                <span class="badge rounded-pill text-bg-info mb-3">{{ $role }}</span>
                                @endforeach
                                @endif
                            </td>
                            <td>
                                <div class="d-grid gap-2 mx-auto">
                                @can('role-edit')
                                <a href="{{ route('role.edit', $item->id) }}" type="button" class="btn btn-warning btn-pill btn-sm">Edit</a>
                                @endcan
                                @if($item->id != 1)
                                    @can('role-delete')
                                    <form action="{{ route('role.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this data?')" class="inline-block">
                                        @method("DELETE")
                                        @csrf
                                        <button class="btn btn-danger btn-pill btn-sm">Delete</button>
                                    </form>
                                    @endcan
                                @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('page-action')
@can('role-create')
<a href="{{ route('role.create') }}" class="btn btn-primary mb-3">Add Role Data</a>
@endcan
@endpush
