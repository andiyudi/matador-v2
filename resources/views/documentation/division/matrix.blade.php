<div class="tab-pane fade show active" id="matrixContent" role="tabpanel" aria-labelledby="matrixTab">
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="" class="form-label">Pilih Divisi</label>
                <select class="form-select" name="" id="">
                    <option disabled selected>Pilih Divisi</option>
                    <option value="">Akuntansi</option>
                    <option value="">Hukum</option>
                    <option value="">Investasi</option>
                    <option value="">Keuangan</option>
                    <option value="">Sistem Informasi Manajemen & Anggaran</option>
                    <option value="">Manajemen Gerbang Tol</option>
                    <option value="">Pelayanan & Pemeliharaan</option>
                    <option value="">Satuan Pengawas Intern</option>
                    <option value="">Sekretaris Perusahaan</option>
                    <option value="">Sumber Daya Manusia</option>
                    <option value="">Teknologi Informasi</option>
                    <option value="">Umum</option>
                    <option value="">Proyek Harbour Road II</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="" class="form-label">PIC Pengadaan</label>
                <select class="form-select" name="" id="">
                    <option disabled selected>Pilih PIC Pengadaan</option>
                    <option value="">Rangga Nopara</option>
                    <option value="">Eryc Pranata</option>
                    <option value="">Eza Pradila Putri</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="" class="form-label">Masukkan No PP</label>
                <input type="text" name="" id="" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label required" for="period">Pilih Periode</label>
                <div class="input-daterange">
                    <input type="text" class="form-control" id="period" name="period" placeholder="Periode">
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-sm-3">
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
