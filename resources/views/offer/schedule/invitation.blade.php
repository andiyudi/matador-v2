<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Rapat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt; /* Ukuran huruf 12px */
            margin: 0;
            padding: 0;
        }
        .page-content {
            padding: 4cm 1cm 0cm 1cm;
            box-sizing: border-box; /* Pastikan padding dihitung dalam ukuran elemen */
            height: 100%;
        }
        .header {
            display: flex;
            justify-content: space-between;
        }
        .header div p {
            margin: 0; /* Menghilangkan margin dari elemen <p> dalam .header */
            padding: 0; /* Menghilangkan padding dari elemen <p> dalam .header */
        }
        .content {
            margin-top: 10px;
        }
        .content .section {
            margin-bottom: 5px;
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
        .regards {
            margin-top: 40px;
        }
        .indented {
            margin-left: 30px;
        }
        .aligned {
            margin-top: 5px;
            margin-left: 0.3cm; /* Menjorok ke dalam sebanyak 0.3 cm */
            width: 100%;
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
            width: 1%; /* Menyesuaikan lebar agar sesuai konten */
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
@foreach ($tender->businessPartners as $businessPartner)
    <div class="page-content page-break">
        <div class="header">
            <div>
                <p>Nomor : &ensp;{{ $invitationNumber }}</p>
                <p>Lamp : -</p>
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
                <p class="bold">Up. Bapak / Ibu :<br>
                    &emsp;&ensp;&nbsp;{{ ucwords(strtolower($businessPartner->partner->director)) }}</p>
            </div>

            <div class="section perihal">
                <p class="label bold">Perihal : </p>
                <p class="bold">Undangan Rapat Penjelasan Teknis (Aanwijzing) @if ($tender->schedule_type == '1')
                    dan Klarifikasi serta Negosiasi Kewajaran Harga
                @endif {{ ucwords(strtolower($tender->procurement->name)) }}</p>
            </div>

            <div class="section regards">
                <p>Dengan Hormat,</p>
                <p>Dengan ini disampaikan bahwa PT Citra Marga Nusaphala Persada Tbk (“CMNP”) akan mengadakan {{ ucwords(strtolower($tender->procurement->name)) }}. Sehubungan dengan hal tersebut kami Panitia Pengadaan dan Kewajaran Harga (PPKH) mengundang perusahaan Saudara dalam rapat Penjelasan Teknis (Aanwijzing) @if ($tender->schedule_type == '1')
                    dan Klarifikasi serta Negosiasi Kewajaran Harga
                @endif yang akan diselenggarakan pada :</p>
            </div>

            <div class="section aligned">
                <p>
                    <span class="label">Hari/Tgl</span><span>:</span><span>{{ $meetDate }}</span>
                </p>
                <p>
                    <span class="label">Waktu</span><span>:</span><span>{{ $meetingTime }}</span>
                </p>
                <p>
                    <span class="label">Tempat</span><span>:</span><span>Ruang Rapat {{ $meetingLocation }} Kantor PT. CMNP Tbk<br>
                    Jalan Yos Sudarso Kav.28 Jakarta 14350</span>
                </p>
                <p>
                    <span class="label">Agenda</span><span>:</span><span>Rapat Penjelasan Teknis (Aanwijzing) @if ($tender->schedule_type == '1')
                        dan Klarifikasi serta Negosiasi Kewajaran Harga
                    @endif</span>
                </p>
            </div>

            <div class="section">
                <p>Adapun anggota pendukung lainnya bisa turut hadir secara <span class="bold">Daring Melalui Aplikasi Zoom Meeting</span> dengan Zoom ID : <span class="bold">{{ $zoomId }}</span> dan Passcode : <span class="bold">{{ $zoomPass }}</span>.</p>
                <p>Demikian undangan ini kami sampaikan atas perhatian dan partisipasinya diucapkan terima kasih.</p>
            </div>

            <div class="signature">
                <p>Hormat kami,</p>
                <br>
                <br>
                <br>
                <p class="bold underline no-margin">{{ ucwords(strtolower($leadInvitationName)) }}</p>
                <p class="no-margin">{{ ucwords(strtolower($leadInvitationPosition)) }} PPKH</p>
            </div>
        </div>
    </div>
@endforeach
</body>
</html>
