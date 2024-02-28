@extends('layouts.template')
@section('content')
@php
$pretitle = 'Detail Data';
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
                                                <input type="checkbox" name="pick_vendor" id="pick_vendor_{{ $businessPartner->partner->id }}" value="{{ $businessPartner->partner->id }}" class="form-check-input"
                                                @if ($businessPartner->pivot->is_selected == '1')
                                                    checked
                                                @endif
                                                disabled>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="tender_files" class="col-sm-2 col-form-label">Tender Files</label>
                        <div class="col-sm-10">
                            <table class="table table-responsive table-bordered table-striped table-hover" id="tender_files_table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama File</th>
                                        <th>Type File</th>
                                        <th>Catatan File</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="selected_partners_list">
                                    @foreach ($tender->tenderFile as $tenderFile)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $tenderFile->name }}</td>
                                            <td>
                                                @if ($tenderFile->type === 0)
                                                    File Selected Vendor
                                                @elseif ($tenderFile->type === 1)
                                                    File Canceled Vendor
                                                @elseif ($tenderFile->type === 2)
                                                    File Repeat Vendor
                                                @elseif ($tenderFile->type === 3)
                                                    File Selected Vendor From Past Tender
                                                @elseif ($tenderFile->type === 4)
                                                    File Evaluation CMNP to Vendor
                                                @elseif ($tenderFile->type === 5)
                                                    File Evaluation Vendor to CMNP
                                                @else
                                                    Unknown
                                                @endif
                                            </td>
                                            <td>{{ $tenderFile->notes }}</td>
                                            <td>
                                                <div class="d-grid gap-2 mx-auto">
                                                    <a href="{{ asset('storage/'.$tenderFile->path) }}" class="btn btn-sm btn-info" target="_blank">View</a>
                                                    <a href="#" class="btn btn-sm btn-danger" data-id="{{ $tenderFile->id }}" data-bs-toggle="modal" data-bs-target="#changeDocumentModal">Change</a>
                                                </div>
                                            </td>
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
<div class="modal fade" id="changeDocumentModal" aria-hidden="true" aria-labelledby="changeDocumentModalLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeDocumentModalLabel">Change Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="changeDocumentForm" action="{{ route('offer.change', $tender->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="tender_file_id" id="tender_file_id">
                    <div class="mb-3">
                        <label for="newDocument" class="form-label">New Document</label>
                        <input class="form-control" type="file" id="newDocument" name="newDocument">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // Menangani klik pada tombol "Change"
    $('a.btn-danger').click(function(){
        var tenderFileId = $(this).data('id');
        console.log(tenderFileId);
        $('#tender_file_id').val(tenderFileId); // Mengatur nilai tender_file_id pada input tersembunyi di dalam modal
    });
</script>

@endsection
