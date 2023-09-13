@extends('layouts.template')
@section('content')
@php
$pretitle = 'Data PP'. $tender->procurement->number;
$title    = 'Edit Schedule '. $tender->procurement->name;
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route ('schedule.update', $tender->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label">Jenis Schedule</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="schedule_type" id="schedule_type_0" value="0" {{ $tender->schedule_type == 0 ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="schedule_type_0">Schedule Normal</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="schedule_type" id="schedule_type_1" value="1" {{ $tender->schedule_type == 1 ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="schedule_type_1">Schedule Aanwijzing & Nego</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="schedule_type" id="schedule_type_2" value="2" {{ $tender->schedule_type == 2 ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="schedule_type_2">Schedule IKP</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-responsive table-bordered table-striped table-hover">
                        <thead class="text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th width="45%">Activity</th>
                                <th width="15%">Start Date</th>
                                <th width="15%">End Date</th>
                                <th width="5%">Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schedules as $schedule)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}.
                                    <input type="hidden" class="form-control" name="id_schedule[]" value="{{ $schedule->id }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="activity[]" value="{{ $schedule->activity }}" readonly>
                                </td>
                                <td>
                                    <input type="date" class="form-control" name="start_date[]" value="{{ $schedule->start_date }}" onchange="calculateDuration(this)">
                                </td>
                                <td>
                                    <input type="date" class="form-control" name="end_date[]" value="{{ $schedule->end_date }}" onchange="calculateDuration(this)">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="duration[]" value="{{ $schedule->duration }}" readonly>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Leave a comment here" name="note" id="note" style="height:100px" >{{ $tender->note }}</textarea>
                        <label for="note">Keterangan</label>
                    </div>
                    <table class="table table-responsive table-bordered table-striped table-hover">
                        <thead class="text-center">
                            <th width="5%">No</th>
                            <th width="60%">Nama Vendor</th>
                            <th width="15%">Start Hour</th>
                            <th width="15%">End Hour</th>
                        </thead>
                        <tbody>
                            @foreach ($tender->businessPartners as $businessPartner)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}.</td>
                                <td>{{ $businessPartner->partner->name }}</td>
                                <td>
                                    <input type="time" class="form-control" name="start_hour_{{ $businessPartner->id }}" id="start_hour_{{ $businessPartner->id }}" value="{{ $businessPartner->pivot->start_hour }}" >
                                </td>
                                <td>
                                    <input type="time" class="form-control" name="end_hour_{{ $businessPartner->id }}" id="end_hour_{{ $businessPartner->id }}" value="{{ $businessPartner->pivot->end_hour }}" >
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row mb-3">
                        <label for="secretary" class="col-sm-2 col-form-label required">Secretary Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('secretary') is-invalid @enderror" id="secretary" name="secretary" value="{{ $tender->secretary }}" placeholder="Input Secretary Name" >
                            @error('secretary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-grid gap-2 mt-3 d-md-flex justify-content-md-end">
                        <a type="button" href="{{ route('schedule.index', $tender->id) }}" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirmModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Penghapusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus jadwal? Tindakan ini tidak dapat dikembalikan! Silahkan buat jadwal baru untuk tender ini.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="{{ route('schedule.destroy', $tender->id) }}" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>
<script>
    function calculateDuration(input) {
        // Ambil elemen terkait dalam baris saat ini
        var row = input.closest('tr');

        // Ambil nilai tanggal awal dan tanggal akhir dari input
        var startDate = new Date(row.querySelector('input[name="start_date[]"]').value);
        var endDate = new Date(row.querySelector('input[name="end_date[]"]').value);

        // Fungsi untuk memeriksa apakah tanggal adalah hari Sabtu atau Minggu
        function isWeekend(date) {
            return date.getDay() === 6 || date.getDay() === 0;
        }

        // Periksa apakah tanggal awal dan tanggal akhir valid
        if (!isNaN(startDate) && !isNaN(endDate)) {
            // Inisialisasi durasi
            var duration = 0;

            // Loop melalui setiap tanggal antara tanggal awal dan akhir
            var currentDate = new Date(startDate);
            while (currentDate <= endDate) {
                // Tambahkan satu hari jika bukan hari Sabtu atau Minggu
                if (!isWeekend(currentDate)) {
                    duration++;
                }
                // Pindah ke tanggal berikutnya
                currentDate.setDate(currentDate.getDate() + 1);
            }

            // Isi input durasi dengan hasil perhitungan
            row.querySelector('input[name="duration[]"]').value = duration;
        } else {
            // Jika salah satu tanggal tidak valid, set durasi ke 0
            row.querySelector('input[name="duration[]"]').value = '0';
        }
    }
</script>

@endsection
@push('page-action')
    <a href="#" class="btn btn-danger mb-3" data-bs-toggle="modal" data-bs-target="#confirmModal">Change Schedule Type</a>
@endpush
