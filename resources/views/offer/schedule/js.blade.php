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
