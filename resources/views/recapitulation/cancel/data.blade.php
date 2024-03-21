<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Rekap PP Yang Dibatalkan</title>
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
        .row {
            display: flex;
            justify-content: space-between;
        }
        .col-md-4 {
            width: 48%; /* Sesuaikan lebar div dengan tabel di dalamnya */
        }
        .col-md-8 {
            width: 67%; /* Sesuaikan lebar div dengan tabel di dalamnya */
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
        REKAPITULASI PP YANG DIBATALKAN<br>
        PERIODE JANUARI - DESEMBER {{ $year }}
    </p>
    <div class="peserta-rapat">
        <table width="100%">
            <thead>
                <tr>
                    <th rowspan="2" style="text-align: center;" width="3%">No</th>
                    <th rowspan="2" style="text-align: center;" width="7%">TTPP</th>
                    <th rowspan="2" style="text-align: center;" width="5%">No PP</th>
                    <th rowspan="2" style="text-align: center;" width="20%">Nama Pekerjaan</th>
                    <th rowspan="2" style="text-align: center;" width="3%">Divisi</th>
                    <th rowspan="2" style="text-align: center;" width="6%">PIC Pengadaan</th>
                    <th colspan="2" style="text-align: center;" width="19%">Nilai PP</th>
                    <th rowspan="2" style="text-align: center;" width="8%">Tgl Pengembalian Ke User</th>
                    <th rowspan="2" style="text-align: center;">Tgl Memo Pembatalan</th>
                    <th rowspan="2" style="text-align: center;">Keterangan</th>
                </tr>
                <tr>
                    <th>EE User</th>
                    <th>EE Teknik</th>
                </tr>
            </thead>
            <tbody>
                @forelse($procurements as $procurement)
                    <tr style="text-align: center">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                        <td>{{ $procurement->number }}</td>
                        <td style="text-align: left;">{{ $procurement->name }}</td>
                        <td>{{ $procurement->division->code }}</td>
                        <td>{{ $procurement->official->initials }}</td>
                        <td style="text-align: right;">
                            @if ($procurement->user_estimate !== null)
                                {{ number_format($procurement->user_estimate, 0, '.', '.') }}
                            @endif
                        </td>
                        <td style="text-align: right;">
                            @if ($procurement->technique_estimate !== null)
                                {{ number_format($procurement->technique_estimate, 0, '.', '.') }}
                            @endif
                        </td>
                        <td>{{ $procurement->return_to_user ? date('d-M-Y', strtotime($procurement->return_to_user)) : '' }}</td>
                        <td>{{ $procurement->cancellation_memo }}</td>
                        <td>{{ $procurement->information }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" style="text-align: center;">Data tidak ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
        </div>
        <div class="col-md-8">
            <div class="document-pic">
                <table style="width: 22%;">
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
                <td style="text-align: center">{{ $data['stafName'] }}<br>{{ $data['stafPosition'] }}</td>
                <td style="text-align: center">{{ $data['managerName'] }}<br>{{ $data['managerPosition'] }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
