
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Monthly Recapitulation by Value</title>
</head>
<body>
    <style>
        @media print{
            @page {
                size: A4 landscape;
            }
        }
        body {
            font-family: 'Arial Narrow', sans-serif; /* Arial Narrow */
            font-size:10pt; /* Ukuran huruf 10px */
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
    REKAPITULASI DOKUMEN PERMINTAAN PENGADAAN (PP)<br>
    BERDASARKAN DIVISI<br>
    PERIODE : JANUARI - DESEMBER {{ $year }}
</p>
<div class="peserta-rapat">
    <table width="100%">
        <thead>
            <tr>
                <th rowspan="2" width="3%" style="text-align: center">No</th>
                <th rowspan="2" width="17%" style="text-align: center">Nama Divisi</th>
                <th colspan="12" style="text-align: center">Bulan</th>
                <th rowspan="2" style="text-align: center">TOTAL</th>
            </tr>
            <tr>
                @foreach ($monthsName as $monthName)
                    <th>{{ $monthName }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody style="text-align: center">
            @foreach ($divisions as $division)
            <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="text-align: left">{{ $division->name }}</td>
                    @foreach($months as $month)
                        <td>{{ $procurementData[$division->id][$month] }}</td>
                    @endforeach
                    <td>{{ $totalPerDivisi[$division->id] }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot style="text-align: center; font-weight: bold">
            <tr>
                <td colspan="2">GRAND TOTAL</td>
                @foreach($months as $month)
                    <td>{{ $totalPerBulan[$month] }}</td>
                @endforeach
                <td>{{ $grandTotal }}</td>
            </tr>
        </tfoot>
    </table>
</div>

{{-- @include('documentation.division.annual-result') --}}
<table width="100%">
    <thead>
        <tr>
            <td style="text-align: center; width: 25%"><br><br>Dibuat Oleh,</td>
            <td style="width: 50%"></td>
            <td style="text-align: center; width: 25%"><br>Jakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>Disetujui Oleh,</td>
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
