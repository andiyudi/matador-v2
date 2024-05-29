<div class="peserta-rapat">
    <table width="100%">
        <thead>
            <tr>
                <th rowspan="2" width="3%" style="text-align: center">No</th>
                <th rowspan="2" width="17%" style="text-align: center">Nilai Pekerjaan</th>
                @php
                    $selectedStartMonth = isset($start_month) ? intval($start_month) : null;
                    $selectedEndMonth = isset($end_month) ? intval($end_month) : null;
                    $colSpan = 1;

                    if ($selectedStartMonth !== null && $selectedEndMonth !== null) {
                        $colSpan = abs($selectedEndMonth - $selectedStartMonth) + 1;
                    }
                @endphp

                <th colspan="{{ $colSpan }}" style="text-align: center">Bulan</th>
                <th rowspan="2" style="text-align: center">TOTAL</th>
            </tr>
            <tr>
                @foreach ($monthsName as $monthName)
                    <th>{{ $monthName }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody style="text-align: center">
            <tr>
                <td>1</td>
                <td style="text-align: left">Nilai 0 s.d < 100 Juta</td>
                @foreach ($months as $month)
                    <td>{{ $procurementsCount[$month]['less_than_100M'] ?? 0 }}</td>
                @endforeach
                <td style="background-color: rgb(199,199,199)">{{ $totalLessThan100M }}</td>
            </tr>
            <tr>
                <td>2</td>
                <td style="text-align: left">Nilai &#8805; 100Jt s.d < 1 Miliar</td>
                @foreach ($months as $month)
                    <td>{{ $procurementsCount[$month]['between_100M_and_1B'] ?? 0 }}</td>
                @endforeach
                <td style="background-color: rgb(199,199,199)">{{ $totalBetween100MAnd1B }}</td>
            </tr>
            <tr>
                <td>3</td>
                <td style="text-align: left">Nilai &#8805; 1M</td>
                @foreach ($months as $month)
                    <td>{{ $procurementsCount[$month]['more_than_1B'] ?? 0 }}</td>
                @endforeach
                <td style="background-color: rgb(199,199,199)">{{ $totalMoreThan1B }}</td>
            </tr>
        </tbody>
        <tfoot style="text-align: center; font-weight: bold">
            <tr>
                <td colspan="2">GRAND TOTAL</td>
                @foreach ($months as $month)
                    @php
                        $monthTotal = ($procurementsCount[$month]['less_than_100M'] ?? 0) + ($procurementsCount[$month]['between_100M_and_1B'] ?? 0) + ($procurementsCount[$month]['more_than_1B'] ?? 0);
                    @endphp
                    <td>{{ $monthTotal }}</td>
                @endforeach
                @php
                    $total = ($totalLessThan100M ?? 0) + ($totalBetween100MAnd1B ?? 0) + ($totalMoreThan1B ?? 0);
                @endphp
                <td style="background-color: rgb(199,199,199)">{{ $total }}</td>
            </tr>
        </tfoot>
    </table>
</div>
