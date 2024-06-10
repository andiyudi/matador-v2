@extends('layouts.template')
@section('content')
@php
$pretitle = 'Data';
$title    = 'Evaluation';
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-responsive table-bordered table-striped table-hover" id="evaluation-table" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Procurement</th>
                            <th>Job Name</th>
                            <th>Division</th>
                            <th>Estimation</th>
                            <th>PIC User</th>
                            <th>Vendors</th>
                            <th>Pick Vendor</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--data displayed here-->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="determinationModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="determinationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="printFormDetermination">
                <div class="modal-header">
                    <h5 class="modal-title" id="determinationModalLabel">Surat Penetapan Menang dan Kalah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="determinationNumber" class="form-label">Number</label>
                            <input type="text" id="determinationNumber" name="determinationNumber" class="form-control" data-mask="****/Peng-PPKH-CMNP/****/****" data-mask-visible="true" placeholder="****/Peng-PPKH-CMNP/****/****" autocomplete="off">
                        </div>
                        <div class="col mb-3">
                            <label for="determinationDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="determinationDate" name="determinationDate" placeholder="Enter determination date" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="selectDeterminationLeadName" class="form-label">Creator Name</label>
                            <select name="selectDeterminationLeadName" id="selectDeterminationLeadName" class="form-select">
                                <option value=""></option>
                            </select>
                            <input type="hidden" class="form-control" id="leadDeterminationName" name="leadDeterminationName" value="">
                        </div>
                        <div class="col mb-3">
                            <label for="leadDeterminationPosition" class="form-label">Lead Position</label>
                            <select name="leadDeterminationPosition" id="leadDeterminationPosition" class="form-select" required>
                                <option value="TIM">TIM</option>
                                <option value="KETUA">KETUA</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Print</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#determinationModal').on('show.bs.modal', function(event) {
            var buttonDetermination = $(event.relatedTarget);
            var procurementData = buttonDetermination.data('procurement');
            var leadDeterminationNameSelect = $('#selectDeterminationLeadName');
            leadDeterminationNameSelect.empty();

            $.ajax({
                url: route("offer.official"),
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log("AJAX Response:", response); // Debugging: Log the response
                    $.each(response.data, function(index, official) {
                        leadDeterminationNameSelect.append($('<option>', {
                            value: official.id,
                            text: official.name,
                            selected: official.id == procurementData.official_id
                        }));
                    });
                    var selectedOfficialName = leadDeterminationNameSelect.find('option:selected').text();
                    $('#leadDeterminationName').val(selectedOfficialName);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });

            leadDeterminationNameSelect.on('change', function() {
                var leadDeterminationName = leadDeterminationNameSelect.find('option:selected').text();
                $('#leadDeterminationName').val(leadDeterminationName);
            });

            $('#printFormDetermination').submit(function(e) {
                e.preventDefault();
                var leadDeterminationName = $('#leadDeterminationName').val();
                var leadDeterminationPosition = $('#leadDeterminationPosition').val();
                var determinationNumber = $('#determinationNumber').val();
                var determinationDate = $('#determinationDate').val();
                var id = procurementData.id;

                var printUrl = route('evaluation.print', id) +
                    '?leadDeterminationName=' + encodeURIComponent(leadDeterminationName) +
                    '&leadDeterminationPosition=' + encodeURIComponent(leadDeterminationPosition) +
                    '&determinationNumber=' + encodeURIComponent(determinationNumber) +
                    '&determinationDate=' + encodeURIComponent(determinationDate);

                window.open(printUrl, '_blank');
                $('#determinationModal').modal('hide');
                $('#printFormDetermination')[0].reset();
                location.reload();
            });
        });
        $('#evaluation-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('evaluation.index') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'number', name: 'number' },
                { data: 'name', name: 'name' },
                { data: 'division', name: 'division' },
                { data: 'estimation', name: 'estimation' },
                { data: 'pic_user', name: 'pic_user' },
                { data: 'vendors', name: 'vendors' },
                { data: 'is_selected', name: 'is_selected' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection
