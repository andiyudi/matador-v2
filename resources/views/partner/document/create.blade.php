@extends('layouts.template')
@section('content')
@php
$pretitle = 'Create Data';
$title    = 'Document '. $partner->name;
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('document.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <input type="hidden" name="id_partner" value="{{ $partner->id }}">
                        <label for="type" class="col-sm-2 col-form-label required">Type File</label>
                        <div class="col-sm-10">
                            <select class="form-control @error('type') is-invalid @enderror" id="type" name="type">
                                <option value="">Select Type File</option>
                                <option value="0">Legalitas</option>
                                <option value="1">Compro</option>
                                <option value="2">Hasil Survey</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="file" class="col-sm-2 col-form-label required">Upload Document</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="file" id="file" name="file">
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="notes" class="col-sm-2 col-form-label required">Document Notes</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="notes" name="notes" rows="5"></textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('document.index', ['partner_id' => $partner->id]) }}" type="button" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
