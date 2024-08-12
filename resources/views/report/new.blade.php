<div class="tab-pane fade" id="newContent" role="tabpanel" aria-labelledby="newTab">
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="inlineRadioOptions">Pilih Laporan:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="report_type" id="report_type_detail" value="detail">
                    <label class="form-check-label" for="report_type_detail">
                        Detail
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="report_type" id="report_type_summary" value="summary">
                    <label class="form-check-label" for="report_type_summary">
                        Summary
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="period">Periode:</label>
                <div class="input-group input-daterange">
                    <input type="text" class="form-control" id="startDateJoin" name="startDateJoin" placeholder="Start Periode">
                    <span class="input-group-text">to</span>
                    <input type="text" class="form-control" id="endDateJoin" name="endDateJoin" placeholder="End Periode">
                </div>
            </div>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
            <button class="btn btn-secondary me-md-2" type="button" id="searchBtnJoin">Search</button>
            <button class="btn btn-primary" type="button" id="printBtnJoin" data-toggle="modal" data-target="#printModalJoin">Print</button>
        </div>
    </div>
    <iframe id="searchResultsJoin" src="" style="width: 100%; height: 500px; border: none;"></iframe>
</div>
<div class="modal fade" id="printModalJoin" tabindex="-1" role="dialog" aria-labelledby="printModalJoinLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="printModalJoinLabel">Data Pembuat dan Atasan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="printFormJoin">
                    <div class="form-group">
                        <label for="creatorNameJoin">Nama Pembuat:</label>
                        <input type="text" class="form-control" id="creatorNameJoin" name="creatorNameJoin">
                    </div>
                    <div class="form-group">
                        <label for="creatorPositionJoin">Jabatan Pembuat:</label>
                        <input type="text" class="form-control" id="creatorPositionJoin" name="creatorPositionJoin">
                    </div>
                    <div class="form-group">
                        <label for="supervisorNameJoin">Nama Atasan:</label>
                        <input type="text" class="form-control" id="supervisorNameJoin" name="supervisorNameJoin">
                    </div>
                    <div class="form-group">
                        <label for="supervisorPositionJoin">Jabatan Atasan:</label>
                        <input type="text" class="form-control" id="supervisorPositionJoin" name="supervisorPositionJoin">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirmPrintBtnJoin">Cetak</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var startDateJoinInput = $('#startDateJoin');
        var endDateJoinInput = $('#endDateJoin');

        startDateJoinInput.datepicker({
            format: 'mm-yyyy',
            startView: 'months',
            minViewMode: 'months',
            autoclose:true,
        });

        endDateJoinInput.datepicker({
        format: 'mm-yyyy',
        startView: 'months',
        minViewMode: 'months',
        autoclose: true,
    }).on('show', function() {
        var startDateVal = startDateJoinInput.val();
        if (startDateVal) {
            var startYear = startDateVal.split('-')[1];
            $(this).datepicker('setStartDate', new Date(startYear, 0, 1));
            $(this).datepicker('setEndDate', new Date(startYear, 11, 31));
        }
    });

    $('#searchBtnJoin').click(function() {
        var fromDateJoin = $('#startDateJoin').val();
        var toDateJoin = $('#endDateJoin').val();
        var reportType = $('input[name="report_type"]:checked').val(); // Mengambil nilai radio button yang dipilih

         // Validasi form
        if (fromDateJoin === '' || toDateJoin === '' || !reportType) {
        Swal.fire({
            icon: 'error',
            title: 'Failed',
            text: 'Please complete all fields',
        });
        return false;
    }

        var url = "{{ route('report.join') }}?startDateJoin=" + fromDateJoin + "&endDateJoin=" + toDateJoin + "&report_type=" + reportType;
        $('#searchResultsJoin').attr('src', url);
    });

    $('#printBtnJoin').click(function() {
        $('#printModalJoin').modal('show');

    });
    $('#confirmPrintBtnJoin').click(function () {
        var creatorNameJoin = $('#creatorNameJoin').val();
        var creatorPositionJoin = $('#creatorPositionJoin').val();
        var supervisorNameJoin = $('#supervisorNameJoin').val();
        var supervisorPositionJoin = $('#supervisorPositionJoin').val();
        var url = $('#searchResultsJoin').attr('src');

         // Validasi form
        if (creatorNameJoin === '' || creatorPositionJoin === '' || supervisorNameJoin === '' || supervisorPositionJoin === '') {
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'Please complete all fields',
            });
            return false;
        }

        if (url) {
            url += '&creatorNameJoin=' + encodeURIComponent(creatorNameJoin);
            url += '&creatorPositionJoin=' + encodeURIComponent(creatorPositionJoin);
            url += '&supervisorNameJoin=' + encodeURIComponent(supervisorNameJoin);
            url += '&supervisorPositionJoin=' + encodeURIComponent(supervisorPositionJoin);
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
                    $('#printModalJoin').modal('hide');
                    $('#printFormJoin')[0].reset();
                    location.reload();
                }
            });
        }
    });
});
</script>

