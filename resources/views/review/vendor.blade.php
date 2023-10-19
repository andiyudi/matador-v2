<div class="tab-pane fade show active" id="vendorContent" role="tabpanel" aria-labelledby="vendorTab">
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="period">Periode:</label>
                <div class="input-group input-daterange">
                    <input type="text" class="form-control" id="startDateVendor" name="startDateVendor" placeholder="Start Periode">
                    <span class="input-group-text">to</span>
                    <input type="text" class="form-control" id="endDateVendor" name="endDateVendor" placeholder="End Periode">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button class="btn btn-secondary me-md-2" type="button" id="searchBtnVendor">Search</button>
                    <button class="btn btn-primary" type="button" id="printBtnVendor" data-toggle="modal" data-target="#printModalVendor">Print</button>
                </div>
            </div>
        </div>
    </div>
    <iframe id="searchResultsVendor" src="" style="width: 100%; height: 500px; border: none;"></iframe>
</div>
<div class="modal fade" id="printModalVendor" tabindex="-1" role="dialog" aria-labelledby="printModalVendorLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="printModalVendorLabel">Data Pembuat dan Atasan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="printFormVendor">
                    <div class="form-group">
                        <label for="creatorNameVendor">Nama Pembuat:</label>
                        <input type="text" class="form-control" id="creatorNameVendor" name="creatorNameVendor">
                    </div>
                    <div class="form-group">
                        <label for="creatorPositionVendor">Jabatan Pembuat:</label>
                        <input type="text" class="form-control" id="creatorPositionVendor" name="creatorPositionVendor">
                    </div>
                    <div class="form-group">
                        <label for="supervisorNameVendor">Nama Atasan:</label>
                        <input type="text" class="form-control" id="supervisorNameVendor" name="supervisorNameVendor">
                    </div>
                    <div class="form-group">
                        <label for="supervisorPositionVendor">Jabatan Atasan:</label>
                        <input type="text" class="form-control" id="supervisorPositionVendor" name="supervisorPositionVendor">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirmPrintBtnVendor">Cetak</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var startDateVendorInput = $('#startDateVendor');
        var endDateVendorInput = $('#endDateVendor');

        startDateVendorInput.datepicker({
            format: 'yyyy',
            startView: 'years',
            minViewMode: 'years',
            autoclose:true,
        });

        endDateVendorInput.datepicker({
            format: 'yyyy',
            startView: 'years',
            minViewMode: 'years',
            autoclose:true,
            startDate: startDateVendorInput.val()
        }).on('show', function() {
            $(this).datepicker('setStartDate', startDateVendorInput.val());
        });

    $('#searchBtnVendor').click(function() {
        var fromDateVendor = $('#startDateVendor').val();
        var toDateVendor = $('#endDateVendor').val();

         // Validasi form
        if (fromDateVendor === '' || toDateVendor === '') {
        Swal.fire({
            icon: 'error',
            title: 'Failed',
            text: 'Please complete all fields',
        });
        return false;
    }

        var url = "{{ route('review.vendor') }}?startDateVendor=" + fromDateVendor + "&endDateVendor=" + toDateVendor;
        $('#searchResultsVendor').attr('src', url);
    });

    $('#printBtnVendor').click(function() {
        $('#printModalVendor').modal('show');

    });
    $('#confirmPrintBtnVendor').click(function () {
        var creatorNameVendor = $('#creatorNameVendor').val();
        var creatorPositionVendor = $('#creatorPositionVendor').val();
        var supervisorNameVendor = $('#supervisorNameVendor').val();
        var supervisorPositionVendor = $('#supervisorPositionVendor').val();
        var url = $('#searchResultsVendor').attr('src');

         // Validasi form
        if (creatorNameVendor === '' || creatorPositionVendor === '' || supervisorNameVendor === '' || supervisorPositionVendor === '') {
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'Please complete all fields',
            });
            return false;
        }

        if (url) {
            url += '&creatorNameVendor=' + encodeURIComponent(creatorNameVendor);
            url += '&creatorPositionVendor=' + encodeURIComponent(creatorPositionVendor);
            url += '&supervisorNameVendor=' + encodeURIComponent(supervisorNameVendor);
            url += '&supervisorPositionVendor=' + encodeURIComponent(supervisorPositionVendor);
            Swal.fire({
                title: 'Print Confirmation',
                text: 'Are you sure you want to print?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Print',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    var printWindow = window.open(url, '_blank');
                    printWindow.print();
                    $('#printModalVendor').modal('hide');
                    $('#printFormVendor')[0].reset();
                    location.reload();
                }
            });
        }
    });
});
</script>
