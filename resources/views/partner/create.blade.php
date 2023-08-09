@extends('layouts.template')
@section('content')
@php
$pretitle = 'Create Data';
$title    = 'Vendors'
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('partner.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Input Vendor Name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Core Business -->
                    <div class="row">
                        <div class="col mb-3">
                            <label for="core_business_id" class="form-label">Core Business</label>
                            <select class="form-select basic-multiple @error('core_business_id') is-invalid @enderror" name="core_business_id[]" id="core_business_id" multiple>
                                <option value="" disabled>Select Core Business</option>
                                @foreach($core_businesses as $core_business)
                                    <option value="{{ $core_business->id }}">{{ $core_business->name }}</option>
                                @endforeach
                            </select>
                            @error('core_business_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Classification -->
                        <div class="col mb-3">
                            <label for="classification_id" class="form-label">Classification</label>
                            <select class="form-select basic-multiple @error('classification_id') is-invalid @enderror" name="classification_id[]" id="classification_id" multiple>
                                <option value="">Select Classification</option>
                            </select>
                            @error('classification_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- Alamat -->
                    <div class="row">
                        <div class="col mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="4">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Alamat 2 -->
                        <div class="col mb-3">
                            <label for="domicility" class="form-label">Residence Address</label>
                            <textarea class="form-control @error('domicility') is-invalid @enderror" id="domicility" name="domicility" rows="4">{{ old('domicility') }}</textarea>
                            @error('domicility')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- Area dan Direktur -->
                    <div class="row">
                        <div class="col mb-3">
                            <label for="area" class="form-label">Area</label>
                            <input type="text" class="form-control @error('area') is-invalid @enderror" id="area" name="area" value="{{ old('area') }}" placeholder="Input Area">
                            @error('area')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col mb-3">
                            <label for="director" class="form-label">Director</label>
                            <input type="text" class="form-control @error('director') is-invalid @enderror" id="director" name="director" value="{{ old('director') }}" placeholder="Input Director">
                            @error('director')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- Telepon dan Email -->
                    <div class="row">
                        <div class="col mb-3">
                            <label for="phone" class="form-label">Telephone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Input Telephone">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Input Email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- Join date dan Reference -->
                    <div class="row">
                        <div class="col mb-3">
                            <label for="join_date" class="form-label">Join Date</label>
                            <input type="date" class="form-control @error('join_date') is-invalid @enderror" id="join_date" name="join_date" value="{{ old('join_date') ?? date('Y-m-d') }}">
                            @error('join_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col mb-3">
                            <label for="reference" class="form-label">Reference</label>
                            <input type="text" class="form-control @error('reference') is-invalid @enderror" id="reference" name="reference" value="{{ old('reference') }}" placeholder="Input Reference">
                            @error('reference')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- Modal dan Grade -->
                    <div class="row">
                        <div class="col mb-3">
                            <label for="capital" class="form-label">Capital</label>
                            <input type="text" class="form-control @error('capital') is-invalid @enderror" id="capital" name="capital" value="{{ old('capital') }}" placeholder="Input Capital">
                            @error('capital')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col mb-3">
                            <label class="form-label">Grade</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('grade') is-invalid @enderror" type="radio" name="grade" id="grade_kecil" value="0" {{ old('grade') == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="grade_kecil">Kecil</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('grade') is-invalid @enderror" type="radio" name="grade" id="grade_menengah" value="1" {{ old('grade') == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="grade_menengah">Menengah</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('grade') is-invalid @enderror" type="radio" name="grade" id="grade_besar" value="2" {{ old('grade') == '2' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="grade_besar">Besar</label>
                                </div>
                            </div>
                            @error('grade')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success float-end">Save</button>
                </form>
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
    $(document).on('change', '#core_business_id', function() {
        var selectedCoreBusinesses = $(this).val();

        $.ajax({
            url: "{{ route('get_classifications') }}",
            type: 'GET',
            data: {
                core_business_id: selectedCoreBusinesses
            },
            success: function(response) {
                var classificationSelect = $('#classification_id');
                classificationSelect.empty();

                if (response.length > 0) {
                    response.forEach(function(classification) {
                        classificationSelect.append('<option value="' + classification.id + '">' + classification.name + '</option>');
                    });
                } else {
                    classificationSelect.append('<option value="" disabled>No classifications available</option>');
                }
            }
        });
    });
</script>
@endsection
