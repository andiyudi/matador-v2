<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Calon Usulan Vendor</title>
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
                <td class="tg-eqkh">FORMULIR<br>USULAN CALON PENYEDIA JASA / VENDOR</td>
            </tr>
        </thead>
    </table>
    <table class="tg" width="100%">
        <tbody>
            <tr>
                <td class="tg-ylov" width=22%>Nama Pekerjaan</td>
                <td class="tg-4zsn" width=1%>:</td>
                <td class="tg-ylov">{{ $tender->procurement->name }}</td>
            </tr>
            <tr>
                <td class="tg-ylov" width=22%>No. PP</td>
                <td class="tg-4zsn" width=1%>:</td>
                <td class="tg-ylov">{{ $tender->procurement->number }}</td>
            </tr>
            <tr>
                <td class="tg-ylov" width=22%>Waktu Pekerjaan</td>
                <td class="tg-4zsn" width=1%>:</td>
                <td class="tg-ylov">{{ $tender->procurement->estimation }}</td>
            </tr>
            <tr>
                <td class="tg-ylov" width=22%>Pengguna Barang / Jasa</td>
                <td class="tg-4zsn" width=1%>:</td>
                <td class="tg-ylov">{{ $tender->procurement->division->name }}</td>
            </tr>
            <tr>
                <td class="tg-ylov" width=22%>P.I.C</td>
                <td class="tg-4zsn" width=1%>:</td>
                <td class="tg-ylov">{{ $tender->procurement->pic_user }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="tg" width="100%">
        <thead>
            <tr>
                <th class="tg-vnnk" colspan="6">Kualifikasi Calon Penyedia Jasa / Vendor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="tg-1xb4" rowspan="2">No</td>
                <td class="tg-1xb4" rowspan="2">Nama Calon Penyedia Jasa / Vendor</td>
                <td class="tg-1xb4" colspan="4">Keterangan</td>
            </tr>
            <tr>
                <td class="tg-1xb4">Status</td>
                <td class="tg-1xb4">PIC</td>
                <td class="tg-1xb4">No. Telp.</td>
                <td class="tg-1xb4">Email</td>
            </tr>
            @foreach ($tender->businessPartners as $vendorPivot)
            @php
                $vendor = $vendorPivot->partner;
            @endphp
            <tr>
                <td class="tg-baqh">{{ $loop->iteration }}.</td>
                <td class="tg-0lax">{{ $vendor->name }}</td>
                <td class="tg-0lax">
                @if($vendor->status == 0)
                    Registered
                @elseif($vendor->status == 1)
                    Active
                @elseif($vendor->status == 2)
                    InActive
                @else
                    Unknown
                @endif
                </td>
                <td class="tg-0lax">{{ $vendor->director }}</td>
                <td class="tg-0lax">{{ $vendor->phone }}</td>
                <td class="tg-0lax">{{ $vendor->email }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <table class="tg" width="100%">
        <thead>
            <tr>
                <th class="tg-eqkh" width="50%">Jakarta, {{ date('d-m-Y') }}<br>Penyusun Laporan</th>
                <th class="tg-eqkh" width="50%"><br>Menyetujui</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="tg-zv4m"></td>
                <td class="tg-zv4m"></td>
            </tr>
            <tr>
                <td class="tg-eqkh">{{ $creatorName }}<br>{{ $creatorPosition }}</td>
                <td class="tg-eqkh">{{ $supervisorName }}<br>{{ $supervisorPosition }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
