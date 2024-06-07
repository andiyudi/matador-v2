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
                @if($negotiationCount > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Vendor</th>
                                <th>Pengambilan Dokumen</th>
                                <th>Aanwijzing</th>
                                <th>Penawaran Harga</th>
                                <th>Hasil Negosiasi</th>
                            </tr>
                        </thead>
                        @foreach($businessPartners as $businessPartner)
                            <tbody>
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $businessPartner->partner->name }}</td>
                                    <td>{{ $businessPartner->pivot->document_pickup }}</td>
                                    <td>{{ $businessPartner->pivot->aanwijzing_date }}</td>
                                    @if($businessPartner->pivot->quotation == 0 && $businessPartner->negotiations->pluck('nego_price')->contains(0))
                                        <td colspan="2" class="text-center"><span class="badge rounded-pill text-bg-danger">GUGUR</span></td>
                                    @else
                                        <td>Rp. {{ number_format($businessPartner->pivot->quotation, 0, ',', '.') }}</td>
                                        <td>
                                            @php
                                                $negoPrices = $businessPartner->negotiations->pluck('nego_price')->sortDesc()->map(function($price) {
                                                    return 'Rp. ' . number_format($price, 0, ',', '.');
                                                })->implode('<br>');
                                            @endphp
                                            {!! $negoPrices !!}
                                        </td>
                                    @endif
                                </tr>
                            </tbody>
                        @endforeach
                    </table>
                    <br>
                    <h3>Hasil negosiasi terendah incl. PPN adalah sebesar Rp. {{ number_format($minNegoPrice, 0, ',', '.') }}</h3>
                    <p>Atas nama vendor:</p>
                    <ul>
                        @foreach($businessPartnersNames as $name)
                            <li>{{ $name }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@include('offer.negotiation.modal')
@include('offer.negotiation.script')
@endsection
@push('page-action')
@if($negotiationCount == 0)
<a href="{{ route('negotiation.create', $tender->id) }}" class="btn btn-primary mb-3">Add Negotiation Data</a>
@else
@if(!$multipleBusinessPartners)
{{-- <a href="{{ route('negotiation.show', $tender->id) }}" class="btn btn-info mb-3" target="_blank">Print</a> --}}
<button type="button" class="btn btn-info mb-3" data-bs-toggle="modal" data-bs-target="#printNegotiation" data-tender="{{ json_encode($tender) }}">Print</button>
@endif
<a href="{{ route('negotiation.edit', $tender->id) }}" class="btn btn-warning mb-3">Edit</a>
<form action="{{ route('negotiation.destroy', $tender->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this data?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger mb-3">Delete</button>
</form>
@endif
@endpush
