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
            margin-top: 2.5cm; /* Atur jarak margin atas sesuai kebutuhan */
        }
        body {
            font-family: 'Tahoma', sans-serif; /* Arial Narrow */
            font-size: 10pt; /* Ukuran huruf 12px */
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
    <p style="font-size: 12pt;">
        BERITA ACARA<br>
        PENINJAUAN LAPANGAN<br>
        {{ $tender->procurement->name }}
    </p>
</center>
<p style="text-align: justify; margin-bottom: 3px">Setelah diadakan pembukaan umum dan penjelasan teknis {{ ucwords(strtolower($tender->procurement->name)) }}, yang dilaksanakan oleh Panitia Pengadaan dan Kewajaran Harga PT. Citra Marga Nusaphala Persada, Tbk yang dihadiri oleh {{ $jumlahVendor }} &#40;{{ $terbilangVendor }}&#41; calon vendor, yaitu :</p>
@foreach ($tender->businessPartners as $businessPartner)
&emsp;{{ $loop->iteration }}.{{ ucwords(strtolower($businessPartner->partner->name)) }}<br>
@endforeach
<p style="text-align: justify; margin-top: 3px">pada hari {{ $day }}, tanggal {{ ucwords($tanggal) }}, bulan {{ $bulan }}, tahun {{ ucwords($tahun) }} &#40;{{ $formattedDate }}&#41; maka untuk lebih jelasnya mengenai hal-hal yang berhubungan dengan pekerjaan yang akan dilaksanakan oleh calon peserta lelang {{ ucwords(strtolower($tender->procurement->name)) }}, diperlukan peninjauan lapangan secara bersama-sama, antara calon peserta dan Panitia Pengadaan & Kewajaran Harga.</p>
<p style="text-align: justify; margin-top: -10px">Untuk itu perlu adanya Berita Acara Peninjauan Lapangan pekerjaan dimaksud, yang tujuannya agar calon peserta mengerti dan memahami situasi dan kondisi lapangan yang akan dikerjakan.</p>
<p style="text-align: justify; margin-top: -10px">Bahwa calon peserta telah melaksanakan peninjauan lapangan secara bersama-sama dan telah mengerti serta memahami situasi maupun kondisi lapangan yang akan dikerjakan.</p>
<p style="text-align: justify; margin-top: -10px">Demikianlah Berita Acara ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>
<p style="text-align: right; margin-bottom: 2px">Jakarta, {{ $tgl }} {{ $bulan }} {{ $thn }}</p>
<div class="peserta-rapat">
    <table width="100%">
        <thead>
            <th width="3%">No</th>
            <th width="37%">CALON PEMASOK</th>
            <th width="40%">NAMA</th>
            <th width="20%">TANDA TANGAN</th>
        </thead>
        <tbody>
            @foreach ($tender->businessPartners as $businessPartner)
            <tr style="height:1.5cm">
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
        Panitia Pengadaan Dan Kewajaran Harga<br>
        {{ ucwords(strtolower($tender->procurement->name)) }}<br>
</center>
<br>
<table width="100%">
    <thead>
        <td align="center">{{ ucwords(strtolower($leadTinjauPosition)) }} PPKH,</td>
        <td align="center">Sekretaris,</td>
    </thead>
    <tbody>
        <tr style="height:2cm;">
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td align="center">{{ ucwords(strtolower($leadTinjauName)) }}</td>
            <td align="center">{{ ucwords(strtolower($secretaryTinjauName)) }}</td>
        </tr>
    </tbody>
</table>
</body>
</html>
