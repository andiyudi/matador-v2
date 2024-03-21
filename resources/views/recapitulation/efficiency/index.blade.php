@extends('layouts.template')
@section('content')
@php
$pretitle = 'Efisiensi Biaya';
$title    = 'Perseroan';
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label required" for="">Pilih Periode</label>
                            <div class="input-group input-daterange">
                                <select class="form-select" id="year" name="year">
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}" @if ($year == $currentYear) selected @endif>{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3 mt-4">
                                <button class="btn btn-secondary me-md-2" type="button" id="searchBtn">Search</button>
                                <button class="btn btn-primary me-md-2" type="button" id="" data-toggle="modal" data-target="#">Print</button>
                                <button type="reset" class="btn btn-success">Export</button>
                            </div>
                        </div>
                    </div>
                </div>
                <iframe id="searchEfficiencyCost" src="" style="width: 100%; height: 500px; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

    $('#searchBtn').on('click', function() {
        if (!isValidInput()) {
            return;
        }
        updateIframe();
    });

    function isValidInput() {
        var year = $('#year').val();

        if (!year) {
            // Menampilkan SweetAlert untuk memberi tahu user bahwa input harus diisi
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'Please select a year',
            });
            return false;
        }

        return true;
    }

    function updateIframe() {
        var year = $('#year').val();

        var iframeSrc = '{{ route('recap.efficiency-cost-data') }}?year=' + year;
        console.log(iframeSrc);
        $('#searchEfficiencyCost').attr('src', iframeSrc);
    }
    });

    </script>
@endsection
