<script>
    $(document).ready(function () {
        $('#category-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('category.index') }}',
            columns: [
                {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
                name: 'row_number',
                searchable: false,
                orderable: false,
                },
                { data: 'partner_name', name: 'partner_name' },
                { data: 'core_business_name', name: 'core_business_name' },
                { data: 'business_name', name: 'business_name' },
                { data: 'status', name: 'status' },
                { data: 'blacklist_at', name: 'blacklist_at' },
                { data: 'can_whitelist_at', name: 'can_whitelist_at' },
                { data: 'whitelist_at', name: 'whitelist_at' },
                { data: 'action', name: 'action', searchable: false, orderable: false },
            ]
        });
    });
</script>
