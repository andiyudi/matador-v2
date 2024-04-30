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
            background-color:rgb(200, 255, 255);
            border: 1px solid black;
            padding: 8px;
            vertical-align: middle;
        } .peserta-rapat td {
            border: 1px solid black;
            padding: 8px;
            vertical-align: middle;
        }
        .peserta-rapat tfoot tr {
            border-bottom: 3px double black; /* Adjust border thickness and color as needed */
        }
        .total {
            margin-top: 0; /* Menaikkan posisi tabel sebanyak 100px */
        }
        .total table {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
            word-wrap: break-word;
        }
        .total th {
            background-color:rgb(255, 255, 255);
            border-left: 1px solid white; /* Atur border kiri */
            border-top: 1px solid white; /* Hanya border atas */
            border-right: 1px solid white; /* Atur border kanan */
            border-bottom: 1px solid black; /* Atur border kanan */
            padding: 8px;
        }
        .total td {
            border: 1px solid black;
            padding: 8px;
            vertical-align: middle;
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
        $noUrut1 = $noUrut2 = $noUrut3 = 0;
        $noProject1 = $noProject2 = $noProject3 = 0;
        $noUrutCancel1 = $noUrutCancel2 = $noUrutCancel3 = 0;
        $noProjectCancel1 = $noProjectCancel2 = $noProjectCancel3 = 0;
        $data1 = $data2 = $data3 = false;
        $dataProject1 = $dataProject2 = $dataProject3 = false;
        $dataCancel1 = $dataCancel2 = $dataCancel3 = false;
        $dataProjectCancel1 = $dataProjectCancel2 = $dataProjectCancel3 = false;
        $jumlahBerkas1 = $jumlahBerkas2 = $jumlahBerkas3 = 0;
        $jumlahBerkasProject1 = $jumlahBerkasProject2 = $jumlahBerkasProject3 = 0;
        $jumlahUserEstimate1 = $jumlahUserEstimate2 = $jumlahUserEstimate3 = 0;
        $jumlahUserEstimateProject1 = $jumlahUserEstimateProject2 = $jumlahUserEstimateProject3 = 0;
        $jumlahTechniqueEstimate1 = $jumlahTechniqueEstimate2 = $jumlahTechniqueEstimate3 = 0;
        $jumlahTechniqueEstimateProject1 = $jumlahTechniqueEstimateProject2 = $jumlahTechniqueEstimateProject3 = 0;
    @endphp
    <!-- Table value 1  < 100 JUTA-->
    <table>
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
            @foreach ($procurements as $procurement)
            @if ($procurement->user_estimate < 100000000 && $procurement->status != '2' && $procurement->division_id != 13)
            @php
                $data1 = true;
                $jumlahBerkas1++;
                $jumlahUserEstimate1 += $procurement->user_estimate;
                $jumlahTechniqueEstimate1 += $procurement->technique_estimate;
            @endphp
            <tr>
                <td style="text-align: center">{{ ++$noUrut1 }}</td>
                <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                <td style="text-align: center">{{ $procurement->number }}</td>
                <td>{{ $procurement->name }}</td>
                <td style="text-align: center">{{ $procurement->division->code }}</td>
                <td style="text-align: center">{{ $procurement->official->initials }}</td>
                <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '' }}</td>
                <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '' }}</td>
            </tr>
            @endif
            @if ($procurement->user_estimate < 100000000 && $procurement->status == '2' && $procurement->division_id != 13)
            @php
                $dataCancel1 = true;
            @endphp
            @endif
            @endforeach
            @if (!$data1)
                <tr>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                </tr>
            @endif
            @if($dataCancel1)
            <tr>
                <td colspan="8" style="color: red; font-weight: bold; text-align: center">PP DIBATALKAN</td>
            </tr>
            @endif
            @foreach ($procurements as $procurement)
            @if ($procurement->user_estimate < 100000000 && $procurement->status == '2' && $procurement->division_id != 13)
            @php
                $jumlahBerkas1++;
                $jumlahUserEstimate1 += $procurement->user_estimate;
                $jumlahTechniqueEstimate1 += $procurement->technique_estimate;
            @endphp
            <tr>
                <td style="text-align: center">{{ ++$noUrutCancel1 }}</td>
                <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                <td style="text-align: center">{{ $procurement->number }}</td>
                <td>{{ $procurement->name }}</td>
                <td style="text-align: center">{{ $procurement->division->code }}</td>
                <td style="text-align: center">{{ $procurement->official->initials }}</td>
                <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '' }}</td>
                <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '' }}</td>
            </tr>
            @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr style="text-align: center">
                <td colspan="4"><strong>JUMLAH</strong></td>
                <td>{{ $jumlahBerkas1 }}</td> <!-- Hitung jumlah berkas data + cancel -->
                <td>BERKAS</td>
                <td style="text-align: right">{{ number_format($jumlahUserEstimate1, 0, ',', '.') }}</td> <!-- Hitung jumlah user estimate data + cancel -->
                <td style="text-align: right">{{ number_format($jumlahTechniqueEstimate1, 0, ',', '.') }}</td> <!-- Hitung jumlah technique data + cancel -->
            </tr>
        </tfoot>
    </table>
    @foreach ($procurements as $procurement)
        @if ($procurement->user_estimate < 100000000 && $procurement->division_id == 13)
            @if (!$dataProject1) <!-- Hanya tampilkan jika data proyek belum ditampilkan -->
                @php
                    $dataProject1 = true; // Set variabel untuk menandai bahwa data proyek sudah ditampilkan
                @endphp
                <strong style="font-size: 14pt">PROYEK {{ $procurement->division->name }}</strong>
                <table>
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
                            <td colspan="8" style="color: red; font-weight: bold">DOKUMEN PROYEK {{ $procurement->division->name }} NILAI 0 s.d <  100 JUTA</td>
                        </tr>
                        @foreach ($procurements as $procurement)
                        @if ($procurement->user_estimate < 100000000 && $procurement->status != '2' && $procurement->division_id == 13)
                        @php
                            $jumlahBerkasProject1++;
                            $jumlahUserEstimateProject1 += $procurement->user_estimate;
                            $jumlahTechniqueEstimateProject1 += $procurement->technique_estimate;
                        @endphp
                        <tr>
                            <td style="text-align: center">{{ ++$noProject1 }}</td>
                            <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                            <td style="text-align: center">{{ $procurement->number }}</td>
                            <td>{{ $procurement->name }}</td>
                            <td style="text-align: center">{{ $procurement->division->code }}</td>
                            <td style="text-align: center">{{ $procurement->official->initials }}</td>
                            <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '' }}</td>
                            <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '' }}</td>
                        </tr>
                        @endif
                        @endforeach
                        @foreach ($procurements as $procurement)
                        @if ($procurement->user_estimate < 100000000 && $procurement->status == '2' && $procurement->division_id == 13)
                        @php
                            $jumlahBerkasProject1++;
                            $jumlahUserEstimateProject1 += $procurement->user_estimate;
                            $jumlahTechniqueEstimateProject1 += $procurement->technique_estimate;
                        @endphp
                        @if (!$dataProjectCancel1)
                        @php
                            $dataProjectCancel1 = true; // Set variabel untuk menandai bahwa pesan "PP DIBATALKAN" sudah ditampilkan
                        @endphp
                        <tr>
                            <td colspan="8" style="color: red; font-weight: bold; text-align: center">PP DIBATALKAN</td>
                        </tr>
                        @endif
                        <tr>
                            <td style="text-align: center">{{ ++$noProjectCancel1 }}</td>
                            <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                            <td style="text-align: center">{{ $procurement->number }}</td>
                            <td>{{ $procurement->name }}</td>
                            <td style="text-align: center">{{ $procurement->division->code }}</td>
                            <td style="text-align: center">{{ $procurement->official->initials }}</td>
                            <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '' }}</td>
                            <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '' }}</td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="text-align: center">
                            <td colspan="4"><strong>JUMLAH</strong></td>
                            <td>{{ $jumlahBerkasProject1 }}</td> <!-- Hitung jumlah berkas data + cancel -->
                            <td>BERKAS</td>
                            <td style="text-align: right">{{ number_format($jumlahUserEstimateProject1, 0, ',', '.') }}</td> <!-- Hitung jumlah user estimate data + cancel -->
                            <td style="text-align: right">{{ number_format($jumlahTechniqueEstimateProject1, 0, ',', '.') }}</td> <!-- Hitung jumlah technique data + cancel -->
                        </tr>
                    </tfoot>
                </table>
            @endif
        @endif
    @endforeach
    <br>
    <!-- Table value 2  >= 100 JUTA s.d < 1 M-->
    <table>
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
            @foreach ($procurements as $procurement)
            @if ($procurement->user_estimate >= 100000000 && $procurement->user_estimate < 1000000000 && $procurement->status != '2' && $procurement->division_id != 13)
            @php
                $data2 = true;
                $jumlahBerkas2++;
                $jumlahUserEstimate2 += $procurement->user_estimate;
                $jumlahTechniqueEstimate2 += $procurement->technique_estimate;
            @endphp
            <tr>
                <td style="text-align: center">{{ ++$noUrut2 }}</td>
                <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                <td style="text-align: center">{{ $procurement->number }}</td>
                <td>{{ $procurement->name }}</td>
                <td style="text-align: center">{{ $procurement->division->code }}</td>
                <td style="text-align: center">{{ $procurement->official->initials }}</td>
                <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '' }}</td>
                <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '' }}</td>
            </tr>
            @endif
            @if ($procurement->user_estimate >= 100000000 && $procurement->user_estimate < 1000000000 && $procurement->status == '2' && $procurement->division_id != 13)
            @php
                $dataCancel2 = true;
            @endphp
            @endif
            @endforeach
            @if (!$data2)
                <tr>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                </tr>
            @endif
            @if($dataCancel2)
            <tr>
                <td colspan="8" style="color: red; font-weight: bold; text-align: center">PP DIBATALKAN</td>
            </tr>
            @endif
            @foreach ($procurements as $procurement)
            @if ($procurement->user_estimate >= 100000000 && $procurement->user_estimate < 1000000000 && $procurement->status == '2' && $procurement->division_id != 13)
            @php
                $jumlahBerkas2++;
                $jumlahUserEstimate2 += $procurement->user_estimate;
                $jumlahTechniqueEstimate2 += $procurement->technique_estimate;
            @endphp
            <tr>
                <td style="text-align: center">{{ ++$noUrutCancel2 }}</td>
                <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                <td style="text-align: center">{{ $procurement->number }}</td>
                <td>{{ $procurement->name }}</td>
                <td style="text-align: center">{{ $procurement->division->code }}</td>
                <td style="text-align: center">{{ $procurement->official->initials }}</td>
                <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '' }}</td>
                <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '' }}</td>
            </tr>
            @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr style="text-align: center">
                <td colspan="4"><strong>JUMLAH</strong></td>
                <td>{{ $jumlahBerkas2 }}</td> <!-- Hitung jumlah berkas data + cancel -->
                <td>BERKAS</td>
                <td style="text-align: right">{{ number_format($jumlahUserEstimate2, 0, ',', '.') }}</td> <!-- Hitung jumlah user estimate data + cancel -->
                <td style="text-align: right">{{ number_format($jumlahTechniqueEstimate2, 0, ',', '.') }}</td> <!-- Hitung jumlah technique data + cancel -->
            </tr>
        </tfoot>
    </table>
    @foreach ($procurements as $procurement)
        @if ($procurement->user_estimate >= 100000000 && $procurement->user_estimate < 1000000000 && $procurement->division_id == 13)
            @if (!$dataProject2) <!-- Hanya tampilkan jika data proyek belum ditampilkan -->
                @php
                    $dataProject2 = true; // Set variabel untuk menandai bahwa data proyek sudah ditampilkan
                @endphp
                <strong style="font-size: 14pt">PROYEK {{ $procurement->division->name }}</strong>
                <table>
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
                            <td colspan="8" style="color: red; font-weight: bold">DOKUMEN PROYEK {{ $procurement->division->name }} NILAI &#8805; 100 JUTA s.d < 1 M</td>
                        </tr>
                        @foreach ($procurements as $procurement)
                        @if ($procurement->user_estimate >= 100000000 && $procurement->user_estimate < 1000000000 && $procurement->status != '2' && $procurement->division_id == 13)
                        @php
                            $jumlahBerkasProject2++;
                            $jumlahUserEstimateProject2 += $procurement->user_estimate;
                            $jumlahTechniqueEstimateProject2 += $procurement->technique_estimate;
                        @endphp
                        <tr>
                            <td style="text-align: center">{{ ++$noProject2 }}</td>
                            <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                            <td style="text-align: center">{{ $procurement->number }}</td>
                            <td>{{ $procurement->name }}</td>
                            <td style="text-align: center">{{ $procurement->division->code }}</td>
                            <td style="text-align: center">{{ $procurement->official->initials }}</td>
                            <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '' }}</td>
                            <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '' }}</td>
                        </tr>
                        @endif
                        @endforeach
                        @foreach ($procurements as $procurement)
                        @if ($procurement->user_estimate >= 100000000 && $procurement->user_estimate < 1000000000 && $procurement->status == '2' && $procurement->division_id == 13)
                        @php
                            $jumlahBerkasProject2++;
                            $jumlahUserEstimateProject2 += $procurement->user_estimate;
                            $jumlahTechniqueEstimateProject2 += $procurement->technique_estimate;
                        @endphp
                        @if (!$dataProjectCancel2)
                        @php
                            $dataProjectCancel2 = true; // Set variabel untuk menandai bahwa pesan "PP DIBATALKAN" sudah ditampilkan
                        @endphp
                        <tr>
                            <td colspan="8" style="color: red; font-weight: bold; text-align: center">PP DIBATALKAN</td>
                        </tr>
                        @endif
                        <tr>
                            <td style="text-align: center">{{ ++$noProjectCancel2 }}</td>
                            <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                            <td style="text-align: center">{{ $procurement->number }}</td>
                            <td>{{ $procurement->name }}</td>
                            <td style="text-align: center">{{ $procurement->division->code }}</td>
                            <td style="text-align: center">{{ $procurement->official->initials }}</td>
                            <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '' }}</td>
                            <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '' }}</td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="text-align: center">
                            <td colspan="4"><strong>JUMLAH</strong></td>
                            <td>{{ $jumlahBerkasProject2 }}</td> <!-- Hitung jumlah berkas data + cancel -->
                            <td>BERKAS</td>
                            <td style="text-align: right">{{ number_format($jumlahUserEstimateProject2, 0, ',', '.') }}</td> <!-- Hitung jumlah user estimate data + cancel -->
                            <td style="text-align: right">{{ number_format($jumlahTechniqueEstimateProject2, 0, ',', '.') }}</td> <!-- Hitung jumlah technique data + cancel -->
                        </tr>
                    </tfoot>
                </table>
            @endif
        @endif
    @endforeach
    <br>
    <!-- Table value 3  >= 1 M -->
    <table>
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
            @foreach ($procurements as $procurement)
            @if ($procurement->user_estimate >= 1000000000 && $procurement->status != '2' && $procurement->division_id != 13)
            @php
                $data3 = true;
                $jumlahBerkas3++;
                $jumlahUserEstimate3 += $procurement->user_estimate;
                $jumlahTechniqueEstimate3 += $procurement->technique_estimate;
            @endphp
            <tr>
                <td style="text-align: center">{{ ++$noUrut3 }}</td>
                <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                <td style="text-align: center">{{ $procurement->number }}</td>
                <td>{{ $procurement->name }}</td>
                <td style="text-align: center">{{ $procurement->division->code }}</td>
                <td style="text-align: center">{{ $procurement->official->initials }}</td>
                <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '' }}</td>
                <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '' }}</td>
            </tr>
            @endif
            @if ($procurement->user_estimate >= 1000000000 && $procurement->status == '2' && $procurement->division_id != 13)
            @php
                $dataCancel3 = true;
            @endphp
            @endif
            @endforeach
            @if (!$data3)
                <tr>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                </tr>
            @endif
            @if($dataCancel3)
            <tr>
                <td colspan="8" style="color: red; font-weight: bold; text-align: center">PP DIBATALKAN</td>
            </tr>
            @endif
            @foreach ($procurements as $procurement)
            @if ($procurement->user_estimate >= 1000000000 && $procurement->status == '2' && $procurement->division_id != 13)
            @php
                $jumlahBerkas3++;
                $jumlahUserEstimate3 += $procurement->user_estimate;
                $jumlahTechniqueEstimate3 += $procurement->technique_estimate;
            @endphp
            <tr>
                <td style="text-align: center">{{ ++$noUrutCancel3 }}</td>
                <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                <td style="text-align: center">{{ $procurement->number }}</td>
                <td>{{ $procurement->name }}</td>
                <td style="text-align: center">{{ $procurement->division->code }}</td>
                <td style="text-align: center">{{ $procurement->official->initials }}</td>
                <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '' }}</td>
                <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '' }}</td>
            </tr>
            @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr style="text-align: center">
                <td colspan="4"><strong>JUMLAH</strong></td>
                <td>{{ $jumlahBerkas3 }}</td> <!-- Hitung jumlah berkas data + cancel -->
                <td>BERKAS</td>
                <td style="text-align: right">{{ number_format($jumlahUserEstimate3, 0, ',', '.') }}</td> <!-- Hitung jumlah user estimate data + cancel -->
                <td style="text-align: right">{{ number_format($jumlahTechniqueEstimate3, 0, ',', '.') }}</td> <!-- Hitung jumlah technique data + cancel -->
            </tr>
        </tfoot>
    </table>
    @foreach ($procurements as $procurement)
        @if ($procurement->user_estimate >= 1000000000 && $procurement->division_id == 13)
            @if (!$dataProject3) <!-- Hanya tampilkan jika data proyek belum ditampilkan -->
                @php
                    $dataProject3 = true; // Set variabel untuk menandai bahwa data proyek sudah ditampilkan
                @endphp
                <strong style="font-size: 14pt">PROYEK {{ $procurement->division->name }}</strong>
                <table>
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
                            <td colspan="8" style="color: red; font-weight: bold">DOKUMEN PROYEK {{ $procurement->division->name }} NILAI &#8805; 1 M</td>
                        </tr>
                        @foreach ($procurements as $procurement)
                        @if ($procurement->user_estimate >= 1000000000 && $procurement->status != '2' && $procurement->division_id == 13)
                        @php
                            $jumlahBerkasProject3++;
                            $jumlahUserEstimateProject3 += $procurement->user_estimate;
                            $jumlahTechniqueEstimateProject3 += $procurement->technique_estimate;
                        @endphp
                        <tr>
                            <td style="text-align: center">{{ ++$noProject3 }}</td>
                            <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                            <td style="text-align: center">{{ $procurement->number }}</td>
                            <td>{{ $procurement->name }}</td>
                            <td style="text-align: center">{{ $procurement->division->code }}</td>
                            <td style="text-align: center">{{ $procurement->official->initials }}</td>
                            <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '' }}</td>
                            <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '' }}</td>
                        </tr>
                        @endif
                        @endforeach
                        @foreach ($procurements as $procurement)
                        @if ($procurement->user_estimate >= 1000000000 && $procurement->status == '2' && $procurement->division_id == 13)
                        @php
                            $jumlahBerkasProject3++;
                            $jumlahUserEstimateProject3 += $procurement->user_estimate;
                            $jumlahTechniqueEstimateProject3 += $procurement->technique_estimate;
                        @endphp
                        @if (!$dataProjectCancel3)
                        @php
                            $dataProjectCancel3 = true; // Set variabel untuk menandai bahwa pesan "PP DIBATALKAN" sudah ditampilkan
                        @endphp
                        <tr>
                            <td colspan="8" style="color: red; font-weight: bold; text-align: center">PP DIBATALKAN</td>
                        </tr>
                        @endif
                        <tr>
                            <td style="text-align: center">{{ ++$noProjectCancel3 }}</td>
                            <td style="text-align: center">{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                            <td style="text-align: center">{{ $procurement->number }}</td>
                            <td>{{ $procurement->name }}</td>
                            <td style="text-align: center">{{ $procurement->division->code }}</td>
                            <td style="text-align: center">{{ $procurement->official->initials }}</td>
                            <td style="text-align: right">{{ $procurement->user_estimate !== null ? number_format($procurement->user_estimate, 0, ',', '.') : '' }}</td>
                            <td style="text-align: right">{{ $procurement->technique_estimate !== null ? number_format($procurement->technique_estimate, 0, ',', '.') : '' }}</td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="text-align: center">
                            <td colspan="4"><strong>JUMLAH</strong></td>
                            <td>{{ $jumlahBerkasProject3 }}</td> <!-- Hitung jumlah berkas data + cancel -->
                            <td>BERKAS</td>
                            <td style="text-align: right">{{ number_format($jumlahUserEstimateProject3, 0, ',', '.') }}</td> <!-- Hitung jumlah user estimate data + cancel -->
                            <td style="text-align: right">{{ number_format($jumlahTechniqueEstimateProject3, 0, ',', '.') }}</td> <!-- Hitung jumlah technique data + cancel -->
                        </tr>
                    </tfoot>
                </table>
            @endif
        @endif
    @endforeach
    <br>
</div>
<div class="total">
    <table>
        <thead>
            <tr>
                <th width="3%" style="text-align: center"></th>
                <th width="7%" style="text-align: center"></th>
                <th width="5%" style="text-align: center"></th>
                <th width="40%" style="text-align: center"></th>
                <th width="5%" style="text-align: center"></th>
                <th width="8%" style="text-align: center"></th>
                <th style="text-align: center"></th>
                <th style="text-align: center"></th>
            </tr>
        </thead>
        <tbody>
            <tr style="text-align: center">
                <td colspan="4"><strong>TOTAL PP {{ strtoupper($monthName) }}</strong></td>
                <td>{{ $jumlahBerkas1 + $jumlahBerkas2 + $jumlahBerkas3 + $jumlahBerkasProject1 + $jumlahBerkasProject2 + $jumlahBerkasProject3 }}</td>
                <td>BERKAS</td>
                <td style="text-align: right"></td>
                <td style="text-align: right"></td>
            </tr>
        </tbody>
    </table>
</div>
</body>
</html>
