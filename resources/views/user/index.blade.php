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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr class="text-center">
                            <td>{{  $loop->iteration }}</td>
                            <td>{{  $user->name }}</td>
                            <td>{{  $user->email }}</td>
                            <td>{{  $user->username }}</td>
                            <td>
                                @if(!empty($user->getRoleNames()))
                                @foreach ($user->getRoleNames() as $role)
                                <span class="badge rounded-pill text-bg-info">{{ $role }}</span>
                                @endforeach
                                @endif
                            </td>
                            <td>
                                @can('user-edit')
                                <a href="{{ route('user.edit', $user->id) }}" type="button" class="btn btn-warning btn-pill btn-sm">Edit</a>
                                @endcan
                                @can('user-delete')
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="inline-block">
                                    @method("DELETE")
                                    @csrf
                                    <button class="btn btn-danger btn-pill btn-sm">Delete</button>
                                </form>
                                @endcan
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
