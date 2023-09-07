<script type="text/javascript">
    $(document).ready(function () {
        $('input[name="schedule_type"]').change(function () {
            var selectedType = $('input[name="schedule_type"]:checked').val();

            // Sembunyikan semua formulir
            $('#form_type_1, #form_type_2, #form_type_3').hide();

            // Tampilkan formulir yang sesuai berdasarkan pilihan
            $('#form_type_' + selectedType).show();
        });
    });
</script>
<script>
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
            // Hitung selisih dalam milidetik
            var timeDiff = endDate - startDate;

            // Hitung jumlah hari (tambahkan 1)
            var daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;

            // Tampilkan jumlah hari di input duration
            durationInput.value = daysDiff;
        } else {
            // Jika salah satu tanggal belum dipilih, atur durasi menjadi 0
            durationInput.value = "0";
        }
    }
</script>
