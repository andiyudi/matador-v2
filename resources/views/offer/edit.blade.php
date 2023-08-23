@extends('layouts.template')
@section('content')
@php
$pretitle = 'Edit Data';
$title    = 'Tender'
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route ('offer.update', $selected_procurement->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <label for="procurement_id" class="col-sm-2 col-form-label required">Procurement Number</label>
                        <div class="col-sm-10">
                            <select class="form-control select2 @error('procurement_id') is-invalid @enderror" id="procurement_id" name="procurement_id">
                                <option value="">Select Procurement</option>
                                @foreach ($procurements as $item)
                                    <option value="{{ $item->id }}" data-name="{{ $item->name }}" data-division="{{ $item->division->name }}" data-estimation="{{ $item->estimation }}" data-pic-user="{{ $item->pic_user }}"
                                            {{ $item->id == $selected_procurement->id ? 'selected' : '' }}>
                                        {{ $item->number }}
                                    </option>
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
                            <input type="text" class="form-control" id="name" name="name" value="{{ $selected_procurement->name }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="division" class="col-sm-2 col-form-label">Division</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="division" name="division" value="{{ $selected_procurement->division->name }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="estimation" class="col-sm-2 col-form-label required">Estimation Time</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="estimation" name="estimation" value="{{ $selected_procurement->estimation }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="pic_user" class="col-sm-2 col-form-label required">PIC User</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="pic_user" name="pic_user" value="{{ $selected_procurement->pic_user }}">
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
                                                <option value="{{ $child->id }}" {{ $child->id == $selected_procurement->business_id ? 'selected' : '' }}>{{ $child->name }}</option>
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
                            <table class="table table-responsive table-bordered table-striped table-hover" id="selected_partners_table">
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
                                    @foreach ($business_partners as $item)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="selected_partners[]" value="{{ $item->id }}"
                                            {{ in_array($item->id, $selected_business_partner->toArray()) ? 'checked' : '' }}>
                                        </td>
                                        <td>{{ $item->partner->name }}</td>
                                        <td>
                                            @if ($item->partner->status === '0')
                                                Registered
                                            @elseif ($item->partner->status === '1')
                                                Active
                                            @elseif ($item->partner->status === '2')
                                                Inactive
                                            @else
                                                Unknown
                                            @endif
                                        </td>
                                        <td>{{ $item->partner->director }}</td>
                                        <td>{{ $item->partner->phone }}</td>
                                        <td>{{ $item->partner->email }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a type="button" href="{{ route('offer.index') }}" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('offer.js')
@endsection
