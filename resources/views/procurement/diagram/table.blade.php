<script>
    $(document).ready(function () {
        var dataTable = $('#dashboard-table').DataTable({
            aLengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            iDisplayLength: 5,
            serverSide: true,
            processing: true,
            sDom: 'lrtip',
            ajax: {
                url: route('diagram.procurementsData'),
                data: function (d) {
                    d.division = $('#division').val();
                    d.official = $('#official').val();
                    d.year = $('#year').val();
                    // Add more filters if needed
                },
                // dataSrc: 'tableData.data' // Specify the data source for DataTables
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'number', name: 'number' },
                { data: 'name', name: 'name' },
                { data: 'division', name: 'division' },
                { data: 'official', name: 'official' },
                { data: 'status', name: 'status' },
            ],
        });
        // Event listener for Division dropdown
        $('#division').on('change', function () {
            dataTable.ajax.reload();
        });

        // Event listener for Official dropdown
        $('#official').on('change', function () {
            dataTable.ajax.reload();
        });
        $('#year').on('change', function () {
            dataTable.ajax.reload();
        });
    });
</script>
