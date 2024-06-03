<div class="peserta-rapat">
    @php
        use Carbon\Carbon;

        // Convert start_month and end_month to integer
        $selectedStartMonth = isset($start_month) ? intval($start_month) : 1;
        $selectedEndMonth = isset($end_month) ? intval($end_month) : 12;

        // Generate the range of months
        $monthsRange = range($selectedStartMonth, $selectedEndMonth);

        // Generate month names for the selected range
        $filteredMonthsName = [];
        foreach ($monthsRange as $month) {
            $filteredMonthsName[$month] = Carbon::create($year, $month)->translatedFormat('F'); // Full month name in Indonesian
        }

        // Calculate totals
        $totalUserEstimate = 0;
        $totalDealNego = 0;
        $totalUserEstimateDiff = 0;
        $totalTechniqueEstimate = 0;
        $totalTechniqueEstimateDiff = 0;
    @endphp

    <table width="100%">
        <thead>
            <tr>
                <th width="3%" rowspan="2">No</th>
                <th rowspan="2">BULAN</th>
                <th colspan="4">PERBANDINGAN</th>
                <th colspan="4">PERBANDINGAN</th>
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
        <tbody style="text-align: center">
            @foreach ($monthsRange as $month)
                @php
                    $userEstimate = $userEstimates[$month] ?? 0;
                    $techniqueEstimate = $techniqueEstimates[$month] ?? 0;
                    $dealNego = $dealNegos[$month] ?? 0;
                    $userEstimateDiff = $userEstimateDiffs[$month] ?? 0;
                    $techniqueEstimateDiff = $techniqueEstimateDiffs[$month] ?? 0;
                    $userEstimatePercentage = $userEstimatePercentages[$month] ?? 0;
                    $techniqueEstimatePercentage = $techniqueEstimatePercentages[$month] ?? 0;

                    // Calculate totals
                    $totalUserEstimate += $userEstimate;
                    $totalDealNego += $dealNego;
                    $totalUserEstimateDiff += $userEstimateDiff;
                    $totalTechniqueEstimate += $techniqueEstimate;
                    $totalTechniqueEstimateDiff += $techniqueEstimateDiff;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ strtoupper($filteredMonthsName[$month] ?? 'Undefined') }}</td>
                    <td style="text-align: right">{{ number_format($userEstimate, 0, ',', '.') }}</td>
                    <td style="text-align: right">{{ number_format($dealNego, 0, ',', '.') }}</td>
                    <td style="text-align: right">{{ number_format($userEstimateDiff, 0, ',', '.') }}</td>
                    <td>{{ number_format($userEstimatePercentage, 2, ',', '.') }}%</td>
                    <td style="text-align: right">{{ number_format($techniqueEstimate, 0, ',', '.') }}</td>
                    <td style="text-align: right">{{ number_format($dealNego, 0, ',', '.') }}</td>
                    <td style="text-align: right">{{ number_format($techniqueEstimateDiff, 0, ',', '.') }}</td>
                    <td>{{ number_format($techniqueEstimatePercentage, 2, ',', '.') }}%</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot style="text-align: center; font-weight: bold">
            @php
                // Calculate total percentages
                $totalUserEstimatePercentage = $totalUserEstimate != 0 ? ($totalUserEstimateDiff / $totalUserEstimate) * 100 : 0;
                $totalTechniqueEstimatePercentage = $totalTechniqueEstimate != 0 ? ($totalTechniqueEstimateDiff / $totalTechniqueEstimate) * 100 : 0;
            @endphp
            <tr>
                <td colspan="2">TOTAL</td>
                <td style="text-align: right">{{ number_format($totalUserEstimate, 0, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($totalDealNego, 0, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($totalUserEstimateDiff, 0, ',', '.') }}</td>
                <td>{{ number_format($totalUserEstimatePercentage, 2, ',', '.') }}%</td>
                <td style="text-align: right">{{ number_format($totalTechniqueEstimate, 0, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($totalDealNego, 0, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($totalTechniqueEstimateDiff, 0, ',', '.') }}</td>
                <td>{{ number_format($totalTechniqueEstimatePercentage, 2, ',', '.') }}%</td>
            </tr>
        </tfoot>
    </table>
    <br>
</div>
