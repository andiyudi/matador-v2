<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Rekap PR Masih Dalam Proses Negosiasi</title>
</head>
<body>
    @include('recapitulation.process.style')
    <table>
        <thead>
            <tr>
                <td><img src="{{ $logoBase64 }}" alt="Logo" style="max-width: 100px; max-height: 50px;"></td>
                <td>PT. CITRA MARGA NUSAPHALA PERSADA Tbk.<br>Divisi Umum - Departemen Pengadaan</td>
            </tr>
        </thead>
    </table>
    <p style="text-align: center; font-size: 14pt">
        REKAPITULASI PR MASIH DALAM PROSES NEGOSIASI<br>
        PERIODE {{ strtoupper($formattedStartDate) }} - {{ strtoupper($formattedEndDate) }}<br>
        UPDATE : {{ strtoupper($formattedDate) }}
    </p>
    @include('recapitulation.process.result')
    <br>
    <div class="row">
        <div class="col-md-4">
            <table class="document-position" style="width: 48%;">
                <tr>
                    <td class="blue-column" style="background: blue"></td>
                    <td><strong>Dokumen di Direksi</strong></td>
                    <td><strong>:&nbsp;&nbsp;</strong></td>
                    <td><strong>{{ $dealNegos }}</strong></td>
                </tr>
                <tr>
                    <td class="black-column" style="background: black"></td>
                    <td><strong>Dokumen di Pengadaan</strong></td>
                    <td><strong>:&nbsp;&nbsp;</strong></td>
                    <td><strong>{{ $emptyDealNegos }}</strong></td>
                </tr>
            </table>
        </div>
        <div class="col-md-8">
            <div class="document-pic">
                <table style="width: 20%;">
                @php
                    $totalDocuments = 0;
                @endphp
                @foreach($documentsPic as $officialId => $count)
                    <tr>
                        <td style="width: 50%"><strong>{{ $officialId }}</strong></td>
                        <td style="width: 50%"><strong>{{ $count }}</strong></td>
                    </tr>
                @php
                    $totalDocuments += $count;
                @endphp
                @endforeach
                <tr class="total-column">
                    <td><strong>TOTAL</strong></td>
                    <td><strong>{{ $totalDocuments }}</strong></td>
                </tr>
                </table>
            </div>
        </div>
    </div>
    <br>
    <table width="100%">
        <thead>
            <tr>
                <td style="text-align: center; width: 25%">Jakarta, {{ date('d-m-Y') }}<br>Dibuat Oleh,</td>
                <td style="width: 50%"></td>
                <td style="text-align: center; width: 25%"><br>Disetujui Oleh,</td>
            </tr>
        </thead>
        <tbody>
            <tr style="height:2cm;">
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align: center">{{ $stafName }}<br>{{ $stafPosition }}</td>
                <td></td>
                <td style="text-align: center">{{ $managerName }}<br>{{ $managerPosition }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
