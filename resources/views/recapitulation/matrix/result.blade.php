<div class="peserta-rapat">
    <table width="100%">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">TTPP</th>
                <th rowspan="2">No PP</th>
                <th rowspan="2">No OP</th>
                <th rowspan="2">No Kontrak</th>
                <th rowspan="2">Tgl Kontrak / OP</th>
                <th rowspan="2">Nama Pekerjaan</th>
                <th rowspan="2">Divisi</th>
                <th rowspan="2">PIC Pengadaan</th>
                <th rowspan="2">Mitra Kerja / Vendor</th>
                <th colspan="2">Laporan Hasil Nego ke Direksi</th>
                <th rowspan="2">Tgl Persetujuan Direksi</th>
                <th colspan="4">Jumlah Hari</th>
                <th colspan="4">Perbandingan</th>
                <th colspan="4">Perbandingan</th>
                <th rowspan="2">Jangka Waktu Pekerjaan</th>
                <th rowspan="2">Keterangan</th>
            </tr>
            <tr>
                <th>I</th>
                <th>II</th>
                <th>Target (A)</th>
                <th>Selesai (B)</th>
                <th>Libur (C)</th>
                <th>Selisih (A-B+C)</th>
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
            @php
                $grandTotalFinishDay = $grandTotalOffDay = $grandTotalDifferenceDay = $grandTotalUserEstimate = $grandTotalDealNego = $grandTotalTechniqueEstimate = 0;
            @endphp
            @foreach ($months as $index => $month)
                @php
                    $totalFinishDay = $totalOffDay = $totalDifferenceDay = $totalUserEstimate = $totalDealNego = $totalTechniqueEstimate = 0;
                @endphp
                <tr>
                    <td colspan="27" style="background-color: yellow;"><strong>{{ strtoupper($monthsName[$index]) }}</strong></td>
                </tr>
                @if(isset($procurementsByMonth[$month]) && count($procurementsByMonth[$month]) > 0)
                    @foreach ($procurementsByMonth[$month] as $index => $procurement)
                        @php
                        // Tambahkan nilai dari setiap baris data ke variabel total
                            $totalFinishDay += $procurement->finish_day;
                            $totalOffDay += $procurement->off_day;
                            $totalDifferenceDay += $procurement->difference_day;
                            $totalUserEstimate += $procurement->user_estimate;
                            $totalDealNego += $procurement->deal_nego;
                            $totalTechniqueEstimate += $procurement->technique_estimate;
                        @endphp
                        <tr style="text-align: center">
                            <td>{{ $index + 1 }}</td>
                            {{-- <td>{{ Carbon\Carbon::parse($procurement->receipt)->format('d-M-y') }}</td> --}}
                            <td>{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                            <td>{{ $procurement->number }}</td>
                            <td>{{ $procurement->op_number }}</td>
                            <td>{{ $procurement->contract_number }}</td>
                            <td>
                                @if ($procurement->contract_date)
                                    {{ $procurement->contract_date ? date('d-M-Y', strtotime($procurement->contract_date)) : '' }}
                                    {{-- {{ \Carbon\Carbon::parse($procurement->contract_date)->format('d-M-y') }} --}}
                                @endif
                            </td>
                            <td style="text-align: left">{{ $procurement->name }}</td>
                            <td>{{ $procurement->division->code }}</td>
                            <td>{{ $procurement->official->initials }}</td>
                            <td>{{ $isSelectedArrayByMonth[$month][$procurement->id]['selected_partner'] }}</td>
                            @if (count($isSelectedArrayByMonth[$month][$procurement->id]['report_nego_results']) > 0)
                                @php
                                    $reportNegoResults = $isSelectedArrayByMonth[$month][$procurement->id]['report_nego_results'];
                                    $count = count($reportNegoResults);
                                @endphp
                                @if ($count == 1)
                                    {{-- <td>{{ \Carbon\Carbon::parse($reportNegoResults[0])->format('d-M-y') }}</td> --}}
                                    <td>{{ $reportNegoResults[0] ? date('d-M-Y', strtotime($reportNegoResults[0])) : '' }}</td>
                                    <td></td> <!-- Kolom kosong untuk report nego result kedua -->
                                @elseif ($count == 2)
                                    {{-- <td>{{ \Carbon\Carbon::parse($reportNegoResults[0])->format('d-M-y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reportNegoResults[1])->format('d-M-y') }}</td> --}}
                                    <td>{{ $reportNegoResults[0] ? date('d-M-Y', strtotime($reportNegoResults[0])) : '' }}</td>
                                    <td>{{ $reportNegoResults[1] ? date('d-M-Y', strtotime($reportNegoResults[1])) : '' }}</td>
                                @else
                                    {{-- <td>{{ \Carbon\Carbon::parse($reportNegoResults[$count - 2])->format('d-M-y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reportNegoResults[$count - 1])->format('d-M-y') }}</td> --}}
                                    <td>{{ $reportNegoResults[$count - 2] ? date('d-M-Y', strtotime($reportNegoResults[$count - 2])) : '' }}</td>
                                    <td>{{ $reportNegoResults[$count - 1] ? date('d-M-Y', strtotime($reportNegoResults[$count - 1])) : '' }}</td>
                                @endif
                            @else
                                <td></td> <!-- Kolom kosong untuk report nego result pertama -->
                                <td></td> <!-- Kolom kosong untuk report nego result kedua -->
                            @endif
                            <td>
                                @if ($procurement->director_approval)
                                    {{ $procurement->director_approval ? date('d-M-Y', strtotime($procurement->director_approval)) : '' }}
                                    {{-- {{ \Carbon\Carbon::parse($procurement->director_approval)->format('d-M-y') }} --}}
                                @endif
                            </td>
                            <td>{{ $procurement->target_day }}</td>
                            <td>{{ $procurement->finish_day }}</td>
                            <td>{{ $procurement->off_day }}</td>
                            <td>{{ $procurement->difference_day }}</td>
                            <td>
                                @if ($procurement->user_estimate !== null)
                                    {{ number_format($procurement->user_estimate, 0, '.', '.') }}
                                @endif
                            </td>
                            <td>
                                @if ($procurement->deal_nego !== null)
                                    {{ number_format($procurement->deal_nego, 0, '.', '.') }}
                                @endif
                            </td>
                            <td>
                                @if ($procurement->user_estimate !== null && $procurement->deal_nego !== null)
                                    {{ number_format($procurement->user_estimate - $procurement->deal_nego, 0, '.', '.') }}
                                @endif
                            </td>
                            <td>
                                @if ($procurement->user_percentage !== null)
                                    {{ str_replace('.', ',', number_format($procurement->user_percentage, 2)) }}%
                                @endif
                            </td>
                            <td>
                                @if ($procurement->technique_estimate !== null)
                                    {{ number_format($procurement->technique_estimate, 0, '.', '.') }}
                                @endif
                            </td>
                            <td>
                                @if ($procurement->deal_nego !== null)
                                    {{ number_format($procurement->deal_nego, 0, '.', '.') }}
                                @endif
                            </td>
                            <td>
                                @if ($procurement->technique_estimate !== null && $procurement->deal_nego !== null)
                                    {{ number_format($procurement->technique_estimate - $procurement->deal_nego, 0, '.', '.') }}
                                @endif
                            </td>
                            <td>
                                @if ($procurement->technique_percentage !== null)
                                    {{ str_replace('.', ',', number_format($procurement->technique_percentage, 2)) }}%
                                @endif
                            </td>
                            <td>{{ $procurement->estimation }}</td>
                            <td>{{ $procurement->information }}</td>
                        </tr>
                    @endforeach
                    @php
                    // Tambahkan nilai dari setiap baris data ke variabel grand total
                        $grandTotalFinishDay += $totalFinishDay;
                        $grandTotalOffDay += $totalOffDay;
                        $grandTotalDifferenceDay += $totalDifferenceDay;
                        $grandTotalUserEstimate += $totalUserEstimate;
                        $grandTotalDealNego += $totalDealNego;
                        $grandTotalTechniqueEstimate += $totalTechniqueEstimate;
                    @endphp
                    <tr style="background-color:floralwhite; text-align:center; font-weight:bold">
                        <td colspan="7">TOTAL</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ $totalFinishDay > 0 ? $totalFinishDay : '' }}</td>
                        <td>{{ $totalOffDay > 0 ? $totalOffDay : '' }}</td>
                        <td>{{ $totalDifferenceDay > 0 ? $totalDifferenceDay : '' }}</td>
                        @php
                            // Hitung persentase selisih terhadap total user estimate
                            $percentageDifference = ($totalUserEstimate != 0) ? (($totalUserEstimate - $totalDealNego) / $totalUserEstimate) * 100 : 0;
                        @endphp
                        <td>{{ $totalUserEstimate > 0 ? number_format($totalUserEstimate, 0, '.', '.') : '' }}</td>
                        <td>{{ $totalDealNego > 0 ? number_format($totalDealNego, 0, '.', '.') : '' }}</td>
                        <td>{{ $totalUserEstimate - $totalDealNego > 0 ? number_format($totalUserEstimate - $totalDealNego, 0, '.', '.') : '' }}</td>
                        <td>{{ $totalUserEstimate > 0 && $totalDealNego > 0 ? str_replace('.', ',', number_format($percentageDifference, 2)) . '%' : '' }}</td>
                        @php
                        // Hitung persentase selisih terhadap total user estimate
                            $percentageDifferenceTechnique = ($totalTechniqueEstimate != 0) ? (($totalTechniqueEstimate - $totalDealNego) / $totalTechniqueEstimate) * 100 : 0;
                        @endphp
                        <td>{{ $totalTechniqueEstimate > 0 ? number_format($totalTechniqueEstimate, 0, '.', '.') : '' }}</td>
                        <td>{{ $totalDealNego > 0 ? number_format($totalDealNego, 0, '.', '.') : '' }}</td>
                        <td>{{ $totalTechniqueEstimate - $totalDealNego > 0 ? number_format($totalTechniqueEstimate - $totalDealNego, 0, '.', '.') : '' }}</td>
                        <td>{{ $totalTechniqueEstimate > 0 && $totalDealNego > 0 ? str_replace('.', ',', number_format($percentageDifferenceTechnique, 2)) . '%' : '' }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                @else
                    <tr style="background-color:ghostwhite">
                        <td colspan="27"></td>
                    </tr>
                @endif
            @endforeach
            <tr style="background-color:whitesmoke; text-align:center; font-weight:bold">
                <td colspan="7">GRAND TOTAL (JANUARI-DESEMBER)</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ $grandTotalFinishDay > 0 ? $grandTotalFinishDay : '' }}</td>
                <td>{{ $grandTotalOffDay > 0 ? $grandTotalOffDay : '' }}</td>
                <td>{{ $grandTotalDifferenceDay > 0 ? $grandTotalDifferenceDay : '' }}</td>
                <td>{{ $grandTotalUserEstimate > 0 ? number_format($grandTotalUserEstimate, 0, '.', '.') : '' }}</td>
                <td>{{ $grandTotalDealNego > 0 ? number_format($grandTotalDealNego, 0, '.', '.') : '' }}</td>
                <td>{{ $grandTotalUserEstimate - $grandTotalDealNego > 0 ? number_format($grandTotalUserEstimate - $grandTotalDealNego, 0, '.', '.') : '' }}</td>
                <td>
                    @php
                        $percentageDifferenceGrand = ($grandTotalUserEstimate != 0) ? (($grandTotalUserEstimate - $grandTotalDealNego) / $grandTotalUserEstimate) * 100 : 0;
                    @endphp
                    {{ $grandTotalUserEstimate > 0 && $grandTotalDealNego > 0 ? str_replace('.', ',', number_format($percentageDifferenceGrand, 2)) . '%' : '' }}
                </td>
                <td>{{ $grandTotalTechniqueEstimate > 0 ? number_format($grandTotalTechniqueEstimate, 0, '.', '.') : '' }}</td>
                <td>{{ $grandTotalDealNego > 0 ? number_format($grandTotalDealNego, 0, '.', '.') : '' }}</td>
                <td>{{ $grandTotalTechniqueEstimate - $grandTotalDealNego > 0 ? number_format($grandTotalTechniqueEstimate - $grandTotalDealNego, 0, '.', '.') : '' }}</td>
                <td>
                    @php
                        $percentageDifferenceTechniqueGrand = ($grandTotalTechniqueEstimate != 0) ? (($grandTotalTechniqueEstimate - $grandTotalDealNego) / $grandTotalTechniqueEstimate) * 100 : 0;
                    @endphp
                    {{ $grandTotalTechniqueEstimate > 0 && $grandTotalDealNego > 0 ? str_replace('.', ',', number_format($percentageDifferenceTechniqueGrand, 2)) . '%' : '' }}
                </td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>
