<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Monitoring Process</title>
</head>
<body>
    <style>
        @media print{
            @page {
                size: A3 landscape;
            }
        }
        body {
            font-family: 'Arial Narrow', sans-serif; /* Arial Narrow */
            font-size:10pt; /* Ukuran huruf 10px */
        }
        .peserta-rapat table {
            border-collapse: collapse;
            width: 100%;
            /* table-layout: fixed; */
            word-wrap: break-word;
        }
        .peserta-rapat th {
            background-color:rgb(155, 165, 175);
            border: 1px solid black;
            padding: 8px;
            vertical-align: middle;
        } .peserta-rapat td {
            border: 1px solid black;
            padding: 8px;
            vertical-align: middle;
        }
    </style>
    <table>
        <thead>
            <tr>
                <td><img src={{ url('assets/logo/cmnplogo.png') }} alt="Logo" style="max-width: 100px; max-height: 50px;"></td>
                <td style="font-weight: bold">LAPORAN MONITORING PROSES PENGADAAN BARANG DAN JASA<br>DIVISI UMUM - DEPARTEMEN PENGADAAN<br>PERIODE : {{ strtoupper($monthName) }}-{{ $year }}</td>
            </tr>
        </thead>
    </table>
    <br>
    @include('monitoring.result')
    <br>
    <table width="100%">
        <thead>
            <tr>
                <td style="text-align: center; width: 25%">Jakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>Dibuat Oleh,</td>
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
                {{-- <td style="text-align: center">{{ $stafName }}<br>{{ $stafPosition }}</td> --}}
                <td></td>
                {{-- <td style="text-align: center">{{ $managerName }}<br>{{ $managerPosition }}</td> --}}
            </tr>
        </tbody>
    </table>
</body>
</html>
