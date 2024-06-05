<script>
    $(document).ready(function() {

        $('#searchBtn').on('click', function() {
            if (!isValidInput()) {
                return;
            }
            updateIframe();
        });

        function isValidInput() {
            var year = $('#year').val();
            var start_month = $('#start_month').val();
            var end_month = $('#end_month').val();

            if (!year) {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Please select a year',
                });
                return false;
            }

            if (start_month && !end_month) {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Please select an end month if a start month is selected',
                });
                return false;
            }

            if (!start_month && end_month) {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Please select a start month if an end month is selected',
                });
                return false;
            }

            if (!start_month && !end_month) {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Please select start month and end month',
                });
                return false;
            }

            if (start_month && end_month && parseInt(end_month) < parseInt(start_month)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'End month must be greater than or equal to start month',
                });
                return false;
            }

            return true;
        }

        function updateIframe() {
            var year = $('#year').val();
            var start_month = $('#start_month').val();
            var end_month = $('#end_month').val();

            var iframeSrc = '{{ route('recap.comparison-matrix-data') }}?year=' + year + '&start_month=' + start_month + '&end_month=' + end_month;
            console.log(iframeSrc);
            $('#searchComparisonMatrix').attr('src', iframeSrc);
        }
        $('#printBtn').click(function() {
                $('#printModal').modal('show');
        });
        $('#confirmPrintBtn').click(function () {
            var stafName = $('#stafName').val();
            var stafPosition = $('#stafPosition').val();
            var managerName = $('#managerName').val();
            var managerPosition = $('#managerPosition').val();
            var url = $('#searchComparisonMatrix').attr('src');
             // Validasi form
            if (stafName === '' || stafPosition === '' || managerName === '' || managerPosition === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Please complete all fields',
                });
                return false;
            }
            if (url) {
                url += '&stafName=' + encodeURIComponent(stafName);
                url += '&stafPosition=' + encodeURIComponent(stafPosition);
                url += '&managerName=' + encodeURIComponent(managerName);
                url += '&managerPosition=' + encodeURIComponent(managerPosition);
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
                        $('#printModal').modal('hide');
                        $('#printForm')[0].reset();
                        location.reload();
                    }
                });
            }
        });
        $('a.btn-success').click(function(event) {
            event.preventDefault(); // Mencegah tindakan default dari tautan
            // Mendapatkan nilai start periode dan end periode dari input form
            var year = $('#year').val();
            var start_month = $('#start_month').val();
            var end_month = $('#end_month').val();
            // Periksa apakah kedua periode sudah diisi
            if (!year) {
                // Menampilkan pesan kesalahan jika salah satu atau kedua periode belum diisi
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Select year are required',
                });
                return;
            }
            // Membuat tautan ekspor dengan menyertakan nilai-nilai start periode dan end periode
            var exportUrl = $(this).attr('href') + '?year=' + year + '&start_month=' + start_month + '&end_month=' + end_month;
            // Mengarahkan pengguna ke tautan ekspor dengan nilai-nilai filter
            window.location.href = exportUrl;
        });
    });
    </script>
