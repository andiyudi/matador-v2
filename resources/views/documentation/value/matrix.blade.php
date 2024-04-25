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
        {{-- <div class="col-md-6">
            <div class="form-group">
                <label for="value" class="form-label">Divisi</label>
                <select class="form-control select2" name="divisi" id="divisi">
                    <option disabled selected>Pilih Divisi</option>
                    @foreach($divisions as $division)
                    <option value="{{ $division->id }}">{{ $division->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row mb-3"> --}}
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
            <button class="btn btn-primary me-md-2" type="button" id="" data-toggle="modal" data-target="#">Print</button>
            <button type="reset" class="btn btn-success">Export</button>
        </div>
    </div>
    <iframe id="searchValueMonthly" src="" style="width: 100%; height: 500px; border: none;"></iframe>
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
    });
</script>
