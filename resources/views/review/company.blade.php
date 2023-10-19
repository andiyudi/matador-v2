<div class="tab-pane fade show active" id="companyContent" role="tabpanel" aria-labelledby="companyTab">
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="period">Periode:</label>
                <div class="input-group input-daterange">
                    <input type="text" class="form-control" id="startDateCompany" name="startDateCompany" placeholder="Start Periode">
                    <span class="input-group-text">to</span>
                    <input type="text" class="form-control" id="endDateCompany" name="endDateCompany" placeholder="End Periode">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button class="btn btn-secondary me-md-2" type="button" id="searchBtnCompany">Search</button>
                    <button class="btn btn-primary" type="button" id="printBtnCompany" data-toggle="modal" data-target="#printModalCompany">Print</button>
                </div>
            </div>
        </div>
    </div>
    <iframe id="searchResultsCompany" src="" style="width: 100%; height: 500px; border: none;"></iframe>
</div>
<div class="modal fade" id="printModalCompany" tabindex="-1" role="dialog" aria-labelledby="printModalCompanyLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="printModalCompanyLabel">Data Pembuat dan Atasan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="printFormCompany">
                    <div class="form-group">
                        <label for="creatorNameCompany">Nama Pembuat:</label>
                        <input type="text" class="form-control" id="creatorNameCompany" name="creatorNameCompany">
                    </div>
                    <div class="form-group">
                        <label for="creatorPositionCompany">Jabatan Pembuat:</label>
                        <input type="text" class="form-control" id="creatorPositionCompany" name="creatorPositionCompany">
                    </div>
                    <div class="form-group">
                        <label for="supervisorNameCompany">Nama Atasan:</label>
                        <input type="text" class="form-control" id="supervisorNameCompany" name="supervisorNameCompany">
                    </div>
                    <div class="form-group">
                        <label for="supervisorPositionCompany">Jabatan Atasan:</label>
                        <input type="text" class="form-control" id="supervisorPositionCompany" name="supervisorPositionCompany">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirmPrintBtnCompany">Cetak</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var startDateCompanyInput = $('#startDateCompany');
        var endDateCompanyInput = $('#endDateCompany');

        startDateCompanyInput.datepicker({
            format: 'yyyy',
            startView: 'years',
            minViewMode: 'years',
            autoclose:true,
        });

        endDateCompanyInput.datepicker({
            format: 'yyyy',
            startView: 'years',
            minViewMode: 'years',
            autoclose:true,
            startDate: startDateCompanyInput.val()
        }).on('show', function() {
            $(this).datepicker('setStartDate', startDateCompanyInput.val());
        });

    $('#searchBtnCompany').click(function() {
        var fromDateCompany = $('#startDateCompany').val();
        var toDateCompany = $('#endDateCompany').val();

         // Validasi form
        if (fromDateCompany === '' || toDateCompany === '') {
        Swal.fire({
            icon: 'error',
            title: 'Failed',
            text: 'Please complete all fields',
        });
        return false;
    }

        var url = "{{ route('review.company') }}?startDateCompany=" + fromDateCompany + "&endDateCompany=" + toDateCompany;
        $('#searchResultsCompany').attr('src', url);
    });

    $('#printBtnCompany').click(function() {
        $('#printModalCompany').modal('show');

    });
    $('#confirmPrintBtnCompany').click(function () {
        var creatorNameCompany = $('#creatorNameCompany').val();
        var creatorPositionCompany = $('#creatorPositionCompany').val();
        var supervisorNameCompany = $('#supervisorNameCompany').val();
        var supervisorPositionCompany = $('#supervisorPositionCompany').val();
        var url = $('#searchResultsCompany').attr('src');

         // Validasi form
        if (creatorNameCompany === '' || creatorPositionCompany === '' || supervisorNameCompany === '' || supervisorPositionCompany === '') {
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'Please complete all fields',
            });
            return false;
        }

        if (url) {
            url += '&creatorNameCompany=' + encodeURIComponent(creatorNameCompany);
            url += '&creatorPositionCompany=' + encodeURIComponent(creatorPositionCompany);
            url += '&supervisorNameCompany=' + encodeURIComponent(supervisorNameCompany);
            url += '&supervisorPositionCompany=' + encodeURIComponent(supervisorPositionCompany);
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
                    $('#printModalCompany').modal('hide');
                    $('#printFormCompany')[0].reset();
                    location.reload();
                }
            });
        }
    });
});
</script>
