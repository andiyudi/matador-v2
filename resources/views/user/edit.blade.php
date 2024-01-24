@extends('layouts.template')
@section('content')
@php
$pretitle = 'Edit Data';
$title    = 'Users'
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('user.update', $user->id) }}" method="POST">
                @method("PUT")
                @csrf
                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label required">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ $user->name }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-sm-2 col-form-label required">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $user->email }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="username" class="col-sm-2 col-form-label required">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ $user->username }}">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @if ($user->id != 1)
                <div class="row mb-3">
                    <label for="roles" class="col-sm-2 col-form-label required">Roles</label>
                    <div class="col-sm-10">
                        <select class="form-control select2 @error('roles') is-invalid @enderror" id="roles" name="roles">
                            <option value="" disabled>Select Role</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->name }}" {{ old('roles') == $role->name ? "selected" : ''}} {{ $user->roles->contains($role->id) ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('roles')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="is_active" class="col-sm-2 col-form-label">Active</label>
                    <div class="col-sm-10">
                        <select class="form-control select" name="is_active" id="is_active">
                            <option value="0">Disable</option>
                            <option value="1">Enable</option>
                        </select>
                    </div>
                </div>
                @endif
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a type="button" href="{{ route('user.index') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
