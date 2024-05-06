
<div class="peserta-rapat">
    @php
        $nomorUrutTable1 = $nomorUrutTable2 = $nomorUrutTable3 = 0; // untuk nomor urut dokumen per value
        $nomorUrutTableCancel1 = $nomorUrutTableCancel2 = $nomorUrutTableCancel3 = 0; // untuk nomor urut dokumen cancel per value
        $cekDataCancel1 = $cekDataCancel2 = $cekDataCancel3 = 0; // untuk cek data cancel per value
        $totalBerkas1 = $totalBerkas2 = $totalBerkas3 = 0; // untuk hitung jumlah data dokumen per value
        $totalBerkasCancel1 = $totalBerkasCancel2 = $totalBerkasCancel3 = 0; // untuk hitung jumlah data dokumen cancel per value
        $totalUserEstimate1 = $totalUserEstimate2 = $totalUserEstimate3 = 0; // untuk hitung total user estimate per value
        $totalUserEstimateCancel1 = $totalUserEstimateCancel2 = $totalUserEstimateCancel3 = 0; // untuk hitung total user estimate cancel per value
        $totalTechniqueEstimate1 = $totalTechniqueEstimate2 = $totalTechniqueEstimate3 = 0; // untuk hitung total technique estimate per value
        $totalTechniqueEstimateCancel1 = $totalTechniqueEstimateCancel2 = $totalTechniqueEstimateCancel3 = 0; // untuk hitung total technique estimate cancel per value
    @endphp

    <!-- Table untuk dokumen PP dengan nilai < 100 Juta -->
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
                <tr>
                    <td colspan="8" style="color: red; font-weight: bold">DOKUMEN PP NILAI 0 s.d <  100 JUTA</td>
                </tr>
            @foreach($procurements as $procurement)
                @if ($procurement->user_estimate < 100000000 && $procurement->status != '2')
                    <tr>
                        <td style="text-align: center">{{ ++$nomorUrutTable1 }}</td>
                        <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                        <td style="text-align: center">{{ $procurement->number }}</td>
                        <td>{{ $procurement->name }}</td>
                        <td style="text-align: center">{{ $procurement->division->code }}</td>
                        <td style="text-align: center">{{ $procurement->official->initials }}</td>
                        <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '' }}</td>
                        <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '' }}</td>
                        @php
                            $totalUserEstimate1 += $procurement->user_estimate;
                            $totalTechniqueEstimate1 += $procurement->technique_estimate;
                            $totalBerkas1++;
                        @endphp
                    </tr>
                @endif
            @endforeach
            @foreach($procurements as $procurement)
                @if ($procurement->user_estimate < 100000000 && $procurement->status == '2')
                    @php
                            $cekDataCancel1++;
                    @endphp
                @endif
            @endforeach
            @if ( $cekDataCancel1 > 0)
            <tr>
                <td colspan="8" style="color: red; font-weight: bold; text-align: center">PP DIBATALKAN</td>
            </tr>
            @endif
            @foreach($procurements as $procurement)
                @if ($procurement->user_estimate < 100000000 && $procurement->status == '2')
                <tr>
                    <td style="text-align: center">{{ ++$nomorUrutTableCancel1 }}</td>
                    <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                    <td style="text-align: center">{{ $procurement->number }}</td>
                    <td>{{ $procurement->name }}</td>
                    <td style="text-align: center">{{ $procurement->division->code }}</td>
                    <td style="text-align: center">{{ $procurement->official->initials }}</td>
                    <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '' }}</td>
                    <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '' }}</td>
                    @php
                        $totalUserEstimateCancel1 += $procurement->user_estimate;
                        $totalTechniqueEstimateCancel1 += $procurement->technique_estimate;
                        $totalBerkasCancel1++;
                    @endphp
                </tr>
                @endif
            @endforeach
            <tr style="text-align: center">
                <td colspan="4"><strong>JUMLAH</strong></td>
                <td>{{ $totalBerkas1 + $totalBerkasCancel1 }}</td>
                <td>BERKAS</td>
                <td style="text-align: right">{{ number_format($totalUserEstimate1 + $totalUserEstimateCancel1, 0, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($totalTechniqueEstimate1 + $totalTechniqueEstimateCancel1, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <!-- Table untuk dokumen PP dengan nilai >= 100 Juta dan < 1 Miliar -->
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
            <tr>
                <td colspan="8" style="color: red; font-weight: bold">DOKUMEN PP NILAI &#8805; 100 JUTA s.d < 1 M</td>
            </tr>
        @foreach($procurements as $procurement)
        @if ($procurement->user_estimate >= 100000000 && $procurement->user_estimate < 1000000000 && $procurement->status != '2')
        <tr>
            <td style="text-align: center">{{ ++$nomorUrutTable2 }}</td>
            <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
            <td style="text-align: center">{{ $procurement->number }}</td>
            <td>{{ $procurement->name }}</td>
            <td style="text-align: center">{{ $procurement->division->code }}</td>
            <td style="text-align: center">{{ $procurement->official->initials }}</td>
            <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '' }}</td>
            <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '' }}</td>
            @php
                $totalUserEstimate2 += $procurement->user_estimate;
                $totalTechniqueEstimate2 += $procurement->technique_estimate;
                $totalBerkas2++;
            @endphp
        </tr>
        @endif
        @endforeach
        @foreach($procurements as $procurement)
            @if ($procurement->user_estimate >= 100000000 && $procurement->user_estimate < 1000000000 && $procurement->status == '2')
            @php
                    $cekDataCancel2++;
            @endphp
            @endif
            @endforeach
            @if ( $cekDataCancel2 > 0)
            <tr>
                <td colspan="8" style="color: red; font-weight: bold; text-align: center">PP DIBATALKAN</td>
            </tr>
            @endif
            @foreach($procurements as $procurement)
            @if ($procurement->user_estimate >= 100000000 && $procurement->user_estimate < 1000000000 && $procurement->status == '2')
            <tr>
                <td style="text-align: center">{{ ++$nomorUrutTableCancel2 }}</td>
                <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                <td style="text-align: center">{{ $procurement->number }}</td>
                <td>{{ $procurement->name }}</td>
                <td style="text-align: center">{{ $procurement->division->code }}</td>
                <td style="text-align: center">{{ $procurement->official->initials }}</td>
                <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '' }}</td>
                <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '' }}</td>
                @php
                    $totalUserEstimateCancel2 += $procurement->user_estimate;
                    $totalTechniqueEstimateCancel2 += $procurement->technique_estimate;
                    $totalBerkasCancel2++;
                @endphp
            </tr>
            @endif
            @endforeach
        <tr style="text-align: center">
            <td colspan="4"><strong>JUMLAH</strong></td>
            <td>{{ $totalBerkas2 + $totalBerkasCancel2 }}</td>
            <td>BERKAS</td>
            <td style="text-align: right">{{ number_format($totalUserEstimate2 + $totalUserEstimateCancel2, 0, ',', '.') }}</td>
            <td style="text-align: right">{{ number_format($totalTechniqueEstimate2 + $totalTechniqueEstimateCancel2, 0, ',', '.') }}</td>
        </tr>
    </tbody>
    </table>
    <br>
    <!-- Table untuk dokumen PP dengan nilai >= 1 Miliar -->
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
            <tr>
                <td colspan="8" style="color: red; font-weight: bold">DOKUMEN PP NILAI &#8805; 1 M</td>
            </tr>
            @foreach($procurements as $procurement)
            @if ($procurement->user_estimate >= 1000000000 && $procurement->status != '2')
            <tr>
                <td style="text-align: center">{{ ++$nomorUrutTable3 }}</td>
                <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                <td style="text-align: center">{{ $procurement->number }}</td>
                <td>{{ $procurement->name }}</td>
                <td style="text-align: center">{{ $procurement->division->code }}</td>
                <td style="text-align: center">{{ $procurement->official->initials }}</td>
                <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '' }}</td>
                <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '' }}</td>
                @php
                    $totalUserEstimate3 += $procurement->user_estimate;
                    $totalTechniqueEstimate3 += $procurement->technique_estimate;
                    $totalBerkas3++;
                @endphp
            </tr>
            @endif
            @endforeach
            @foreach($procurements as $procurement)
            @if ($procurement->user_estimate >= 1000000000 && $procurement->status == '2')
            @php
                    $cekDataCancel3++;
            @endphp
            @endif
            @endforeach
            @if ( $cekDataCancel3 > 0)
            <tr>
                <td colspan="8" style="color: red; font-weight: bold; text-align: center">PP DIBATALKAN</td>
            </tr>
            @endif
            @foreach($procurements as $procurement)
            @if ($procurement->user_estimate >= 1000000000 && $procurement->status == '2')
            <tr>
                <td style="text-align: center">{{ ++$nomorUrutTableCancel3 }}</td>
                <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                <td style="text-align: center">{{ $procurement->number }}</td>
                <td>{{ $procurement->name }}</td>
                <td style="text-align: center">{{ $procurement->division->code }}</td>
                <td style="text-align: center">{{ $procurement->official->initials }}</td>
                <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '' }}</td>
                <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '' }}</td>
                @php
                    $totalUserEstimateCancel3 += $procurement->user_estimate;
                    $totalTechniqueEstimateCancel3 += $procurement->technique_estimate;
                    $totalBerkasCancel3++;
                @endphp
            </tr>
            @endif
            @endforeach
            <tr style="text-align: center">
                <td colspan="4"><strong>JUMLAH</strong></td>
                <td>{{ $totalBerkas3 + $totalBerkasCancel3 }}</td>
                <td>BERKAS</td>
                <td style="text-align: right">{{ number_format($totalUserEstimate3 + $totalUserEstimateCancel3, 0, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($totalTechniqueEstimate3 + $totalTechniqueEstimateCancel3, 0, ',', '.') }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr style="text-align: center">
                <td colspan="4"><strong>TOTAL PP {{ strtoupper($monthName) }}</strong></td>
                <td>{{ $totalBerkas1 + $totalBerkas2 + $totalBerkas3 + $totalBerkasCancel1 + $totalBerkasCancel2 + $totalBerkasCancel3 }}</td>
                <td>BERKAS</td>
                <td style="text-align: right">{{ number_format($totalUserEstimate1 + $totalUserEstimate2 + $totalUserEstimate3 + $totalUserEstimateCancel1 + $totalUserEstimateCancel2 + $totalUserEstimateCancel3, 0, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($totalTechniqueEstimate1 + $totalTechniqueEstimate2 + $totalTechniqueEstimate3 + $totalTechniqueEstimateCancel1 + $totalTechniqueEstimateCancel2 + $totalTechniqueEstimateCancel3, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
    <br>
</div>
