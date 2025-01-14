<div class="tab-pane fade" id="historyContent" role="tabpanel" aria-labelledby="historyTab">
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="inlineRadioOptions">Pilih Laporan:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="history_type" id="history_type_result" value="result">
                    <label class="form-check-label" for="history_type_result">
                        Result
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="history_type" id="history_type_recapitulation" value="recapitulation">
                    <label class="form-check-label" for="history_type_recapitulation">
                        Recapitulation
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="period">Periode:</label>
                <div class="input-group input-daterange">
                    <input type="text" class="form-control" id="startDateHistory" name="startDateHistory" placeholder="Start Periode">
                    <span class="input-group-text">to</span>
                    <input type="text" class="form-control" id="endDateHistory" name="endDateHistory" placeholder="End Periode">
                </div>
            </div>

        </div>
        <div class="form-group">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                <button class="btn btn-secondary me-md-2" type="button" id="searchBtnHistory">Search</button>
                <button class="btn btn-primary" type="button" id="printBtnHistory" data-toggle="modal" data-target="#printModalHistory">Print</button>
            </div>
        </div>
    </div>
    <iframe id="searchResultsHistory" src="" style="width: 100%; height: 500px; border: none;"></iframe>
</div>
<div class="modal fade" id="printModalHistory" tabindex="-1" role="dialog" aria-labelledby="printModalHistoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="printModalHistoryLabel">Data Pembuat dan Atasan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="printFormHistory">
                    <div class="form-group">
                        <label for="creatorNameHistory">Nama Pembuat:</label>
                        <input type="text" class="form-control" id="creatorNameHistory" name="creatorNameHistory">
                    </div>
                    <div class="form-group">
                        <label for="creatorPositionHistory">Jabatan Pembuat:</label>
                        <input type="text" class="form-control" id="creatorPositionHistory" name="creatorPositionHistory">
                    </div>
                    <div class="form-group">
                        <label for="supervisorNameHistory">Nama Atasan:</label>
                        <input type="text" class="form-control" id="supervisorNameHistory" name="supervisorNameHistory">
                    </div>
                    <div class="form-group">
                        <label for="supervisorPositionHistory">Jabatan Atasan:</label>
                        <input type="text" class="form-control" id="supervisorPositionHistory" name="supervisorPositionHistory">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirmPrintBtnHistory">Cetak</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var startDateHistoryInput = $('#startDateHistory');
        var endDateHistoryInput = $('#endDateHistory');

        startDateHistoryInput.datepicker({
            format: 'mm-yyyy',
            startView: 'months',
            minViewMode: 'months',
            autoclose:true,
        });

        endDateHistoryInput.datepicker({
            format: 'mm-yyyy',
            startView: 'months',
            minViewMode: 'months',
            autoclose:true,
            startDate: startDateHistoryInput.val()
        }).on('show', function() {
            $(this).datepicker('setStartDate', startDateHistoryInput.val());
        });

    $('#searchBtnHistory').click(function() {
        var fromDateHistory = $('#startDateHistory').val();
        var toDateHistory = $('#endDateHistory').val();
        var historyType = $('input[name="history_type"]:checked').val(); // Mengambil nilai radio button yang dipilih

         // Validasi form
        if (fromDateHistory === '' || toDateHistory === '' || !historyType) {
        Swal.fire({
            icon: 'error',
            title: 'Failed',
            text: 'Please complete all fields',
        });
        return false;
    }

        var url = "{{ route('report.history') }}?startDateHistory=" + fromDateHistory + "&endDateHistory=" + toDateHistory + "&history_type=" + historyType;
        $('#searchResultsHistory').attr('src', url);
    });

    $('#printBtnHistory').click(function() {
        $('#printModalHistory').modal('show');

    });
    $('#confirmPrintBtnHistory').click(function () {
        var creatorNameHistory = $('#creatorNameHistory').val();
        var creatorPositionHistory = $('#creatorPositionHistory').val();
        var supervisorNameHistory = $('#supervisorNameHistory').val();
        var supervisorPositionHistory = $('#supervisorPositionHistory').val();
        var url = $('#searchResultsHistory').attr('src');

         // Validasi form
        if (creatorNameHistory === '' || creatorPositionHistory === '' || supervisorNameHistory === '' || supervisorPositionHistory === '') {
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'Please complete all fields',
            });
            return false;
        }

        if (url) {
            url += '&creatorNameHistory=' + encodeURIComponent(creatorNameHistory);
            url += '&creatorPositionHistory=' + encodeURIComponent(creatorPositionHistory);
            url += '&supervisorNameHistory=' + encodeURIComponent(supervisorNameHistory);
            url += '&supervisorPositionHistory=' + encodeURIComponent(supervisorPositionHistory);
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
                    $('#printModalHistory').modal('hide');
                    $('#printFormHistory')[0].reset();
                    location.reload();
                }
            });
        }
    });
});
</script>
