<div class="tab-pane fade" id="recapContent" role="tabpanel" aria-labelledby="recapTab">
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="form-group">
                <label for="filterType" class="form-label">Pilih Filter</label>
                <select class="form-select" id="filterType" name="filterType" onchange="selectFilter(this.value)">
                    <option value="">Pilih Filter</option>
                    <option value="bulan">Filter Berdasarkan Bulan</option>
                    <option value="semester">Filter Berdasarkan Semester</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="filterValue" class="form-label">Pilih Option</label>
                <select class="form-select" id="filterValue" name="filterValue" onchange="selectValue(this.value)">
                    <!-- Dropdown 2 isi akan di-generate oleh JavaScript -->
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
            <button class="btn btn-primary me-md-2" type="button" id="btnPrint" data-toggle="modal" data-target="#modalPrint">Print</button>
            <a href="{{ route('documentation.division-annual-excel') }}" class="btn btn-success" id="btnExport">Export</a>
        </div>
    </div>
    <iframe id="searchDivisionAnnual" src="" style="width: 100%; height: 500px; border: none;"></iframe>
</div>
<script>
    function selectFilter(filterType) {
        var filterValueDropdown = document.getElementById('filterValue');
        filterValueDropdown.innerHTML = ''; // Bersihkan isi dropdown sebelumnya jika ada

        if (filterType === 'bulan') {
            var defaultOption = document.createElement("option");
            defaultOption.setAttribute("value", "");
            defaultOption.textContent = "Pilih Bulan";
            defaultOption.setAttribute("disabled", true);
            defaultOption.setAttribute("selected", true);
            filterValueDropdown.appendChild(defaultOption);

            // Tambahkan opsi bulan pada dropdown 2
            var months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            for (var i = 0; i < months.length; i++) {
                var monthOption = document.createElement("option");
                monthOption.setAttribute("value", i + 1); // Set nilai bulan menjadi angka 1-12
                monthOption.textContent = months[i];
                filterValueDropdown.appendChild(monthOption);
            }
        } else if (filterType === 'semester') {
            var defaultOption = document.createElement("option");
            defaultOption.setAttribute("value", "");
            defaultOption.textContent = "Pilih Semester";
            defaultOption.setAttribute("disabled", true);
            defaultOption.setAttribute("selected", true);
            filterValueDropdown.appendChild(defaultOption);

            // Tambahkan opsi semester pada dropdown 2
            var semesters = ["Ganjil", "Genap"];
            for (var j = 0; j < semesters.length; j++) {
                var semesterOption = document.createElement("option");
                semesterOption.setAttribute("value", j + 1); // Set nilai semester menjadi angka 1-2
                semesterOption.textContent = semesters[j];
                filterValueDropdown.appendChild(semesterOption);
            }
        }
         // Set filterValue to be required when filterType is not null
        if (filterType) {
            filterValueDropdown.setAttribute("required", true);
        } else {
            filterValueDropdown.removeAttribute("required");
        }
    }

    function selectValue(filterValue) {
        var filterType = document.getElementById('filterType').value;
        var year = document.getElementById('year').value;
        // Cek apakah opsi yang dipilih bukan opsi "Pilih Salah Satu"
        if (filterValue !== "") {
            console.log("Tahun: " + year + ", Type: " + filterType + ", Value: " + filterValue);
        } else {
            // Jika opsi "Pilih Salah Satu" dipilih, beri pesan peringatan
            console.log("Silakan pilih opsi yang valid!");
        }
    }
    $(document).ready(function () {
        $('#btnSearch').on('click', function() {
        if (!isValidInput()) {
            return;
        }
        updateIframe();
    });
    function isValidInput() {
            var year = $('#year').val();
            var filterType = $('#filterType').val();
            var filterValue = $('#filterValue').val();
            if (!year) {
                // Menampilkan SweetAlert untuk memberi tahu user bahwa input harus diisi
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Please select a year',
                });
                return false;
            }
            if (filterType && !filterValue) {
                // Menampilkan SweetAlert untuk memberi tahu user bahwa filterValue harus diisi jika filterType dipilih
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Please select a filter value',
                });
                return false;
            }
            return true;
        }

    function updateIframe() {
        var year = $('#year').val();
        var filterType = $('#filterType').val();
        var filterValue = $('#filterValue').val();

        var iframeSrc = '{{ route('documentation.division-annual-data') }}?year=' + year +
        '&filterType=' + filterType +
        '&filterValue=' + filterValue;
        console.log(iframeSrc);
        $('#searchDivisionAnnual').attr('src', iframeSrc);
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
        var filterType = $('#filterType').val();
        var filterValue = $('#filterValue').val();
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
        var exportUrl = $(this).attr('href') + '?year=' + year + '&filterType=' + filterType + '&filterValue=' + filterValue;
        // Mengarahkan pengguna ke tautan ekspor dengan nilai-nilai filter
        window.location.href = exportUrl;
    });
});
</script>


