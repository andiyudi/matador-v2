<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Penetapan Menang dan Kalah</title>
</head>
<body>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14pt; /* Ukuran huruf 12px */
            margin: 0;
            padding: 0;
        }
        .page-content {
            padding: 6cm 2cm 0cm 3cm;
            box-sizing: border-box; /* Pastikan padding dihitung dalam ukuran elemen */
            height: 100%;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .header div p {
            margin: 0; /* Menghilangkan margin dari elemen <p> dalam .header */
            padding: 0; /* Menghilangkan padding dari elemen <p> dalam .header */
        }
        .content {
            margin-top: 40px;
        }
        .content .section {
            margin-bottom: 40px;
            text-align: justify; /* Menambahkan rata kiri dan kanan pada teks */
        }
        .content .no-spacing p {
            margin: 0;
        }
        .perihal {
            display: table;
            width: 100%;
            margin-bottom: 5px; /* Jarak bawah */
        }
        .perihal p {
            display: table-cell;
            padding: 0;
            margin: 0;
        }
        .perihal .label {
            white-space: nowrap;
            width: 1%; /* Menyesuaikan lebar agar sesuai konten */
            padding-right: 10px; /* Jarak proporsional antara label dan deskripsi */
        }
        .indented {
            margin-left: 30px;
        }
        .aligned {
            margin-top: 5px;
            margin-left: 1.5cm; /* Menjorok ke dalam sebanyak 1.5 cm */
            width: 90%;
            display: table;
        }
        .aligned p {
            margin: 0;
            display: table-row;
        }
        .aligned span {
            display: table-cell;
            padding-right: 10px;
        }
        .aligned .label {
            width: 35%; /* Menyesuaikan lebar agar sesuai konten */
        }
        .signature {
            margin-top: 5px;
        }
        .bold {
            font-weight: bold;
        }
        .underline {
            text-decoration: underline;
        }
        .no-margin {
            margin: 0; /* Menghilangkan margin pada elemen <p> */
        }
        .page-break {
            page-break-before: always; /* Menambahkan halaman baru sebelum elemen ini */
        }
    </style>
</head>
<body>
@foreach ($procurement->tenders as $tender)
    @foreach($tender->businessPartners as $businessPartner)
    <div class="page-content page-break">
        <div class="header">
            <div>
                <p>Nomor : &ensp;{{ $determinationNumber }}</p>
            </div>
            <div>
                <p>Jakarta, {{ $formattedDate }}</p>
            </div>
        </div>

        <div class="content">
            <div class="section no-spacing">
                <p>Kepada Yth.</p>
                <p class="bold">Direksi</p>
                <p class="bold">{{ $businessPartner->partner->name }}</p>
                <p>di Tempat</p>
            </div>

            <div class="section">
                <p class="bold">Up. Bapak / Ibu {{ ucwords(strtolower($businessPartner->partner->director)) }}</p>
            </div>

            <div class="section perihal">
                <p class="label bold">Perihal : </p>
                <p class="bold">Hasil Klarisifikasi &#38; Negosiasi
                    @if($businessPartner->pivot->is_selected == '1')
                        Penetapan Pemenang
                    @endif
                    {{ ucwords(strtolower($procurement->name)) }}</p>
            </div>

            <div class="section">
                <p>Dengan Hormat,</p>
                @if($businessPartner->pivot->is_selected == '1')
                <p>Sehubungan dengan pelaksanaan tender {{ ucwords(strtolower($procurement->name)) }}, dengan ini kami menetapkan Pemenang pekerjaan dimaksud sebagai berikut :</p>
                <div class="section aligned">
                    <p>
                        <span class="label">Nama Perusahaan</span><span>:</span><span>{{ $businessPartner->partner->name }}</span>
                    </p>
                    <p>
                        <span class="label">Alamat</span><span>:</span><span>{{ $businessPartner->partner->address }}</span>
                    </p>
                    <p>
                        <span class="label">NPWP</span><span>:</span><span>{{ $businessPartner->partner->npwp }}</span>
                    </p>
                    <p>
                        <span class="label">Harga Penawaran Setelah Negosiasi</span><span>:</span><span>Rp. {{ number_format($businessPartner->nego_price, 0, ',', '.') }}</span>
                    </p>
                </div>
                <div class="section">
                    <p>Demikian Surat Penetapan Pemenang ini kami buat untuk dipergunakan sebagaimana mestinya.</p>
                </div>
                @else
                <p>Menindaklanjuti tahapan klarifikasi &#38; Negosiasi terhadap {{ ucwords(strtolower($procurement->name)) }}, maka dengan ini kami menyampaikan hasil akhir dari tahapan tersebut, yaitu dengan ini menyatakan bahwa {{ $businessPartner->partner->name }} tidak dapat dilanjutkan ke tahapan pemenang (Kalah Tender).</p>
                <div class="section">
                    <p>Atas nama Perusahaan, kami mengucapkan terima kasih atas minat dan partisipasi perusahaan Bapak / Ibu dalam proses yang telah berlangsung ini</p>
                    <p>Demikian kami sampaikan atas perhatian dan kerjasamanya diucapkan terima kasih.</p>
                </div>
                @endif
            </div>
            <div class="section">
                <p><strong>Panitia Pengadaan Kewajaran Harga (PPKH)</strong></p>
            </div>

            <div class="signature">
                <p>Hormat kami,</p>
                <br>
                <br>
                <br>
                <p class="bold underline no-margin">{{ ucwords(strtolower($leadDeterminationName)) }}</p>
                <p class="no-margin">{{ ucwords(strtolower($leadDeterminationPosition)) }} PPKH</p>
            </div>
        </div>
    </div>
    @endforeach
@endforeach
</body>
</html>
