@extends('layouts.template')
@section('content')
@php
$pretitle = 'Show Data';
$title    = 'Tender';
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="" method="">
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
                        <label for="business" class="col-sm-2 col-form-label">Business Category</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="business" id="business" value={{ $tender->procurement->business->name }} readonly>
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
                                        <th>End Date</th>
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
                                            <td>{{ $businessPartner->partner->end_deed ? \Carbon\Carbon::parse($businessPartner->partner->end_deed)->format('d-m-Y') : '' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a type="button" href="{{ route('offer.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
