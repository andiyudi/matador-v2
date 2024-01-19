<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jadwal Lelang</title>
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
<p style="text-align: center; font-size: 14pt">JADWAL LELANG</p>
<p style="text-align: center; margin-top: -20px">
    {{ $tender->procurement->name }}
</p>
<div class="peserta-rapat">
    <table width="100%">
        <thead class="text-center">
            <tr>
                <th>No</th>
                <th>Aktivitas</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Akhir</th>
                <th>Durasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($schedules as $schedule)
            <tr>
                <td style="text-align: center">{{ $loop->iteration }}.</td>
                <td>{{ $schedule->activity }}</td>
                <td style="text-align: center">{{ $schedule->start_date }}</td>
                <td style="text-align: center">{{ $schedule->end_date }}</td>
                <td style="text-align: center">{{ $schedule->duration }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<br><u>Keterangan :</u><br>
    &#160;{{ $tender->note }}
<table>
    <thead>
        @foreach ($tender->businessPartners->sortBy(function($businessPartner) {
            return strtotime($businessPartner->pivot->start_hour);
        }) as $businessPartner)
        <tr>
            <td>{{ $loop->iteration }}&#46;&#41;&#32;{{ $businessPartner->partner->name }}</td>
            <td>&emsp;{{ date('H:i', strtotime($businessPartner->pivot->start_hour)) }}&#32;&#45;&#32;{{ date('H:i', strtotime($businessPartner->pivot->end_hour)) }}</td>
        </tr>
        @endforeach
    </body>
    </thead>
</table>
<br>
<table width="100%">
    <thead>
        <tr style="text-align: center">
            <td width="50%">Dibuat Oleh,</td>
            <td width="50%">Disetujui Oleh,</td>
        </tr>
    </thead>
    <tbody>
        <tr style="height:2cm;">
            <td></td>
            <td></td>
        </tr>
        <tr style="text-align: center">
            <td><u>{{ ucwords(strtolower($secretaryName)) }}</u><br>{{ ucwords(strtolower($secretaryPosition)) }} PPKH</td>
            <td><u>{{ ucwords(strtolower($leadName)) }}</u><br>{{ ucwords(strtolower($leadPosition)) }} PPKH</td>
        </tr>
    </tbody>
</table>
</body>
</html>
