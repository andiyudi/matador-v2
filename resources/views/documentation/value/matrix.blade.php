<div class="tab-pane fade show active" id="matrixContent" role="tabpanel" aria-labelledby="matrixTab">
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="" class="form-label">Nilai Pekerjaan</label>
                <select class="form-select" name="" id="">
                    <option disabled selected>Pilih Nilai Pekerjaan</option>
                    <option value="">Nilai 0 s.d < 100Jt</option>
                    <option value="">Nilai &#8805; 100Jt s.d < 1M</option>
                    <option value="">Nilai &#8805; 1M</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="" class="form-label">Masukkan No PP</label>
                <input type="text" name="" id="" class="form-control">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="" class="form-label">Pilih Bulan</label>
                <select class="form-select" name="" id="">
                    <option disabled selected>Pilih Bulan</option>
                    <option value="">Januari</option>
                    <option value="">Februari</option>
                    <option value="">Maret</option>
                    <option value="">April</option>
                    <option value="">Mei</option>
                    <option value="">Juni</option>
                    <option value="">Juli</option>
                    <option value="">Agustus</option>
                    <option value="">September</option>
                    <option value="">Oktober</option>
                    <option value="">Nevember</option>
                    <option value="">Desember</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="" class="form-label required">Periode</label>
                <select class="form-select" name="" id="">
                    <option selected>2024</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button class="btn btn-secondary me-md-2" type="button" id="">Search</button>
            <button class="btn btn-primary me-md-2" type="button" id="" data-toggle="modal" data-target="#">Print</button>
            <button type="reset" class="btn btn-success">Export</button>
        </div>
    </div>
    <iframe id="searchResultsVendor" src="" style="width: 100%; height: 500px; border: none;"></iframe>
</div>
