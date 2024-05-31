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
                <th rowspan="2" width="17%" style="text-align: center">Nama Divisi</th>
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
            @foreach ($divisions as $division)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $division->name }}</td>
                @foreach ($months as $month)
                    <td>{{ $totalPerDivisionPerBulan[$division->id][$month] ?? 0 }}</td>
                @endforeach
                <td>{{ $totalPerDivisi[$division->id] ?? 0 }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot style="text-align: center; font-weight: bold">
            <tr>
                <td colspan="2">GRAND TOTAL</td>
                @foreach ($filteredMonths as $month)
                    <td>{{ $totalPerBulan[$month] }}</td>
                @endforeach
                <td>{{ $grandTotal }}</td>
            </tr>
        </tfoot>
    </table>
</div>
