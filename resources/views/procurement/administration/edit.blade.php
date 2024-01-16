@extends('layouts.template')
@section('content')
@php
$pretitle = 'Procurement';
$title    = 'Estimate'
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('administration.update', $procurement->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <label for="receipt" class="col-sm-2 col-form-label">TTPP</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control @error('receipt') is-invalid @enderror" name="receipt" id="receipt" value="{{ $procurement->receipt }}" readonly>
                            @error('receipt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="number" class="col-sm-2 col-form-label">Procurement Number</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('number') is-invalid @enderror" id="number" name="number" value="{{ $procurement->number }}" placeholder="Input Procurement Number" readonly>
                            @error('number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Job Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $procurement->name }}" placeholder="Input Job Name" readonly>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="division" class="col-sm-2 col-form-label">Division</label>
                        <div class="col-sm-10">
                            <select class="form-select @error('division') is-invalid @enderror" id="division" name="division" disabled>
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
                        <label for="person_in_charge" class="col-sm-2 col-form-label">PIC Pengadaan</label>
                        <div class="col-sm-10">
                            <select class="form-select @error('official') is-invalid @enderror" id="official" name="official" disabled>
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
                    <div class="row mb-3">
                        <label for="user_estimate" class="col-sm-2 col-form-label required">User Estimate</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                <input type="text" class="form-control currency @error('user_estimate') is-invalid @enderror" id="user_estimate" name="user_estimate" value="{{ old('user_estimate') }}" placeholder="Input EE User">
                                @error('user_estimate')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="technique_estimate" class="col-sm-2 col-form-label required">Technique Estimate</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                <input type="text" class="form-control currency @error('technique_estimate') is-invalid @enderror" id="technique_estimate" name="technique_estimate" value="{{ old('technique_estimate') }}" placeholder="Input EE Teknik">
                                @error('technique_estimate')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="deal_nego" class="col-sm-2 col-form-label required">Hasil Negosiasi</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                <input type="text" class="form-control currency @error('deal_nego') is-invalid @enderror" id="deal_nego" name="deal_nego" value="{{ old('deal_nego') }}" placeholder="Input Hasil Negosiasi">
                                @error('deal_nego')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @for ($i = 1; $i <= $tendersCount; $i++)
                    <div class="row mb-3">
                        <label for="report_nego_result_{{ $i }}" class="col-sm-2 col-form-label">
                            Lap. Hasil Nego ke Direksi {{ $i }}
                        </label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="report_nego_result_{{ $i }}" name="report_nego_result_{{ $i }}" value="{{ old('report_nego_result_' . $i) }}">
                        </div>
                    </div>
                    @endfor
                    @if($procurementStatus == '2')
                    <div class="row mb-3">
                        <label for="return_to_user" class="col-sm-2 col-form-label">
                            Tanggal Pengembalian ke User
                        </label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="return_to_user" name="return_to_user" value="{{ old('return_to_user') }}">
                        </div>
                    </div>
                    @endif
                    <div class="row mb-3">
                        <label for="information" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="information" id="information" cols="30" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a type="button" href="{{ route('administration.index') }}" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('currency')) {
            // Hapus karakter selain digit dan koma
            const rawValue = e.target.value.replace(/[^\d,]/g, '');

            // Konversi nilai ke format mata uang
            const formattedValue = new Intl.NumberFormat('id-ID').format(Number(rawValue));

            // Setel nilai input yang sudah diformat
            e.target.value = formattedValue;
        }
    });
</script>
@endsection
