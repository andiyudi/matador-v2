<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Rekap History Vendor Aktif</title>
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
        .peserta-rapat th, .peserta-rapat td {
            border: 1px solid black;
            padding: 8px;
            vertical-align: text-top
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
    <p style="text-align: center; font-size: 16pt">Rekapitulasi Mitra Kerja Aktif<br>PT. Citra Marga Nusaphala Persada, Tbk<br>Periode : {{ $formattedStartDate }} - {{ $formattedEndDate }}</p>
    <div class="peserta-rapat">
        <table width="100%">
            <thead>
                <tr style="text-align: center">
                    <th rowspan="2" style="vertical-align: middle;">No</th>
                    <th rowspan="2" style="vertical-align: middle;">Core Business</th>
                    <th rowspan="2" style="vertical-align: middle;">Aktif</th>
                    <th colspan="3">Kualifikasi / Grade Aktif</th>
                </tr>
                <tr>
                    <th>Besar</th>
                    <th>Menengah</th>
                    <th>Kecil</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recapitulation as $coreBusiness => $data)
                    <tr style="text-align: center">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $coreBusiness }}</td>
                        <td>{{ $data['total_aktif'] }}</td>
                        <td>{{ $data['besar'] }}</td>
                        <td>{{ $data['menengah'] }}</td>
                        <td>{{ $data['kecil'] }}</td>
                    </tr>
                    @endforeach
            </tbody>
            <tfoot>
                <tr style="text-align: center">
                    <td colspan="2" style="font-weight:bold">Jumlah Total </td>
                    <td>{{ $totals['total_aktif'] }}</td>
                    <td>{{ $totals['besar'] }}</td>
                    <td>{{ $totals['menengah'] }}</td>
                    <td>{{ $totals['kecil'] }}</td>
                </tr>
            </tfoot>
        </table>

    </div>
    <br>
    <table width="100%">
        <thead>
            <tr>
                <td style="text-align: center; width: 50%">Jakarta, {{ date('d-m-Y') }}<br>Dibuat Oleh,</td>
                <td style="text-align: center; width: 50%"><br>Disetujui Oleh,</td>
            </tr>
        </thead>
        <tbody>
            <tr style="height:2cm;">
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align: center">{{ $creatorNameHistory }}<br>{{ $creatorPositionHistory }}</td>
                <td style="text-align: center">{{ $supervisorNameHistory }}<br>{{ $supervisorPositionHistory }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
