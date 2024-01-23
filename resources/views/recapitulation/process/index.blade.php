@extends('layouts.template')
@section('content')
@php
$pretitle = 'Rekapitulasi PP';
$title    = 'Masih Dalam Proses Negosiasi'
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="vendorStatus">Masukkan No PP</label>
                            <input type="text" class="form-control" name="number" id="number">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="period">Masukkan Nama Pekerjaan</label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="vendorStatus">Pilih Divisi</label>
                            <select class="form-select" id="division-filter" name="division">
                                <option value="">All Divisions</option>
                                @foreach($divisions as $division)
                                <option value="{{ $division->id }}">{{ $division->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label required" for="period">Pilih Periode</label>
                            <div class="input-group input-daterange">
                                <input type="text" class="form-control" id="startDateTtpp" name="startDateTtpp" placeholder="Start Periode">
                                <span class="input-group-text">to</span>
                                <input type="text" class="form-control" id="endDateTtpp" name="endDateTtpp" placeholder="End Periode">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                    <button class="btn btn-secondary me-md-2" type="button" id="searchBtn">Search</button>
                    <button class="btn btn-primary me-md-2" type="button" id="printBtn" data-toggle="modal" data-target="#printModal">Print</button>
                    <button type="reset" class="btn btn-success">Export</button>
                </div>
                <iframe id="searchRecapProcessNego" src="" style="width: 100%; height: 500px; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var startDateInputTtpp = $('#startDateTtpp');
        var endDateInputTtpp = $('#endDateTtpp');

        startDateInputTtpp.datepicker({
            format: 'mm-yyyy',
            startView: 'months',
            minViewMode: 'months',
            autoclose:true,
        });

        endDateInputTtpp.datepicker({
            format: 'mm-yyyy',
            startView: 'months',
            minViewMode: 'months',
            autoclose:true,
            startDate: startDateInputTtpp.val()
        }).on('show', function() {
            $(this).datepicker('setStartDate', startDateInputTtpp.val());
        });

        $('#searchBtn').on('click', function() {
            if (!isValidInput()) {
                return;
            }
            updateIframe();
        });

        function isValidInput() {
            var startDateTtpp = $('#startDateTtpp').val();
            var endDateTtpp = $('#endDateTtpp').val();

            if (!startDateTtpp || !endDateTtpp) {
                // Menampilkan SweetAlert untuk memberi tahu user bahwa kedua input harus diisi
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Start period and End periode is required',
                });
                return false;
            }

            return true;
        }

        function updateIframe() {
        var number = $('#number').val();
        var name = $('#name').val();
        var division = $('#division-filter').val();
        var startDateTtpp = $('#startDateTtpp').val();
        var endDateTtpp = $('#endDateTtpp').val();

        var iframeSrc = '{{ route('recap.process-nego-data') }}?number=' + number +
            '&name=' + name +
            '&division=' + division +
            '&startDateTtpp=' + startDateTtpp +
            '&endDateTtpp=' + endDateTtpp;
        console.log(iframeSrc);
        $('#searchRecapProcessNego').attr('src', iframeSrc);
        }
    });
</script>
@endsection
