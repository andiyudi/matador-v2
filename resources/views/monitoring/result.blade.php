<div class="peserta-rapat">
    <table width="100%">
        <thead>
            <tr>
                <th rowspan="4">No</th>
                <th rowspan="4">TTPP</th>
                <th rowspan="4">No PP</th>
                <th rowspan="4">Nama Pekerjaan</th>
                <th rowspan="4">PIC Pengadaan</th>
                <th rowspan="4">PP + OE Diterima</th>
                <th colspan="2">Disposisi</th>
                <th colspan="13">Proses Tender & Negosiasi</th>
                <th colspan="4" rowspan="3">Waktu Penyelesaian Tender (Hari)</th>
                <th colspan="8">Proses Dokumen Kontrak</th>
                <th rowspan="4">Input SAP (PO)</th>
            </tr>
            <tr>
                <th rowspan="3">Man. Umum Ke Kadep Pengadaan</th>
                <th rowspan="3">Kadep Pengadaan Ke Seksi</th>
                <th rowspan="3">Penawaran Kerjasama Kepada Vendor</th>
                <th rowspan="2" colspan="2">Aanwijzing</th>
                <th rowspan="2" colspan="2">Tender (Pembukaan Harga)</th>
                <th colspan="4">Review Teknik</th>
                <th colspan="4">Direksi</th>
                <th rowspan="3">Terima Dari Biro Hukum</th>
                <th rowspan="3">Paraf Mandiv Umum</th>
                <th rowspan="3">Paraf User</th>
                <th rowspan="3">Ttd Vendor</th>
                <th rowspan="3">Diserahkan ke Biro Hukum untuk Ttd Direksi</th>
                <th rowspan="3">Final Kontrak dari Biro Hukum</th>
                <th rowspan="3">Final Kontrak / OP Diserahkan ke Vendor</th>
                <th rowspan="3">Final Kontrak Diserahkan ke User</th>
            </tr>
            <tr>
                <th colspan="2">I</th>
                <th colspan="2">II</th>
                <th rowspan="2">Disposisi Untuk Nego Ulang</th>
                <th rowspan="2">Hasil Nego Ulang</th>
                <th rowspan="2">Laporan Hasil Tender</th>
                <th rowspan="2">Persetujuan</th>
            </tr>
            <tr>
                <th>I</th>
                <th>II</th>
                <th>I</th>
                <th>II</th>
                <th>Keluar</th>
                <th>Masuk</th>
                <th>Keluar</th>
                <th>Masuk</th>
                <th>Target (A)</th>
                <th>Selesai (B)</th>
                <th>Libur (C)</th>
                <th>Selisih (A-B+C)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($procurements as $procurement)
                <tr style="text-align: center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                    <td>{{ $procurement->number }}</td>
                    <td style="text-align: left">{{ $procurement->name }}</td>
                    <td>{{ $procurement->official->initials }}</td>
                    <td>{{ $procurement->ppoe_accepted ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                    <td>{{ $procurement->division_disposition ? date('d-M-Y', strtotime($procurement->division_disposition)) : '' }}</td>
                    <td>{{ $procurement->departement_disposition ? date('d-M-Y', strtotime($procurement->departement_disposition)) : '' }}</td>
                    <td>{{ $procurement->vendor_offer ? date('d-M-Y', strtotime($procurement->vendor_offer)) : '' }}</td>
                    @php
                        // Mengumpulkan data untuk kolom Aanwijzing
                        $aanwijzings = [];
                        foreach ($procurement->tenders as $tender) {
                            $aanwijzings[] = $tender->aanwijzing;
                        }

                        $aanwijzingI = $aanwijzings[count($aanwijzings) - 2] ?? '';
                        $aanwijzingII = $aanwijzings[count($aanwijzings) - 1] ?? '';

                        // Mengumpulkan data untuk kolom Tender (Pembukaan Harga)
                        $tenderOpenings = [];
                        foreach ($procurement->tenders as $tender) {
                            $tenderOpenings[] = $tender->open_tender;
                        }

                        $tenderOpeningI = $tenderOpenings[count($tenderOpenings) - 2] ?? '';
                        $tenderOpeningII = $tenderOpenings[count($tenderOpenings) - 1] ?? '';

                        // Mengumpulkan data untuk kolom Review Teknik
                        $reviewTechnicalsOut = [];
                        foreach ($procurement->tenders as $tender) {
                            $reviewTechnicalsOut[] = $tender->review_technique_out;
                        }

                        $reviewTechnicalOutI = $reviewTechnicalsOut[count($reviewTechnicalsOut) - 2] ?? '';
                        $reviewTechnicalOutII = $reviewTechnicalsOut[count($reviewTechnicalsOut) - 1] ?? '';

                        // Mengumpulkan data untuk kolom Direksi
                        $reviewTechnicalsIn = [];
                        foreach ($procurement->tenders as $tender) {
                            $reviewTechnicalsIn[] = $tender->review_technique_in;
                        }

                        $reviewTechnicalInI = $reviewTechnicalsIn[count($reviewTechnicalsIn) - 2] ?? '';
                        $reviewTechnicalInII = $reviewTechnicalsIn[count($reviewTechnicalsIn) - 1] ?? '';
                    @endphp
                    <td>{{ $aanwijzingI ? date('d-M-Y', strtotime($aanwijzingI)) : '' }}</td>
                    <td>{{ $aanwijzingII ? date('d-M-Y', strtotime($aanwijzingII)) : '' }}</td>
                    <td>{{ $tenderOpeningI ? date('d-M-Y', strtotime($tenderOpeningI)) : '' }}</td>
                    <td>{{ $tenderOpeningII ? date('d-M-Y', strtotime($tenderOpeningII)) : '' }}</td>
                    <td>{{ $reviewTechnicalOutI ? date('d-M-Y', strtotime($reviewTechnicalOutI)) : '' }}</td>
                    <td>{{ $reviewTechnicalInI ? date('d-M-Y', strtotime($reviewTechnicalInI)) : '' }}</td>
                    <td>{{ $reviewTechnicalOutII ? date('d-M-Y', strtotime($reviewTechnicalOutII)) : '' }}</td>
                    <td>{{ $reviewTechnicalInII ? date('d-M-Y', strtotime($reviewTechnicalInII)) : '' }}</td>
                    <td>{{ $procurement->disposition_second_tender ? date('d-M-Y', strtotime($procurement->disposition_second_tender)) : '' }}</td>
                    <td>{{ $procurement->renegotiation_result ? date('d-M-Y', strtotime($procurement->renegotiation_result)) : '' }}</td>
                    <td>{{ $procurement->tender_result ? date('d-M-Y', strtotime($procurement->tender_result)) : '' }}</td>
                    <td>{{ $procurement->director_agreement ? date('d-M-Y', strtotime($procurement->director_agreement)) : '' }}</td>
                    <td>{{ $procurement->target_day }}</td>
                    <td>{{ $procurement->finish_day }}</td>
                    <td>{{ $procurement->off_day }}</td>
                    <td>{{ $procurement->difference_day }}</td>
                    <td>{{ $procurement->legal_accept ? date('d-M-Y', strtotime($procurement->legal_accept)) : '' }}</td>
                    <td>{{ $procurement->general_accept ? date('d-M-Y', strtotime($procurement->general_accept)) : '' }}</td>
                    <td>{{ $procurement->user_accept ? date('d-M-Y', strtotime($procurement->user_accept)) : '' }}</td>
                    <td>{{ $procurement->vendor_accept ? date('d-M-Y', strtotime($procurement->vendor_accept)) : '' }}</td>
                    <td>{{ $procurement->director_accept ? date('d-M-Y', strtotime($procurement->director_accept)) : '' }}</td>
                    <td>{{ $procurement->contract_from_legal ? date('d-M-Y', strtotime($procurement->contract_from_legal)) : '' }}</td>
                    <td>{{ $procurement->contract_to_vendor ? date('d-M-Y', strtotime($procurement->contract_to_vendor)) : '' }}</td>
                    <td>{{ $procurement->contract_to_user ? date('d-M-Y', strtotime($procurement->contract_to_user)) : '' }}</td>
                    <td>{{ $procurement->input_sap ? date('d-M-Y', strtotime($procurement->input_sap)) : '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
