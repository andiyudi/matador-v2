<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Berita Acara Peninjauan Lapangan</title>
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
        PENINJAUAN LAPANGAN<br>
        {{ $tender->procurement->name }}
    </h3>
</center>
<p style="line-height: 1.15">Setelah diadakan pembukaan umum dan penjelasan teknis {{ ucwords(strtolower($tender->procurement->name)) }}, yang dilaksanakan oleh Panitia Pengadaan dan Kewajaran Harga PT. Citra Marga Nusaphala Persada, Tbk yang dihadiri oleh {{ $jumlahVendor }} &#40;{{ $terbilangVendor }}&#41; calon vendor, yaitu : <br>
@foreach ($tender->businessPartners as $businessPartner)
&nbsp;&nbsp;&nbsp;&nbsp;{{ $loop->iteration }}.{{ ucwords(strtolower($businessPartner->partner->name)) }}<br>
@endforeach
Pada hari {{ $day }}, tanggal {{ ucwords($tanggal) }}, bulan {{ $bulan }}, tahun {{ ucwords($tahun) }} &#40;{{ $formattedDate }}&#41; maka untuk lebih jelasnya mengenai hal-hal yang berhubungan dengan pekerjaan yang akan dilaksanakan oleh calon peserta lelang {{ ucwords(strtolower($tender->procurement->name)) }}, diperlukan peninjauan lapangan secara bersama-sama, antara calon peserta dan Panitia Pengadaan & Kewajaran Harga.
<br>
Untuk itu perlu adanya Berita Acara Peninjauan Lapangan pekerjaan dimaksud, yang tujuannya agar calon peserta mengerti dan memahami situasi dan kondisi lapangan yang akan dikerjakan.
<br>
Bahwa calon peserta telah melaksanakan peninjauan lapangan secara bersama-sama dan telah mengerti serta memahami situasi maupun kondisi lapangan yang akan dikerjakan.
<br>Demikianlah Berita Acara ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>
<p align="right">Jakarta, {{ $tgl }} {{ $bulan }} {{ $thn }}</p>
<div class="peserta-rapat">
    <table width="100%">
        <thead>
            <th  width="3%">No</th>
            <th  width="37%">PERUSAHAAN</th>
            <th  width="40%">NAMA</th>
            <th  width="20%">TANDA TANGAN</th>
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
        PANITIA PENGADAAN DAN KEWAJARAN HARGA<br>
        {{ strtoupper($tender->procurement->name) }}<br>
</center>
<table width="100%">
    <thead>
        <td align="center">{{ $leadTinjauPosition }} PPKH</td>
        <td align="center">SEKRETARIS</td>
    </thead>
    <tbody>
        <tr style="height:50px;">
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td align="center">{{ $leadTinjauName }}</td>
            <td align="center">{{ $secretaryTinjauName }}</td>
        </tr>
    </tbody>
</table>
</body>
</html>
