@extends('layouts.template')
@section('content')
@php
$pretitle = 'Detail Data';
$title    = 'Vendors'
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $partner->name }}" disabled>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="core_business_id" class="form-label">Core Business</label>
                        <select class="form-select basic-multiple @error('core_business_id') is-invalid @enderror" name="core_business_id[]" id="core_business" multiple disabled>
                            <option value="" disabled>Pilih Jenis Bisnis</option>
                            @foreach($core_businesses as $core_business)
                                <option value="{{ $core_business->id }}" {{ in_array($core_business->id, $selectedCoreBusinesses) ? 'selected' : '' }}>
                                    {{ $core_business->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('core_business_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col mb-3">
                        <label for="classification_id" class="form-label">Classification</label>
                        <select class="form-select basic-multiple @error('classification_id') is-invalid @enderror" name="classification_id[]" id="classification" multiple disabled>
                            <option value="" disabled>Pilih Klasifikasi</option>
                            @foreach($classifications as $classification)
                                <option value="{{ $classification->id }}" {{ in_array($classification->id, $selectedClassifications) ? 'selected' : '' }}>
                                    {{ $classification->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('classification_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="4" disabled>{{ $partner->address }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col mb-3">
                        <label for="domicility" class="form-label">Residence Address</label>
                        <textarea class="form-control @error('domicility') is-invalid @enderror" id="domicility" name="domicility" rows="4" disabled>{{ $partner->domicility }}</textarea>
                        @error('domicility')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="area" class="form-label">Area</label>
                        <input type="text" class="form-control @error('area') is-invalid @enderror" id="area" name="area" value="{{ $partner->area }}" disabled>
                        @error('area')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col mb-3">
                        <label for="director" class="form-label">Director</label>
                        <input type="text" class="form-control @error('director') is-invalid @enderror" id="director" name="director" value="{{ $partner->director }}" disabled>
                        @error('director')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="phone" class="form-label">Telephone</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ $partner->phone }}" disabled>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $partner->email }}" disabled>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="join_date" class="form-label">Join Date</label>
                        <input type="date" class="form-control @error('join_date') is-invalid @enderror" id="join_date" name="join_date" value="{{ $partner->join_date }}" disabled>
                        @error('join_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col mb-3">
                        <label for="reference" class="form-label">Reference</label>
                        <input type="reference" class="form-control @error('reference') is-invalid @enderror" id="reference" name="reference" value="{{ $partner->reference }}" disabled>
                        @error('reference')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="capital" class="form-label">Capital</label>
                        <input type="text" class="form-control @error('capital') is-invalid @enderror" id="capital" name="capital" value="{{ $partner->capital }}" disabled>
                        @error('capital')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col mb-3">
                        <label for="grade" class="form-label">Grade</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('grade') is-invalid @enderror" type="radio" name="grade" id="grade_kecil" value="0" {{ $partner->grade == 0 ? 'checked' : '' }} disabled>
                                <label class="form-check-label" for="grade_kecil">Kecil</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('grade') is-invalid @enderror" type="radio" name="grade" id="grade_menengah" value="1" {{ $partner->grade == 1 ? 'checked' : '' }} disabled>
                                <label class="form-check-label" for="grade_menengah">Menengah</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('grade') is-invalid @enderror" type="radio" name="grade" id="grade_besar" value="2" {{ $partner->grade == 2 ? 'checked' : '' }} disabled>
                                <label class="form-check-label" for="grade_besar">Besar</label>
                            </div>
                        </div>
                        @error('grade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <a href="{{ route('partner.index') }}" type="button" class="btn btn-secondary float-end">Back</a>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.basic-multiple').select2({
            theme: "bootstrap-5",
            selectionCssClass: "select2--small",
            dropdownCssClass: "select2--small",
        });
    });
</script>
@endsection