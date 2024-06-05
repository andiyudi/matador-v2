<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Rekap PP Yang Dibatalkan</title>
</head>
<body>
    @include('recapitulation.cancel.style')
    <table>
        <thead>
            <tr>
                <td><img src="{{ $logoBase64 }}" alt="Logo" style="max-width: 100px; max-height: 50px;"></td>
                <td>PT. CITRA MARGA NUSAPHALA PERSADA Tbk.<br>Divisi Umum - Departemen Pengadaan</td>
            </tr>
        </thead>
    </table>
    <p style="text-align: center; font-size: 14pt">
        REKAPITULASI PP YANG DIBATALKAN<br>
        PERIODE {{ strtoupper($startMonthName) }} - {{ strtoupper($endMonthName) }} {{ $year }}
    </p>
    @include('recapitulation.cancel.result')
    <br>
    <div class="row">
        <div class="col-md-4">
        </div>
        <div class="col-md-8">
            <div class="document-pic">
                <table style="width: 22%;">
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
                <td style="text-align: center">{{ $data['stafName'] }}<br>{{ $data['stafPosition'] }}</td>
                <td></td>
                <td style="text-align: center">{{ $data['managerName'] }}<br>{{ $data['managerPosition'] }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
