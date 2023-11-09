<div id="form_type_1" style="display:none;">
    <form action="{{ route('schedule.store') }}" method="POST">
        @csrf
        <input type="hidden" class="form-control" name="schedule_type" value="1">
        <input type="hidden" class="form-control" name="is_holiday" value="0">
        <input type="hidden" class="form-control" name="tender_id" value="{{ $tender->id }}">
        <table class="table table-responsive table-bordered table-striped table-hover">
            <thead class="text-center">
                <tr>
                    <th width="5%">No</th>
                    <th width="60%">Activity</th>
                    <th width="15%">Start Date</th>
                    <th width="15%">End Date</th>
                    <th width="5%">Duration</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_1" id="nego_activity_1" readonly value="Pengiriman Dokumen Tender Via Email (Mitra Kerja Terseleksi)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_1" id="nego_start_date_1" onchange="calculateDuration('nego', 1)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_1" id="nego_end_date_1" onchange="calculateDuration('nego', 1)">
                    </td>
                    <td>
                        <input type="number" class="form-control" name="duration_1" id="nego_duration_1" value="0" min="1">
                    </td>
                </tr>
                <tr>
                    <td class="text-center">2.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_2" id="nego_activity_2" readonly value="Undangan Tender">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_2" id="nego_start_date_2" onchange="calculateDuration('nego', 2)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_2" id="nego_end_date_2" onchange="calculateDuration('nego', 2)">
                    </td>
                    <td>
                        <input type="number" class="form-control" name="duration_2" id="nego_duration_2" value="0" min="1">
                    </td>
                </tr>
                <tr>
                    <td class="text-center">3.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_3" id="nego_activity_3" readonly value="Pemasukan Dokumen Penawaran Harga Via Email">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_3" id="nego_start_date_3" onchange="calculateDuration('nego', 3)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_3" id="nego_end_date_3" onchange="calculateDuration('nego', 3)">
                    </td>
                    <td>
                        <input type="number" class="form-control" name="duration_3" id="nego_duration_3" value="0" min="1">
                    </td>
                </tr>
                <tr>
                    <td class="text-center">4.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_4" id="nego_activity_4" readonly value="Verifikasi Penawaran Harga">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_4" id="nego_start_date_4" onchange="calculateDuration('nego', 4)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_4" id="nego_end_date_4" onchange="calculateDuration('nego', 4)">
                    </td>
                    <td>
                        <input type="number" class="form-control" name="duration_4" id="nego_duration_4" value="0" min="1">
                    </td>
                </tr>
                <tr>
                    <td class="text-center">5.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_5" id="nego_activity_5" readonly value="Penjelasan Teknis (Aanwijzing) & Negosiasi Harga (Online / Offline)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_5" id="nego_start_date_5" onchange="calculateDuration('nego', 5)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_5" id="nego_end_date_5" onchange="calculateDuration('nego', 5)">
                    </td>
                    <td>
                        <input type="number" class="form-control" name="duration_5" id="nego_duration_5" value="0" min="1">
                    </td>
                </tr>
                <tr>
                    <td class="text-center">6.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_6" id="nego_activity_6" readonly value="Evaluasi Hasil Tender">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_6" id="nego_start_date_6" onchange="calculateDuration('nego', 6)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_6" id="nego_end_date_6" onchange="calculateDuration('nego', 6)">
                    </td>
                    <td>
                        <input type="number" class="form-control" name="duration_6" id="nego_duration_6" value="0" min="1">
                    </td>
                </tr>
                <tr>
                    <td class="text-center">7.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_7" id="nego_activity_7" readonly value="Persetujuan Direksi">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_7" id="nego_start_date_7" onchange="calculateDuration('nego', 7)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_7" id="nego_end_date_7" onchange="calculateDuration('nego', 7)">
                    </td>
                    <td>
                        <input type="number" class="form-control" name="duration_7" id="nego_duration_7" value="0" min="1">
                    </td>
                </tr>
                <tr>
                    <td class="text-center">8.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_8" id="nego_activity_8" readonly value="Surat Penetapan Pemenang / Kalah Tender">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_8" id="nego_start_date_8" onchange="calculateDuration('nego', 8)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_8" id="nego_end_date_8" onchange="calculateDuration('nego', 8)">
                    </td>
                    <td>
                        <input type="number" class="form-control" name="duration_8" id="nego_duration_8" value="0" min="1">
                    </td>
                </tr>
                <tr>
                    <td class="text-center">9.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_9" id="nego_activity_9" readonly value="Pembuatan Kontrak / PO">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_9" id="nego_start_date_9" onchange="calculateDuration('nego', 9)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_9" id="nego_end_date_9" onchange="calculateDuration('nego', 9)">
                    </td>
                    <td>
                        <input type="number" class="form-control" name="duration_9" id="nego_duration_9" value="0" min="1">
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="form-floating mb-3">
            <textarea class="form-control" placeholder="Leave a comment here" name="note" id="note" style="height:100px"></textarea>
            <label for="note" class="col-form-label required">Keterangan</label>
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
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $businessPartner->partner->name }}</td>
                    <td><input type="time" class="form-control" name="start_hour_{{ $businessPartner->id }}" id="start_hour_{{ $businessPartner->id }}"></td>
                    <td><input type="time" class="form-control" name="end_hour_{{ $businessPartner->id }}" id="end_hour_{{ $businessPartner->id }}"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row mb-3">
            <label for="secretary" class="col-sm-2 col-form-label required">Secretary Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('secretary') is-invalid @enderror" id="secretary" name="secretary" value="{{ old('secretary') }}" placeholder="Input Secretary Name">
                @error('secretary')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="d-grid gap-2 mt-3 d-md-flex justify-content-md-end">
            <a type="button" href="{{ route('schedule.index', $tender->id) }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-success">Save</button>
        </div>
    </form>
</div>

