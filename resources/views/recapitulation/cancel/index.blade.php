@extends('layouts.template')
@section('content')
@php
$pretitle = 'Rekapitulasi Permintaan';
$title    = 'Dibatalkan';
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="number">Masukkan No PP</label>
                            <input type="text" class="form-control" name="number" id="number">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="name">Masukkan Nama Pekerjaan</label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="">Nilai Pekerjaan</label>
                            <select class="form-select" id="value_cost" name="value_cost">
                                <option disabled selected>Pilih Nilai Pekerjaan</option>
                                <option value=0>0 s.d &lt; 100Jt</option>
                                <option value=1>&ge; 100Jt s.d &lt; 1 Miliar</option>
                                <option value=2>&ge; 1 Miliar</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="return_to_user">Tanggal Pengembalian Ke User</label>
                            <input type="date" class="form-control" id="return_to_user" name="return_to_user">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="cancellation_memo">Tanggal Memo Pembatalan</label>
                            <input type="text" class="form-control" id="cancellation_memo" name="cancellation_memo">
                        </div>
                    </div>
                    <div class="col-md-4">
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
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                    <button class="btn btn-secondary me-md-2" type="button" id="searchBtn">Search</button>
                    <button class="btn btn-primary me-md-2" type="button" id="printBtn" data-toggle="modal" data-target="#printModal">Print</button>
                    <button type="reset" class="btn btn-success">Export</button>
                </div>
                <iframe id="searchRequestCancelled" src="" style="width: 100%; height: 500px; border: none;"></iframe>
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
        var number = $('#number').val();
        var name = $('#name').val();
        var returnToUser = $('#return_to_user').val();
        var cancellationMemo = $('#cancellation_memo').val();
        var valueCost = $('#value_cost').val();

        var iframeSrc = '{{ route('recap.request-cancelled-data') }}?year=' + year +
        '&number=' + number +
        '&name=' + name +
        '&returnToUser=' + returnToUser +
        '&cancellationMemo=' + cancellationMemo +
        '&valueCost=' + valueCost;
        console.log(iframeSrc);
        $('#searchRequestCancelled').attr('src', iframeSrc);
    }
    });

    </script>
@endsection
