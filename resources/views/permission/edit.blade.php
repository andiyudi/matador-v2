@extends('layouts.template')
@section('content')
@php
$pretitle = 'Edit Data';
$title    = 'Permisions';
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('permission.update', $permission->id) }}" method="POST">
                @method("PUT")
                @csrf
                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label required">Permissions Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name', $permission->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="guard_name" class="col-sm-2 col-form-label required">Guard Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('guard_name') is-invalid @enderror" name="guard_name" id="guard_name" value="{{ old('guard_name', $permission->guard_name) }}">
                        @error('guard_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a type="button" href="{{ route('permission.index') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
