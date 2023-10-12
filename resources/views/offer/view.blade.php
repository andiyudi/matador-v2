@extends('layouts.template')
@section('content')
@php
$pretitle = 'Data Tender';
$title    = 'Decision'
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route ('offer.decision', $tender->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <label for="procurement_id" class="col-sm-2 col-form-label">Procurement Number</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="procurement" id="procurement" value={{ $tender->procurement->number }} readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Job Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" value="{{ $tender->procurement->name }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="division" class="col-sm-2 col-form-label">Division</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="division" name="division" value="{{ $tender->procurement->division->name }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="estimation" class="col-sm-2 col-form-label">Estimation Time</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="estimation" name="estimation" value="{{ $tender->procurement->estimation }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="pic_user" class="col-sm-2 col-form-label">PIC User</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="pic_user" name="pic_user" value="{{ $tender->procurement->pic_user }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="decision" class="col-sm-2 col-form-label required">Decision</label>
                        <div class="col-sm-10">
                            <select class="form-select @error('decision') is-invalid @enderror" name="decision" id="decision">
                                <option value="">Select Decision</option>
                                <option value="1">Pick Vendor</option>
                                <option value="2">Cancel Tender</option>
                                <option value="3">Repeat Tender</option>
                                <option value="4">Pick Vendor From Past Tender</option>
                            </select>
                            @error('decision')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3" id="vendorData" style="display: none;">
                        <label for="pic_user" class="col-sm-2 col-form-label required">Data Vendor</label>
                        <div class="col-sm-10">
                            <table class="table table-responsive table-bordered table-striped table-hover" id="selected_partners_table">
                                <thead>
                                    <tr>
                                        <th>Vendor Name</th>
                                        <th>Status</th>
                                        <th>Director</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Pick Vendor</th>
                                    </tr>
                                </thead>
                                <tbody id="selected_partners_list">
                                    @foreach ($tender->businessPartners as $businessPartner)
                                        <tr>
                                            <td>{{ $businessPartner->partner->name }}</td>
                                            <td>
                                                @if ($businessPartner->partner->status === '0')
                                                    Registered
                                                @elseif ($businessPartner->partner->status === '1')
                                                    Active
                                                @elseif ($businessPartner->partner->status === '2')
                                                    Inactive
                                                @else
                                                    Unknown
                                                @endif
                                            </td>
                                            <td>{{ $businessPartner->partner->director }}</td>
                                            <td>{{ $businessPartner->partner->phone }}</td>
                                            <td>{{ $businessPartner->partner->email }}</td>
                                            <td align="center">
                                                <input type="radio" name="pick_vendor" id="pick_vendor_{{ $businessPartner->partner->id }}" value="{{ $businessPartner->partner->id }}" class="form-check-input">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row mb-3" id="vendorDataAll" style="display: none;">
                        <label for="vendorDataAll" class="col-sm-2 col-form-label required">Data Vendor Past Tender</label>
                        <div class="col-sm-10">
                            <table class="table table-responsive table-bordered table-striped table-hover" id="selected_partners_table_all">
                                <thead>
                                    <tr>
                                        <th>Vendor Name</th>
                                        <th>Status</th>
                                        <th>Director</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Pick Vendor</th>
                                    </tr>
                                </thead>
                                <tbody id="selected_partners_list_all">
                                    @foreach ($previousTenders as $previousTender)
                                        @foreach ($previousTender->businessPartners as $businessPartner)
                                            <tr>
                                                <td>{{ $businessPartner->partner->name }}</td>
                                                <td>
                                                    @if ($businessPartner->partner->status === '0')
                                                        Registered
                                                    @elseif ($businessPartner->partner->status === '1')
                                                        Active
                                                    @elseif ($businessPartner->partner->status === '2')
                                                        Inactive
                                                    @else
                                                        Unknown
                                                    @endif
                                                </td>
                                                <td>{{ $businessPartner->partner->director }}</td>
                                                <td>{{ $businessPartner->partner->phone }}</td>
                                                <td>{{ $businessPartner->partner->email }}</td>
                                                <td align="center">
                                                    <input type="radio" name="pick_vendor_old" id="pick_vendor_old_{{ $businessPartner->partner->id }}" value="{{ $previousTender->id }}_{{ $businessPartner->partner->id }}" class="form-check-input">
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row mb-3" id="uploadFile" style="display: none;">
                        <label for="file" class="col-sm-2 col-form-label required">Upload File</label>
                        <div class="col-sm-10">
                            <input type="file" name="file" id="file" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3" id="notes" style="display: none;">
                        <label for="notes" class="col-sm-2 col-form-label required">Tender Notes</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="notes" name="notes" rows="5"></textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
<script>
    $(document).ready(function() {
        // Fungsi untuk menangani perubahan dalam elemen select
        $('#decision').on('change', function() {
            var decision = $(this).val();

            // Sembunyikan semua elemen terlebih dahulu
            $('#vendorData, #vendorDataAll, #uploadFile, #notes').hide();

            if (decision === '1') {
                // Tampilkan elemen data vendor
                // $('#vendorData').show();
                // Tampilkan elemen radio button dan upload file jika Pick Vendor dipilih
                $('#vendorData, #uploadFile, #notes').show();
            } else if (decision === '2' || decision === '3') {
                // Tampilkan elemen upload file jika Cancel Tender atau Repeat Tender dipilih
                $('#uploadFile, #notes').show();
            } else if (decision === '4') {
                $('#vendorDataAll, #uploadFile, #notes').show();
            }
        });
    });
</script>
@endsection
