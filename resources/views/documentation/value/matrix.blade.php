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
            <button class="btn btn-secondary me-md-2" type="button" id="">Search</button>
            <button class="btn btn-primary me-md-2" type="button" id="" data-toggle="modal" data-target="#">Print</button>
            <button type="reset" class="btn btn-success">Export</button>
        </div>
    </div>
    <iframe id="searchResultsVendor" src="" style="width: 100%; height: 500px; border: none;"></iframe>
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
    });
</script>
