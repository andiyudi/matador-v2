@extends('layouts.template')
@section('content')
@php
$pretitle = 'Daftar Mitra Kerja';
$title    = 'Pemenang Tender';
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="division" class="form-label">Pilih Divisi</label>
                            <select class="form-select select2" name="division[]" id="division" multiple="multiple">
                                <option value="">Pilih Divisi</option>
                                @foreach ($divisions as $division)
                                    <option value="{{ $division->id }}">{{ $division->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="number" class="form-label">Masukkan No PP</label>
                            <input type="text" name="number" id="number" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="start_month" class="form-label required">Pilih Bulan Awal</label>
                            <select class="form-select" name="start_month" id="start_month">
                                <option value="">Start Month</option>
                                @foreach ($bulan as $key => $name)
                                    <option value="{{ $key }}" {{ $key == 1 ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="end_month" class="form-label required">Pilih Bulan Akhir</label>
                            <select class="form-select" name="end_month" id="end_month">
                                <option value="">End Month</option>
                                @foreach ($bulan as $key => $name)
                                    <option value="{{ $key }}" {{ $key == $currentMonth ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="year" class="form-label required">Pilih Periode</label>
                            <select id="year" class="form-select" name="year">
                                @foreach ($years as $year)
                                    <option value="{{ $year }}" @if ($year == $currentYear) selected @endif>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                        <button class="btn btn-secondary me-md-2" type="button" id="searchBtn">Search</button>
                        <button class="btn btn-primary me-md-2" type="button" id="printBtn" data-toggle="modal" data-target="#printModal">Print</button>
                        <a href="{{ route('monitoring.selected-excel') }}" class="btn btn-success" id="exportBtn">Export</a>
                    </div>
                </div>
                <iframe id="searchMonitoringSelected" src="" style="width: 100%; height: 500px; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="printModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="printModalLabel">Data Pembuat dan Atasan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="printForm">
                    <div class="form-group">
                        <label for="stafName">Nama Pembuat:</label>
                        <input type="text" class="form-control" id="stafName" name="stafName">
                    </div>
                    <div class="form-group">
                        <label for="stafPosition">Jabatan Pembuat:</label>
                        <input type="text" class="form-control" id="stafPosition" name="stafPosition">
                    </div>
                    <div class="form-group">
                        <label for="managerName">Nama Atasan:</label>
                        <input type="text" class="form-control" id="managerName" name="managerName">
                    </div>
                    <div class="form-group">
                        <label for="managerPosition">Jabatan Atasan:</label>
                        <input type="text" class="form-control" id="managerPosition" name="managerPosition">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirmPrintBtn">Cetak</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.select2').select2({
            placeholder: "Pilih Divisi",
            theme: "bootstrap-5",
            selectionCssClass: "select2--small",
            dropdownCssClass: "select2--small",
        });
    $('#searchBtn').on('click', function() {
        if (!isValidInput()) {
            return;
        }
        updateIframe();
    });

    function isValidInput() {
        var year = $('#year').val();
        var start_month = $('#start_month').val();
        var end_month = $('#end_month').val();
        var number = $('#number').val();
        var division = $('#division').val();

        if (!year) {
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'Please select a year',
            });
            return false;
        }

        if (!start_month) {
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'Please select a start month',
            });
            return false;
        }

        if (!end_month) {
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'Please select an end month',
            });
            return false;
        }

        if (parseInt(end_month) < parseInt(start_month)) {
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'End month must be greater than or equal to start month',
            });
            return false;
        }

        return true;
    }

    function updateIframe() {
        var year = $('#year').val();
        var start_month = $('#start_month').val();
        var end_month = $('#end_month').val();
        var number = $('#number').val();
        var division = $('#division').val();

        var iframeSrc = '{{ route('monitoring.selected-data') }}?year=' + year +
        '&start_month=' + start_month +
        '&end_month=' + end_month +
        '&number=' + number +
        '&division=' + division;
        console.log(iframeSrc);
        $('#searchMonitoringSelected').attr('src', iframeSrc);
    }

    $('#printBtn').click(function() {
        $('#printModal').modal('show');
    });

    $('#confirmPrintBtn').click(function () {
        var stafName = $('#stafName').val();
        var stafPosition = $('#stafPosition').val();
        var managerName = $('#managerName').val();
        var managerPosition = $('#managerPosition').val();
        var url = $('#searchMonitoringSelected').attr('src');

        // Validasi form
        if (stafName === '' || stafPosition === '' || managerName === '' || managerPosition === '') {
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'Please complete all fields',
            });
            return false;
        }

        if (url) {
            url += '&stafName=' + encodeURIComponent(stafName);
            url += '&stafPosition=' + encodeURIComponent(stafPosition);
            url += '&managerName=' + encodeURIComponent(managerName);
            url += '&managerPosition=' + encodeURIComponent(managerPosition);
            Swal.fire({
                title: 'Print Confirmation',
                text: 'Are you sure you want to print?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Print',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    var printWindow = window.open(url, '_blank');
                    printWindow.print();
                    $('#printModal').modal('hide');
                    $('#printForm')[0].reset();
                    location.reload();
                }
            });
        }
    });

    $('#exportBtn').click(function(event) {
        event.preventDefault(); // Mencegah tindakan default dari tautan

        // Mendapatkan nilai start periode dan end periode dari input form
        var year = $('#year').val();
        var start_month = $('#start_month').val();
        var end_month = $('#end_month').val();
        var number = $('#number').val();
        var division = $('#division').val();
        console.log(year, start_month, end_month, number, division);

        // Periksa apakah year, start month, dan end month sudah diisi
        if (!year || !start_month || !end_month) {
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'Year, Start Month, and End Month are required',
            });
            return;
        }

        // Validasi bulan mulai tidak boleh lebih besar dari bulan akhir
        if (parseInt(start_month) > parseInt(end_month)) {
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'Start month cannot be greater than end month',
            });
            return;
        }

        // Membuat tautan ekspor dengan menyertakan nilai-nilai start periode dan end periode
        var exportUrl = $(this).attr('href') + '?year=' + year + '&start_month=' + start_month + '&end_month=' + end_month + '&number=' + number + '&division=' + division;
        // Mengarahkan pengguna ke tautan ekspor dengan nilai-nilai filter
        window.location.href = exportUrl;
    });
});

</script>
@endsection

