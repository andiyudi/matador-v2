<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Efisiensi Biaya Perseroan</title>
</head>
<body>
    @include('recapitulation.efficiency.style')
    <table>
        <thead>
            <tr>
                <td><img src="{{ $logoBase64 }}" alt="Logo" style="max-width: 100px; max-height: 50px;"></td>
                <td>PT. CITRA MARGA NUSAPHALA PERSADA Tbk.<br>Divisi Umum - Departemen Pengadaan</td>
            </tr>
        </thead>
    </table>
    <p style="text-align: center; font-size: 14pt">
        LAPORAN EFISIENSI BIAYA PERSEROAN<br>
        NILAI PR VS HASIL NEGOSIASI<br>
        @php
        $bulan = [
        '01' => 'JANUARI',
        '02' => 'FEBRUARI',
        '03' => 'MARET',
        '04' => 'APRIL',
        '05' => 'MEI',
        '06' => 'JUNI',
        '07' => 'JULI',
        '08' => 'AGUSTUS',
        '09' => 'SEPTEMBER',
        '10' => 'OKTOBER',
        '11' => 'NOVEMBER',
        '12' => 'DESEMBER'
    ];

        $selectedStartMonthName = isset($start_month) ? $bulan[$start_month] : null;
        $selectedEndMonthName = isset($end_month) ? $bulan[$end_month] : null;
    @endphp
    PERIODE: {{ $selectedStartMonthName }} - {{ $selectedEndMonthName }} {{ $year }}
    </p>
    @include('recapitulation.efficiency.result')
    <br>
    <table width="100%">
        <thead>
            <tr>
                <td style="text-align: center; width: 25%">Jakarta, {{ date('d-m-Y') }}<br>Dibuat Oleh,</td>
                <td style="width: 50%"></td>
                <td style="text-align: center; width: 25%"><br>Disetujui Oleh,</td>
            </tr>
        </thead>
        <tbody>
            <tr style="height:2cm;">
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align: center">{{ $data['stafName'] }}<br>{{ $data['stafPosition'] }}</td>
                <td></td>
                <td style="text-align: center">{{ $data['managerName'] }}<br>{{ $data['managerPosition'] }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
