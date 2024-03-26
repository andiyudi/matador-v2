<div class="peserta-rapat">
    <table width="100%">
        <thead>
            <tr>
                <th rowspan="2" style="text-align: center; width: 2%">No</th>
                <th rowspan="2" style="text-align: center; width: 8%">TTPP</th>
                <th rowspan="2" style="text-align: center; width: 5%">No PP</th>
                <th rowspan="2" style="text-align: center; width: 20%">Nama Pekerjaan</th>
                <th rowspan="2" style="text-align: center; width: 4%">Divisi</th>
                <th rowspan="2" style="text-align: center; width: 7%">PIC Pengadaan</th>
                <th rowspan="2" style="text-align: center; width: 8%">Mitra Kerja / Vendor</th>
                <th colspan="3" style="text-align: center; width: 30%">Perbandingan Nilai PP</th>
                <th rowspan="2" style="text-align: center; width: 8%">Tgl Memo Ke Direksi</th>
                <th rowspan="2" style="text-align: center; width: 8%">Keterangan</th>
            </tr>
            <tr>
                <th>EE User</th>
                <th>EE Teknik</th>
                <th>Hasil Negosiasi</th>
            </tr>
        </thead>
        <tbody>
            @if(count($procurements) > 0)
            @foreach($procurements as $procurement)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                <td>{{ $procurement->number }}</td>
                <td>{{ $procurement->name }}</td>
                <td>{{ $procurement->division->code }}</td>
                <td>{{ $procurement->official->initials }}</td>
                <td>{{ $procurement->is_selected }}</td>
                <td>
                    @if ($procurement->user_estimate !== null)
                        {{ number_format($procurement->user_estimate, 0, '.', '.') }}
                    @endif
                </td>
                <td>
                    @if ($procurement->technique_estimate !== null)
                        {{ number_format($procurement->technique_estimate, 0, '.', '.') }}
                    @endif
                </td>
                <td>
                    @if ($procurement->deal_nego !== null)
                        {{ number_format($procurement->deal_nego, 0, '.', '.') }}
                    @endif
                </td>
                <td>{{ $procurement->latest_report_nego_result ? date('d-M-Y', strtotime($procurement->latest_report_nego_result)) : '' }}</td>
                <td>{{ $procurement->information }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="5"><strong>GRAND TOTAL</strong></td>
                <td colspan="7"><strong>{{ count($procurements) }} DOKUMEN</strong></td>
            </tr>
            @else
            <tr>
                <td colspan="12" style="text-align: center;"><h3>Data tidak ditemukan</h3></td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
