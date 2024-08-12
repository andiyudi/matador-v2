<div class="peserta-rapat">
    <table width="100%">
        <thead>
            <tr>
                <th rowspan="2" style="text-align: center;" width="3%">No</th>
                <th rowspan="2" style="text-align: center;" width="7%">TTPP</th>
                <th rowspan="2" style="text-align: center;" width="5%">No PP</th>
                <th rowspan="2" style="text-align: center;" width="20%">Nama Pekerjaan</th>
                <th rowspan="2" style="text-align: center;" width="3%">Divisi</th>
                <th rowspan="2" style="text-align: center;" width="6%">PIC Pengadaan</th>
                <th colspan="2" style="text-align: center;" width="19%">Nilai PP</th>
                <th rowspan="2" style="text-align: center;" width="8%">Tgl Pengembalian Ke User</th>
                <th rowspan="2" style="text-align: center;">Tgl Memo Pembatalan</th>
                <th rowspan="2" style="text-align: center;">Keterangan</th>
            </tr>
            <tr>
                <th>EE User</th>
                <th>EE Teknik</th>
            </tr>
        </thead>
        <tbody>
            @forelse($procurements as $procurement)
                <tr style="text-align: center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $procurement->receipt ? date('d-M-Y', strtotime($procurement->receipt)) : '' }}</td>
                    <td>{{ $procurement->number }}</td>
                    <td style="text-align: left;">{{ $procurement->name }}</td>
                    <td>{{ $procurement->division->code }}</td>
                    <td>{{ $procurement->official->initials }}</td>
                    <td style="text-align: right;">
                        @if ($procurement->user_estimate !== null)
                            @if (fmod($procurement->user_estimate, 1) == 0)
                                {{ number_format($procurement->user_estimate, 0, ',', '.') }}
                            @else
                                {{ number_format($procurement->user_estimate, 2, ',', '.') }}
                            @endif
                        @endif
                    </td>
                    <td style="text-align: right;">
                        @if ($procurement->technique_estimate !== null)
                            @if (fmod($procurement->technique_estimate, 1) == 0)
                                {{ number_format($procurement->technique_estimate, 0, ',', '.') }}
                            @else
                                {{ number_format($procurement->technique_estimate, 2, ',', '.') }}
                            @endif
                        @endif
                    </td>
                    <td>{{ $procurement->return_to_user ? date('d-M-Y', strtotime($procurement->return_to_user)) : '' }}</td>
                    <td>{{ $procurement->cancellation_memo }}</td>
                    <td>{{ $procurement->information }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" style="text-align: center;">Data tidak ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
