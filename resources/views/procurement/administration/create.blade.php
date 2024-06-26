@extends('layouts.template')
@section('content')
@php
$pretitle = 'Create Procurement';
$title    = 'Documentation '. $procurement->number;
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form id="procurementDocsForm" action="{{ route('administration.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <input type="hidden" name="id_procurement" value="{{ $procurement->id }}">
                        <label for="type" class="col-sm-2 col-form-label required">Type File</label>
                        <div class="col-sm-10">
                            <select name="definition_id" class="form-control" id="definition_id">
                                    <option value=""selected disabled>Select Type File</option>
                                @foreach($definitionFileProcurements as $definitionFileProcurement)
                                    <option value="{{ $definitionFileProcurement->id }}">{{ $definitionFileProcurement->name }}</option>
                                @endforeach
                            </select>
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
                        <a href="{{ route('administration.show', ($procurement->id)) }}" type="button" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-success" onclick="this.disabled=true; this.innerHTML='Processing...'; this.form.submit();">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
