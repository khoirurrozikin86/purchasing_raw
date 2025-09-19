@extends('admin.admin_dashboard')

@section('admin')
    <style>
        .table1 tr th {
            background: #35A9DB;
            color: #fff;
            font-weight: normal;
        }

        td {
            text-align: center;
        }
    </style>
    <div class="page-content">

        <div class="align-items-center">
            <div>
                {{-- <h4 class="mb-3 mb-md-0 text-center">Dashboard Peminjaman </h4> --}}
                <h2 class="time-now text-center" id="timenow"></h2>
                <div class="date-now text-center" id="datenow"></div>
            </div>

        </div>

        <div class="row">
            <div class="col-12 col-xl-12 stretch-card">
                <div class="area-datetime  align-items-center">

                </div>

            </div>
        </div>

        <div class="container mt-3">

            <div class="row mt-2">
                <div class="col-12 col-xl-12 stretch-card">
                    <div class="row flex-grow-1">
                        <div class="col-md-3 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body bg-info text-white">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <h6 class="card-title mb-0">REQUEST DOCUMENT (PR)</h6>

                                    </div>
                                    <div class="row">
                                        <h1 class="txt-count mb-2" id="txt-count-request-pr"></h1>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body bg-warning text-white">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <h6 class="card-title mb-0">PURCHASE DOCUMENT (PO) </h6>

                                    </div>
                                    <div class="row">
                                        <h1 class="txt-count mb-2" id="txt-count-purchase-po"></h1>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body bg-secondary text-white">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <h6 class="card-title mb-0">PENDING DOCUMENT (PR) </h6>

                                    </div>
                                    <div class="row">
                                        <h1 class="txt-count mb-2" id="txt-count-request-pending"></h1>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body bg-success text-white">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <h6 class="card-title mb-0">SEND PO </h6>

                                    </div>
                                    <div class="row">
                                        <h1 class="txt-count mb-2" id="txt-count-send-po"></h1>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="container mt-3">

            <div class="row mt-2">
                <div class="col-12 col-xl-12 stretch-card">
                    <div class="row flex-grow-1">
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body bg-danger text-white">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <h6 class="card-title mb-0">REQUEST BY ITEM</h6>

                                    </div>
                                    <div class="row">
                                        <h1 class="txt-count mb-2" id="txt-count-request"></h1>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body bg-primary text-white">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <h6 class="card-title mb-0">PURCHASE BY ITEM </h6>

                                    </div>
                                    <div class="row">
                                        <h1 class="txt-count mb-2" id="txt-count-purchase"></h1>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

    <script>
        $(document).ready(function() {
            // Fetch data dari server
            fetchRequest();
            fetchPurchase();
            fetchRequestPR();
            fetchPurchasePO();
            fetchPurchasePending();
            fetchSendPO();

            function fetchRequest() {
                $.ajax({
                    url: "{{ route('get.purchaserequestcount') }}",

                    method: "GET",
                    success: function(data) {
                        // Update data di kartu
                        $('#txt-count-request').text(data.request);

                    },
                    error: function(xhr) {
                        console.error("Error fetching stats:", xhr);
                    }
                });
            }

            function fetchPurchase() {
                $.ajax({
                    url: "{{ route('get.purchaseordercount') }}",
                    method: "GET",
                    success: function(data) {
                        // Update data di kartu

                        $('#txt-count-purchase').text(data.request);

                    },
                    error: function(xhr) {
                        console.error("Error fetching stats:", xhr);
                    }
                });
            }

            function fetchRequestPR() {
                $.ajax({
                    url: "{{ route('get.purchaserequestcountPR') }}",

                    method: "GET",
                    success: function(data) {
                        // Update data di kartu
                        $('#txt-count-request-pr').text(data.request);

                    },
                    error: function(xhr) {
                        console.error("Error fetching stats:", xhr);
                    }
                });
            }

            function fetchPurchasePO() {
                $.ajax({
                    url: "{{ route('get.purchaseordercountPO') }}",
                    method: "GET",
                    success: function(data) {
                        // Update data di kartu

                        $('#txt-count-purchase-po').text(data.request);

                    },
                    error: function(xhr) {
                        console.error("Error fetching stats:", xhr);
                    }
                });
            }

            function fetchPurchasePending() {
                $.ajax({
                    url: "{{ route('get.purchaserequestcountPending') }}",
                    method: "GET",
                    success: function(data) {
                        // Update data di kartu

                        $('#txt-count-request-pending').text(data.request);

                    },
                    error: function(xhr) {
                        console.error("Error fetching stats:", xhr);
                    }
                });
            }

            function fetchSendPO() {
                $.ajax({
                    url: "{{ route('get.purchaseordersendcount') }}",

                    method: "GET",
                    success: function(data) {
                        // Update data di kartu
                        $('#txt-count-send-po').text(data.request);

                    },
                    error: function(xhr) {
                        console.error("Error fetching stats:", xhr);
                    }
                });
            }

            function fetchIn() {
                $.ajax({
                    url: "{{ route('get.materialincount') }}",
                    method: "GET",
                    success: function(data) {
                        // Update data di kartu

                        $('#txt-count-in').text(data.request);

                    },
                    error: function(xhr) {
                        console.error("Error fetching stats:", xhr);
                    }
                });
            }

            function fetchOut() {
                $.ajax({
                    url: "{{ route('get.materialoutcount') }}",
                    method: "GET",
                    success: function(data) {
                        // Update data di kartu

                        $('#txt-count-out').text(data.request);
                    },
                    error: function(xhr) {
                        console.error("Error fetching stats:", xhr);
                    }
                });
            }

        });
    </script>
@endsection
