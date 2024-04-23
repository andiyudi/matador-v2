<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Monthly Recapitulation by Value</title>
</head>
<body>
    <style>
        @media print{
            @page {
                size: A4 landscape;
            }
        }
        body {
            font-family: 'Arial Narrow', sans-serif; /* Arial Narrow */
            font-size:10pt; /* Ukuran huruf 10px */
        }
        .peserta-rapat table {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
            word-wrap: break-word;
        }
        .peserta-rapat th {
            background-color:rgb(130, 195, 250);
            border: 1px solid black;
            padding: 8px;
            vertical-align: middle;
        } .peserta-rapat td {
            border: 1px solid black;
            padding: 8px;
            vertical-align: middle;
        }
        .peserta-rapat tbody tr:last-child {
            border-bottom: 3px double black; /* Adjust border thickness and color as needed */
        }
        .row {
            display: flex;
            justify-content: space-between;
        }
        .col-md-4 {
            width: 48%; /* Sesuaikan lebar div dengan tabel di dalamnya */
        }
        .col-md-8 {
            width: 69%; /* Sesuaikan lebar div dengan tabel di dalamnya */
        }
        .blue-column, .black-column {
            width: 15%; /* Menyesuaikan lebar kolom dengan kolom No pada peserta rapat */
        }
        .total-column {
            background-color:deepskyblue;
        }
        .document-pic table {
            border-collapse: collapse; /* Menyatukan batas seluruhnya */
            width: 100%;
            font-size:8pt;
        }
        .document-pic th,
        .document-pic td {
            border: 1px solid black; /* Batas individual */
            padding: 3px;
            vertical-align: middle;
            text-align: center;
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
<p style="text-align: center; font-size: 14pt">
    REKAPITULASI DOKUMEN PERMINTAAN PEKERJAAN (PP) MASUK<br>
    BERDASARKAN NILAI PEKERJAAN<br>
    PERIODE : {{ strtoupper($periodFormatted) }}
</p>
<div class="peserta-rapat">
    @php
    $countTable1 = $countTable2 = $countTable3 = 0; // untuk nomor urut dokumen per value
    $cancelTable1 = $cancelTable2 = $cancelTable3 = 0; // untuk nomor urut dokumen cancel per value
    $cancelCount1 = $cancelCount2 = $cancelCount3 = 0; // untuk hitung data dokumen cancel per value
    $totalBerkas1 = $totalBerkas2 = $totalBerkas3 = 0; // untuk hitung jumlah data dokumen per value
    $totalBerkasCancel1 = $totalBerkasCancel2 = $totalBerkasCancel3 = 0; // untuk hitung jumlah data dokumen cancel per value
    $totalUserEstimate1 = $totalUserEstimate2 = $totalUserEstimate3 = 0; // untuk hitung total user estimate per value
    $totalUserEstimateCancel1 = $totalUserEstimateCancel2 = $totalUserEstimateCancel3 = 0; // untuk hitung total user estimate cancel per value
    $totalTechniqueEstimate1 = $totalTechniqueEstimate2 = $totalTechniqueEstimate3 = 0; // untuk hitung total technique estimate per value
    $totalTechniqueEstimateCancel1 = $totalTechniqueEstimateCancel2 = $totalTechniqueEstimateCancel3 = 0; // untuk hitung total technique estimate cancel per value
@endphp

    <!-- Table untuk dokumen PP dengan nilai < 100 Juta -->
    <table width="100%">
        <thead>
            <tr>
                <th rowspan="2" width="3%" style="text-align: center">No</th>
                <th rowspan="2" width="7%" style="text-align: center">TTPP</th>
                <th rowspan="2" width="5%" style="text-align: center">No PP</th>
                <th rowspan="2" width="40%" style="text-align: center">Nama Pekerjaan</th>
                <th rowspan="2" width="5%" style="text-align: center">Divisi</th>
                <th rowspan="2" width="8%" style="text-align: center">PIC Pengadaan</th>
                <th colspan="2" style="text-align: center">Nilai PP</th>
            </tr>
            <tr>
                <th>EE User</th>
                <th>EE Teknik</th>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td colspan="8" style="color: red; font-weight: bold">DOKUMEN PP NILAI 0 s.d <  100 JUTA</td>
                </tr>
            @foreach($procurements as $procurement)
            @if ($procurement->user_estimate < 100000000 && $procurement->status != '2')
                <tr>
                    <td style="text-align: center">{{ ++$countTable1 }}</td>
                    <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                    <td style="text-align: center">{{ $procurement->number }}</td>
                    <td>{{ $procurement->name }}</td>
                    <td style="text-align: center">{{ $procurement->division->code }}</td>
                    <td style="text-align: center">{{ $procurement->official->initials }}</td>
                    <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '' }}</td>
                    <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '' }}</td>
                    @php
                        $totalUserEstimate1 += $procurement->user_estimate;
                        $totalTechniqueEstimate1 += $procurement->technique_estimate;
                        $totalBerkas1++;
                    @endphp
                </tr>
            @endif
            @endforeach
            @foreach($procurements as $procurement)
            @if ($procurement->user_estimate < 100000000 && $procurement->status == '2')
            @php
                    $cancelCount1++;
            @endphp
            @endif
            @endforeach
            @if ( $cancelCount1 > 0)
            <tr>
                <td colspan="8" style="color: red; font-weight: bold; text-align: center">PP DIBATALKAN</td>
            </tr>
            @endif
            @foreach($procurements as $procurement)
            @if ($procurement->user_estimate < 100000000 && $procurement->status == '2')
            <tr>
                <td style="text-align: center">{{ ++$cancelTable1 }}</td>
                <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                <td style="text-align: center">{{ $procurement->number }}</td>
                <td>{{ $procurement->name }}</td>
                <td style="text-align: center">{{ $procurement->division->code }}</td>
                <td style="text-align: center">{{ $procurement->official->initials }}</td>
                <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '' }}</td>
                <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '' }}</td>
                @php
                    $totalUserEstimateCancel1 += $procurement->user_estimate;
                    $totalTechniqueEstimateCancel1 += $procurement->technique_estimate;
                    $totalBerkasCancel1++;
                @endphp
            </tr>
            @endif
            @endforeach
            <tr style="text-align: center">
                <td colspan="4"><strong>JUMLAH</strong></td>
                <td>{{ $totalBerkas1 + $totalBerkasCancel1 }}</td>
                <td>BERKAS</td>
                <td style="text-align: right">{{ number_format($totalUserEstimate1 + $totalUserEstimateCancel1, 0, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($totalTechniqueEstimate1 + $totalTechniqueEstimateCancel1, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <!-- Table untuk dokumen PP dengan nilai >= 100 Juta dan < 1 Miliar -->
    <table width="100%">
        <thead>
            <tr>
                <th rowspan="2" width="3%" style="text-align: center">No</th>
                <th rowspan="2" width="7%" style="text-align: center">TTPP</th>
                <th rowspan="2" width="5%" style="text-align: center">No PP</th>
                <th rowspan="2" width="40%" style="text-align: center">Nama Pekerjaan</th>
                <th rowspan="2" width="5%" style="text-align: center">Divisi</th>
                <th rowspan="2" width="8%" style="text-align: center">PIC Pengadaan</th>
                <th colspan="2" style="text-align: center">Nilai PP</th>
            </tr>
            <tr>
                <th>EE User</th>
                <th>EE Teknik</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="8" style="color: red; font-weight: bold">DOKUMEN PP NILAI &#8805; 100 JUTA s.d < 1 M</td>
            </tr>
        @foreach($procurements as $procurement)
        @if ($procurement->user_estimate >= 100000000 && $procurement->user_estimate < 1000000000 && $procurement->status != '2')
        <tr>
            <td style="text-align: center">{{ ++$countTable2 }}</td>
            <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
            <td style="text-align: center">{{ $procurement->number }}</td>
            <td>{{ $procurement->name }}</td>
            <td style="text-align: center">{{ $procurement->division->code }}</td>
            <td style="text-align: center">{{ $procurement->official->initials }}</td>
            <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '' }}</td>
            <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '' }}</td>
            @php
                $totalUserEstimate2 += $procurement->user_estimate;
                $totalTechniqueEstimate2 += $procurement->technique_estimate;
                $totalBerkas2++;
            @endphp
        </tr>
        @endif
        @endforeach
        @foreach($procurements as $procurement)
            @if ($procurement->user_estimate >= 100000000 && $procurement->user_estimate < 1000000000 && $procurement->status == '2')
            @php
                    $cancelCount2++;
            @endphp
            @endif
            @endforeach
            @if ( $cancelCount2 > 0)
            <tr>
                <td colspan="8" style="color: red; font-weight: bold; text-align: center">PP DIBATALKAN</td>
            </tr>
            @endif
            @foreach($procurements as $procurement)
            @if ($procurement->user_estimate >= 100000000 && $procurement->user_estimate < 1000000000 && $procurement->status == '2')
            <tr>
                <td style="text-align: center">{{ ++$cancelTable2 }}</td>
                <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                <td style="text-align: center">{{ $procurement->number }}</td>
                <td>{{ $procurement->name }}</td>
                <td style="text-align: center">{{ $procurement->division->code }}</td>
                <td style="text-align: center">{{ $procurement->official->initials }}</td>
                <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '' }}</td>
                <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '' }}</td>
                @php
                    $totalUserEstimateCancel2 += $procurement->user_estimate;
                    $totalTechniqueEstimateCancel2 += $procurement->technique_estimate;
                    $totalBerkasCancel2++;
                @endphp
            </tr>
            @endif
            @endforeach
        <tr style="text-align: center">
            <td colspan="4"><strong>JUMLAH</strong></td>
            <td>{{ $totalBerkas2 + $totalBerkasCancel2 }}</td>
            <td>BERKAS</td>
            <td style="text-align: right">{{ number_format($totalUserEstimate2 + $totalUserEstimateCancel2, 0, ',', '.') }}</td>
            <td style="text-align: right">{{ number_format($totalTechniqueEstimate2 + $totalTechniqueEstimateCancel2, 0, ',', '.') }}</td>
        </tr>
    </tbody>
    </table>
    <br>
    <!-- Table untuk dokumen PP dengan nilai >= 1 Miliar -->
    <table width="100%">
        <thead>
            <tr>
                <th rowspan="2" width="3%" style="text-align: center">No</th>
                <th rowspan="2" width="7%" style="text-align: center">TTPP</th>
                <th rowspan="2" width="5%" style="text-align: center">No PP</th>
                <th rowspan="2" width="40%" style="text-align: center">Nama Pekerjaan</th>
                <th rowspan="2" width="5%" style="text-align: center">Divisi</th>
                <th rowspan="2" width="8%" style="text-align: center">PIC Pengadaan</th>
                <th colspan="2" style="text-align: center">Nilai PP</th>
            </tr>
            <tr>
                <th>EE User</th>
                <th>EE Teknik</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="8" style="color: red; font-weight: bold">DOKUMEN PP NILAI &#8805; 1 M</td>
            </tr>
            @foreach($procurements as $procurement)
            @if ($procurement->user_estimate >= 1000000000 && $procurement->status != '2')
            <tr>
                <td style="text-align: center">{{ ++$countTable3 }}</td>
                <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                <td style="text-align: center">{{ $procurement->number }}</td>
                <td>{{ $procurement->name }}</td>
                <td style="text-align: center">{{ $procurement->division->code }}</td>
                <td style="text-align: center">{{ $procurement->official->initials }}</td>
                <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '' }}</td>
                <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '' }}</td>
                @php
                    $totalUserEstimate3 += $procurement->user_estimate;
                    $totalTechniqueEstimate3 += $procurement->technique_estimate;
                    $totalBerkas3++;
                @endphp
            </tr>
            @endif
            @endforeach
            @foreach($procurements as $procurement)
            @if ($procurement->user_estimate >= 1000000000 && $procurement->status == '2')
            @php
                    $cancelCount3++;
            @endphp
            @endif
            @endforeach
            @if ( $cancelCount3 > 0)
            <tr>
                <td colspan="8" style="color: red; font-weight: bold; text-align: center">PP DIBATALKAN</td>
            </tr>
            @endif
            @foreach($procurements as $procurement)
            @if ($procurement->user_estimate >= 1000000000 && $procurement->status == '2')
            <tr>
                <td style="text-align: center">{{ ++$cancelTable3 }}</td>
                <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                <td style="text-align: center">{{ $procurement->number }}</td>
                <td>{{ $procurement->name }}</td>
                <td style="text-align: center">{{ $procurement->division->code }}</td>
                <td style="text-align: center">{{ $procurement->official->initials }}</td>
                <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '' }}</td>
                <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '' }}</td>
                @php
                    $totalUserEstimateCancel3 += $procurement->user_estimate;
                    $totalTechniqueEstimateCancel3 += $procurement->technique_estimate;
                    $totalBerkasCancel3++;
                @endphp
            </tr>
            @endif
            @endforeach
            <tr style="text-align: center">
                <td colspan="4"><strong>JUMLAH</strong></td>
                <td>{{ $totalBerkas3 + $totalBerkasCancel3 }}</td>
                <td>BERKAS</td>
                <td style="text-align: right">{{ number_format($totalUserEstimate3 + $totalUserEstimateCancel3, 0, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($totalTechniqueEstimate3 + $totalTechniqueEstimateCancel3, 0, ',', '.') }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr style="text-align: center">
                <td colspan="4"><strong>JUMLAH PP {{ strtoupper($monthName) }}</strong></td>
                <td>{{ $totalBerkas1 + $totalBerkas2 + $totalBerkas3 + $totalBerkasCancel1 + $totalBerkasCancel2 + $totalBerkasCancel3 }}</td>
                <td>BERKAS</td>
                <td style="text-align: right">{{ number_format($totalUserEstimate1 + $totalUserEstimate2 + $totalUserEstimate3 + $totalUserEstimateCancel1 + $totalUserEstimateCancel2 + $totalUserEstimateCancel3, 0, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($totalTechniqueEstimate1 + $totalTechniqueEstimate2 + $totalTechniqueEstimate3 + $totalTechniqueEstimateCancel1 + $totalTechniqueEstimateCancel2 + $totalTechniqueEstimateCancel3, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</div>
</body>
</html>
