<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jadwal Lelang</title>
</head>
<body>
    <style type="text/css">
        .tg  {border-collapse:collapse;border-spacing:0;}
        .tg td{border-color:black;border-style:solid;border-width:1px;font-family:"Times New Roman", Times, serif;font-size:14px;
            overflow:hidden;padding:10px 5px;word-break:normal;}
        .tg th{border-color:black;border-style:solid;border-width:1px;font-family:"Times New Roman", Times, serif;font-size:14px;
            font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
        .tg .tg-oe15{background-color:#ffffff;border-color:#ffffff;text-align:left;vertical-align:top}
        .tg .tg-eqkh{border-color:#ffffff;font-family:"Times New Roman", Times, serif !important;font-size:14px;text-align:center;
                vertical-align:top}
        .tg .tg-cjdc{background-color:#ffffff;border-color:#ffffff;font-family:"Times New Roman", Times, serif !important;font-size:14px;
            text-align:left;vertical-align:top}
        .tg .tg-4zsn{border-color:black;font-family:"Times New Roman", Times, serif !important;font-size:14px;text-align:left;
                vertical-align:top}
        .tg .tg-ylov{border-color:#000000;font-family:"Times New Roman", Times, serif !important;font-size:14px;text-align:left;
            vertical-align:top}
        .tg .tg-vnnk{font-family:"Times New Roman", Times, serif !important;font-size:14px;text-align:center;vertical-align:top}

        .tg .tg-baqh{text-align:center;vertical-align:top}

        .tg .tg-1xb4{font-family:"Times New Roman", Times, serif !important;font-size:14px;text-align:center;vertical-align:middle}

        .tg .tg-0lax{text-align:left;vertical-align:top}

        .tg .tg-eqkh{border-color:#ffffff;font-family:"Times New Roman", Times, serif !important;font-size:14px;text-align:center;
            vertical-align:top}

        .tg .tg-zv4m{border-color:#ffffff;text-align:left;vertical-align:top}
    </style>
    <table class="tg">
        <thead>
            <tr>
                <td class="tg-oe15"><img src="{{ $logoBase64 }}" alt="Logo" style="max-width: 100px; max-height: 50px;"></td>
                <td class="tg-cjdc">PT. CITRA MARGA NUSAPHALA PERSADA Tbk.<br>Divisi Umum - Departemen Pengadaan</td>
            </tr>
        </thead>
    </table>
    <table class="tg" width="100%">
        <thead>
            <tr>
                <td class="tg-eqkh">JADWAL LELANG<br>{{ $tender->procurement->name }}</td>
            </tr>
        </thead>
    </table>
    <table class="tg" width="100%">
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
                <td class="tg-1xb4">{{ $loop->iteration }}.</td>
                <td>{{ $schedule->activity }}</td>
                <td class="tg-1xb4">{{ $schedule->start_date }}</td>
                <td class="tg-1xb4">{{ $schedule->end_date }}</td>
                <td class="tg-1xb4">{{ $schedule->duration }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <u>Keterangan :</u><br>
    &#160;{{ $tender->note }}
    <table class="tg">
        <thead>
            @foreach ($tender->businessPartners as $businessPartner)
            <tr>
                <td class="tg-cjdc">{{ $loop->iteration }}&#46;&#41;&#32;{{ $businessPartner->partner->name }}</td>
                <td class="tg-cjdc">{{ $businessPartner->pivot->start_hour }}&#32;&#45;&#32;{{ $businessPartner->pivot->end_hour }}</td>
            </tr>
            @endforeach
        </body>
        </thead>
    </table>
    <table class="tg" width="100%">
        <thead>
            <tr>
                <th class="tg-eqkh" width="50%">Dibuat Oleh,</th>
                <th class="tg-eqkh" width="50%">Disetujui Oleh,</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="tg-zv4m"></td>
                <td class="tg-zv4m"></td>
            </tr>
            <tr>
                <td class="tg-eqkh"><u>{{ $secretaryName }}</u><br>{{ $secretaryPosition }}</td>
                <td class="tg-eqkh"><u>{{ $leadName }}</u><br>{{ $leadPosition }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
