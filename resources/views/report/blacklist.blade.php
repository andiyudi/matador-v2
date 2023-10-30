<div class="tab-pane fade" id="blacklistContent" role="tabpanel" aria-labelledby="blacklistTab">
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="period">Periode:</label>
                <div class="input-group input-daterange">
                    <input type="text" class="form-control" id="startDateBlacklist" name="startDateBlacklist" placeholder="Start Periode">
                    <span class="input-group-text">to</span>
                    <input type="text" class="form-control" id="endDateBlacklist" name="endDateBlacklist" placeholder="End Periode">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button class="btn btn-secondary me-md-2" type="button" id="searchBtnBlacklist">Search</button>
                    <button class="btn btn-primary" type="button" id="printBtnBlacklist" data-toggle="modal" data-target="#printModalBlacklist">Print</button>
                </div>
            </div>
        </div>
    </div>
    <iframe id="searchResultsBlacklist" src="" style="width: 100%; height: 500px; border: none;"></iframe>
</div>
<div class="modal fade" id="printModalBlacklist" tabindex="-1" role="dialog" aria-labelledby="printModalBlacklistLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="printModalBlacklistLabel">Data Pembuat dan Atasan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="printFormBlacklist">
                    <div class="form-group">
                        <label for="creatorNameBlacklist">Nama Pembuat:</label>
                        <input type="text" class="form-control" id="creatorNameBlacklist" name="creatorNameBlacklist">
                    </div>
                    <div class="form-group">
                        <label for="creatorPositionBlacklist">Jabatan Pembuat:</label>
                        <input type="text" class="form-control" id="creatorPositionBlacklist" name="creatorPositionBlacklist">
                    </div>
                    <div class="form-group">
                        <label for="supervisorNameBlacklist">Nama Atasan:</label>
                        <input type="text" class="form-control" id="supervisorNameBlacklist" name="supervisorNameBlacklist">
                    </div>
                    <div class="form-group">
                        <label for="supervisorPositionBlacklist">Jabatan Atasan:</label>
                        <input type="text" class="form-control" id="supervisorPositionBlacklist" name="supervisorPositionBlacklist">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirmPrintBtnBlacklist">Cetak</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var startDateBlacklistInput = $('#startDateBlacklist');
        var endDateBlacklistInput = $('#endDateBlacklist');

        startDateBlacklistInput.datepicker({
            format: 'mm-yyyy',
            startView: 'months',
            minViewMode: 'months',
            autoclose:true,
        });

        endDateBlacklistInput.datepicker({
            format: 'mm-yyyy',
            startView: 'months',
            minViewMode: 'months',
            autoclose:true,
            startDate: startDateBlacklistInput.val()
        }).on('show', function() {
            $(this).datepicker('setStartDate', startDateBlacklistInput.val());
        });

    $('#searchBtnBlacklist').click(function() {
        var fromDateBlacklist = $('#startDateBlacklist').val();
        var toDateBlacklist = $('#endDateBlacklist').val();

         // Validasi form
        if (fromDateBlacklist === '' || toDateBlacklist === '') {
        Swal.fire({
            icon: 'error',
            title: 'Failed',
            text: 'Please complete all fields',
        });
        return false;
    }

        var url = "{{ route('report.blacklist') }}?startDateBlacklist=" + fromDateBlacklist + "&endDateBlacklist=" + toDateBlacklist;
        $('#searchResultsBlacklist').attr('src', url);
    });

    $('#printBtnBlacklist').click(function() {
        $('#printModalBlacklist').modal('show');

    });
    $('#confirmPrintBtnBlacklist').click(function () {
        var creatorNameBlacklist = $('#creatorNameBlacklist').val();
        var creatorPositionBlacklist = $('#creatorPositionBlacklist').val();
        var supervisorNameBlacklist = $('#supervisorNameBlacklist').val();
        var supervisorPositionBlacklist = $('#supervisorPositionBlacklist').val();
        var url = $('#searchResultsBlacklist').attr('src');

         // Validasi form
        if (creatorNameBlacklist === '' || creatorPositionBlacklist === '' || supervisorNameBlacklist === '' || supervisorPositionBlacklist === '') {
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'Please complete all fields',
            });
            return false;
        }

        if (url) {
            url += '&creatorNameBlacklist=' + encodeURIComponent(creatorNameBlacklist);
            url += '&creatorPositionBlacklist=' + encodeURIComponent(creatorPositionBlacklist);
            url += '&supervisorNameBlacklist=' + encodeURIComponent(supervisorNameBlacklist);
            url += '&supervisorPositionBlacklist=' + encodeURIComponent(supervisorPositionBlacklist);
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
                    $('#printModalBlacklist').modal('hide');
                    $('#printFormBlacklist')[0].reset();
                    location.reload();
                }
            });
        }
    });
});
</script>
