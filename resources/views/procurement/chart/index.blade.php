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
                <div class="col-lg-12 mt-3">
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <canvas id="scatterChart" width="50" height="50"></canvas>
                        </div>
                        <div class="col-lg-6">
                            <canvas id="doughnutChart" width="50" height="50"></canvas>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <canvas id="barChart" width="50" height="50"></canvas>
                        </div>
                        <div class="col-lg-6">
                            <canvas id="lineChart" width="50" height="50"></canvas>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <canvas id="multipleAxes" width="50" height="50"></canvas>
                        </div>
                        <div class="col-lg-6">
                            <canvas id="pieChart" width="50" height="50"></canvas>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <canvas id="areaChart" width="50" height="50"></canvas>
                        </div>
                        <div class="col-lg-6">
                            <canvas id="densityChart" width="50" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const chartScatter = document.getElementById('scatterChart');

    new Chart(chartScatter, {
        type: 'scatter',
        data: {
        labels: [
            'January',
            'February',
            'March',
            'April',
            'Mei',
            'Juni',
            'Juli',
        ],
        datasets: [{
            type: 'bar',
            label: 'Bar Dataset',
            data: [5, 8, 12, 17, 22, 28, 36],
            borderColor: [
            'rgb(255, 99, 132)',
            'rgb(255, 159, 64)',
            'rgb(255, 205, 86)',
            'rgb(75, 192, 192)',
            'rgb(54, 162, 235)',
            'rgb(153, 102, 255)',
            'rgb(201, 203, 207)'
            ],
            borderWidth: 1,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(201, 203, 207, 0.2)'
            ]
        }, {
            type: 'line',
            label: 'Line Dataset',
            data: [2, 6, 9, 12, 16, 8, 10],
            fill: false,
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
            pointStyle: 'rectRounded'
        }]
        },
        options: {
            plugins: {
                legend: {
                    display: true,
                    position: 'right'
                }
            },
            scales: {
                y: {
                beginAtZero: true
                }
            }
        }
    });
</script>
<script>
    const chartDoughnut = document.getElementById('doughnutChart');

    new Chart(chartDoughnut, {
        type: 'doughnut',
        data: {
            labels: [
                'Red',
                'Blue',
                'Yellow'
            ],
            datasets: [{
                label: 'My First Dataset',
                data: [300, 50, 100],
                backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
            }]
        },
    });
</script>
<script>
    var barChart = document.getElementById("barChart");

    var densityData = {
        label: 'Density of Planet (kg/m3)',
        data: [5427, 5243, 5514, 3933, 1326, 687, 1271, 1638],
        backgroundColor: 'rgba(0, 99, 132, 0.6)',
        borderColor: 'rgba(0, 99, 132, 1)',
        yAxisID: "y-axis-density"
    };

    var gravityData = {
        label: 'Gravity of Planet (m/s2)',
        data: [3.7, 8.9, 9.8, 3.7, 23.1, 9.0, 8.7, 11.0],
        backgroundColor: 'rgba(99, 132, 0, 0.6)',
        borderColor: 'rgba(99, 132, 0, 1)',
        yAxisID: "y-axis-gravity"
    };

    var planetData = {
        labels: ["Mercury", "Venus", "Earth", "Mars", "Jupiter", "Saturn", "Uranus", "Neptune"],
        datasets: [densityData, gravityData]
    };

    var chartOptions = {
        scales: {
            xAxes: [{
            barPercentage: 1,
            categoryPercentage: 0.6
            }],
            yAxes: [{
            id: "y-axis-density"
            }, {
            id: "y-axis-gravity"
            }]
        }
    };

    var barChart = new Chart(barChart, {
        type: 'bar',
        data: planetData,
        options: chartOptions
    });
</script>
<script>
    var speedCanvas = document.getElementById("lineChart");

    var dataFirst = {
        label: "Car A - Speed (mph)",
        data: [0, 59, 75, 20, 20, 55, 40],
        lineTension: 0,
        fill: false,
        borderColor: 'red'
    };

    var dataSecond = {
        label: "Car B - Speed (mph)",
        data: [20, 15, 60, 60, 65, 30, 70],
        lineTension: 0,
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        fill: true,
        borderColor: 'blue'
    };

    var speedData = {
    labels: ["0s", "10s", "20s", "30s", "40s", "50s", "60s"],
    datasets: [dataFirst, dataSecond]
    };

    var chartOptions = {
    legend: {
        display: true,
        position: 'top',
        labels: {
        boxWidth: 80,
        fontColor: 'black'
        }
    }
    };

    var lineChart = new Chart(speedCanvas, {
    type: 'line',
    data: speedData,
    options: chartOptions
    });
</script>
<script>
    var multipleAxes = new Chart("multipleAxes", {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            data: [20, 50, 100, 75, 25, 0],
            label: 'Left dataset',

            // This binds the dataset to the left y axis
            yAxisID: 'left-y-axis'
        }, {
            data: [0.1, 0.5, 1.0, 2.0, 1.5, 0],
            label: 'Right dataset',

            // This binds the dataset to the right y axis
            yAxisID: 'right-y-axis'
        }],
    },
    options: {
        scales: {
            'left-y-axis': {
                type: 'linear',
                position: 'left'
            },
            'right-y-axis': {
                type: 'linear',
                position: 'right'
            }
        }
    }
    });
</script>
<script>
    const chartPie = document.getElementById('pieChart');

    new Chart(chartPie, {
        type: 'pie',
        data: {
            labels: [
                'Red',
                'Blue',
                'Yellow',
                'Green',
            ],
            datasets: [{
                label: 'My First Dataset',
                data: [300, 50, 100, 25],
                backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)',
                'rgb(60, 179, 113)',
                ],
                hoverOffset: 4
            }]
        },
    });
</script>
<script>
    var areaChart =document.getElementById('areaChart').getContext('2d');
        var myChart = new Chart(areaChart, {
            type: 'line',
            data: {
                labels: ['January',
                        'February',
                        'March',
                        'April',
                        'May'],
                datasets: [{
                    label: 'Page Views',
                    data: [5000, 7500, 8000, 6000, 9000],
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: 'origin'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Page Views'
                        }
                    }
                },
                layout: {
                    padding: {
                        left: 20,
                        right: 20,
                        top: 20,
                        bottom: 20
                    }
                },
                responsive: true,
                tension: 0.3
            }
        });
</script>
<script>
    var densityCanvas = document.getElementById("densityChart");

    var densityData = {
    label: 'Density of Planets (kg/m3)',
    data: [5427, 5243, 5514, 3933, 1326, 687, 1271, 1638],
    backgroundColor: [
        'rgba(0, 99, 132, 0.6)',
        'rgba(30, 99, 132, 0.6)',
        'rgba(60, 99, 132, 0.6)',
        'rgba(90, 99, 132, 0.6)',
        'rgba(120, 99, 132, 0.6)',
        'rgba(150, 99, 132, 0.6)',
        'rgba(180, 99, 132, 0.6)',
        'rgba(210, 99, 132, 0.6)',
        'rgba(240, 99, 132, 0.6)'
    ],
    borderColor: [
        'rgba(0, 99, 132, 1)',
        'rgba(30, 99, 132, 1)',
        'rgba(60, 99, 132, 1)',
        'rgba(90, 99, 132, 1)',
        'rgba(120, 99, 132, 1)',
        'rgba(150, 99, 132, 1)',
        'rgba(180, 99, 132, 1)',
        'rgba(210, 99, 132, 1)',
        'rgba(240, 99, 132, 1)'
    ],
    borderWidth: 2,
    hoverBorderWidth: 0
    };

    var chartOptions = {
    scales: {
        yAxes: [{
        barPercentage: 0.5
        }]
    },
    elements: {
        rectangle: {
        borderSkipped: 'left',
        }
    }
    };

    var barChart = new Chart(densityCanvas, {
    type: 'horizontalBar',
    data: {
        labels: ["Mercury", "Venus", "Earth", "Mars", "Jupiter", "Saturn", "Uranus", "Neptune"],
        datasets: [densityData],
    },
    options: chartOptions
    });
</script>
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
                }
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
@endsection
