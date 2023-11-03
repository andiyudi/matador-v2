@extends('layouts.template')
@section('content')
@php
$pretitle = 'Edit Data';
$title    = 'Vendor Category'
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form id="blacklistDocsForm" action="{{ route('category.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @method("PUT")
                    @csrf
                    <input type="hidden" name="id_category" value="{{ $data->id }}">
                    <input type="hidden" name="is_blacklist" id="is_blacklist" value="{{ $data->is_blacklist }}">
                    <input type="hidden" name="type" id="type" value="{{ $data->is_blacklist === 0 ? 1 : 0 }}">
                    <div class="row mb-3">
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
                        <a href="{{ route('category.index') }}" type="button" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-success" onclick="this.disabled=true; this.innerHTML='Processing...'; this.form.submit();">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const isBlacklistInput = document.getElementById('is_blacklist');
        const typeInput = document.getElementById('type');

        // Set initial value based on is_blacklist
        typeInput.value = isBlacklistInput.value === '0' ? '1' : '0';

        // Update value when is_blacklist changes
        isBlacklistInput.addEventListener('change', function () {
            typeInput.value = isBlacklistInput.value === '0' ? '1' : '0';
        });
    });
</script>
