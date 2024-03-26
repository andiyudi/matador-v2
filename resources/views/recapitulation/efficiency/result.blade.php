<div class="peserta-rapat">
    <table width="100%">
        <thead>
            <tr>
                <th rowspan="2" style="text-align: center;" width="5%">No</th>
                <th rowspan="2" style="text-align: center;">Bulan</th>
                <th colspan="4" style="text-align: center;">Perbandingan</th>
            </tr>
            <tr>
                <th>Nilai PP</th>
                <th>Hasil Negosiasi</th>
                <th>Efisiensi</th>
                <th>Persentase</th>
            </tr>
        </thead>
        @php
            $total_user_estimate_all = 0;
            $total_deal_nego_all = 0;
            $total_efficiency_all = 0;
            $total_percentage_all = 0;

            foreach ($months as $index => $month) {
                $total_user_estimate_all += $procurementData[$month]->total_user_estimate ?? 0;
                $total_deal_nego_all += $procurementData[$month]->total_deal_nego ?? 0;
                $total_efficiency_all = $total_user_estimate_all - $total_deal_nego_all;
                $total_percentage_all = ($total_user_estimate_all != 0) ? ($total_efficiency_all / $total_user_estimate_all) * 100 : 0;
            }
        @endphp

        <tbody>
            @foreach($months as $index => $month)
                @php
                    $total_user_estimate = $procurementData[$month]->total_user_estimate ?? 0;
                    $total_deal_nego = $procurementData[$month]->total_deal_nego ?? 0;
                    $efficiency = $total_user_estimate - $total_deal_nego;
                    $percentage = $total_user_estimate != 0 ? ($efficiency / $total_user_estimate) * 100 : 0;
                @endphp

                <tr>
                    <td style="text-align: center">{{ $index + 1 }}</td>
                    <td style="text-align: center">{{ $monthsName[$index] }}</td>
                    <td style="text-align: right">
                        @if($total_user_estimate != 0)
                            {{ number_format($total_user_estimate, 0, '.', '.') }}
                        @endif
                    </td>
                    <td style="text-align: right">
                        @if($total_deal_nego != 0)
                            {{ number_format($total_deal_nego, 0, '.', '.') }}
                        @endif
                    </td>
                    <td style="text-align: right">
                        @if($efficiency != 0)
                            {{ number_format($efficiency, 0, '.', '.') }}
                        @endif
                    </td>
                    <td style="text-align: center">
                        @if($percentage != 0)
                            {{ str_replace('.', ',', round($percentage, 2)) }}%
                        @endif
                    </td>
                </tr>
            @endforeach

            <tr>
                <td colspan="2" style="text-align: center; font-weight: bold;">Total</td>
                <td style="text-align: right; font-weight: bold;">
                    @if($total_user_estimate_all != 0)
                        {{ number_format($total_user_estimate_all, 0, '.', '.') }}
                    @endif
                </td>
                <td style="text-align: right; font-weight: bold;">
                    @if($total_deal_nego_all != 0)
                        {{ number_format($total_deal_nego_all, 0, '.', '.') }}
                    @endif
                </td>
                <td style="text-align: right; font-weight: bold;">
                    @if($total_efficiency_all != 0)
                        {{ number_format($total_efficiency_all, 0, '.', '.') }}
                    @endif
                </td>
                <td style="text-align: center; font-weight: bold;">
                    @if($total_percentage_all != 0)
                        {{ str_replace('.', ',', round($total_percentage_all, 2)) }}%
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>
