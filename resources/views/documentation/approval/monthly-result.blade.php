<div class="peserta-rapat">
    @php
    $nomorUrutTable1 = $nomorUrutTable2 = $nomorUrutTable3 = 0; // untuk nomor urut dokumen per value
    $totalBerkas1 = $totalBerkas2 = $totalBerkas3 = 0; // untuk hitung jumlah data dokumen per value
    $totalUserEstimate1 = $totalUserEstimate2 = $totalUserEstimate3 = 0; // untuk hitung total user estimate per value
    $totalTechniqueEstimate1 = $totalTechniqueEstimate2 = $totalTechniqueEstimate3 = 0; // untuk hitung total technique estimate per value
    $totalDealNego1 = $totalDealNego2 = $totalDealNego3 = 0; // untuk hitung total deal nego per value
    @endphp
    <table width="100%">
        <thead>
            <tr style="text-align: center">
                <th width="2%">No</th>
                <th width="4%">TTPR</th>
                <th width="4%">No PR</th>
                <th width="15%">Nama Pekerjaan</th>
                <th width="3%">Divisi</th>
                <th width="6%">PIC Pengadaan</th>
                <th>EE User</th>
                <th>EE Teknik</th>
                <th>Hasil Negosiasi</th>
                <th>Tanggal Persetujuan Direksi</th>
                <th>Nama Vendor / Mitra Kerja</th>
                <th>Jangka Waktu Pekerjaan</th>
            </tr>
            <tr>
                <td colspan="12" style="color: red; font-weight: bold">PR YANG DISETUJUI DIREKSI</td>
            </tr>
        </thead>
        <tbody>
            @foreach($procurements as $procurement)
            @if ($procurement->status == '1')
            <tr>
                <td style="text-align: center">{{ ++$nomorUrutTable1 }}</td>
                <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                <td style="text-align: center">{{ $procurement->number }}</td>
                <td>{{ $procurement->name }}</td>
                <td style="text-align: center">{{ $procurement->division->code }}</td>
                <td style="text-align: center">{{ $procurement->official->initials }}</td>
                <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '0' }}</td>
                <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '0' }}</td>
                <td style="text-align: right">{{ $procurement->deal_nego !== null ? number_format($procurement->deal_nego, 0, ',', '.') : '0' }}</td>
                <td style="text-align: center">{{ $procurement->director_approval ? date('d-M-Y', strtotime($procurement->director_approval)) : '' }}</td>
                <td style="text-align: center">
                @php
                    $selectedVendorName = null;
                    foreach ($procurement->tenders as $tender) {
                        $selectedVendor = $tender->businessPartners->first(function ($businessPartner) {
                            return $businessPartner->pivot->is_selected === '1';
                        });
                        if ($selectedVendor) {
                            $selectedVendorName = $selectedVendor->partner->name;
                            break;
                        }
                    }
                @endphp
                {{ $selectedVendorName ?? 'No vendor selected' }}
                </td>
                <td style="text-align: center">{{ $procurement->estimation }}</td>
            </tr>
            @php
                $totalUserEstimate1 += $procurement->user_estimate;
                $totalTechniqueEstimate1 += $procurement->technique_estimate;
                $totalDealNego1 += $procurement->deal_nego;
                $totalBerkas1++;
            @endphp
            @endif
            @endforeach
            <tr style="text-align: center">
                <td colspan="4"><strong>JUMLAH</strong></td>
                <td>{{ $totalBerkas1 }}</td>
                <td>BERKAS</td>
                <td style="text-align: right">{{ number_format($totalUserEstimate1 , 0, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($totalTechniqueEstimate1 , 0, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($totalDealNego1 , 0, ',', '.') }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table width="100%">
        <thead>
            <tr style="text-align: center">
                <th width="2%">No</th>
                <th width="4%">TTPR</th>
                <th width="4%">No PR</th>
                <th width="15%">Nama Pekerjaan</th>
                <th width="3%">Divisi</th>
                <th width="6%">PIC Pengadaan</th>
                <th>EE User</th>
                <th>EE Teknik</th>
                <th>Hasil Negosiasi</th>
                <th>Tanggal Persetujuan Direksi</th>
                <th>Nama Vendor / Mitra Kerja</th>
                <th>Jangka Waktu Pekerjaan</th>
            </tr>
            <tr>
                <td colspan="12" style="color: red; font-weight: bold">PR MASIH DALAM PROSES NEGOSIASI</td>
            </tr>
        </thead>
        <tbody>
            @foreach($procurements as $procurement)
            @if ($procurement->status == '0')
            <tr>
                <td style="text-align: center">{{ ++$nomorUrutTable2 }}</td>
                <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                <td style="text-align: center">{{ $procurement->number }}</td>
                <td>{{ $procurement->name }}</td>
                <td style="text-align: center">{{ $procurement->division->code }}</td>
                <td style="text-align: center">{{ $procurement->official->initials }}</td>
                <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '0' }}</td>
                <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '0' }}</td>
                <td style="text-align: right"></td>
                <td style="text-align: center"></td>
                <td style="text-align: center"></td>
                <td style="text-align: center"></td>
            </tr>
            @php
                $totalUserEstimate2 += $procurement->user_estimate;
                $totalTechniqueEstimate2 += $procurement->technique_estimate;
                $totalDealNego2 += $procurement->deal_nego;
                $totalBerkas2++;
            @endphp
            @endif
            @endforeach
            <tr style="text-align: center">
                <td colspan="4"><strong>JUMLAH</strong></td>
                <td>{{ $totalBerkas2 }}</td>
                <td>BERKAS</td>
                <td style="text-align: right">{{ number_format($totalUserEstimate2 , 0, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($totalTechniqueEstimate2 , 0, ',', '.') }}</td>
                <td style="text-align: right"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table width="100%">
        <thead>
            <tr style="text-align: center">
                <th width="2%">No</th>
                <th width="4%">TTPR</th>
                <th width="4%">No PR</th>
                <th width="15%">Nama Pekerjaan</th>
                <th width="3%">Divisi</th>
                <th width="6%">PIC Pengadaan</th>
                <th>EE User</th>
                <th>EE Teknik</th>
                <th>Hasil Negosiasi</th>
                <th>Tanggal Persetujuan Direksi</th>
                <th>Nama Vendor / Mitra Kerja</th>
                <th>Jangka Waktu Pekerjaan</th>
            </tr>
            <tr>
                <td colspan="12" style="color: red; font-weight: bold">PR DIBATALKAN</td>
            </tr>
        </thead>
        <tbody>
            @foreach($procurements as $procurement)
            @if ($procurement->status == '2')
            <tr style="color: red">
                <td style="text-align: center">{{ ++$nomorUrutTable3 }}</td>
                <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                <td style="text-align: center">{{ $procurement->number }}</td>
                <td>{{ $procurement->name }}</td>
                <td style="text-align: center">{{ $procurement->division->code }}</td>
                <td style="text-align: center">{{ $procurement->official->initials }}</td>
                <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '0' }}</td>
                <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '0' }}</td>
                <td colspan="4" style="text-align: center">{{ $procurement->cancellation_memo }}</td>
            </tr>
            @php
            $totalUserEstimate3 += $procurement->user_estimate;
            $totalTechniqueEstimate3 += $procurement->technique_estimate;
            $totalDealNego3 += $procurement->deal_nego;
            $totalBerkas3++;
        @endphp
        @endif
        @endforeach
        <tr style="text-align: center">
            <td colspan="4"><strong>JUMLAH</strong></td>
            <td>{{ $totalBerkas3 }}</td>
            <td>BERKAS</td>
            <td style="text-align: right">{{ number_format($totalUserEstimate3 , 0, ',', '.') }}</td>
            <td style="text-align: right">{{ number_format($totalTechniqueEstimate3 , 0, ',', '.') }}</td>
            <td style="text-align: right"></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tbody>
    </table>
    <br>
</div>
