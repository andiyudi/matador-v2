<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aanwijzing</title>
    <style>
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
        RAPAT PENJELASAN TEKNIS<br>
        {{ strtoupper($tender->procurement->name) }}<br>
        <br>
    </h3>
    <p>
        NOMOR : {{ $number }}<br>
        <hr>
    </p>
</center>
<p style="line-height: 2">Pada hari ini {{ $day }} tanggal {{ ucwords($tanggal) }} bulan {{ $bulan }} tahun {{ ucwords($tahun) }} &#40;{{ $formattedDate }}&#41; telah diadakan rapat Penjelasan Teknis &#40;<i>Aanwijzing</i>&#41;, bertempat di ruang rapat PT CMNP Tbk, Jalan Yos Sudarso Kav.28 Sunter Jakarta Utara, untuk :</p>
<table width="100%">
    <tr style="line-height: 2">
        <td width="38%" style="vertical-align: text-top">A. <strong>Nama Pekerjaan</strong></td>
        <td width="2%" style="vertical-align: text-top">:</td>
        <td width="60%">{{ ucwords($tender->procurement->name) }}</td>
    </tr>
    <tr style="line-height: 2">
        <td width="38%">B. <strong>Lokasi Pekerjaan</strong></td>
        <td width="2%">:</td>
        <td width="60%">{{ ucwords($location) }}</td>
    </tr>
    <tr style="line-height: 2">
        <td width="38%">C. <strong>Peserta Rapat</strong></td>
    </tr>
    <tr style="line-height: 2">
        <td width="38%" style="vertical-align: text-top">&nbsp;&nbsp;&nbsp;&nbsp;1. Pemimpin Rapat</td>
        <td width="2%" style="vertical-align: text-top">:</td>
        <td width="60%">{{ $tender->procurement->official->name }} sebagai Ketua Panitia Pengadaan dan Kewajaran Harga {{ ucwords($tender->procurement->name) }}.</td>
    </tr>
    <tr style="line-height: 2">
        <td width="38%">&nbsp;&nbsp;&nbsp;&nbsp;2. Sekretaris</td>
        <td width="2%">:</td>
        <td width="60%">{{ $secretaryAanwijzingName }}</td>
    </tr>
    <tr style="line-height: 2">
        <td width="38%">&nbsp;&nbsp;&nbsp;&nbsp;3. Anggota Panitia</td>
        <td width="2%">:</td>
        <td width="60%">&#40;Daftar hadir terlampir&#41;</td>
    </tr>
    <tr style="line-height: 2">
        <td width="38%">&nbsp;&nbsp;&nbsp;&nbsp;4. Calon Kontraktor</td>
        <td width="2%">:</td>
        <td width="60%">&#40;Daftar hadir terlampir&#41;</td>
    </tr>
</table>
<table width="100%">
    <tr style="line-height: 2">
        <td width="100%">D. <strong>Penjelasan Rencana Kerja Dan Syarat &#40;RKS&#41;</strong></td>
    </tr>
</table>
<table width="100%">
    <tr style="line-height: 2">
        <td width="38%">&nbsp;&nbsp;&nbsp;&nbsp;1. Penjelasan Teknis Oleh</td>
        <td width="2%">:</td>
        <td width="60%">{{ $tender->procurement->pic_user }}</td>
    </tr>
    <tr style="line-height: 2">
        <td>E. <strong>Lampiran</strong></td>
    </tr>
    <tr style="line-height: 2">
        <td width="38%">&nbsp;&nbsp;&nbsp;&nbsp;Risalah Rapat Penjelasan Teknis</td>
    </tr>
</table>
<div style="page-break-after:always;"></div>
<div class="page-break-before"></div>
<center>
    <h3>
        PESERTA RAPAT PENJELASAN TEKNIS<br>
        {{ strtoupper($tender->procurement->name) }}<br>
        <br>
    </h3>
</center>
<div class="peserta-rapat">
    <table width="100%">
        <thead>
            <th>No</th>
            <th>PERUSAHAAN</th>
            <th>NAMA</th>
            <th>TANDA TANGAN</th>
        </thead>
        <tbody>
            @foreach ($tender->businessPartners as $businessPartner)
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}.</td>
                <td>{{ $businessPartner->partner->name }}</td>
                <td>
                </td>
                <td>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<br>
<center>
    <h3>
        PANITIA PENGADAAN DAN KEWAJARAN HARGA<br>
        {{ strtoupper($tender->procurement->name) }}<br>
        <br>
    </h3>
</center>
</body>
</html>
