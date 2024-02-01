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
                        <label for="division" class="col-sm-3 form-label">Division:</label>
                        <select id="division" class="form-select" name="division">
                            <option value="">All Divisions</option>
                            @foreach ($divisions as $division)
                            <option value="{{ $division->id }}">{{ $division->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="official" class="col-sm-3 form-label">Official:</label>
                        <select id="official" class="form-select" name="official">
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
            </div>
        </div>
    </div>
    <div class="col-md-12 mt-3">
        <div class="card">
            <div class="card-body">
                <h3>Charts</h3>
                <div class="row mb-3">
                    <div class="row">
                        <div class="col-lg-12">
                            <canvas id="barChart"></canvas>
                        </div>
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
                    d.division = $('#division').val();
                    d.official = $('#official').val();
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
    });
</script>

<script>
    $(document).ready(function() {

    let chart;

    function getData(){
        $.ajax({
            url: route('chart.barChart'),
            method: 'GET',
            dataType: 'json',
            data: {
                'division' : $("#division").val(),
                'official' : $("#official").val(),
            },
            success:function(data){

                const procurementsData = data.procurementsData;

                const ctx = document.getElementById('barChart').getContext('2d');

                if (chart){
                    chart.destroy();
                }
                let labels = [];
                let dataEEUser = [];
                let dataDealNego = [];
                let dataUserPercentage = [];

                if (procurementsData.length > 0) {
                    labels = procurementsData.map(item => item.month_year);
                    dataEEUser = procurementsData.map(item => item.user_estimates);
                    dataDealNego = procurementsData.map(item => item.deal_negos);
                    dataUserPercentage = procurementsData.map(item => item.user_percentages);
                }

                chart = new Chart(ctx,{
                    type:'scatter',
                    data:{
                        labels: labels,
                        datasets: [
                            {
                            type: 'bar',
                            label: 'EE User',
                            data: dataEEUser,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            yAxisID: 'left-y-axis',
                            },
                            {
                            type: 'bar',
                            label: 'Hasil Negosiasi',
                            data: dataDealNego,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            yAxisID: 'left-y-axis',
                            },
                            {
                            type: 'line',
                            label: '% User',
                            data: dataUserPercentage,
                            borderColor: 'rgb(75, 192, 192)',
                            lineTension: 0,
                            fill: false,
                            borderColor: 'orange',
                            backgroundColor: 'transparent',
                            borderDash: [5, 5],
                            pointBorderColor: 'orange',
                            pointBackgroundColor: 'rgba(255,150,0,0.5)',
                            pointRadius: 5,
                            pointHoverRadius: 10,
                            pointHitRadius: 30,
                            pointBorderWidth: 2,
                            pointStyle: 'rectRounded',
                            yAxisID: 'right-y-axis',
                            },
                        ]
                    },
                    options:{
                        responsive:true,
                        scales:{
                            'left-y-axis': {
                                type: 'linear',
                                position: 'left'
                            },
                            'right-y-axis': {
                                type: 'linear',
                                position: 'right'
                            },
                            y: {
                                beginAtZero: true,
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom',
                            },
                        },
                    }
                })
            },
            error: function(error){
                console.log(error);
            }
        })
    }
    getData();
      // Tambahkan event listener untuk pembaruan ketika filter diubah
    $('#division, #official').on('change', function() {
        getData();
    });
});
</script>
@endsection
