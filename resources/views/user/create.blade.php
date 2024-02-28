@extends('layouts.template')
@section('content')
@php
$pretitle = 'Create Data';
$title    = 'Users';
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label required">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-sm-2 col-form-label required">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="username" class="col-sm-2 col-form-label required">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="roles" class="col-sm-2 col-form-label required">Roles</label>
                    <div class="col-sm-10">
                        <select class="form-control select2 @error('roles') is-invalid @enderror" id="roles" name="roles">
                            <option value="" disabled>Select Role</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->name }}" {{ old('roles') == $role->name ? "selected" : ''}}>
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
                    <label for="password" class="col-sm-2 col-form-label required">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a type="button" href="{{ route('user.index') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
