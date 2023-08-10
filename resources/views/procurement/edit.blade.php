@extends('layouts.template')
@section('content')
@php
$pretitle = 'Edit Data';
$title    = 'Procurements'
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('procurements.update', $procurement->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <label for="receipt" class="col-sm-2 col-form-label required">TTPP</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control @error('receipt') is-invalid @enderror" name="receipt" id="receipt" value="{{ $procurement->receipt }}">
                            @error('receipt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="number" class="col-sm-2 col-form-label required">Procurement Number</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('number') is-invalid @enderror" id="number" name="number" value="{{ $procurement->number }}" placeholder="Input Procurement Number">
                            @error('number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label required">Job Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $procurement->name }}" placeholder="Input Job Name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="division" class="col-sm-2 col-form-label required">Division</label>
                        <div class="col-sm-10">
                            <select class="form-control select2 @error('division') is-invalid @enderror" id="division" name="division">
                                <option value="">Select Division</option>
                                @foreach ($divisions as $division)
                                <option value="{{ $division->id }}" {{ $procurement->division_id == $division->id ? 'selected' : '' }}>
                                    {{ $division->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('division')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="person_in_charge" class="col-sm-2 col-form-label required">PIC Pengadaan</label>
                        <div class="col-sm-10">
                            <select class="form-control select2 @error('official') is-invalid @enderror" id="official" name="official">
                                <option value="">Select Official</option>
                                @foreach ($officials as $official)
                                    <option value="{{ $official->id }}" {{ $procurement->official_id == $official->id ? 'selected' : '' }}>{{ $official->name }}</option>
                                @endforeach
                            </select>
                            @error('official')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <a type="button" href="{{ route('procurements.index') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
        $(document).ready(function() {
        $('.select2').select2({
            theme: "bootstrap-5",
            selectionCssClass: "select2--small",
            dropdownCssClass: "select2--small",
        });
    });
</script>
@endsection
