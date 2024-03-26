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

            if (!year) {
                // Menampilkan SweetAlert untuk memberi tahu user bahwa input harus diisi
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Please select a year',
                });
                return false;
            }

            return true;
        }

        function updateIframe() {
            var year = $('#year').val();

            var iframeSrc = '{{ route('recap.comparison-matrix-data') }}?year=' + year;
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
            var exportUrl = $(this).attr('href') + '?year=' + year;
            // Mengarahkan pengguna ke tautan ekspor dengan nilai-nilai filter
            window.location.href = exportUrl;
        });
    });
    </script>
