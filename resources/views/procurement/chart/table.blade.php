<script>
    $(document).ready(function () {
        var dataTable = $('#dashboard-table').DataTable({
            aLengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            iDisplayLength: 5,
            serverSide: true,
            processing: true,
            sDom: 'lrtip',
            ajax: {
                url: route('chart.procurementsData'),
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
                { data: 'name', name: 'name' },
                { data: 'is_selected', name: 'is_selected' },
                { data: 'user_estimate', name: 'user_estimate' },
                { data: 'deal_nego', name: 'deal_nego' },
                { data: 'user_percentage', name: 'user_percentage' },
                { data: 'technique_estimate', name: 'technique_estimate' },
                { data: 'technique_difference', name: 'technique_difference' },
                { data: 'technique_percentage', name: 'technique_percentage' },
                { data: 'target_day', name: 'target_day' },
                { data: 'finish_day', name: 'finish_day' },
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
