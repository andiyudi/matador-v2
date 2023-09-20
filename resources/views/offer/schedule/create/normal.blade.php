<div id="form_type_0" style="display:none;">
    <form action="{{ route('schedule.store') }}" method="POST">
        @csrf
        <input type="hidden" class="form-control" name="schedule_type" value="0">
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
                        <input type="text" class="form-control" name="activity_1" id="normal_activity_1" readonly value="Pengiriman Dokumen Tender Via Email">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_1" id="normal_start_date_1" onchange="calculateDuration('normal', 1)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_1" id="normal_end_date_1" onchange="calculateDuration('normal', 1)">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="duration_1" id="normal_duration_1" value="0" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">2.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_2" id="normal_activity_2" readonly value="Undangan Tender">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_2" id="normal_start_date_2" onchange="calculateDuration('normal', 2)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_2" id="normal_end_date_2" onchange="calculateDuration('normal', 2)">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="duration_2" id="normal_duration_2" value="0" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">3.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_3" id="normal_activity_3" readonly value="Penjelasan Teknis (Aanwijzing)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_3" id="normal_start_date_3" onchange="calculateDuration('normal', 3)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_3" id="normal_end_date_3" onchange="calculateDuration('normal', 3)">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="duration_3" id="normal_duration_3" value="0" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">4.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_4" id="normal_activity_4" readonly value="Peninjauan Lapangan">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_4" id="normal_start_date_4" onchange="calculateDuration('normal', 4)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_4" id="normal_end_date_4" onchange="calculateDuration('normal', 4)">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="duration_4" id="normal_duration_4" value="0" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">5.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_5" id="normal_activity_5" readonly value="Pemasukan Dokumen Penawaran Harga Via Email">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_5" id="normal_start_date_5" onchange="calculateDuration('normal', 5)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_5" id="normal_end_date_5" onchange="calculateDuration('normal', 5)">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="duration_5" id="normal_duration_5" value="0" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">6.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_6" id="normal_activity_6" readonly value="Verifikasi Penawaran Harga">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_6" id="normal_start_date_6" onchange="calculateDuration('normal', 6)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_6" id="normal_end_date_6" onchange="calculateDuration('normal', 6)">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="duration_6" id="normal_duration_6" value="0" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">7.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_7" id="normal_activity_7" readonly value="Negosiasi Kewajaran Harga">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_7" id="normal_start_date_7" onchange="calculateDuration('normal', 7)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_7" id="normal_end_date_7" onchange="calculateDuration('normal', 7)">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="duration_7" id="normal_duration_7" value="0" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">8.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_8" id="normal_activity_8" readonly value="Evaluasi Hasil Tender">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_8" id="normal_start_date_8" onchange="calculateDuration('normal', 8)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_8" id="normal_end_date_8" onchange="calculateDuration('normal', 8)">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="duration_8" id="normal_duration_8" value="0" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">9.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_9" id="normal_activity_9" readonly value="Persetujuan Direksi">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_9" id="normal_start_date_9" onchange="calculateDuration('normal', 9)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_9" id="normal_end_date_9" onchange="calculateDuration('normal', 9)">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="duration_9" id="normal_duration_9" value="0" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">10.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_10" id="normal_activity_10" readonly value="Surat Penetapan Pemenang / Kalah Tender">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_10" id="normal_start_date_10" onchange="calculateDuration('normal', 10)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_10" id="normal_end_date_10" onchange="calculateDuration('normal', 10)">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="duration_10" id="normal_duration_10" value="0" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">11.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_11" id="normal_activity_11" readonly value="Pembuatan Kontrak / PO">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_11" id="normal_start_date_11" onchange="calculateDuration('normal', 11)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_11" id="normal_end_date_11" onchange="calculateDuration('normal', 11)">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="duration_11" id="normal_duration_11" value="0" readonly>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="form-floating mb-3">
            <textarea class="form-control" placeholder="Leave a comment here" name="note" id="note" style="height:100px"></textarea>
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

