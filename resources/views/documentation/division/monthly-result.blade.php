<div class="peserta-rapat">
    @php
        $nomorUrutTable = 0; // untuk nomor urut dokumen per value
        $nomorUrutTableCancel = 0; // untuk nomor urut dokumen cancel per value
        $cekDataCancel = 0; // untuk cek data cancel per value
        $totalBerkas = 0; // untuk hitung jumlah data dokumen per value
        $totalBerkasCancel = 0; // untuk hitung jumlah data dokumen cancel per value
        $totalUserEstimate = 0; // untuk hitung total user estimate per value
        $totalUserEstimateCancel = 0; // untuk hitung total user estimate cancel per value
        $totalTechniqueEstimate = 0; // untuk hitung total technique estimate per value
        $totalTechniqueEstimateCancel = 0; // untuk hitung total technique estimate cancel per value
    @endphp

    <table width="100%">
        <thead>
            <tr>
                <th rowspan="2" width="3%" style="text-align: center">No</th>
                <th rowspan="2" width="7%" style="text-align: center">TTPP</th>
                <th rowspan="2" width="5%" style="text-align: center">No PP</th>
                <th rowspan="2" width="40%" style="text-align: center">Nama Pekerjaan</th>
                <th rowspan="2" width="5%" style="text-align: center">Divisi</th>
                <th rowspan="2" width="8%" style="text-align: center">PIC Pengadaan</th>
                <th colspan="2" style="text-align: center">Nilai PP</th>
            </tr>
            <tr>
                <th>EE User</th>
                <th>EE Teknik</th>
            </tr>
        </thead>
        <tbody>
            @foreach($procurements as $procurement)
                @if ($procurement->status != '2')
                    <tr>
                        <td style="text-align: center">{{ ++$nomorUrutTable }}</td>
                        <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                        <td style="text-align: center">{{ $procurement->number }}</td>
                        <td>{{ $procurement->name }}</td>
                        <td style="text-align: center">{{ $procurement->division->code }}</td>
                        <td style="text-align: center">{{ $procurement->official->initials }}</td>
                        <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '' }}</td>
                        <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '' }}</td>
                        @php
                            $totalUserEstimate += $procurement->user_estimate;
                            $totalTechniqueEstimate += $procurement->technique_estimate;
                            $totalBerkas++;
                        @endphp
                    </tr>
                @endif
            @endforeach
            @foreach($procurements as $procurement)
                @if ($procurement->status == '2')
                    @php
                            $cekDataCancel++;
                    @endphp
                @endif
            @endforeach
            @if ( $cekDataCancel > 0)
            <tr>
                <td colspan="8" style="color: red; font-weight: bold; text-align: center">PP DIBATALKAN</td>
            </tr>
            @endif
            @foreach($procurements as $procurement)
                @if ($procurement->status == '2')
                <tr>
                    <td style="text-align: center">{{ ++$nomorUrutTableCancel }}</td>
                    <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                    <td style="text-align: center">{{ $procurement->number }}</td>
                    <td>{{ $procurement->name }}</td>
                    <td style="text-align: center">{{ $procurement->division->code }}</td>
                    <td style="text-align: center">{{ $procurement->official->initials }}</td>
                    <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '' }}</td>
                    <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '' }}</td>
                    @php
                        $totalUserEstimateCancel += $procurement->user_estimate;
                        $totalTechniqueEstimateCancel += $procurement->technique_estimate;
                        $totalBerkasCancel++;
                    @endphp
                </tr>
                @endif
            @endforeach
            <tr style="text-align: center">
                <td colspan="4"><strong>JUMLAH</strong></td>
                <td>{{ $totalBerkas + $totalBerkasCancel }}</td>
                <td>BERKAS</td>
                <td style="text-align: right">{{ number_format($totalUserEstimate + $totalUserEstimateCancel, 0, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($totalTechniqueEstimate + $totalTechniqueEstimateCancel, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    <br>
</div>
