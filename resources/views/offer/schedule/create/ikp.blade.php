<div id="form_type_2" style="display:none;">
    <form action="{{ route('schedule.store') }}" method="POST">
        @csrf
        <input type="hidden" class="form-control" name="schedule_type" value="2">
        <input type="hidden" class="form-control" name="category" value="0">
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
                        <input type="text" class="form-control" name="activity_1" id="ikp_activity_1" readonly value="Pengiriman Dokumen Tender">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_1" id="ikp_start_date_1" onchange="calculateDuration('ikp', 1)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_1" id="ikp_end_date_1" onchange="calculateDuration('ikp', 1)">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="duration_1" id="ikp_duration_1" value="0" readonly>
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
            <button type="reset" class="btn btn-secondary">Reset</button>
            <button type="submit" class="btn btn-success">Save</button>
        </div>
    </form>
</div>
{{-- <tr>
    <td class="text-center">2.</td>
    <td>
        <input type="text" class="form-control" name="activity_2" id="ikp_activity_2" readonly value="Undangan Rapat Penjelasan Teknis">
    </td>
    <td>
        <input type="date" class="form-control" name="start_date_2" id="ikp_start_date_2" onchange="calculateDuration('ikp', 2)">
    </td>
    <td>
        <input type="date" class="form-control" name="end_date_2" id="ikp_end_date_2" onchange="calculateDuration('ikp', 2)">
    </td>
    <td>
        <input type="text" class="form-control" name="duration_2" id="ikp_duration_2" value="0" readonly>
    </td>
</tr>
<tr>
    <td class="text-center">3.</td>
    <td>
        <input type="text" class="form-control" name="activity_3" id="ikp_activity_3" readonly value="Penjelasan Teknis (Aanwijzing)">
    </td>
    <td>
        <input type="date" class="form-control" name="start_date_3" id="ikp_start_date_3" onchange="calculateDuration('ikp', 3)">
    </td>
    <td>
        <input type="date" class="form-control" name="end_date_3" id="ikp_end_date_3" onchange="calculateDuration('ikp', 3)">
    </td>
    <td>
        <input type="text" class="form-control" name="duration_3" id="ikp_duration_3" value="0" readonly>
    </td>
</tr> --}}
{{-- <tr>
                    <td class="text-center">4.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_4" id="ikp_activity_4" readonly value="Peninjauan Lapangan">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_4" id="ikp_start_date_4" onchange="calculateDuration('ikp', 4)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_4" id="ikp_end_date_4" onchange="calculateDuration('ikp', 4)">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="duration_4" id="ikp_duration_4" value="0" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">5.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_5" id="ikp_activity_5" readonly value="Penyampaian Penawaran Harga">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_5" id="ikp_start_date_5" onchange="calculateDuration('ikp', 5)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_5" id="ikp_end_date_5" onchange="calculateDuration('ikp', 5)">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="duration_5" id="ikp_duration_5" value="0" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">6.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_6" id="ikp_activity_6" readonly value="Verifikasi Penawaran Harga">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_6" id="ikp_start_date_6" onchange="calculateDuration('ikp', 6)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_6" id="ikp_end_date_6" onchange="calculateDuration('ikp', 6)">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="duration_6" id="ikp_duration_6" value="0" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">7.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_7" id="ikp_activity_7" readonly value="Penyerahan Dokumen Sampul A,B,C (Softcopy & Hardcopy) ke Kantor PT. CMNP Tbk.">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_7" id="ikp_start_date_7" onchange="calculateDuration('ikp', 7)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_7" id="ikp_end_date_7" onchange="calculateDuration('ikp', 7)">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="duration_7" id="ikp_duration_7" value="0" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">8.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_8" id="ikp_activity_8" readonly value="Pembukaan Dokumen Sampul A,B,C dan Negosiasi Kewajaran Harga">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_8" id="ikp_start_date_8" onchange="calculateDuration('ikp', 8)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_8" id="ikp_end_date_8" onchange="calculateDuration('ikp', 8)">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="duration_8" id="ikp_duration_8" value="0" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">9.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_9" id="ikp_activity_9" readonly value="Evaluasi Hasil Klarifikasi dan Negosiasi">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_9" id="ikp_start_date_9" onchange="calculateDuration('ikp', 9)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_9" id="ikp_end_date_9" onchange="calculateDuration('ikp', 9)">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="duration_9" id="ikp_duration_9" value="0" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">10.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_10" id="ikp_activity_10" readonly value="Persetujuan Direksi">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_10" id="ikp_start_date_10" onchange="calculateDuration('ikp', 10)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_10" id="ikp_end_date_10" onchange="calculateDuration('ikp', 10)">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="duration_10" id="ikp_duration_10" value="0" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">11.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_11" id="ikp_activity_11" readonly value="Surat Penetapan Pemenang">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_11" id="ikp_start_date_11" onchange="calculateDuration('ikp', 11)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_11" id="ikp_end_date_11" onchange="calculateDuration('ikp', 11)">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="duration_11" id="ikp_duration_11" value="0" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">12.</td>
                    <td>
                        <input type="text" class="form-control" name="activity_12" id="ikp_activity_12" readonly value="Pembuatan Kontrak">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="start_date_12" id="ikp_start_date_12" onchange="calculateDuration('ikp', 12)">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="end_date_12" id="ikp_end_date_12" onchange="calculateDuration('ikp', 12)">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="duration_12" id="ikp_duration_12" value="0" readonly>
                    </td>
                </tr> --}}
