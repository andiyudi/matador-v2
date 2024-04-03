<div class="tab-pane fade show active" id="matrixContent" role="tabpanel" aria-labelledby="matrixTab">
    <div class="row mb-3">
        <div class="col-md-6">
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
        <div class="col-md-6">
            <div class="form-group">
                <label for="number" class="form-label">Masukkan No PP</label>
                <input type="text" name="number" id="number" class="form-control">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
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
        <div class="col-md-6">
            <div class="form-group">
                <label for="year" class="form-label required">Periode</label>
                <select class="form-select" name="year" id="year">
                    <option selected>2024</option>
                </select>
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
