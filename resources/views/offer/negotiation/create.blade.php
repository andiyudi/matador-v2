@extends('layouts.template')
@section('content')
@php
$pretitle = 'Tender '. $tender->procurement->name;
$title    = 'Create Data Negotiation '. $tender->procurement->number;
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('negotiation.store', $tender->id) }}" method="POST">
                    @csrf
                    <table class="table">
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
                        <tbody>
                            @foreach($tender->businessPartners as $businessPartner)
                            <tr>
                                <td>{{ $businessPartner->partner->name }}</td>
                                <td><input type="date" id="document_pickup_{{ $businessPartner->id }}" name="document_pickup_{{ $businessPartner->id }}" class="form-control"></td>
                                <td><input type="date" id="aanwijzing_{{ $businessPartner->id }}" name="aanwijzing_{{ $businessPartner->id }}" class="form-control"></td>
                                <td><input type="text" id="quotation_{{ $businessPartner->id }}" name="quotation_{{ $businessPartner->id }}" class="form-control"></td>
                                <td><input type="text" id="negotiation_result_{{ $businessPartner->id }}" name="negotiation_result_{{ $businessPartner->id }}" class="form-control"></td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm add-negotiation" data-business-partner-id="{{ $businessPartner->id }}">Tambah</button>
                                </td>
                            </tr>
                            <tr style="display:none;">
                                <!-- Hidden row to store cloned columns -->
                                <td></td> <!-- Nama Vendor -->
                                <td></td> <!-- Pengambilan Dokumen -->
                                <td></td> <!-- Aanwijzing -->
                                <td></td> <!-- Penawaran Harga -->
                                <td>
                                    <input type="text" id="negotiation_result_{{ $businessPartner->id }}" name="negotiation_result_{{ $businessPartner->id }}" class="form-control"> <!-- Input for Hasil Negosiasi -->
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm remove-negotiation">Hapus</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-grid gap-2 mt-3 d-md-flex justify-content-md-end">
                        <a type="button" href="{{ route('negotiation.index', $tender->id) }}" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // Event listener for "Tambah" button click
    $(document).on('click', '.add-negotiation', function() {
        var businessPartnerId = $(this).data('business-partner-id');
        var clonedRow = $(this).closest('tr').next('tr').clone();
        clonedRow.show();
        $(this).closest('tr').after(clonedRow);
    });

    // Event listener for "Hapus" button click
    $(document).on('click', '.remove-negotiation', function() {
        $(this).closest('tr').hide();
    });
    </script>
{{-- <script>
    // Function to add negotiation input field
function addNegotiationInput(businessPartnerId) {
      // Find the row corresponding to the business partner id
    var targetRow = $('table tbody tr').filter(function() {
        return $(this).find('.add-negotiation').data('business-partner-id') == businessPartnerId;
    });

    // Clone the found row
    var newRow = targetRow.clone();
    // Clear input values in the new row
    newRow.find('input').val('');

    // Change button text to "Hapus"
    newRow.find('.add-negotiation').removeClass('btn-success').addClass('btn-danger').text('Hapus');

    // Append the new row after the row with the corresponding business partner id
    $('table tbody tr').each(function(index, element) {
        var currentBusinessPartnerId = $(this).find('.add-negotiation').data('business-partner-id');
        if (currentBusinessPartnerId == businessPartnerId) {
            $(this).after(newRow);
        }
    });

    // Change the function of the button to removeNegotiationInput
    newRow.find('.add-negotiation').removeClass('add-negotiation').addClass('remove-negotiation');

    // Change the click event to removeNegotiationInput function
    newRow.find('.remove-negotiation').on('click', function() {
        removeNegotiationInput($(this));
    });
}

// Function to remove negotiation input field
function removeNegotiationInput(button) {
    // Find the parent row and remove it
    button.closest('tr').remove();
}

// Event listener for "Tambah" button click
$(document).on('click', '.add-negotiation', function() {
    var businessPartnerId = $(this).data('business-partner-id');
    addNegotiationInput(businessPartnerId);
});

// Event listener for "Hapus" button click
$(document).on('click', '.remove-negotiation', function() {
    removeNegotiationInput($(this));
});

</script> --}}
@endsection
