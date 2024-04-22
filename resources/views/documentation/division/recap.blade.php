<div class="tab-pane fade" id="recapContent" role="tabpanel" aria-labelledby="recapTab">
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="form-group">
                <label for="filterType" class="form-label">Pilih Filter</label>
                <select class="form-select" id="filterType" onchange="selectFilter(this.value)">
                    <option value="">Pilih Filter</option>
                    <option value="monthly">Filter Berdasarkan Bulan</option>
                    <option value="semester">Filter Berdasarkan Semester</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="filterValue" class="form-label">Pilih Option</label>
                <select class="form-select" id="filterValue" onchange="selectValue(this.value)">
                    <!-- Dropdown 2 isi akan di-generate oleh JavaScript -->
                </select>
            </div>
        </div>
        <div class="col-md-4">
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
<script>
    function selectFilter(filterType) {
        var filterValueDropdown = document.getElementById('filterValue');
        filterValueDropdown.innerHTML = ''; // Bersihkan isi dropdown sebelumnya jika ada

        if (filterType === 'monthly') {
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
                monthOption.setAttribute("value", months[i]);
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
            var semesters = ["Semester Ganjil", "Semester Genap"];
            for (var j = 0; j < semesters.length; j++) {
                var semesterOption = document.createElement("option");
                semesterOption.setAttribute("value", semesters[j]);
                semesterOption.textContent = semesters[j];
                filterValueDropdown.appendChild(semesterOption);
            }
        }
    }

    function selectValue(value) {
        // Cek apakah opsi yang dipilih bukan opsi "Pilih Salah Satu"
        if (value !== "") {
            alert("Anda memilih: " + value);
        } else {
            // Jika opsi "Pilih Salah Satu" dipilih, beri pesan peringatan
            alert("Silakan pilih opsi yang valid!");
        }
    }
</script>


