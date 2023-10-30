@extends('layouts.template')
@section('content')
@php
$pretitle = 'Application';
$title    = 'Dashboard'
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card border-primary mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Total All Vendors</h6>
                                <p class="card-text" id="totalVendor">Loading...</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-info mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Registered Vendors</h6>
                                <p class="card-text" id="registered">Loading...</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-success mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Active Vendors</h6>
                                <p class="card-text" id="active">Loading...</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-warning mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Expired Vendors</h6>
                                <p class="card-text" id="expired">Loading...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card border-primary mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Total All Procurements</h6>
                                <p class="card-text" id="totalProcurement">Loading...</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-info mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Process Procurements</h6>
                                <p class="card-text" id="processProcurement">Loading...</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-success mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Success Procurements</h6>
                                <p class="card-text" id="successProcurement">Loading...</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-danger mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Canceled Procurements</h6>
                                <p class="card-text" id="canceledProcurement">Loading...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h1>Last 5 Vendor Data</h1>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Vendor Name</th>
                                    <th>Join Date</th>
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
                    <div class="col-md-6">
                        <h1>Last 5 Procurements Data</h1>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Job Name</th>
                                    <th>Procurement Number</th>
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
                var cellJoinDate = row.insertCell(2);
                cellJoinDate.innerHTML = data[i].join_date;

                var cellVendorStatus = row.insertCell(3);
                if (data[i].status === "0") {
                    cellVendorStatus.innerHTML = '<span class="badge text-bg-info">Registered</span>';
                } else if (data[i].status === "1") {
                    cellVendorStatus.innerHTML = '<span class="badge text-bg-success">Active</span>';
                } else if (data[i].status === "2") {
                    cellVendorStatus.innerHTML = '<span class="badge text-bg-warning">Expired</span>';
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
@endsection
