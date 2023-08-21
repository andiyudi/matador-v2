@extends('layouts.template')
@section('content')
@php
$pretitle = 'Create Data';
$title    = 'Tender'
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('offer.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <label for="procurement_id" class="col-sm-2 col-form-label required">Procurement Number</label>
                        <div class="col-sm-10">
                            <select class="form-control select2 @error('procurement_id') is-invalid @enderror" id="procurement_id" name="procurement_id">
                                <option value="">Select Procurement</option>
                                @foreach ($procurements as $item)
                                    <option value="{{ $item->id }}" data-name="{{ $item->name }}" data-division="{{ $item->division->name }}" {{ old('procurement_id') == $item->id ? 'selected' : '' }}>{{ $item->number }}</option>
                                @endforeach
                            </select>
                            @error('procurement_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Job Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" readonly>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="division" class="col-sm-2 col-form-label">Division</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('division') is-invalid @enderror" id="division" name="division" value="{{ old('division') }}" readonly>
                            @error('division')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="estimation" class="col-sm-2 col-form-label required">Estimation Time</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('estimation') is-invalid @enderror" id="estimation" name="estimation" value="{{ old('estimation') }}">
                            @error('estimation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="pic_user" class="col-sm-2 col-form-label required">PIC User</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('pic_user') is-invalid @enderror" id="pic_user" name="pic_user" value="{{ old('pic_user') }}">
                            @error('pic_user')
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
                    <div class="row mb-3">
                        <label for="pic_user" class="col-sm-2 col-form-label required">Pilih Vendor</label>
                        <div class="col-sm-10">
                            <table class="table" id="selected_partners_table">
                                <thead>
                                    <tr>
                                        <th>Select</th>
                                        <th>Vendor Name</th>
                                        <th>Status</th>
                                        <th>Director</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody id="selected_partners_list">
                                    <!-- Partners will be added here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a type="button" href="{{ route('offer.index') }}" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('offer.js')
@endsection
