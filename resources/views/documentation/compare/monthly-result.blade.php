<div class="peserta-rapat">
    @php
    $nomorUrutTable = 0; // untuk nomor urut dokumen per value
    $totalUserEstimate = 0; // untuk hitung total user estimate per value
    $totalTechniqueEstimate = 0; // untuk hitung total technique estimate per value
    $totalDealNego = 0; // untuk hitung total deal nego per value
    @endphp
    <table width="100%">
        <thead>
            <tr style="text-align: center">
                <th rowspan="2" width="2%">No</th>
                <th rowspan="2" width="4%">TTPP</th>
                <th rowspan="2" width="4%">No PP</th>
                <th rowspan="2" width="10%">Nama Pekerjaan</th>
                <th rowspan="2" width="3%">Divisi</th>
                <th rowspan="2" width="3%">PIC Pengadaan</th>
                <th rowspan="2" width="5%">Nama Vendor / Mitra Kerja</th>
                <th rowspan="2" width="4%">Tanggal Persetujuan Direksi</th>
                <th colspan="4">Perbandingan</th>
                <th colspan="4">Perbandingan</th>
            </tr>
            <tr>
                <th>EE User</th>
                <th>Hasil Negosiasi</th>
                <th>Selisih</th>
                <th>%</th>
                <th>EE Teknik</th>
                <th>Hasil Negosiasi</th>
                <th>Selisih</th>
                <th>%</th>
            </tr>
        </thead>
        <tbody>
            @foreach($procurements as $procurement)
            @if ($procurement->status == '1')
            <tr>
                <td style="text-align: center">{{ ++$nomorUrutTable }}</td>
                <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                <td style="text-align: center">{{ $procurement->number }}</td>
                <td>{{ $procurement->name }}</td>
                <td style="text-align: center">{{ $procurement->division->code }}</td>
                <td style="text-align: center">{{ $procurement->official->initials }}</td>
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
                <td style="text-align: center">{{ $procurement->director_approval ? date('d-M-Y', strtotime($procurement->director_approval)) : '' }}</td>
                <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '0' }}</td>
                <td style="text-align: right">{{ $procurement->deal_nego !== null ? number_format($procurement->deal_nego, 0, ',', '.') : '0' }}</td>
                <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate - $procurement->deal_nego, 0, ',', '.') : '0' }}</td>
                <td style="text-align: center">{{ $procurement->user_percentage !== null ? number_format($procurement->user_percentage, 2, ',', '.') : '0' }}%</td>
                <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '0' }}</td>
                <td style="text-align: right">{{ $procurement->deal_nego !== null ? number_format($procurement->deal_nego, 0, ',', '.') : '0' }}</td>
                <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate - $procurement->deal_nego, 0, ',', '.') : '0' }}</td>
                <td style="text-align: center">{{ $procurement->technique_percentage !== null ? number_format($procurement->technique_percentage, 2, ',', '.') : '0' }}%</td>
            </tr>
            @php
                $totalUserEstimate += $procurement->user_estimate;
                $totalTechniqueEstimate += $procurement->technique_estimate;
                $totalDealNego += $procurement->deal_nego;
            @endphp
            @endif
            @endforeach
            <tr style="text-align: center; font-weight: bold">
                <td colspan="8"><strong>JUMLAH</strong></td>
                <td style="text-align: right">{{ number_format($totalUserEstimate , 0, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($totalDealNego , 0, ',', '.') }}</td>
                @php
                $differenceUser = $totalUserEstimate - $totalDealNego;
                $percentageUser = ($totalUserEstimate > 0) ? (($differenceUser / $totalUserEstimate) * 100) : 0;
                @endphp
                <td style="text-align: right">{{ number_format($differenceUser, 0, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($percentageUser, 2, ',', '.') }}%</td>
                @php
                $differenceTechnique = $totalTechniqueEstimate - $totalDealNego;
                $percentageTechnique = ($totalTechniqueEstimate > 0) ? (($differenceTechnique / $totalTechniqueEstimate) * 100) : 0;
                @endphp
                <td style="text-align: right">{{ number_format($totalTechniqueEstimate , 0, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($totalDealNego , 0, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($differenceTechnique, 0, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($percentageTechnique, 2, ',', '.') }}%</td>
            </tr>
        </tbody>
    </table>
    <br>
</div>
