<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Calon Usulan Vendor</title>
</head>
<body>
<style>
    body {
        font-family: 'Arial Narrow', sans-serif; /* Arial Narrow */
        font-size:12pt; /* Ukuran huruf 12px */
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
<p style="text-align: center; font-size: 14pt">FORMULIR<br>USULAN CALON PENYEDIA JASA / VENDOR</p>
<div class="peserta-rapat">
    <table width="100%">
        <tbody>
            <tr style="height:30pt">
                <td style="vertical-align: top; width: 24%;">Nama Pekerjaan</td>
                <td style="vertical-align: top; width: 1%;">:</td>
                <td>{{ $tender->procurement->name }}</td>
            </tr>
            <tr style="height:15pt">
                <td style="width: 24%;">No. PP</td>
                <td style="width: 1%">:</td>
                <td>{{ $tender->procurement->number }}</td>
            </tr>
            <tr style="height:15pt">
                <td style="width: 24%;">Waktu Pekerjaan</td>
                <td style="width: 1%">:</td>
                <td>{{ $tender->procurement->estimation }}</td>
            </tr>
            <tr style="height:15pt">
                <td style="width: 24%;">Pengguna Barang / Jasa</td>
                <td style="width: 1%">:</td>
                <td>{{ $tender->procurement->division->name }}</td>
            </tr>
            <tr style="height:15pt">
                <td style="width: 24%;">P.I.C</td>
                <td style="width: 1%">:</td>
                <td>{{ $tender->procurement->pic_user }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table width="100%">
        <thead>
            <tr>
                <th colspan="6">Kualifikasi Calon Penyedia Jasa / Vendor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Nama Calon Penyedia Jasa / Vendor</th>
                <th colspan="4">Keterangan</th>
            </tr>
            <tr>
                <th>Status</th>
                <th>PIC</th>
                <th>No. Telp.</th>
                <th>Email</th>
            </tr>
            @foreach ($tender->businessPartners as $vendorPivot)
            @php
                $vendor = $vendorPivot->partner;
            @endphp
            <tr>
                <td style="text-align: center; width: 1%;">{{ $loop->iteration }}.</td>
                <td style="width: 24%;">{{ $vendor->name }}</td>
                <td style="width: 6%;">
                @if($vendor->status == '0')
                    Registered
                @elseif($vendor->status == '1')
                    Active
                @elseif($vendor->status == '2')
                    Inactive
                @else
                    Unknown
                @endif
                </td>
                <td style="width: 23%;">{{ $vendor->director }}</td>
                <td style="width: 23%;">{{ $vendor->phone }}</td>
                <td style="width: 23%;">{{ $vendor->email }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<table width="100%">
    <thead>
        <tr>
            <td style="text-align: center; width: 50%">Jakarta, {{ date('d-m-Y') }}<br>Penyusun Laporan</td>
            <td style="text-align: center; width: 50%"><br>Menyetujui</td>
        </tr>
    </thead>
    <tbody>
        <tr style="height:2cm;">
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="text-align: center">{{ ucwords(strtolower($creatorName)) }}<br>{{ $creatorPosition }}</td>
            <td style="text-align: center">{{ $supervisorName }}<br>{{ $supervisorPosition }}</td>
        </tr>
    </tbody>
</table>
</body>
</html>
