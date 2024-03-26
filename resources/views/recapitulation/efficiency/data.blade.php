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
        NILAI PP VS HASIL NEGOSIASI<br>
        PERIODE JANUARI - DESEMBER {{ $year }}
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
