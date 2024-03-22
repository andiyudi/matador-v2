<script>
    $(document).ready(function() {
        var startDateInputTtpp = $('#startDateTtpp');
        var endDateInputTtpp = $('#endDateTtpp');

        startDateInputTtpp.datepicker({
            format: 'mm-yyyy',
            startView: 'months',
            minViewMode: 'months',
            autoclose:true,
        });

        endDateInputTtpp.datepicker({
            format: 'mm-yyyy',
            startView: 'months',
            minViewMode: 'months',
            autoclose:true,
            startDate: startDateInputTtpp.val()
        }).on('show', function() {
            $(this).datepicker('setStartDate', startDateInputTtpp.val());
        });

        $('#searchBtn').on('click', function() {
            if (!isValidInput()) {
                return;
            }
            updateIframe();
        });

        function isValidInput() {
            var startDateTtpp = $('#startDateTtpp').val();
            var endDateTtpp = $('#endDateTtpp').val();

            if (!startDateTtpp || !endDateTtpp) {
                // Menampilkan SweetAlert untuk memberi tahu user bahwa kedua input harus diisi
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Start period and End periode is required',
                });
                return false;
            }

            return true;
        }

        function updateIframe() {
        var number = $('#number').val();
        var name = $('#name').val();
        var division = $('#division-filter').val();
        var startDateTtpp = $('#startDateTtpp').val();
        var endDateTtpp = $('#endDateTtpp').val();
        //tampilan data
        var iframeSrc = '{{ route('recap.process-nego-data') }}?number=' + number +
            '&name=' + name +
            '&division=' + division +
            '&startDateTtpp=' + startDateTtpp +
            '&endDateTtpp=' + endDateTtpp;
        console.log(iframeSrc);
        $('#searchRecapProcessNego').attr('src', iframeSrc);
        }
        $('#printBtn').click(function() {
            $('#printModal').modal('show');
        });
        $('#confirmPrintBtn').click(function () {
        var stafName = $('#stafName').val();
        var stafPosition = $('#stafPosition').val();
        var managerName = $('#managerName').val();
        var managerPosition = $('#managerPosition').val();
        var url = $('#searchRecapProcessNego').attr('src');
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
        var startDateTtpp = $('#startDateTtpp').val();
        var endDateTtpp = $('#endDateTtpp').val();
        var number = $('#number').val();
        var name = $('#name').val();
        var division = $('#division-filter').val();
        // Periksa apakah kedua periode sudah diisi
        if (!startDateTtpp || !endDateTtpp) {
            // Menampilkan pesan kesalahan jika salah satu atau kedua periode belum diisi
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'Start period and End periode are required',
            });
            return;
        }
        // Membuat tautan ekspor dengan menyertakan nilai-nilai start periode dan end periode
        var exportUrl = $(this).attr('href') + '?startDateTtpp=' + startDateTtpp + '&endDateTtpp=' + endDateTtpp + '&number=' + number + '&name=' + name+ '&division=' + division;
        // Mengarahkan pengguna ke tautan ekspor dengan nilai-nilai filter
        window.location.href = exportUrl;
    });
});
</script>
