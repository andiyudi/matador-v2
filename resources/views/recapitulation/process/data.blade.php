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
        .peserta-rapat th, .peserta-rapat td {
            border: 1px solid black;
            padding: 8px;
            vertical-align: middle;
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
</body>
</html>
