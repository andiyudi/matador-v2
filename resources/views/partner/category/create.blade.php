@extends('layouts.template')
@section('content')
@php
$pretitle = 'Create Data';
$title    = 'Category Vendor'
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('category.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <label for="partner" class="col-sm-2 col-form-label required">Vendor Name</label>
                        <div class="col-sm-10">
                            <select class="form-control select2 @error('partner') is-invalid @enderror" id="partner" name="partner">
                                <option value="">Select Vendor</option>
                                @foreach ($partner as $item)
                                    <option value="{{ $item->id }}" {{ old('partner') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('partner')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="business" class="col-sm-2 col-form-label required">Business Category</label>
                        <div class="col-sm-10">
                            <select class="form-control select2 @error('business') is-invalid @enderror" id="business" name="business">
                                <option value="">Select Category</option>
                                @foreach ($business as $item)
                                    @if (!$item->parent_id)
                                        <optgroup label="{{ $item->name }}">
                                            @foreach ($item->children as $child)
                                                <option value="{{ $child->id }}" {{ old('business') == $child->id ? 'selected' : '' }}>{{ $child->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endif
                                @endforeach
                            </select>
                            @error('business')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a type="button" href="{{ route('procurements.index') }}" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.select2').select2({
            theme: "bootstrap-5",
            selectionCssClass: "select2--small",
            dropdownCssClass: "select2--small",
        });
    });
</script>
@endsection
