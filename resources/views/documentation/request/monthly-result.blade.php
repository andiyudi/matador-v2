<div class="peserta-rapat">
    @php
        $nomorUrutTable = 0; // untuk nomor urut dokumen per value
        $totalBerkas = 0; // untuk hitung jumlah data dokumen per value
        $totalUserEstimate = 0; // untuk hitung total user estimate per value
        $totalTechniqueEstimate = 0; // untuk hitung total technique estimate per value
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
                    <tr>
                        <td style="text-align: center">{{ ++$nomorUrutTable }}</td>
                        <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                        <td style="text-align: center">{{ $procurement->number }}</td>
                        <td>{{ $procurement->name }}</td>
                        <td style="text-align: center">{{ $procurement->division->code }}</td>
                        <td style="text-align: center">{{ $procurement->official->initials }}</td>
                        <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '0' }}</td>
                        <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '0' }}</td>
                        @php
                            $totalUserEstimate += $procurement->user_estimate;
                            $totalTechniqueEstimate += $procurement->technique_estimate;
                            $totalBerkas++;
                        @endphp
                    </tr>
            @endforeach
            <tr style="text-align: center">
                <td colspan="4"><strong>JUMLAH</strong></td>
                <td>{{ $totalBerkas }}</td>
                <td>BERKAS</td>
                <td style="text-align: right">{{ number_format($totalUserEstimate, 0, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($totalTechniqueEstimate, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    <br>
</div>
