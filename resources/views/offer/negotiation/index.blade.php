@extends('layouts.template')
@section('content')
@php
$pretitle = 'Tender '. $tender->procurement->name;
$title    = 'Negotiation '. $tender->procurement->number;
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama Vendor</th>
                                <th>Pengambilan Dokumen</th>
                                <th>Aanwijzing</th>
                                <th>Penawaran Harga</th>
                                <th>Hasil Negosiasi</th>
                            </tr>
                        </thead>
                        {{-- @foreach($tender->negotiations as $negotiation)
                            <tbody>
                                <tr>
                                    <td>{{ $negotiation->businessPartner->partner->name }}</td>
                                    <td>{{ $negotiation->document_pickup }}</td>
                                    <td>{{ $negotiation->aanwijzing }}</td>
                                    <td>Rp. {{ number_format($negotiation->quotation, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($negotiation->nego_price, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        @endforeach --}}
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('page-action')
<a href="{{ route('negotiation.create', $tender->id) }}" class="btn btn-primary mb-3">Add Negotiation Data</a>
@endpush
