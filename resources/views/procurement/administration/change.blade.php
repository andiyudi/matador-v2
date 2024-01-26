@extends('layouts.template')
@section('content')
@php
$pretitle = 'Procurement';
$title    = 'Monitoring'
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('administration.save', $procurement->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <label for="receipt" class="col-sm-2 col-form-label">TTPP</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control @error('receipt') is-invalid @enderror" name="receipt" id="receipt" value="{{ $procurement->receipt }}" readonly>
                            @error('receipt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <label for="number" class="col-sm-2 col-form-label">Procurement Number</label>
                        <div class="col-sm-4">
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
                        <div class="col-sm-4">
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
                        <label for="person_in_charge" class="col-sm-2 col-form-label">PIC Pengadaan</label>
                        <div class="col-sm-4">
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
                        <label for="ppoe_accepted" class="col-sm-2 col-form-label">
                            PP &#43; OE Diterima
                        </label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="ppoe_accepted" name="ppoe_accepted" value="{{ old('ppoe_accepted', $procurement->ppoe_accepted) }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="division_disposition" class="col-sm-2 col-form-label">
                            Disposisi Manajer Umum Ke Kadep Pengadaan
                        </label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="division_disposition" name="division_disposition" value="{{ old('division_disposition', $procurement->division_disposition) }}">
                        </div>
                        <label for="departement_disposition" class="col-sm-2 col-form-label">
                            Disposisi Kadep Pengadaan Ke Seksi
                        </label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="departement_disposition" name="departement_disposition" value="{{ old('departement_disposition', $procurement->departement_disposition) }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="vendor_offer" class="col-sm-2 col-form-label">
                            Penawaran Kerjasama Ke Vendor
                        </label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="vendor_offer" name="vendor_offer" value="{{ old('vendor_offer', $procurement->vendor_offer) }}">
                        </div>
                    </div>
                    @php
                        $tenderIdsKeys = array_keys($tenderData);
                    @endphp
                    @for ($i = 0; $i < $tendersCount; $i++)
                        @php
                            $tenderId = $tenderIdsKeys[$i];
                            $idTender = old('id_' . $tenderId, isset($tenderData[$tenderId]['id']) ? $tenderData[$tenderId]['id'] : '');
                            $aanwijzingValue = old('aanwijzing_' . $tenderId, isset($tenderData[$tenderId]['aanwijzing']) ? $tenderData[$tenderId]['aanwijzing'] : '');
                            $openTenderValue = old('open_tender_' . $tenderId, isset($tenderData[$tenderId]['open_tender']) ? $tenderData[$tenderId]['open_tender'] : '');
                        @endphp
                        <div class="row mb-3">
                            <label for="open_tender_{{ $tenderId }}" class="col-sm-2 col-form-label">
                                Aanwijzing (ke-{{ $i + 1 }})
                            </label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control " id="open_tender_{{ $idTender }}" name="open_tender_{{ $idTender }}" value="{{ $aanwijzingValue }}">
                            </div>
                            <label for="aanwijzing_{{ $tenderId }}" class="col-sm-2 col-form-label">
                                Tender (Pembukaan Harga) (ke-{{ $i + 1 }})
                            </label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" id="aanwijzing_{{ $idTender }}" name="aanwijzing_{{ $idTender }}" value="{{ $openTenderValue }}">
                                <input type="hidden" name="tender_ids[]" value="{{ $idTender }}">
                            </div>
                        </div>
                    @endfor
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a type="button" href="{{ route('administration.index') }}" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
