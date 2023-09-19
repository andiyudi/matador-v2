<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aanwijzing</title>
</head>
<body>
<center>
    <h3>
        BERITA ACARA<br>
        RAPAT PENJELASAN TEKNIS<br>
        {{ strtoupper($tender->procurement->name) }}<br>
        <br>
    </h3>
    <p>
        NOMOR : {{ $number }}<br>
        <hr>
    </p>
</center>
<p>Pada hari ini {{ $day }} tanggal {{ ucwords($tanggal) }} bulan {{ $bulan }} tahun {{ ucwords($tahun) }} &#40;{{ $formattedDate }}&#41; telah diadakan rapat Penjelasan Teknis &#40;<i>Aanwijzing</i>&#41;, bertempat di ruang rapat PT CMNP Tbk, Jalan Yos Sudarso Kav.28 Sunter Jakarta Utara, untuk :</p>
</body>
</html>
