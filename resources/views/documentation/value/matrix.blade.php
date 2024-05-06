<div class="tab-pane fade show active" id="matrixContent" role="tabpanel" aria-labelledby="matrixTab">
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="form-group">
                <label for="value" class="form-label">Nilai Pekerjaan</label>
                <select class="form-select" name="value" id="value">
                    <option disabled selected>Pilih Nilai Pekerjaan</option>
                    <option value="0">Nilai 0 s.d < 100Jt</option>
                    <option value="1">Nilai &#8805; 100Jt s.d < 1M</option>
                    <option value="2">Nilai &#8805; 1M</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="number" class="form-label">Masukkan No PP</label>
                <input type="text" name="number" id="number" class="form-control">
            </div>
        </div>
        <div class="col-md-4">
            <label class="form-label required" for="period">Pilih Periode</label>
            <div class="input-daterange">
                <input type="text" class="form-control" id="period" name="period" placeholder="Periode">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
            <button class="btn btn-secondary me-md-2" type="button" id="searchBtn">Search</button>
            <button class="btn btn-primary me-md-2" type="button" id="printBtn" data-toggle="modal" data-target="#printModal">Print</button>
            <a href="{{ route('documentation.value-monthly-excel') }}" class="btn btn-success">Export</a>
        </div>
    </div>
    <iframe id="searchValueMonthly" src="" style="width: 100%; height: 500px; border: none;"></iframe>
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
                        <input type="text" class="form-control" id="stafName" name="stafName">
                    </div>
                    <div class="form-group">
                        <label for="creatorPosition">Jabatan Pembuat:</label>
                        <input type="text" class="form-control" id="stafPosition" name="stafPosition">
                    </div>
                    <div class="form-group">
                        <label for="supervisorName">Nama Atasan:</label>
                        <input type="text" class="form-control" id="managerName" name="managerName">
                    </div>
                    <div class="form-group">
                        <label for="supervisorPosition">Jabatan Atasan:</label>
                        <input type="text" class="form-control" id="managerPosition" name="managerPosition">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirmPrintBtn">Cetak</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var period = $('#period');

        period.datepicker({
            format: 'mm-yyyy',
            startView: 'months',
            minViewMode: 'months',
            autoclose:true,
        });

        $('#searchBtn').on('click', function() {
            if (!isValidInput()) {
                return;
            }
            updateIframe();
        });

        function isValidInput() {
            var period = $('#period').val();

            if (!period) {
                // Menampilkan SweetAlert untuk memberi tahu user bahwa kedua input harus diisi
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Period is required',
                });
                return false;
            }

            return true;
        }
        function updateIframe() {
        var period = $('#period').val();
        var number = $('#number').val();
        var value = $('#value').val();
        // var divisi = $('#divisi').val();
        //tampilan data
        var iframeSrc = '{{ route('documentation.value-monthly-data') }}?period=' + period +
            '&number=' + number +
            // '&divisi=' + divisi +
            '&value=' + value;
        console.log(iframeSrc);
        $('#searchValueMonthly').attr('src', iframeSrc);
        }
        $('#printBtn').click(function() {
            $('#printModal').modal('show');
        });
        $('#confirmPrintBtn').click(function () {
        var stafName = $('#stafName').val();
        var stafPosition = $('#stafPosition').val();
        var managerName = $('#managerName').val();
        var managerPosition = $('#managerPosition').val();
        var url = $('#searchValueMonthly').attr('src');
         // Validasi form
        if (stafName === '' || stafPosition === '' || managerName === '' || managerPosition === '') {
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'Please complete all fields',
            });
            return false;
        }
        if (url) {
            url += '&stafName=' + encodeURIComponent(stafName);
            url += '&stafPosition=' + encodeURIComponent(stafPosition);
            url += '&managerName=' + encodeURIComponent(managerName);
            url += '&managerPosition=' + encodeURIComponent(managerPosition);
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
    $('a.btn-success').click(function(event) {
        event.preventDefault(); // Mencegah tindakan default dari tautan
        // Mendapatkan nilai start periode dan end periode dari input form
        var period = $('#period').val();
        var number = $('#number').val();
        var value = $('#value').val();
        // Periksa apakah kedua periode sudah diisi
        if (!period) {
            // Menampilkan pesan kesalahan jika salah satu atau kedua periode belum diisi
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'Periode are required',
            });
            return;
        }
        // Membuat tautan ekspor dengan menyertakan nilai-nilai start periode dan end periode
        var exportUrl = $(this).attr('href') + '?period=' + period + '&value=' + value + '&number=' + number;
        // Mengarahkan pengguna ke tautan ekspor dengan nilai-nilai filter
        window.location.href = exportUrl;
    });
});
</script>
