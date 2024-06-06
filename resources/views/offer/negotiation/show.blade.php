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
        <p>Bersama ini kami laporkan hasil negosiasi {{ ucwords(strtolower($tender->procurement->name)) }} PT Citra Marga Nusaphala Persada Tbk dengan No. PP: {{ $tender->procurement->number }} sebagai berikut:</p>

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
                @foreach ($businessPartners as $index => $businessPartner)
                    {{-- Menampilkan header tambahan sebelum data kedua --}}
                    @if($index != 0)
                        <tr>
                            <th colspan="5"></th>
                            <th>Ke 1</th>
                            <th>Ke 2</th>
                            <th>Ke 3</th>
                        </tr>
                    @endif
                    <tr>
                        <td>{{ $loop->iteration }}.</td>
                        <td style="text-align: left">{{ $businessPartner->partner->name }}</td>
                        <td>{{ Carbon\Carbon::parse($businessPartner->pivot->document_pickup)->format('d-m-Y') }}</td>
                        <td>{{ Carbon\Carbon::parse($businessPartner->pivot->aanwijzing_date)->format('d-m-Y') }}</td>
                        <td>Rp.{{ number_format($businessPartner->pivot->quotation, 0, ',', '.') }},-</td>
                        @if($businessPartner->pivot->quotation == 0 && $businessPartner->negotiations->pluck('nego_price')->contains(0))
                            <td colspan="3">GUGUR</td>
                        @else
                            @php
                                $negoPrices = $businessPartner->negotiations->pluck('nego_price')->sortDesc()->map(function($price) {
                                    return 'Rp.' . number_format($price, 0, ',', '.') . ',-';
                                });
                            @endphp
                            @foreach ($negoPrices->take(3) as $price)
                                <td>{{ $price }}</td>
                            @endforeach
                            {{-- Tambahkan kolom kosong jika kurang dari 3 harga --}}
                            @for ($i = $negoPrices->count(); $i < 3; $i++)
                                <td>-</td>
                            @endfor
                        @endif
                    </tr>
                    @if($businessPartner->pivot->quotation != 0 && $businessPartner->negotiations->pluck('nego_price')->contains(0))
                    <tr>
                        <td colspan="5"></td>
                        <td>Ke 4</td>
                        <td>Ke 5</td>
                        <td>Ke 6</td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                        @for ($i = 4; $i <= 6; $i++)
                            <td>-</td>
                        @endfor
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <p>Hasil negosiasi terendah incl. PPN adalah sebesar Rp. {{ number_format($minNegoPrice, 0, ',', '.') }},- atas nama Kontraktor {{ $businessPartnersNames[0] }}</p>
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
                    <td>Ke 1</td>
                    <td>Ke 2</td>
                    <td>Ke 3</td>
                </tr>
            </thead>
            <tbody>
                <!-- Add new vendor rows similarly -->
            </tbody>
        </table>

        <p>Hasil negosiasi terendah dari Pengadaan Barang & Jasa tahap II adalah sebesar Rp ……………..…………….. atas nama Kontraktor PT ……………..……………..</p>

        <p>Demikian hasil negosiasi ini disampaikan dan bersama ini pula kami lampirkan:</p>
        <ol>
            <li>Notulen Aanwijzing</li>
            <li>Penawaran harga dari masing-masing vendor</li>
            <li>Notulen negosiasi dari masing-masing vendor</li>
        </ol>

        <div class="footer">
            <p>Jakarta, 14 September 2023</p>
            <p>(Rangga Nopara)</p>
            <p>TIM PPKH</p>
        </div>
    </div>
</body>
</html>
