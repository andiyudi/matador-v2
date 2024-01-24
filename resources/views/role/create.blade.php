@extends('layouts.template')
@section('content')
@php
$pretitle = 'Create Data';
$title    = 'Roles';
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('role.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label required">Roles Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- <div class="row mb-3">
                    <label for="permission" class="col-sm-2 col-form-label required">Permissions</label>
                    <div class="col-sm-10">
                        @foreach ($permission as $item)
                        <div class="w-full mx-2">
                            <input type="checkbox" name="permission[]" id="check-{{ $item->id }}" value="{{ $item->name }}">
                            <label for="check-{{ $item->id }}">{{ $item->name }}</label>
                        </div>
                        @endforeach
                    </div>
                </div> --}}
                <div class="row mb-3">
                    <label for="permission" class="col-sm-2 col-form-label required">Permissions</label>
                    <div class="col-sm-10">
                        <div class="row">
                            @foreach ($permission as $item)
                            <div class="col-md-4 mb-2">
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" name="permission[]" id="check-{{ $item->id }}" value="{{ $item->name }}" class="form-check-input">
                                    <label for="check-{{ $item->id }}" class="form-check-label">{{ $item->name }}</label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a type="button" href="{{ route('role.index') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
