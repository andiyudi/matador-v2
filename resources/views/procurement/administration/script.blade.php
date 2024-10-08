<script>
    document.addEventListener('DOMContentLoaded', function () {
    const currencyInputs = document.querySelectorAll('.currency');

    currencyInputs.forEach(function (input) {
        input.addEventListener('input', function (e) {
            // Hapus karakter selain digit dan koma
            const rawValue = e.target.value.replace(/[^\d]/g, '');

            // Konversi nilai ke format mata uang dengan dua desimal
            const formattedValue = new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(parseFloat(rawValue) / 100 || 0);

            // Setel nilai input yang sudah diformat
            e.target.value = formattedValue;
        });

            // Cek nilai dari database dan format nilai mata uang saat halaman dimuat
            const valueFromDB = input.value ? parseFloat(input.value.replace(/[^\d.-]/g, '')) : 0;
            const formattedValue = valueFromDB === 0 ? '0' : new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(valueFromDB);

            input.value = formattedValue;
    });
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Mendengarkan perubahan pada input negotiation_result
        $('.negotiation-result').on('input', function() {
            var selectedValue = $(this).val();
            $('#deal_nego').val(selectedValue);
            $('#contract_value').val(selectedValue);
        });

        $('#deal_nego').on('input', function() {
            var selectedValue = $(this).val();
            $('#contract_value').val(selectedValue);
        });

         // Memeriksa apakah deal_nego sudah ada saat halaman dimuat pertama kali
        var dealNegoValue = $('#deal_nego').val();
        if (dealNegoValue) {
            $('#contract_value').val(dealNegoValue);
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Mendapatkan nilai dari database (jika ada)
    var targetDayValueFromDB = parseInt($('#target_day').val()) || null;
    var finishDayValueFromDB = parseInt($('#finish_day').val()) || null;
    var offDaysFromDB = parseInt($('#off_day').val()) || null;
    var differenceDayValueFromDB = parseInt($('#difference_day').val()) || null;

    // Jika nilai dari database tidak null, tampilkan nilai tersebut
    if (targetDayValueFromDB !== null && finishDayValueFromDB !== null && offDaysFromDB !== null && differenceDayValueFromDB !== null) {
        $('#target_day').val(targetDayValueFromDB);
        $('#finish_day').val(finishDayValueFromDB);
        $('#off_day').val(offDaysFromDB);
        $('#difference_day').val(differenceDayValueFromDB);
    } else {
         // Panggil fungsi untuk menghitung waktu penyelesaian tender berdasarkan nilai yang sudah ada dari database
        var reportNegoResultTimestamp = Date.parse($('#report_nego_result_{{ $idTender ?? '' }}').val());
        if (!isNaN(reportNegoResultTimestamp)) {
            updateFinishAndOffDays(reportNegoResultTimestamp);
        }
    }

    // Mendengarkan perubahan pada input report_nego_result terakhir
    $('[id^="report_nego_result_"]').on('input', function () {
        var reportNegoResultTimestamp = Date.parse($(this).val());
        if (!isNaN(reportNegoResultTimestamp)) {
            updateFinishAndOffDays(reportNegoResultTimestamp);
        }
    });

    // Mendengarkan perubahan pada input secara manual
    $('#target_day, #finish_day, #off_day').on('input', function () {
        updateDifferenceDay(); // Memanggil fungsi untuk mengupdate difference day saat diubah secara manual
    });
});

function updateFinishAndOffDays(reportNegoResultTimestamp) {
    // Mendapatkan tanggal awal (receipt)
    var receiptValue = new Date($('#receipt').val()).getTime();

    // Menghitung finish_day berdasarkan selisih tanggal akhir dan tanggal awal
    var finishDayValue = Math.ceil((reportNegoResultTimestamp - receiptValue) / (1000 * 60 * 60 * 24));

    // Menghitung off day (hari libur sabtu dan minggu) antara tanggal awal dan tanggal akhir
    var startDate = new Date($('#receipt').val());
    var endDate = new Date(reportNegoResultTimestamp);
    var currentDate = new Date(startDate); // Buat salinan tanggal untuk digunakan dalam perhitungan

    var offDays = 0;

    while (currentDate <= endDate) {
        var dayOfWeek = currentDate.getDay();
        if (dayOfWeek === 0 || dayOfWeek === 6) { // 0: Minggu, 6: Sabtu
            offDays++;
        }
        currentDate.setDate(currentDate.getDate() + 1);
    }

    // Mengisi finish_day dan off_day
    $('#finish_day').val(finishDayValue > 0 ? finishDayValue : 0);
    $('#off_day').val(offDays > 0 ? offDays : 0);

    updateDifferenceDay(); // Memanggil fungsi untuk mengupdate difference day
}

function updateDifferenceDay() {
    var targetDayValue = parseInt($('#target_day').val()) || 0;
    var finishDayValue = parseInt($('#finish_day').val()) || 0;
    var offDays = parseInt($('#off_day').val()) || 0;

    var differenceDayValue = targetDayValue - finishDayValue + offDays;
    $('#difference_day').val(differenceDayValue);
}

</script>
