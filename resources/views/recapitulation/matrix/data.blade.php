<!DOCTYPE html>
<html lang="id">
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
        MATRIK PERBANDINGAN<br>
        NILAI PP VS HASIL NEGOSIASI - NILAI VERIFIKASI TEKNIK VS HASIL NEGOSIASI<br>
        PERIODE JANUARI - DESEMBER {{ $year }}
    </p>
    <div class="peserta-rapat">
        <table width="100%">
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">TTPP</th>
                    <th rowspan="2">No PP</th>
                    <th rowspan="2">No OP</th>
                    <th rowspan="2">No Kontrak</th>
                    <th rowspan="2">Tgl Kontrak / OP</th>
                    <th rowspan="2">Nama Pekerjaan</th>
                    <th rowspan="2">Divisi</th>
                    <th rowspan="2">PIC Pengadaan</th>
                    <th rowspan="2">Mitra Kerja / Vendor</th>
                    <th colspan="2">Laporan Hasil Nego ke Direksi</th>
                    <th rowspan="2">Tgl Persetujuan Direksi</th>
                    <th colspan="4">Jumlah Hari</th>
                    <th colspan="4">Perbandingan</th>
                    <th colspan="4">Perbandingan</th>
                    <th rowspan="2">Jangka Waktu Pekerjaan</th>
                    <th rowspan="2">Keterangan</th>
                </tr>
                <tr>
                    <th>I</th>
                    <th>II</th>
                    <th>Target (A)</th>
                    <th>Selesai (B)</th>
                    <th>Libur (C)</th>
                    <th>Selisih (A-B+C)</th>
                    <th>EE User</th>
                    <th>Hasil Negosiasi</th>
                    <th>Selisih</th>
                    <th>%</th>
                    <th>EE Teknik</th>
                    <th>Hasil Negosiasi</th>
                    <th>Selisih</th>
                    <th>%</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($months as $index => $month)
                    <tr>
                        <td colspan="27" style="background-color: yellow;"><strong>{{ $monthsName[$index] }}</strong></td>
                    </tr>
                    @if(isset($procurementsByMonth[$month]) && count($procurementsByMonth[$month]) > 0)
                        @foreach ($procurementsByMonth[$month] as $index => $procurement)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ Carbon\Carbon::parse($procurement->receipt)->format('d-M-y') }}</td>
                                <td>{{ $procurement->number }}</td>
                                <td>{{ $procurement->op_number }}</td>
                                <td>{{ $procurement->contract_number }}</td>
                                <td>{{ $procurement->contract_date }}</td>
                                <td>{{ $procurement->name }}</td>
                                <td>{{ $procurement->division->code }}</td>
                                <td>{{ $procurement->official->initials }}</td>
                                <td>{{ $isSelectedArrayByMonth[$month][$procurement->id]['selected_partner'] }}</td>
                                @if (count($isSelectedArrayByMonth[$month][$procurement->id]['report_nego_results']) > 0)
                                    @foreach ($isSelectedArrayByMonth[$month][$procurement->id]['report_nego_results'] as $report)
                                        <td>{{ $report }}</td>
                                    @endforeach
                                @else
                                    <td></td> <!-- Kolom kosong untuk report nego result pertama -->
                                    <td></td> <!-- Kolom kosong untuk report nego result kedua -->
                                @endif
                                <td>{{ $procurement->director_approval }}</td>
                                <td>{{ $procurement->target_day }}</td>
                                <td>{{ $procurement->finish_day }}</td>
                                <td>{{ $procurement->off_day }}</td>
                                <td>{{ $procurement->difference_day }}</td>
                                <td>{{ $procurement->user_estimate }}</td>
                                <td>{{ $procurement->deal_nego }}</td>
                                <td>{{ $procurement->user_estimate-$procurement->deal_nego }}</td>
                                <td>{{ $procurement->user_percentage }}%</td>
                                <td>{{ $procurement->technique_estimate }}</td>
                                <td>{{ $procurement->deal_nego }}</td>
                                <td>{{ $procurement->technique_estimate-$procurement->deal_nego }}</td>
                                <td>{{ $procurement->technique_percentage }}%</td>
                                <td>{{ $procurement->estimation }}</td>
                                <td>{{ $procurement->information }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="27">Data tidak ditemukan</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">

        </div>
        <div class="col-md-8">
            <div class="document-pic">
                <table style="width: 20%;">

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
                <td style="text-align: center"><br></td>
                <td style="text-align: center"><br></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
