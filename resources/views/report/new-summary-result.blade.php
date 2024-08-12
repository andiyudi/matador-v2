<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Rekap Vendor Baru</title>
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
    <p style="text-align: center; font-size: 16pt">Rekapitulasi Daftar Penyedia Jasa / Vendor Baru<br>PT. Citra Marga Nusaphala Persada, Tbk<br>Periode : {{ $formattedStartDateJoin }} - {{ $formattedEndDateJoin }}</p>
    <div class="peserta-rapat">
        <table width="100%">
            <thead>
                <tr style="text-align: center">
                    <th rowspan="2" style="vertical-align: middle;">No</th>
                    <th rowspan="2" style="vertical-align: middle;">Nama Bulan</th>
                    <th rowspan="2" style="vertical-align: middle;">Jumlah Vendor Baru</th>
                    <th colspan="2">Keterangan Vendor Baru</th>
                    <th rowspan="2" style="vertical-align: middle;">Keterangan Grade Vendor Baru</th>
                </tr>
                <tr>
                    <th>Core Business</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                    $totalVendorsSum = 0; // Inisialisasi variabel untuk menjumlahkan total_vendors
                @endphp
                @foreach($allMonths as $monthYear => $data)
                    @php
                        $rowSpan = max(count($data['core_businesses']), 1); // Tentukan berapa banyak core businesses untuk rowspan
                        $totalVendorsSum += $data['total_vendors']; // Tambahkan nilai total_vendors ke total sum
                    @endphp
                    @foreach($data['core_businesses'] as $coreBusiness => $coreBusinessData)
                        <tr style="text-align: center;">
                            @if ($loop->first) <!-- Tampilkan hanya di baris pertama -->
                                <td rowspan="{{ $rowSpan }}" style="vertical-align: middle;">{{ $no++ }}</td>
                                <td rowspan="{{ $rowSpan }}" style="vertical-align: middle;">{{ \Carbon\Carbon::parse($monthYear)->locale('id')->translatedFormat('F') }}</td>
                                <td rowspan="{{ $rowSpan }}" style="vertical-align: middle;">{{ $data['total_vendors'] }}</td>
                            @endif
                            <td style="text-align: left; vertical-align: middle;">{{ $coreBusiness }}</td>
                            <td style="vertical-align: middle;">{{ $coreBusinessData['count'] }}</td>
                            <td style="text-align: left; vertical-align: middle;">
                                @foreach($coreBusinessData['grades'] as $grade => $gradeCount)
                                    @if ($gradeCount > 0)
                                        @php
                                            $gradeLabel = $grade === 0 ? 'Kecil' : ($grade === 1 ? 'Menengah' : 'Besar');
                                        @endphp
                                        <div>{{ $gradeLabel }}: {{ $gradeCount }} <br></div>
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                    @if (empty($data['core_businesses']))
                        <tr style="text-align: center;">
                            <td>{{ $no++ }}</td>
                            <td rowspan="{{ $rowSpan }}" style="vertical-align: middle;">{{ \Carbon\Carbon::parse($monthYear)->locale('id')->translatedFormat('F') }}</td>
                            <td>{{ $data['total_vendors'] }}</td>
                            <td style="text-align: left;">-</td>
                            <td>0</td>
                            <td style="text-align: left;">-</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
            <tfoot>
                <tr style="text-align: center">
                    <td colspan="4" style="font-weight:bold">Jumlah Vendor Baru Periode : {{ $formattedStartDateJoin }} - {{ $formattedEndDateJoin }}</td>
                    <td><strong>{{ $totalVendorsSum }}</strong></td>
                    <td></td>
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
                <td style="text-align: center">{{ $creatorNameJoin }}<br>{{ $creatorPositionJoin }}</td>
                <td style="text-align: center">{{ $supervisorNameJoin }}<br>{{ $supervisorPositionJoin }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
