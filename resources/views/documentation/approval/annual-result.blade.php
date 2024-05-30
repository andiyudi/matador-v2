<div class="peserta-rapat">
    @php
        use Carbon\Carbon;

        // Convert start_month and end_month to integer
        $selectedStartMonth = isset($start_month) ? intval($start_month) : 1;
        $selectedEndMonth = isset($end_month) ? intval($end_month) : 12;

        // Filter the months array based on the selected range
        $filteredMonths = array_filter($months, function($month) use ($selectedStartMonth, $selectedEndMonth) {
            return $month >= $selectedStartMonth && $month <= $selectedEndMonth;
        });

        // Generate month names for the selected range
        $filteredMonthsName = [];
        foreach ($filteredMonths as $month) {
            $filteredMonthsName[] = Carbon::create($year, $month)->translatedFormat('M'); // Full month name in Indonesian
        }

        // Calculate colspan
        $colSpan = count($filteredMonthsName);
    @endphp

    <table width="100%">
        <thead>
            <tr>
                <th rowspan="2" width="3%" style="text-align: center">No</th>
                <th rowspan="2" width="17%" style="text-align: center">Keterangan</th>
                <th colspan="{{ $colSpan }}" style="text-align: center">Bulan</th>
                <th rowspan="2" style="text-align: center">TOTAL</th>
            </tr>
            <tr>
                @foreach ($filteredMonthsName as $monthName)
                    <th>{{ $monthName }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody style="text-align: center">
            <tr>
                <td>1</td>
                <td style="text-align: left">PP Masuk All User</td>
                @foreach ($months as $month)
                    <td>{{ $totalsAll['totalPerBulan'][$month] ?? 0 }}</td>
                @endforeach
                <td style="background-color: rgb(250, 220, 220)">{{ $totalsAll['grandTotal'] }}</td>
            </tr>
            <tr>
                <td>2</td>
                <td style="text-align: left">PP Yang Disetujui Direksi</td>
                @foreach ($months as $month)
                    <td>{{ $totalsStatus1['totalPerBulan'][$month] ?? 0 }}</td>
                @endforeach
                <td style="background-color: rgb(250, 220, 220)">{{ $totalsStatus1['grandTotal'] }}</td>
            </tr>
            <tr>
                <td>3</td>
                <td style="text-align: left">PP Masih Dalam Proses Negosiasi</td>
                @foreach ($months as $month)
                    <td>{{ $totalsStatus0['totalPerBulan'][$month] ?? 0 }}</td>
                @endforeach
                <td style="background-color: rgb(250, 220, 220)">{{ $totalsStatus0['grandTotal'] }}</td>
            </tr>
            <tr>
                <td>4</td>
                <td style="text-align: left">PP Dibatalkan</td>
                @foreach ($months as $month)
                    <td>{{ $totalsStatus2['totalPerBulan'][$month] ?? 0 }}</td>
                @endforeach
                <td style="background-color: rgb(250, 220, 220)">{{ $totalsStatus2['grandTotal'] }}</td>
            </tr>
        </tbody>
    </table>
</div>
