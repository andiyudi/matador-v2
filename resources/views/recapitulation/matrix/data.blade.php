<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Matriks Perbandingan Rekap All Done</title>
</head>
<body>
    @include('recapitulation.matrix.style')
    <table>
        <thead>
            <tr>
                <td><img src="{{ $logoBase64 }}" alt="Logo" style="max-width: 100px; max-height: 50px;"></td>
                <td>PT. CITRA MARGA NUSAPHALA PERSADA Tbk.<br>Divisi Umum - Departemen Pengadaan</td>
            </tr>
        </thead>
    </table>
    <p style="text-align: center; font-size: 14pt">
        MATRIK PERBANDINGAN<br>
        NILAI PP VS HASIL NEGOSIASI - NILAI VERIFIKASI TEKNIK VS HASIL NEGOSIASI<br>
        @php
        $bulan = [
        '01' => 'JANUARI',
        '02' => 'FEBRUARI',
        '03' => 'MARET',
        '04' => 'APRIL',
        '05' => 'MEI',
        '06' => 'JUNI',
        '07' => 'JULI',
        '08' => 'AGUSTUS',
        '09' => 'SEPTEMBER',
        '10' => 'OKTOBER',
        '11' => 'NOVEMBER',
        '12' => 'DESEMBER'
    ];

        $selectedStartMonthName = isset($start_month) ? $bulan[$start_month] : null;
        $selectedEndMonthName = isset($end_month) ? $bulan[$end_month] : null;
    @endphp
    PERIODE: {{ $selectedStartMonthName }} - {{ $selectedEndMonthName }} {{ $year }}
    </p>
    @include('recapitulation.matrix.result')
    <br>
    <div class="row">
        <div class="col-md-3">
            <table width="100%">
                <thead>
                    <tr>
                        <td style="text-align: center; width: 50%">Jakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>Dibuat Oleh,</td>
                        <td style="width: 50%"></td>
                    </tr>
                </thead>
                <tbody>
                    <tr style="height:1cm;">
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="text-align: center"><strong><u>{{ $stafName }}</u></strong><br>{{ $stafPosition }}</td>
                        <td style="text-align: center"><br></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <div class="document-pic">
                <table style="width: 22%;">
                @php
                    $totalDocuments = 0;
                @endphp
                @foreach($documentsPic as $officialId => $count)
                    <tr>
                        <td style="width: 38%"><strong>{{ $officialId }}</strong></td>
                        <td style="width: 62%"><strong>{{ $count }}</strong></td>
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
        <div class="col-md-3">
            <table width="100%">
                <thead>
                    <tr>
                        <td style="width: 50%"></td>
                        <td style="text-align: center; width: 25%"><br>Disetujui Oleh,</td>
                    </tr>
                </thead>
                <tbody>
                    <tr style="height:1cm;">
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="text-align: center"><br></td>
                        <td style="text-align: center"><strong><u>{{ $managerName }}</u></strong><br>{{ $managerPosition }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
