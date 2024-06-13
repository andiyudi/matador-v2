<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Negotiation</title>
    @include('offer.negotiation.style')
</head>
<body>
    <div class="container">
        <h4>Laporan Hasil Negosiasi</h4>
        <p>Bersama ini kami laporkan hasil negosiasi <strong>{{ ucwords(strtolower($tender->procurement->name)) }}</strong> PT Citra Marga Nusaphala Persada Tbk dengan No. PP: {{ $tender->procurement->number }} sebagai berikut:</p>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Vendor</th>
                    <th>Pengambilan Dokumen</th>
                    <th>Aanwijzing</th>
                    <th>Penawaran Harga Incl. PPN (Rp)</th>
                    <th colspan="3">Hasil Negosiasi (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($businessPartners as $index => $businessPartner)
                    @php
                        $negoPrices = $businessPartner->negotiations->pluck('nego_price')->sortDesc()->map(function($price) {
                            return 'Rp.' . number_format($price, 0, ',', '.') . ',-';
                        });

                        $chunks = $negoPrices->chunk(3);
                        $rowspan = $chunks->count() * 2
                    @endphp

                    <tr>
                        <td rowspan="{{ $rowspan }}">{{ $loop->iteration }}.</td>
                        <td rowspan="{{ $rowspan }}" style="text-align: left">{{ $businessPartner->partner->name }}</td>
                        <td rowspan="{{ $rowspan }}">{{ Carbon\Carbon::parse($businessPartner->pivot->document_pickup)->format('d-m-Y') }}</td>
                        <td rowspan="{{ $rowspan }}">{{ Carbon\Carbon::parse($businessPartner->pivot->aanwijzing_date)->format('d-m-Y') }}</td>
                        <td rowspan="{{ $rowspan }}">Rp.{{ number_format($businessPartner->pivot->quotation, 0, ',', '.') }},-</td>

                        @if($businessPartner->pivot->quotation == 0 || $businessPartner->negotiations->contains('nego_price', 0))
                            <td colspan="3">GUGUR</td>
                        @else
                            @foreach ($chunks->first() as $priceIndex => $price)
                                <td>Ke {{ $priceIndex + 1 }}</td> <!-- Menambahkan label Ke-n -->
                            @endforeach

                            @for ($i = $chunks->first()->count(); $i < 3; $i++)
                                <td>-</td>
                            @endfor
                        @endif
                    </tr>

                    <tr>
                        @if(!($businessPartner->pivot->quotation == 0 || $businessPartner->negotiations->contains('nego_price', 0)))
                            @foreach ($chunks->first() as $price)
                                <td>{{ $price }}</td>
                            @endforeach

                            @for ($i = $chunks->first()->count(); $i < 3; $i++)
                                <td>-</td>
                            @endfor
                        @endif
                    </tr>

                    @foreach ($chunks->slice(1) as $chunkIndex => $chunk)
                        <tr>
                            @for ($i = 1; $i <= 3; $i++)
                                <td>Ke {{ ($chunkIndex * 3) + $i }}</td> <!-- Menambahkan label Ke-n -->
                            @endfor
                        </tr>
                        <tr>
                            @foreach ($chunk as $price)
                                <td>{{ $price }}</td>
                            @endforeach

                            @for ($i = $chunk->count(); $i < 3; $i++)
                                <td>-</td>
                            @endfor
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>

        <p>Hasil negosiasi terendah incl. PPN adalah sebesar Rp. {{ number_format($minNegoPrice, 0, ',', '.') }},- atas nama Kontraktor <strong>{{ $businessPartnerWithMinNegoPrice }}</strong></p>
        <p>Mengingat hasil negosiasi masih belum mendekati dengan acuan harga yang ada maka perlu mencari vendor lain dan proses pengadaan ulang diantaranya:</p>

        <table>
            <thead>
                <tr>
                    <th rowspan="2">No.</th>
                    <th rowspan="2">Nama Vendor</th>
                    <th rowspan="2">Pengambilan Dokumen</th>
                    <th rowspan="2">Aanwijzing</th>
                    <th rowspan="2">Penawaran Harga Incl. PPN (Rp)</th>
                    <th colspan="3">Hasil Negosiasi (Rp)</th>
                </tr>
                <tr>
                    <th>Ke 1</th>
                    <th>Ke 2</th>
                    <th>Ke 3</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <p>Hasil negosiasi terendah dari Pengadaan Barang & Jasa tahap II adalah sebesar Rp ……………..…………….. atas nama Kontraktor PT ……………..……………..</p>

        <div class="content">
            <p>Demikian hasil negosiasi ini disampaikan dan bersama ini pula kami lampirkan:</p>
            <ol>
                <li>Notulen Aanwijzing</li>
                <li>Penawaran harga dari masing-masing vendor</li>
                <li>Notulen negosiasi dari masing-masing vendor</li>
            </ol>

            <div class="footer">
                <p>Jakarta, {{ $formattedDate }}</p>
                <br>
                <br>
                <p>({{ ucwords(strtolower($leadName)) }})</p>
                <p><strong>{{ $leadPosition }} PPKH</strong></p>
            </div>
        </div>
    </div>
</body>
</html>
