<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Rekap Penilaian CMNP Terhadap Vendor</title>
</head>
<body>
    <style>
        body {
            font-family: 'Arial Narrow', sans-serif; /* Arial Narrow */
            font-size:10pt; /* Ukuran huruf 12px */
        }
        .peserta-rapat table {
            border-collapse: collapse;
            width: 100%;
        }
        .peserta-rapat th, .peserta-rapat td {
            border: 1px solid black;
            padding: 8px;
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
    <p style="text-align: center; font-size: 16pt">REKAPITULASI PENILAIAN KINERJA PENYEDIA JASA / VENDOR<br>Terhadap PT. Citra Marga Nusaphala Persada, Tbk<br>Periode Tahun {{ $periodeAwal }} - {{ $periodeAkhir }}</p>
    <div class="peserta-rapat">
        <table width="100%">
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Unit Kerja</th>
                    <th rowspan="2">Jumlah Form <br> Penilaian Yang Diserahkan</th>
                    <th colspan="2">Penilaian</th>
                </tr>
                <tr>
                    <th>Buruk <br> &#40;Tidak Layak: &le; 60&#41;</th>
                    <th>Baik <br> &#40;Dipertahankan: 61-100&#41;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($divisions as $division)
                <tr style="text-align: center">
                    <td>{{ $loop->iteration }}</td>
                    <td style="text-align: left">{{ $division->name }}</td>
                    <td>{{ $jumlahPenilaian[$division->id] }}</td>
                    <td>{{ $jumlahPenilaianBuruk[$division->id] }}</td>
                    <td>{{ $jumlahPenilaianBaik[$division->id] }}</td>
                </tr>
                @endforeach
                <tr style="text-align: center; font-weight: bold;">
                    <td colspan="2">Jumlah Total Penilaian</td>
                    <td>{{ array_sum($jumlahPenilaian) }}</td>
                    <td>{{ array_sum($jumlahPenilaianBuruk) }}</td>
                    <td>{{ array_sum($jumlahPenilaianBaik) }}</td>
                </tr>
            </tbody>
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
                <td style="text-align: center">{{ $creatorNameCompany }}<br>{{ $creatorPositionCompany }}</td>
                <td style="text-align: center">{{ $supervisorNameCompany }}<br>{{ $supervisorPositionCompany }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
