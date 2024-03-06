@extends('layouts.template')
@section('content')
@php
$pretitle = 'Tender '. $tender->procurement->name;
$title    = 'Edit Data Negotiation '. $tender->procurement->number;
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('negotiation.update', $tender->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <table class="table table-responsive table-bordered table-striped table-hover" id="negotiation-table" width="100%">
                        <thead>
                            <tr>
                                <th>Nama Vendor</th>
                                <th>Pengambilan Dokumen</th>
                                <th>Aanwijzing</th>
                                <th>Penawaran Harga</th>
                                <th>Hasil Negosiasi</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @foreach($tender->businessPartners as $businessPartner)
                        @php
                            $negotiations = $businessPartner->negotiations->sortBy('id');
                        @endphp
                            @foreach ($negotiations as $index => $negotiation)
                                @if ($index === 0)
                                    <tbody>
                                        <tr>
                                            <td>{{ $businessPartner->partner->name }}</td>
                                            <td><input type="date" id="document_pickup_{{ $businessPartner->id }}" name="document_pickup_{{ $businessPartner->id }}" class="form-control" value="{{ $businessPartner->pivot->document_pickup }}"></td>
                                            <td><input type="date" id="aanwijzing_date_{{ $businessPartner->id }}" name="aanwijzing_date_{{ $businessPartner->id }}" class="form-control" value="{{ $businessPartner->pivot->aanwijzing_date }}"></td>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-text" id="basic-addon1">Rp.</span>
                                                    <input type="text" id="quotation_{{ $businessPartner->id }}" name="quotation_{{ $businessPartner->id }}" class="form-control currency" value="{{ number_format($businessPartner->pivot->quotation, 0, ',', '.') }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-text" id="basic-addon1">Rp.</span>
                                                    <input type="text" id="nego_price_{{ $businessPartner->id }}" name="nego_price[{{ $businessPartner->id }}][{{ $negotiation->id }}]" class="form-control currency" value="{{ number_format($negotiation->nego_price, 0, ',', '.') }}">
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm add-negotiation" data-business-partner-id="{{ $businessPartner->id }}">Tambah</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                @else
                                    <tbody>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-text" id="basic-addon1">Rp.</span>
                                                    <input type="text" id="nego_price_{{ $businessPartner->id }}" name="nego_price[{{ $businessPartner->id }}][{{ $negotiation->id }}]" class="form-control currency" value="{{ number_format($negotiation->nego_price, 0, ',', '.') }}">
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm remove-negotiation" data-business-partner-id="{{ $businessPartner->id }}">Hapus</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endif
                            @endforeach
                            <tbody class="additional-row" data-business-partner-id="{{ $businessPartner->id }}"></tbody>
                        @endforeach
                    </table>
                    <div class="d-grid gap-2 mt-3 d-md-flex justify-content-md-end">
                        <a type="button" href="{{ route('negotiation.index', $tender->id) }}" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-success" onclick="this.disabled=true; this.innerHTML='Processing...'; this.form.submit();">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // Event listener for "Tambah" button click
    $(document).ready(function() {
        // Event listener untuk tombol "Tambah"
        $(document).on('click', '.add-negotiation', function() {
            var businessPartnerId = $(this).data('business-partner-id');
            var newRow = '<tr>' +
                '<td colspan="4"></td>' +
                '<td>' +
                '<div class="input-group">' +
                '<span class="input-group-text" id="basic-addon1">Rp.</span>' +
                '<input type="text" name="nego_price[' + businessPartnerId + '][]" class="form-control currency" value="0">' +
                '</div>' +
                '</td>' +
                '<td>' +
                '<button type="button" class="btn btn-danger btn-sm remove-negotiation">Hapus</button>' +
                '</td>' +
                '</tr>';

            // Menambahkan baris baru pada tbody yang sesuai dengan business partner id
            $('tbody.additional-row[data-business-partner-id="' + businessPartnerId + '"]').append(newRow);
        });

    $(document).on('click', '.remove-negotiation', function() {
        $(this).closest('tr').remove();
    });

    $(document).on('input', '.currency', function() {
        // Hapus karakter selain digit dan koma
        const rawValue = this.value.replace(/[^\d,]/g, '');

        // Konversi nilai ke format mata uang
        const formattedValue = new Intl.NumberFormat('id-ID').format(Number(rawValue));

        // Setel nilai input yang sudah diformat
        this.value = formattedValue;
    });
});
</script>
@endsection
