<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Rekap Penilaian Vendor Terhadap CMNP</title>
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
            font-size:10pt; /* Ukuran huruf 12px */
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
    <p style="text-align: center; font-size: 16pt">REKAPITULASI FORMULIR PENILAIAN PENYEDIA JASA / VENDOR<br>Terhadap PT. Citra Marga Nusaphala Persada, Tbk<br>Periode Tahun {{ $formattedStartDate }} - {{ $formattedEndDate }}</p>
    <div class="peserta-rapat">
        <table width="100%">
            <thead>
                <tr>
                    <th rowspan="3">No</th>
                    <th rowspan="3">Nama Perusahaan</th>
                    <th rowspan="3">Core Business</th>
                    <th rowspan="3">Grade</th>
                    <th rowspan="3">Jumlah Penilaian Pekerjaan</th>
                    <th colspan="3">Nilai Pekerjaan</th>
                    <th colspan="15">Hasil Penilaian Complain Vendor</th>
                </tr>
                <tr>
                    <th rowspan="2">0 s.d &lt; 100 Jt</th>
                    <th rowspan="2">&ge; 100 Jt s.d &lt; 1 Miliar</th>
                    <th rowspan="2">&ge; 1 Miliar</th>
                    <th colspan="3">Penerbitan Kontrak / PO</th>
                    <th colspan="3">Pelaksanaan Pekerjaan (Koordinasi)</th>
                    <th colspan="3">Pengajuan &amp; Pelaksanaan PHO</th>
                    <th colspan="3">Pengajuan &amp; Pelaksanaan FHO</th>
                    <th colspan="3">Pengajuan Invoice &amp; Real Pembayaran</th>
                </tr>
                <tr>
                    <th>Cepat</th>
                    <th>Lama</th>
                    <th>Sangat Lama</th>
                    <th>Mudah</th>
                    <th>Sulit</th>
                    <th>Sangat Sulit</th>
                    <th>Cepat</th>
                    <th>Lama</th>
                    <th>Sangat Lama</th>
                    <th>Cepat</th>
                    <th>Lama</th>
                    <th>Sangat Lama</th>
                    <th>Cepat</th>
                    <th>Lama</th>
                    <th>Sangat Lama</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vendorData as $index => $data)
                <tr style="text-align: center">
                    <td>{{ $loop->iteration }}</td>
                    <td style="text-align: justify">{{ $data['vendorName'] }}</td>
                    <td>{!! $data['core_business'] !!}</td>
                    <td>{{ $data['grade'] }}</td>
                    <td>{{ $data['jumlah_penilaian'] }}</td>
                    <td>{{ $data['jumlahValueCost0'] }}</td>
                    <td>{{ $data['jumlahValueCost1'] }}</td>
                    <td>{{ $data['jumlahValueCost2'] }}</td>
                    <td>{{ $data['jumlahContractOrder0'] }}</td>
                    <td>{{ $data['jumlahContractOrder1'] }}</td>
                    <td>{{ $data['jumlahContractOrder2'] }}</td>
                    <td>{{ $data['jumlahWorkImplementation0'] }}</td>
                    <td>{{ $data['jumlahWorkImplementation1'] }}</td>
                    <td>{{ $data['jumlahWorkImplementation2'] }}</td>
                    <td>{{ $data['jumlahPreHandover0'] }}</td>
                    <td>{{ $data['jumlahPreHandover1'] }}</td>
                    <td>{{ $data['jumlahPreHandover2'] }}</td>
                    <td>{{ $data['jumlahFinalHandover0'] }}</td>
                    <td>{{ $data['jumlahFinalHandover1'] }}</td>
                    <td>{{ $data['jumlahFinalHandover2'] }}</td>
                    <td>{{ $data['jumlahInvoicePayment0'] }}</td>
                    <td>{{ $data['jumlahInvoicePayment1'] }}</td>
                    <td>{{ $data['jumlahInvoicePayment2'] }}</td>
                </tr>
                @endforeach
                <tr style="text-align: center; font-weight: bold;">
                    <td colspan="4">Jumlah Total</td>
                    <td>{{ $totalData['totalPenilaian'] }}</td>
                    <td>{{ $totalData['totalValueCost0'] }}</td>
                    <td>{{ $totalData['totalValueCost1'] }}</td>
                    <td>{{ $totalData['totalValueCost2'] }}</td>
                    <td>{{ $totalData['totalContractOrder0'] }}</td>
                    <td>{{ $totalData['totalContractOrder1'] }}</td>
                    <td>{{ $totalData['totalContractOrder2'] }}</td>
                    <td>{{ $totalData['totalWorkImplementation0'] }}</td>
                    <td>{{ $totalData['totalWorkImplementation1'] }}</td>
                    <td>{{ $totalData['totalWorkImplementation2'] }}</td>
                    <td>{{ $totalData['totalPreHandover0'] }}</td>
                    <td>{{ $totalData['totalPreHandover1'] }}</td>
                    <td>{{ $totalData['totalPreHandover2'] }}</td>
                    <td>{{ $totalData['totalFinalHandover0'] }}</td>
                    <td>{{ $totalData['totalFinalHandover1'] }}</td>
                    <td>{{ $totalData['totalFinalHandover2'] }}</td>
                    <td>{{ $totalData['totalInvoicePayment0'] }}</td>
                    <td>{{ $totalData['totalInvoicePayment1'] }}</td>
                    <td>{{ $totalData['totalInvoicePayment2'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <table width="100%">
        <thead>
            <tr>
                <td style="text-align: center; width: 50%">Jakarta, {{ date('d-m-Y') }}<br>Dibuat Oleh,</td>
                <td style="text-align: center; width: 50%"><br>Disetujui Oleh,</td>
            </tr>
        </thead>
        <tbody>
            <tr style="height:2cm;">
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align: center">{{ $creatorNameVendor }}<br>{{ $creatorPositionVendor }}</td>
                <td style="text-align: center">{{ $supervisorNameVendor }}<br>{{ $supervisorPositionVendor }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
