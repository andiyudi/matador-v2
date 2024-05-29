<div class="tab-pane fade" id="recapContent" role="tabpanel" aria-labelledby="recapTab">
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="form-group">
                <label for="work_value" class="form-label">Nilai Pekerjaan</label>
                <select class="form-select" name="work_value" id="work_value">
                    <option value="">Pilih Nilai Pekerjaan</option>
                    <option value="0">Nilai 0 s.d < 100Jt</option>
                    <option value="1">Nilai &#8805; 100Jt s.d < 1M</option>
                    <option value="2">Nilai &#8805; 1M</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="month" class="form-label required">Bulan</label>
                <div class="input-group input-daterange">
                    <select class="form-select" name="start_month" id="start_month">
                        <option value="">Start Month</option>
                        @foreach ($bulan as $key => $name)
                            <option value="{{ $key }}" {{ $key == 1 ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    <span class="input-group-text">to</span>
                    <select class="form-select" name="end_month" id="end_month">
                        <option value="">End Month</option>
                        @foreach ($bulan as $key => $name)
                            <option value="{{ $key }}" {{ $key == $currentMonth ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="year" class="form-label required">Pilih Periode</label>
                <select id="year" class="form-select" name="year">
                    @foreach ($years as $year)
                        <option value="{{ $year }}" @if ($year == $currentYear) selected @endif>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
            <button class="btn btn-secondary me-md-2" type="button" id="btnSearch">Search</button>
            <button class="btn btn-primary me-md-2" type="button" id="btnPrint" data-toggle="modal" data-target="#modalPrint">Print</button>
            <a href="{{ route('documentation.value-annual-excel') }}" class="btn btn-success" id="btnExport">Export</a>
        </div>
    </div>
    <iframe id="searchValueAnnual" src="" style="width: 100%; height: 500px; border: none;"></iframe>
</div>
<div class="modal fade" id="modalPrint" tabindex="-1" role="dialog" aria-labelledby="modalPrintLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPrintLabel">Data Pembuat dan Atasan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formPrint">
                    <div class="form-group">
                        <label for="creatorName">Nama Pembuat:</label>
                        <input type="text" class="form-control" id="nameStaf" name="nameStaf">
                    </div>
                    <div class="form-group">
                        <label for="creatorPosition">Jabatan Pembuat:</label>
                        <input type="text" class="form-control" id="positionStaf" name="positionStaf">
                    </div>
                    <div class="form-group">
                        <label for="supervisorName">Nama Atasan:</label>
                        <input type="text" class="form-control" id="nameManager" name="nameManager">
                    </div>
                    <div class="form-group">
                        <label for="supervisorPosition">Jabatan Atasan:</label>
                        <input type="text" class="form-control" id="positionManager" name="positionManager">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirmBtnPrint">Cetak</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#start_month, #end_month').change(function() {
        var startMonth = parseInt($('#start_month').val());
        var endMonth = parseInt($('#end_month').val());

        // Validasi jika start month atau end month tidak dipilih
        if (isNaN(startMonth) || isNaN(endMonth)) {
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'Both start month and end month must be selected.',
            });
            return;
        }

        // Validasi jika end month lebih kecil dari start month
        if (endMonth < startMonth) {
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'End month must be greater than or equal to start month.',
            });
            $('#end_month').val('');
        }
    });
        $('#btnSearch').on('click', function() {
        if (!isValidInput()) {
            return;
        }
        updateIframe();
    });
    function isValidInput() {
        var year = $('#year').val();
        var start_month = $('#start_month').val();
        var end_month = $('#end_month').val();
        var work_value = $('#work_value').val();
        if (!year) {
            // Menampilkan SweetAlert untuk memberi tahu user bahwa input harus diisi
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'Please select a year',
            });
            return false;
        }

        return true;
    }
    function updateIframe() {
        var year = $('#year').val();
        var start_month = $('#start_month').val();
        var end_month = $('#end_month').val();
        var work_value = $('#work_value').val();

        var iframeSrc = '{{ route('documentation.value-annual-data') }}?year=' + year +
        '&start_month=' + start_month +
        '&end_month=' + end_month +
        '&work_value=' + work_value;
        console.log(iframeSrc);
        $('#searchValueAnnual').attr('src', iframeSrc);
    }
    $('#btnPrint').click(function() {
            $('#modalPrint').modal('show');
        });
        $('#confirmBtnPrint').click(function () {
        var nameStaf = $('#nameStaf').val();
        var positionStaf = $('#positionStaf').val();
        var nameManager = $('#nameManager').val();
        var positionManager = $('#positionManager').val();
        var url = $('#searchValueAnnual').attr('src');
         // Validasi form
        if (nameStaf === '' || positionStaf === '' || nameManager === '' || positionManager === '') {
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'Please complete all fields',
            });
            return false;
        }
        if (url) {
            url += '&nameStaf=' + encodeURIComponent(nameStaf);
            url += '&positionStaf=' + encodeURIComponent(positionStaf);
            url += '&nameManager=' + encodeURIComponent(nameManager);
            url += '&positionManager=' + encodeURIComponent(positionManager);
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
                    $('#modalPrint').modal('hide');
                    $('#formPrint')[0].reset();
                    location.reload();
                }
            });
        }
    });
    $('#btnExport').click(function(event) {
        event.preventDefault(); // Mencegah tindakan default dari tautan
        // Mendapatkan nilai start periode dan end periode dari input form
        var year = $('#year').val();
        var start_month = $('#start_month').val();
        var end_month = $('#end_month').val();
        var work_value = $('#work_value').val();
        // Periksa apakah kedua periode sudah diisi
        if (!year) {
            // Menampilkan pesan kesalahan jika salah satu atau kedua periode belum diisi
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'Year are required',
            });
            return;
        }
        // Membuat tautan ekspor dengan menyertakan nilai-nilai start periode dan end periode
        var exportUrl = $(this).attr('href') + '?year=' + year + '&start_month=' + start_month + '&end_month=' + end_month + '&work_value=' + work_value;
        // Mengarahkan pengguna ke tautan ekspor dengan nilai-nilai filter
        window.location.href = exportUrl;
    });
});
</script>
