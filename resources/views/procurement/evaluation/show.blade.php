@extends('layouts.template')
@section('content')
@php
$pretitle = 'Evaluation Data';
$title    = 'Procurement'
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="" method="">
                    <div class="row mb-3">
                        <label for="procurement_id" class="col-sm-2 col-form-label">Procurement Number</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="procurement" id="procurement" value={{ $procurement->number }} readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Job Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" value="{{ $procurement->name }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="division" class="col-sm-2 col-form-label">Division</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="division" name="division" value="{{ $procurement->division->name }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="estimation" class="col-sm-2 col-form-label">Estimation Time</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="estimation" name="estimation" value="{{ $procurement->estimation }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="pic_user" class="col-sm-2 col-form-label">PIC User</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="pic_user" name="pic_user" value="{{ $procurement->pic_user }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="business" class="col-sm-2 col-form-label">Business Category</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="business" id="business" value={{ $procurement->business->name }} readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="pic_user" class="col-sm-2 col-form-label">Data Vendor</label>
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
                                    @foreach ($procurement->tenders as $tender)
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
                                                <input type="checkbox" name="pick_vendor" id="pick_vendor_{{ $businessPartner->partner->id }}" value="{{ $tender->id }}_{{ $businessPartner->partner->id }}" class="form-check-input"
                                                @if ($businessPartner->pivot->is_selected == '1')
                                                checked
                                                @endif
                                                disabled>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="pic_user" class="col-sm-2 col-form-label">Data Dokumen</label>
                        <div class="col-sm-10">
                            <table class="table table-responsive table-bordered table-striped table-hover" id="document_tender_table">
                                <thead>
                                    <tr>
                                        <th>Nama File</th>
                                        <th>Type File</th>
                                        <th>Catatan File</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="document_tender_list">
                                    @foreach ($procurement->tenders as $tender)
                                        @foreach ($tender->tenderFile as $tenderFile)
                                        <tr>
                                            <td>{{ $tenderFile->name }}</td>
                                            <td>
                                                @if ($tenderFile->type === 0)
                                                File Selected Vendor
                                                @elseif ($tenderFile->type === 1)
                                                File Cancelled Tender
                                                @elseif ($tenderFile->type === 2)
                                                File Repeat Tender
                                                @elseif ($tenderFile->type === 3)
                                                File Evaluation Company
                                                @elseif ($tenderFile->type === 4)
                                                File Evaluation Vendor
                                                @else
                                                Unknown
                                                @endif
                                            </td>
                                            <td>{{ $tenderFile->notes }}</td>
                                            <td>
                                                <a href="{{ asset('storage/'.$tenderFile->path) }}" class="btn btn-sm btn-info" target="_blank">View</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a type="button" href="{{ route('evaluation.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('procurement.evaluation.modal')
@endsection
@push('page-action')
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <button id="evaluationCompanyButton" class="btn btn-secondary me-md-2" type="button"data-bs-target="#modalEvaluationCompany" data-bs-toggle="modal" @if(!$fileCompanyExist) disabled @endif>CMNP To Vendor</button>
    <button id="evaluationVendorButton" class="btn btn-dark" data-bs-target="#modalEvaluationVendor" data-bs-toggle="modal" @if(!$fileVendorExist) disabled @endif>Vendor To CMNP</button>
</div>
@endpush
