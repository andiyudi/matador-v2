<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Rekap PP Masih Dalam Proses Negosiasi</title>
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
            background-color:rgb(20, 55, 85);
            color : white;
            border: 1px solid black;
            padding: 8px;
            vertical-align: middle;
        } .peserta-rapat td {
            border: 1px solid black;
            padding: 8px;
            vertical-align: middle;
        }
        .peserta-rapat tbody tr:last-child {
            border-top: 3px double black; /* Adjust border thickness and color as needed */
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
                <td><img src="{{ $logoBase64 }}" alt="Logo" style="max-width: 100px; max-height: 50px;"></td>
                <td>PT. CITRA MARGA NUSAPHALA PERSADA Tbk.<br>Divisi Umum - Departemen Pengadaan</td>
            </tr>
        </thead>
    </table>
    <p style="text-align: center; font-size: 14pt">
        REKAPITULASI PP MASIH DALAM PROSES NEGOSIASI<br>
        PERIODE {{ strtoupper($formattedStartDate) }} - {{ strtoupper($formattedEndDate) }}<br>
        UPDATE : {{ strtoupper($formattedDate) }}
    </p>
    <div class="peserta-rapat">
        <table width="100%">
            <thead>
                <tr>
                    <th rowspan="2" style="text-align: center; width: 2%">No</th>
                    <th rowspan="2" style="text-align: center; width: 8%">TTPP</th>
                    <th rowspan="2" style="text-align: center; width: 5%">No PP</th>
                    <th rowspan="2" style="text-align: center; width: 20%">Nama Pekerjaan</th>
                    <th rowspan="2" style="text-align: center; width: 4%">Divisi</th>
                    <th rowspan="2" style="text-align: center; width: 7%">PIC Pengadaan</th>
                    <th rowspan="2" style="text-align: center; width: 8%">Mitra Kerja / Vendor</th>
                    <th colspan="3" style="text-align: center; width: 30%">Perbandingan Nilai PP</th>
                    <th rowspan="2" style="text-align: center; width: 8%">Tgl Memo Ke Direksi</th>
                    <th rowspan="2" style="text-align: center; width: 8%">Keterangan</th>
                </tr>
                <tr>
                    <th>EE User</th>
                    <th>EE Teknik</th>
                    <th>Hasil Negosiasi</th>
                </tr>
            </thead>
            <tbody>
                @if(count($procurements) > 0)
                @foreach($procurements as $procurement)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                    <td>{{ $procurement->number }}</td>
                    <td>{{ $procurement->name }}</td>
                    <td>{{ $procurement->division->code }}</td>
                    <td>{{ $procurement->official->initials }}</td>
                    <td>{{ $procurement->is_selected }}</td>
                    <td>Rp. {{ $procurement->user_estimate ? number_format($procurement->user_estimate, 0, ',', '.') : '0' }},-</td>
                    <td>Rp. {{ $procurement->technique_estimate ? number_format($procurement->technique_estimate, 0, ',', '.') : '0' }},-</td>
                    <td>Rp. {{ $procurement->deal_nego ? number_format($procurement->deal_nego, 0, ',', '.') : '0' }},-</td>
                    <td>{{ $procurement->latest_report_nego_result ? date('d-M-Y', strtotime($procurement->latest_report_nego_result)) : '' }}</td>
                    <td>{{ $procurement->information }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="5"><strong>GRAND TOTAL</strong></td>
                    <td colspan="7"><strong>{{ count($procurements) }} DOKUMEN</strong></td>
                </tr>
                @else
                <tr>
                    <td colspan="12" style="text-align: center;"><h3>Data tidak ditemukan</h3></td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <table class="document-position" style="width: 48%;">
                <tr>
                    <td class="blue-column" style="background: blue"></td>
                    <td><strong>Dokumen di Direksi</strong></td>
                    <td><strong>:&nbsp;&nbsp;</strong></td>
                    <td><strong>{{ $dealNegos }}</strong></td>
                </tr>
                <tr>
                    <td class="black-column" style="background: black"></td>
                    <td><strong>Dokumen di Pengadaan</strong></td>
                    <td><strong>:&nbsp;&nbsp;</strong></td>
                    <td><strong>{{ $emptyDealNegos }}</strong></td>
                </tr>
            </table>
        </div>
        <div class="col-md-8">
            <div class="document-pic">
                <table style="width: 20%;">
                @php
                    $totalDocuments = 0;
                @endphp
                @foreach($documentsPic as $officialId => $count)
                    <tr>
                        <td style="width: 50%"><strong>{{ $officialId }}</strong></td>
                        <td style="width: 50%"><strong>{{ $count }}</strong></td>
                    </tr>
                @php
                    $totalDocuments += $count;
                @endphp
                @endforeach
                <tr class="total-column">
                    <td><strong>TOTAL</strong></td>
                    <td><strong>{{ $totalDocuments }}</strong></td>
                </tr>
                </table>
            </div>
        </div>
    </div>
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
                <td style="text-align: center">{{ $stafName }}<br>{{ $stafPosition }}</td>
                <td style="text-align: center">{{ $managerName }}<br>{{ $managerPosition }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
