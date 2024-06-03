<div class="peserta-rapat">
    <table width="100%">
        <thead>
            <tr style="text-align: center">
                <th width="2%">No</th>
                <th width="10%">Nama Vendor / Mitra Kerja</th>
                <th width="15%">Nama Pekerjaan</th>
                <th width="4%">No PP</th>
                <th width="3%">Divisi</th>
                <th width="6%">PIC Pengadaan</th>
                <th width="7%">Tanggal Persetujuan Direksi</th>
                <th>Nilai Kontrak / Purchase Order</th>
                <th>No. Purchase Order</th>
                <th>No. Kontrak / Purchase Order</th>
                <th>Jangka Waktu Pekerjaan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($procurements as $procurement)
                <tr style="text-align: center">
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @php
                            $selectedVendorName = null;
                            foreach ($procurement->tenders as $tender) {
                                $selectedVendor = $tender->businessPartners->first(function ($businessPartner) {
                                    return $businessPartner->pivot->is_selected === '1';
                                });
                                if ($selectedVendor) {
                                    $selectedVendorName = $selectedVendor->partner->name;
                                    break;
                                }
                            }
                        @endphp
                        {{ $selectedVendorName ?? 'No vendor selected' }}
                    </td>
                    <td style="text-align: left">{{ $procurement->name ?? '-' }}</td>
                    <td>{{ $procurement->number ?? '-' }}</td>
                    <td>{{ $procurement->division->code ?? '-' }}</td>
                    <td>{{ $procurement->official->initials ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($procurement->director_approval)->format('d-M-Y') ?? '-' }}</td>
                    <td style="text-align: right">{{ number_format($procurement->contract_value, 0, ',', '.') ?? '-' }}</td>
                    <td>{{ $procurement->op_number ?? '-' }}</td>
                    <td>{{ $procurement->contract_number ?? '-' }}</td>
                    <td>{{ $procurement->estimation ?? '-' }}</td>
                </tr>
            @endforeach
                <tr style="text-align: center; font-weight: bold">
                    <td colspan="3">TOTAL PP</td>
                    <td></td>
                    <td>{{ $procurements->count() }}</td>
                    <td>BERKAS</td>
                    <td></td>
                    <td style="text-align: right">{{ number_format($procurements->sum('contract_value'), 0, ',', '.')?? '-' }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
        </tbody>
    </table>
    <br>
</div>
