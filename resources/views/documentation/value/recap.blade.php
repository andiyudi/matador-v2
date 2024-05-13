<div class="tab-pane fade" id="recapContent" role="tabpanel" aria-labelledby="recapTab">
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="form-group">
                <label for="work_value" class="form-label">Nilai Pekerjaan</label>
                <select class="form-select" name="work_value" id="work_value">
                    <option disabled selected>Pilih Nilai Pekerjaan</option>
                    <option value="0">Nilai 0 s.d < 100Jt</option>
                    <option value="1">Nilai &#8805; 100Jt s.d < 1M</option>
                    <option value="2">Nilai &#8805; 1M</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="month" class="form-label">Pilih Bulan</label>
                <select class="form-select" name="month" id="month">
                    <option disabled selected>Pilih Bulan</option>
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">Nevember</option>
                    <option value="12">Desember</option>
                </select>
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
            <button class="btn btn-primary me-md-2" type="button" id="printBtn" data-toggle="modal" data-target="#printModal">Print</button>
            <a href="#" class="btn btn-success">Export</a>
        </div>
    </div>
    <iframe id="searchValueAnnual" src="" style="width: 100%; height: 500px; border: none;"></iframe>
</div>
<script>
    $(document).ready(function () {
        $('#btnSearch').on('click', function() {
        if (!isValidInput()) {
            return;
        }
        updateIframe();
    });
    function isValidInput() {
        var year = $('#year').val();
        var month = $('#month').val();
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
        var month = $('#month').val();
        var work_value = $('#work_value').val();

        var iframeSrc = '{{ route('documentation.value-annual-data') }}?year=' + year +
        '&month=' + month +
        '&work_value=' + work_value;
        console.log(iframeSrc);
        $('#searchValueAnnual').attr('src', iframeSrc);
    }
});
</script>
