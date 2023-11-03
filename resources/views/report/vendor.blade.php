<div class="tab-pane fade show active" id="vendorContent" role="tabpanel" aria-labelledby="vendorTab">
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="vendorStatus">Status Vendor:</label>
                <select class="form-select" id="vendorStatus" name="vendorStatus">
                    <option disabled selected>Pilih Status Vendor</option>
                    <option value="0">Registered</option>
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="period">Periode:</label>
                <div class="input-group input-daterange">
                    <input type="text" class="form-control" id="startDate" name="startDate" placeholder="Start Periode">
                    <span class="input-group-text">to</span>
                    <input type="text" class="form-control" id="endDate" name="endDate" placeholder="End Periode">
                </div>
            </div>
        </div>
    </div>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
        <button class="btn btn-secondary me-md-2" type="button" id="searchBtn">Search</button>
        <button class="btn btn-primary" type="button" id="printBtn" data-toggle="modal" data-target="#printModal">Print</button>
    </div>
    <iframe id="searchResults" src="" style="width: 100%; height: 500px; border: none;"></iframe>
</div>
<div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="printModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="printModalLabel">Data Pembuat dan Atasan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="printForm">
                    <div class="form-group">
                        <label for="creatorName">Nama Pembuat:</label>
                        <input type="text" class="form-control" id="creatorName" name="creatorName">
                    </div>
                    <div class="form-group">
                        <label for="creatorPosition">Jabatan Pembuat:</label>
                        <input type="text" class="form-control" id="creatorPosition" name="creatorPosition">
                    </div>
                    <div class="form-group">
                        <label for="supervisorName">Nama Atasan:</label>
                        <input type="text" class="form-control" id="supervisorName" name="supervisorName">
                    </div>
                    <div class="form-group">
                        <label for="supervisorPosition">Jabatan Atasan:</label>
                        <input type="text" class="form-control" id="supervisorPosition" name="supervisorPosition">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirmPrintBtn">Cetak</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var startDateInput = $('#startDate');
        var endDateInput = $('#endDate');

        startDateInput.datepicker({
            format: 'mm-yyyy',
            startView: 'months',
            minViewMode: 'months',
            autoclose:true,
        });

        endDateInput.datepicker({
            format: 'mm-yyyy',
            startView: 'months',
            minViewMode: 'months',
            autoclose:true,
            startDate: startDateInput.val()
        }).on('show', function() {
            $(this).datepicker('setStartDate', startDateInput.val());
        });

    $('#searchBtn').click(function() {
        var status = $('#vendorStatus').val();
        var fromDate = $('#startDate').val();
        var toDate = $('#endDate').val();

         // Validasi form
        if (status === null || fromDate === '' || toDate === '') {
        Swal.fire({
            icon: 'error',
            title: 'Failed',
            text: 'Please complete all fields',
        });
        return false;
    }

        var url = "{{ route('report.vendor') }}?statusVendor=" + status + "&startDate=" + fromDate + "&endDate=" + toDate;
        $('#searchResults').attr('src', url);
    });

    $('#printBtn').click(function() {
        $('#printModal').modal('show');

    });
    $('#confirmPrintBtn').click(function () {
        var creatorName = $('#creatorName').val();
        var creatorPosition = $('#creatorPosition').val();
        var supervisorName = $('#supervisorName').val();
        var supervisorPosition = $('#supervisorPosition').val();
        var url = $('#searchResults').attr('src');

         // Validasi form
        if (creatorName === '' || creatorPosition === '' || supervisorName === '' || supervisorPosition === '') {
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'Please complete all fields',
            });
            return false;
        }

        if (url) {
            url += '&creatorName=' + encodeURIComponent(creatorName);
            url += '&creatorPosition=' + encodeURIComponent(creatorPosition);
            url += '&supervisorName=' + encodeURIComponent(supervisorName);
            url += '&supervisorPosition=' + encodeURIComponent(supervisorPosition);
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
                    $('#printModal').modal('hide');
                    $('#printForm')[0].reset();
                    location.reload();
                }
            });
        }
    });
});
</script>

