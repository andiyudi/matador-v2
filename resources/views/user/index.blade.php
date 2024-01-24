@extends('layouts.template')
@section('content')
@php
$pretitle = 'Data';
$title    = 'Users'
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped table-responsive">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Roles</th>
                            <th>Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr class="text-left">
                            <td>{{  $loop->iteration }}</td>
                            <td>{{  $user->name }}</td>
                            <td>{{  $user->email }}</td>
                            <td>{{  $user->username }}</td>
                            <td class="text-center">
                                @if(!empty($user->getRoleNames()))
                                @foreach ($user->getRoleNames() as $role)
                                <span class="badge rounded-pill text-bg-info">{{ $role }}</span>
                                @endforeach
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">
                                    {{ $user->is_active ? 'Enable' : 'Disable' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                                @can('user-edit')
                                <a href="{{ route('user.edit', $user->id) }}" type="button" class="btn btn-warning btn-pill btn-sm">Edit</a>
                                @endcan
                                @if($user->id != 1)
                                @can('user-delete')
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this data?')" class="inline-block">
                                        @method("DELETE")
                                        @csrf
                                        <button class="btn btn-danger btn-pill btn-sm">Delete</button>
                                    </form>
                                @endcan
                                @else
                                    <button class="btn btn-danger btn-pill btn-sm" disabled>Delete</button>
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
@can('user-create')
<a href="{{ route('user.create') }}" class="btn btn-primary mb-3">Add User Data</a>
@endcan
@endpush
