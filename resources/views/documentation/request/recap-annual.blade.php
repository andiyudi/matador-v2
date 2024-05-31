
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Annual Recapitulation by Division</title>
</head>
<body>
    <style>
        @media print{
            @page {
                size: A4 portrait;
            }
        }
        body {
            font-family: 'Arial Narrow', sans-serif; /* Arial Narrow */
            font-size:14pt; /* Ukuran huruf 10px */
        }
        .peserta-rapat table {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
            word-wrap: break-word;
        }
        .peserta-rapat th {
            background-color: rgb(199, 199, 199);
            border: 1px solid black;
            padding: 8px;
            vertical-align: middle;
        } .peserta-rapat td {
            border: 1px solid black;
            padding: 8px;
            vertical-align: middle;
        }
        .peserta-rapat thead tr:last-child {
            border-bottom: 3px double black; /* Adjust border thickness and color as needed */
        }
        .row {
            display: flex;
            justify-content: space-between;
        }
        .col-md-4 {
            width: 48%; /* Sesuaikan lebar div dengan tabel di dalamnya */
        }
        .col-md-8 {
            width: 69%; /* Sesuaikan lebar div dengan tabel di dalamnya */
        }
        .blue-column, .black-column {
            width: 15%; /* Menyesuaikan lebar kolom dengan kolom No pada peserta rapat */
        }
        .total-column {
            background-color:deepskyblue;
        }
        .document-pic table {
            border-collapse: collapse; /* Menyatukan batas seluruhnya */
            width: 100%;
            font-size:8pt;
        }
        .document-pic th,
        .document-pic td {
            border: 1px solid black; /* Batas individual */
            padding: 3px;
            vertical-align: middle;
            text-align: center;
        }
    </style>
<table>
    <thead>
        <tr>
            <td><img src={{ url('assets/logo/cmnplogo.png') }} alt="Logo" style="max-width: 100px; max-height: 50px;"></td>
            <td>PT. CITRA MARGA NUSAPHALA PERSADA Tbk.<br>Divisi Umum - Departemen Pengadaan</td>
        </tr>
    </thead>
</table>
<p style="text-align: center; font-size: 14pt">
    REKAPITULASI DOKUMEN PERMINTAAN PEKERJAAN (PP) MASUK<br>
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

        $selectedStartMonth = isset($start_month) ? $bulan[$start_month] : null;
        $selectedEndMonth = isset($end_month) ? $bulan[$end_month] : null;
    @endphp
    PERIODE: {{ $selectedStartMonth }} - {{ $selectedEndMonth }} {{ $year }}
</p>


@include('documentation.request.annual-result')
<table width="100%">
    <thead>
        <tr>
            <td style="text-align: center; width: 25%">Jakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br><br>Dibuat Oleh,</td>
            <td style="width: 50%"></td>
            <td style="text-align: center; width: 25%"><br><br>Disetujui Oleh,</td>
        </tr>
    </thead>
    <tbody>
        <tr style="height:2cm;">
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="text-align: center">{{ $nameStaf }}<br>{{ $positionStaf }}</td>
            <td></td>
            <td style="text-align: center">{{ $nameManager }}<br>{{ $positionManager }}</td>
        </tr>
    </tbody>
</table>
</body>
</html>
