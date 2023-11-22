<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Rekap Vendor Blacklist</title>
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
                <td><img src="{{ $logoBase64 }}" alt="Logo" style="max-width: 100px; max-height: 50px;"></td>
                <td>PT. CITRA MARGA NUSAPHALA PERSADA Tbk.<br>Divisi Umum - Departemen Pengadaan</td>
            </tr>
        </thead>
    </table>
    <p style="text-align: center; font-size: 16pt">Daftar Penyedia Jasa / Vendor Blacklist<br>PT. Citra Marga Nusaphala Persada, Tbk<br>Periode : {{ $formattedStartDateBlacklist }} - {{ $formattedEndDateBlacklist }}</p>
    <div class="peserta-rapat">
        <table width="100%">
            <thead>
                <tr>
                    <th style="width: 1%">No</th>
                    <th style="width: 9%">Tgl/Bln/Thn Bergabung</th>
                    <th style="width: 10%">Nama Perusahaan</th>
                    <th style="width: 10%">Core Business</th>
                    <th style="width: 10%">Klasifikasi</th>
                    <th style="width: 10%">Alamat Legalitas</th>
                    <th style="width: 10%">Alamat Domisili</th>
                    <th style="width: 10%">Direktur/PIC</th>
                    <th style="width: 10%">No. Telp</th>
                    <th style="width: 10%">Email</th>
                    <th style="width: 10%">Modal Perusahaan</th>
                </tr>
            </thead>
            <tbody>
                @if(count($vendors) > 0)
                @foreach($vendors as $vendor)
                <tr>
                    <td style="text-align: center; width: 1%">{{ $loop->iteration }}</td>
                    <td style="width: 9%">{{ $vendor->join_date }}</td>
                    <td style="width: 10%">{{ $vendor->name }}</td>
                    <td style="width: 10%">{!! $vendor->core_businesses !!}</td>
                    <td style="width: 10%">{!! $vendor->classifications !!}</td>
                    <td style="width: 10%">{{ $vendor->address }}</td>
                    <td style="width: 10%">{{ $vendor->domicility }}</td>
                    <td style="width: 10%">{{ $vendor->director }}</td>
                    <td style="width: 10%">{{ $vendor->phone }}</td>
                    <td style="width: 10%">{{ $vendor->email }}</td>
                    <td style="width: 10%">{{ $vendor->capital }}</td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="11" style="text-align: center;"><h3>Data tidak ditemukan</h3></td>
                </tr>
                @endif
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
                <td style="text-align: center">{{ $creatorName }}<br>{{ $creatorPosition }}</td>
                <td style="text-align: center">{{ $supervisorName }}<br>{{ $supervisorPosition }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
