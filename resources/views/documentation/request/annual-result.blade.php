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
    @endphp

    <table width="100%">
        <thead>
            <tr>
                <th width="3%" style="text-align: center">No</th>
                <th style="text-align: center">BULAN</th>
                <th style="text-align: center">PERMINTAAN PEKERJAAN (PP) MASUK</th>
            </tr>
        </thead>
        <tbody style="text-align: center">
            @foreach ($monthsRange as $month)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ strtoupper($filteredMonthsName[$month] ?? 'Undefined') }}</td>
                    <td>{{ $totalPerBulan[$month] ?? '0' }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot style="text-align: center; font-weight: bold">
            <tr>
                <td colspan="2">GRAND TOTAL</td>
                <td>{{ $grandTotal }}</td>
            </tr>
        </tfoot>
    </table>
    <br>
</div>
