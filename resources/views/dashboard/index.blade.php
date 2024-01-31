@extends('layouts.template')
@section('content')
@php
$pretitle = 'Application';
$title    = 'Dashboard'
@endphp
@if(auth()->user()->hasRole('Developer'))
    @can('dashboard-chart')
        <div class="row row-deck row-cards mb-3">
            <div class="col-12">
                <div class="row row-cards">
                    <div class="col-lg-4">
                        <div class="card">
                            <canvas id="doughnutChart" width="50" height="50"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <canvas id="pieChart" width="50" height="50"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <canvas id="myChart" width="50" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row row-cards">
                    <div class="col-lg-4">
                        <div class="card">
                            <canvas id="densityChart" width="50" height="50"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <canvas id="areaChart" width="50" height="50"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <canvas id="lineChart" width="50" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row row-cards">
                    <div class="col-lg-4">
                        <div class="card">
                            <canvas id="barChart" width="50" height="50"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <canvas id="multipleAxes" width="50" height="50"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <canvas id="scatterChart" width="50" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endif
    <div class="row row-deck row-cards">
        <div class="col-12">
            <div class="row row-cards">
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-primary text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-sum" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M18 16v2a1 1 0 0 1 -1 1h-11l6 -7l-6 -7h11a1 1 0 0 1 1 1v2"></path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                        Total All Vendors
                                    </div>
                                    <div class="text-secondary" id="totalVendor">
                                        Loading...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-info text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/shopping-cart -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-registered" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                    <path d="M10 15v-6h2a2 2 0 1 1 0 4h-2"></path>
                                    <path d="M14 15l-2 -2"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">
                                Registered Vendors
                            </div>
                            <div class="text-secondary" id="registered">
                                Loading...
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-success text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/brand-twitter -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-checkbox" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M9 11l3 3l8 -8"></path>
                                    <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">
                                Active Vendors
                            </div>
                            <div class="text-secondary" id="active">
                                Loading...
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-warning text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/brand-facebook -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alert-square-rounded-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 2l.642 .005l.616 .017l.299 .013l.579 .034l.553 .046c4.687 .455 6.65 2.333 7.166 6.906l.03 .29l.046 .553l.041 .727l.006 .15l.017 .617l.005 .642l-.005 .642l-.017 .616l-.013 .299l-.034 .579l-.046 .553c-.455 4.687 -2.333 6.65 -6.906 7.166l-.29 .03l-.553 .046l-.727 .041l-.15 .006l-.617 .017l-.642 .005l-.642 -.005l-.616 -.017l-.299 -.013l-.579 -.034l-.553 -.046c-4.687 -.455 -6.65 -2.333 -7.166 -6.906l-.03 -.29l-.046 -.553l-.041 -.727l-.006 -.15l-.017 -.617l-.004 -.318v-.648l.004 -.318l.017 -.616l.013 -.299l.034 -.579l.046 -.553c.455 -4.687 2.333 -6.65 6.906 -7.166l.29 -.03l.553 -.046l.727 -.041l.15 -.006l.617 -.017c.21 -.003 .424 -.005 .642 -.005zm.01 13l-.127 .007a1 1 0 0 0 0 1.986l.117 .007l.127 -.007a1 1 0 0 0 0 -1.986l-.117 -.007zm-.01 -8a1 1 0 0 0 -.993 .883l-.007 .117v4l.007 .117a1 1 0 0 0 1.986 0l.007 -.117v-4l-.007 -.117a1 1 0 0 0 -.993 -.883z" stroke-width="0" fill="currentColor"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">
                                Inactive Vendors
                            </div>
                            <div class="text-secondary" id="expired">
                                Loading...
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="row row-cards">
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-primary text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                        Total All Procurements
                                    </div>
                                    <div class="text-secondary" id="totalProcurement">
                                        Loading...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-info text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/shopping-cart -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-time" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                    <path d="M12 14m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                    <path d="M12 12.496v1.504l1 1"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">
                                Process Procurements
                            </div>
                            <div class="text-secondary" id="processProcurement">
                                Loading...
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-success text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/brand-twitter -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                    <path d="M9 15l2 2l4 -4"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">
                                Success Procurements
                            </div>
                            <div class="text-secondary" id="successProcurement">
                                Loading...
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-danger text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/brand-facebook -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                    <path d="M10 12l4 4m0 -4l-4 4"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">
                                Canceled Procurements
                            </div>
                            <div class="text-secondary" id="canceledProcurement">
                                Loading...
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="row row-cards">
                <div class="col-sm-6 col-lg-6">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <h1>Last 5 Vendors Data</h1>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Vendor Name</th>
                                                <th>Grade</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody  id="latestVendorsTable">
                                            <tr id="loadingRow">
                                                <td colspan="4" class="text-center">
                                                    <div class="spinner-border" role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <h1>Last 5 Procurements Data</h1>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Job Name</th>
                                                <th>Number</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody  id="latestProcurementTable">
                                            <tr id="loadingRow">
                                                <td colspan="4" class="text-center">
                                                    <div class="spinner-border" role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- Data will be populated dynamically -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    // Fungsi untuk mengambil data jumlah vendor terdaftar, aktif, dan kedaluwarsa melalui API
    function fetchDataVendor() {
        fetch('{{ route('dashboard.vendor-count') }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
            document.getElementById('totalVendor').textContent = data.totalVendor;
            document.getElementById('registered').textContent = data.registered;
            document.getElementById('active').textContent = data.active;
            document.getElementById('expired').textContent = data.expired;
            } else {
            console.log(data.message); // Menampilkan pesan error jika ada
            }
        })
        .catch(error => {
            console.log(error);
        });
    }
    function fetchDataProcurement() {
        fetch('{{ route('dashboard.procurement-count') }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
            document.getElementById('totalProcurement').textContent = data.totalProcurement;
            document.getElementById('processProcurement').textContent = data.processProcurement;
            document.getElementById('successProcurement').textContent = data.successProcurement;
            document.getElementById('canceledProcurement').textContent = data.canceledProcurement;
            } else {
            console.log(data.message); // Menampilkan pesan error jika ada
            }
        })
        .catch(error => {
            console.log(error);
        });
    }

    // Memanggil fungsi fetchData saat halaman selesai dimuat
    document.addEventListener('DOMContentLoaded', fetchDataVendor);
    document.addEventListener('DOMContentLoaded', fetchDataProcurement);

</script>
<script>
    // Populate table with data
    function populateTable(data, tableId) {
        var table = document.getElementById(tableId);
        table.innerHTML = ''; // Clear existing table content

        for (var i = 0; i < data.length; i++) {
            var row = table.insertRow(i);

            // Create cells and fill them with data
            var cellIndex = row.insertCell(0);
            cellIndex.innerHTML = i + 1;

            var cellName = row.insertCell(1);
            cellName.innerHTML = data[i].name;

            if (tableId === 'latestVendorsTable') {
                var cellGrade = row.insertCell(2);
                if (data[i].grade === "0") {
                    cellGrade.innerHTML = '<span class="badge badge-outline text-purple">Kecil</span>';
                } else if (data[i].grade === "1") {
                    cellGrade.innerHTML = '<span class="badge badge-outline text-indigo">Menengah</span>';
                } else if (data[i].grade === "2") {
                    cellGrade.innerHTML = '<span class="badge badge-outline text-azure">Besar</span>';
                } else {
                    cellGrade.innerHTML = '<span class="badge badge-outline text-blue">Unknown</span'; // Handle case when status has unexpected value
                }
                // cellGrade.innerHTML = data[i].grade;

                var cellVendorStatus = row.insertCell(3);
                if (data[i].status === "0") {
                    cellVendorStatus.innerHTML = '<span class="badge text-bg-info">Registered</span>';
                } else if (data[i].status === "1") {
                    cellVendorStatus.innerHTML = '<span class="badge text-bg-success">Active</span>';
                } else if (data[i].status === "2") {
                    cellVendorStatus.innerHTML = '<span class="badge text-bg-warning">Inactive</span>';
                } else {
                    cellVendorStatus.innerHTML = '<span class="badge text-bg-secondary">Unknown</span'; // Handle case when status has unexpected value
                }

            } else if (tableId === 'latestProcurementTable') {
                var cellProcurementNumber = row.insertCell(2);
                cellProcurementNumber.innerHTML = data[i].number;

                var cellStatus = row.insertCell(3);
                if (data[i].status === "0") {
                    cellStatus.innerHTML = '<span class="badge rounded-pill text-bg-info">Process</span>';
                } else if (data[i].status === "1") {
                    cellStatus.innerHTML = '<span class="badge rounded-pill text-bg-success">Success</span>';
                } else if (data[i].status === "2") {
                    cellStatus.innerHTML = '<span class="badge rounded-pill text-bg-danger">Canceled</span>';
                } else {
                    cellStatus.innerHTML = '<span class="badge rounded-pill text-bg-secondary">Unknown</span>'; // Handle case when status has unexpected value
                }
            }
        }
    }

    // Fetch data and populate vendor table
    function fetchVendorData() {
        fetch('{{ route('dashboard.table-data-vendor') }}')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    populateTable(data.data, 'latestVendorsTable');
                    table.style.display = 'table'; // Tampilkan tabel setelah data diperoleh
                    loadingRow.style.display = 'none'; // Sembunyikan pesan loading
                } else {
                    console.log(data.message); // Display error message if any
                }
            })
            .catch(error => {
                console.log(error);
            });
    }

    // Fetch data and populate procurement table
    function fetchProcurementData() {
        fetch('{{ route('dashboard.table-data-procurement') }}')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    populateTable(data.data, 'latestProcurementTable');
                    table.style.display = 'table'; // Tampilkan tabel setelah data diperoleh
                    loadingRow.style.display = 'none'; // Sembunyikan pesan loading
                } else {
                    console.log(data.message); // Display error message if any
                }
            })
            .catch(error => {
                console.log(error);
            });
    }

    // Call fetchData functions when the DOM content is loaded
    document.addEventListener('DOMContentLoaded', () => {
        fetchVendorData();
        fetchProcurementData();
    });
</script>
<!-- bagian untuk chart -->
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
                    position: 'top'
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
            x: {
            barPercentage: 1,
            categoryPercentage: 0.6
            },
            y: {
            id: "y-axis-density, y-axis-gravity"
            }
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
    indexAxis: 'y',
    scales: {
        y: {
        ticks: {
            crossAlign: 'far',
            }
        }
    },
    elements: {
        rectangle: {
        borderSkipped: 'left',
        }
    }
    };

    var barChart = new Chart(densityCanvas, {
    type: 'bar',
    data: {
        labels: ["Mercury", "Venus", "Earth", "Mars", "Jupiter", "Saturn", "Uranus", "Neptune"],
        datasets: [densityData],
    },
    options: chartOptions
    });
</script>
<script>
    const ctx = document.getElementById('myChart');

        new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            borderWidth: 1
            }]
        },
        options: {
            scales: {
            y: {
                beginAtZero: true
            }
            }
        }
    });
</script>
@endsection
