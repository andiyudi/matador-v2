<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Berita Acara Negosiasi IKP</title>
    <style>
        /* Mengatur margin atas pada setiap halaman */
        @page {
            margin-top: 3cm; /* Atur jarak margin atas sesuai kebutuhan */
        }
        body {
            font-family: 'Arial Narrow', sans-serif; /* Arial Narrow */
            font-size: 24px; /* Ukuran huruf 12px */
        }
        /* CSS untuk memberikan border pada tabel dengan kelas "peserta-rapat" */
        .peserta-rapat table {
            border-collapse: collapse;
            width: 100%;
        }
        .peserta-rapat th, .peserta-rapat td {
            border: 1px solid black;
            padding: 8px;
        }
        .page-break-before {
        page-break-before: always;
        }
    </style>
</head>
<body>
<div class="page-break-before"></div>
<center>
    <h3>
        BERITA ACARA<br>
        PEMBUKAAN DOKUMEN SAMPUL A, B &#40;ADMINISTRASI & TEKNIS&#41; DAN SAMPUL C &#40;PROPOSAL PENAWARAN HARGA&#41; SERTA KLARIFIKASI DAN NEGOSIASI KEWAJARAN HARGA {{ strtoupper($tender->procurement->name) }}<br>
    </h3>
    <p>
        NOMOR : {{ $banegoNumber }}
        <hr>
    </p>
</center>
<p style="line-height: 1.15">Pada hari ini {{ $day }} tanggal {{ ucwords($tanggal) }} bulan {{ $bulan }} tahun {{ ucwords($tahun) }} &#40;{{ $formattedDate }}&#41; telah diadakan rapat pembukaan proposal / penawaran harga, bertempat di ruang rapat PT CMNP Tbk, Jalan Yos Sudarso Kav.28 Sunter Jakarta Utara, untuk :</p>
<table width="100%">
    <tr style="line-height: 1.15">
        <td width="38%" style="vertical-align: text-top">A. <strong>Nama Pekerjaan</strong></td>
        <td width="2%" style="vertical-align: text-top">:</td>
        <td width="60%">{{ ucwords($tender->procurement->name) }}</td>
    </tr>
    <tr style="line-height: 1.15">
        <td width="38%">B. <strong>Lokasi Pekerjaan</strong></td>
        <td width="2%">:</td>
        <td width="60%">{{ ucwords($location) }}</td>
    </tr>
    <tr style="line-height: 1.15">
        <td width="38%">C. <strong>Peserta Rapat</strong></td>
    </tr>
    <tr style="line-height: 1.15">
        <td width="38%" style="vertical-align: text-top">&nbsp;&nbsp;&nbsp;&nbsp;1. Pemimpin Rapat</td>
        <td width="2%" style="vertical-align: text-top">:</td>
        <td width="60%">{{ $tender->procurement->official->name }} sebagai Ketua Panitia Pengadaan dan Kewajaran Harga {{ ucwords($tender->procurement->name) }}.</td>
    </tr>
    <tr style="line-height: 1.15">
        <td width="38%">&nbsp;&nbsp;&nbsp;&nbsp;2. Sekretaris</td>
        <td width="2%">:</td>
        <td width="60%">{{ $secretaryBanegoName }}</td>
    </tr>
    <tr style="line-height: 1.15">
        <td width="38%">&nbsp;&nbsp;&nbsp;&nbsp;3. Anggota Panitia</td>
        <td width="2%">:</td>
        <td width="60%">&#40;Daftar hadir terlampir&#41;</td>
    </tr>
    <tr style="line-height: 1.15">
        <td width="38%">&nbsp;&nbsp;&nbsp;&nbsp;4. Calon Kontraktor</td>
        <td width="2%">:</td>
        <td width="60%">&#40;Daftar hadir terlampir&#41;</td>
    </tr>
    <tr style="line-height: 1.15">
        <td width="38%" style="vertical-align: text-top">D. <strong>Harga Pagu Pekerjaan</strong></td>
        <td width="2%" style="vertical-align: text-top">:</td>
    </tr>
    <tr style="line-height: 1.15">
        <td width="38%" style="vertical-align: text-top">E. <strong>Keterangan</strong></td>
        <td width="2%" style="vertical-align: text-top">:</td>
    </tr>
</table>
@foreach ($tender->businessPartners as $businessPartner)
<div style="page-break-after:always;"></div>
<div class="page-break-before"></div>
<center>
    <h3>
        PESERTA RAPAT PEMBUKAAN PROPOSAL PENAWARAN HARGA<br>
        PEMBUKAAN DOKUMEN SAMPUL A, B &#40;ADMINISTRASI & TEKNIS&#41; DAN SAMPUL C &#40;PROPOSAL PENAWARAN HARGA&#41; SERTA KLARIFIKASI DAN NEGOSIASI KEWAJARAN HARGA {{ strtoupper($tender->procurement->name) }}<br>
        <br>
    </h3>
</center>
<div class="peserta-rapat">
    <table width="100%">
        <thead>
            <th  width="3%">No</th>
            <th  width="37%">PERUSAHAAN</th>
            <th  width="40%">HARGA PENAWARAN</th>
            <th  width="20%">TANDA TANGAN</th>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}.</td>
                <td>{{ $businessPartner->partner->name }}</td>
                <td>
                </td>
                <td>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<br>
<center>
    <h3>
        PANITIA PENGADAAN DAN KEWAJARAN HARGA<br>
        PEMBUKAAN DOKUMEN SAMPUL A, B &#40;ADMINISTRASI & TEKNIS&#41; DAN SAMPUL C &#40;PROPOSAL PENAWARAN HARGA&#41; SERTA KLARIFIKASI DAN NEGOSIASI KEWAJARAN HARGA {{ strtoupper($tender->procurement->name) }}<br>
        <br>
    </h3>
</center>
<table width="100%">
    <thead>
        <th>KETUA PPKH</th>
        <th>SEKRETARIS</th>
    </thead>
    <tbody>
        <tr style="height:50px;">
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td align="center"><strong>{{ $leadBanegoName }}</strong></td>
            <td align="center"><strong>{{ $secretaryBanegoName }}</strong></td>
        </tr>
    </tbody>
</table>
@endforeach
</body>
</html>
