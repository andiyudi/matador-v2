<script type="text/javascript">
    $(document).ready(function () {
        $('input[name="schedule_type"]').change(function () {
            var selectedType = $('input[name="schedule_type"]:checked').val();

            // Sembunyikan semua formulir
            $('#form_type_0, #form_type_1, #form_type_2').hide();

            // Tampilkan formulir yang sesuai berdasarkan pilihan
            $('#form_type_' + selectedType).show();
        });
    });
</script>
<script>
    function isWeekend(date) {
        // Periksa apakah tanggal merupakan hari Sabtu atau Minggu (6 atau 0 adalah indeks hari)
        return date.getDay() === 6 || date.getDay() === 0;
    }

    function calculateWorkDays(startDate, endDate) {
        var workDays = 0;
        var currentDate = new Date(startDate);

        while (currentDate <= endDate) {
            if (!isWeekend(currentDate)) {
                workDays++;
            }
            currentDate.setDate(currentDate.getDate() + 1);
        }

        return workDays;
    }

    function calculateDuration(type, rowNumber) {
        // Ambil nilai tanggal mulai dan tanggal selesai dari input
        var startDateInput = document.getElementById(type + "_start_date_" + rowNumber);
        var endDateInput = document.getElementById(type + "_end_date_" + rowNumber);
        var durationInput = document.getElementById(type + "_duration_" + rowNumber);

        // Konversi tanggal menjadi objek Date
        var startDate = new Date(startDateInput.value);
        var endDate = new Date(endDateInput.value);

        // Pastikan kedua tanggal telah dipilih sebelum menghitung
        if (startDateInput.value !== "" && endDateInput.value !== "") {
            // Hitung durasi hari kerja (tanpa memeriksa hari libur nasional)
            var workDays = calculateWorkDays(startDate, endDate);

            // Tampilkan jumlah hari kerja di input duration
            durationInput.value = workDays;
        } else {
            // Jika salah satu tanggal belum dipilih, atur durasi menjadi 0
            durationInput.value = "0";
        }
    }
</script>
<script>
    $(document).ready(function() {
        $(document).on('submit', 'form', function() {
            $('button').attr('disabled', 'disabled');
        });
    });
</script>
