@extends('layouts.template')
@section('content')
@php
$pretitle = 'Application';
$title    = 'Dashboard'
@endphp
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
@endsection
