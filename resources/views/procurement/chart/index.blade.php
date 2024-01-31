@extends('layouts.template')
@section('content')
@php
$pretitle = 'Procurement Data';
$title    = 'Charts';
@endphp

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="division-filter" class="col-sm-3 form-label">Division:</label>
                        <select id="division-filter" class="form-select">
                            <option value="">All Divisions</option>
                            @foreach ($divisions as $division)
                            <option value="{{ $division->id }}">{{ $division->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="official-filter" class="col-sm-3 form-label">Official:</label>
                        <select id="official-filter" class="form-select">
                            <option value="">All Officials</option>
                            @foreach ($officials as $official)
                            <option value="{{ $official->id }}">{{ $official->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <table id="dashboard-table" class="table table-responsive table-bordered table-striped table-hover" width="100%">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Mitra Kerja</th>
                        <th>EE User</th>
                        <th>Hasil</th>
                        <th>% User</th>
                        <th>EE Teknik</th>
                        <th>Selisih</th>
                        <th>% Teknik</th>
                        <th>Jumlah</th>
                        <th>Selesai</th>
                    </thead>
                </table>
                <div class="row">
                    <div class="col-lg-12">
                        <canvas id="barChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
                    d.division = $('#division-filter').val();
                    d.official = $('#official-filter').val();
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
        $('#division-filter').on('change', function () {
            dataTable.ajax.reload();
        });

        // Event listener for Official dropdown
        $('#official-filter').on('change', function () {
            dataTable.ajax.reload();
        });
    });
</script>
<script>
    // Ajax request to get data from backend
    $.ajax({
        url: route('chart.barChart'),
        type: 'GET',
        data: {
            division: $('#division-filter').val(),
            official: $('#official-filter').val(),
            // ... add more filters if needed
        },
        success: function (data) {
            var colorPalette = [
                'rgba(75, 192, 192, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                // ... tambahkan warna sesuai kebutuhan
            ];

            // Data received from backend
            var chartData = data.chartData;

            // Membuat struktur data yang sesuai untuk Chart.js
            var labels = Object.keys(chartData);
            var userValues = Object.values(chartData).map(item => item.userValues);
            var dealNegoValues = Object.values(chartData).map(item => item.dealNegoValues);

            // Create bar chart
            var ctxBar = document.getElementById('barChart');
            var barChart = new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'User Estimate',
                            data: userValues,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                        },
                        {
                            label: 'Deal Nego',
                            data: dealNegoValues,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                        },
                    ],
                },
            });
        },
    });
</script>
@endsection
