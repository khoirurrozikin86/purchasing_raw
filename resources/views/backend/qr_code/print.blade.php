@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">

        <div class="row profile-body">

            <!-- left wrapper end -->
            <!-- middle wrapper start -->
            <div class="col-md-12 col-xl-12 middle-wrapper">
                <div class="row">
                    <div class="card">
                        <div class="card-body">

                            <h6 class="card-title">Print Barcode</h6>

                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    @foreach ($errors->all() as $error)
                                        <h3> {{ $error }} </h3>
                                    @endforeach

                                </div>
                            @endif

                            <form id="myForm" class="forms-sample" method="POST" action="{{ route('pdf.qr_code') }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="mt-3">
                                    <label for="">From</label>
                                </div>
                                <div class="input-group">

                                    <div class="form-outline" data-mdb-input-init>

                                        <input type="search" id="range1" name="range1" class="form-control"
                                            placeholder="Search" required />

                                    </div>
                                    <button type="button" class="btn btn-primary" data-mdb-ripple-init
                                        id="showQrcodeModal">
                                        <i class="feather-16" data-feather="search"></i>
                                    </button>
                                </div>

                                <div class="mt-3">
                                    <label for="">TO</label>
                                </div>
                                <div class="input-group">

                                    <div class="form-outline" data-mdb-input-init>

                                        <input type="search" id="range2" name="range2" class="form-control"
                                            placeholder="Search" required />

                                    </div>
                                    <button type="button" class="btn btn-primary" data-mdb-ripple-init
                                        id="showQrcodeModal1">
                                        <i class="feather-16" data-feather="search"></i>
                                    </button>
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary"> <i class="feather-16"
                                            data-feather="printer"></i> Print</button>
                                    <a href="{{ route('all.qr_code') }}" class="btn btn-danger">Back</a>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>
            <!-- middle wrapper end -->
            <!-- right wrapper start -->

            <!-- right wrapper end -->
        </div>

    </div>

    <!-- Modal for displaying qrcode details -->
    <div class="modal fade" id="qrcodeModal" tabindex="-1" aria-labelledby="qrcodeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrcodeModalLabel">QRCode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="dataTableExamples" class="table table-hover">
                        <thead>
                            <tr>

                                <th>Original No</th>
                            </tr>
                        </thead>
                        <tbody id="qrcodeData">
                            <!-- Qrcode data will be dynamically populated here -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- Add additional buttons if needed -->
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="qrcodeModal1" tabindex="-1" aria-labelledby="qrcodeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrcodeModalLabel">QRCode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="dataTableExamples1" class="table table-hover">
                        <thead>
                            <tr>

                                <th>Original No</th>
                            </tr>
                        </thead>
                        <tbody id="qrcodeData1">
                            <!-- Qrcode data will be dynamically populated here -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- Add additional buttons if needed -->
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Initialize the DataTable

            $('#range1').val('');
            var table;
            var table1;

            // CSRF token for secure requests
            var token = $('meta[name="csrf-token"]').attr('content');

            // Function to load data via AJAX and populate the DataTable
            function loadQrcodeData() {
                $.ajax({
                    url: "{{ route('get.original') }}", // Adjust to your route
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    success: function(response) {
                        if (table) {
                            table.clear().rows.add(response.map(function(range1) {
                                return [range1];
                            })).draw();
                        } else {
                            table = $('#dataTableExamples').DataTable({
                                paging: true,
                                searching: true,
                                ordering: true,
                                info: true,
                                data: response.map(function(range1) {
                                    return [range1];
                                }),
                                columns: [{
                                    title: "Original No"
                                }]
                            });

                            // Add click event listener to table rows
                            $('#dataTableExamples tbody').on('click', 'tr', function() {
                                var data = table.row(this).data();
                                $('#range1').val(data[0]);
                                $('#qrcodeModal').modal('hide'); // Hide modal after selection
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            function loadQrcodeData1() {
                $.ajax({
                    url: "{{ route('get.original') }}", // Adjust to your route
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    success: function(response) {
                        if (table1) {
                            table1.clear().rows.add(response.map(function(range2) {
                                return [range2];
                            })).draw();
                        } else {
                            table1 = $('#dataTableExamples1').DataTable({
                                paging: true,
                                searching: true,
                                ordering: true,
                                info: true,
                                data: response.map(function(range2) {
                                    return [range2];
                                }),
                                columns: [{
                                    title: "Original No"
                                }]
                            });

                            // Add click event listener to table1 rows
                            $('#dataTableExamples1 tbody').on('click', 'tr', function() {
                                var data = table1.row(this).data();
                                $('#range2').val(data[0]);
                                $('#qrcodeModal1').modal('hide'); // Hide modal after selection
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            // Show the modal and load data when the button is clicked
            $('#showQrcodeModal').click(function() {
                $('#qrcodeModal').modal('show');
                loadQrcodeData();
            });

            $('#showQrcodeModal1').click(function() {
                $('#qrcodeModal1').modal('show');
                loadQrcodeData1();
            });

            // Adjust columns once the modal is fully shown
            $('#qrcodeModal').on('shown.bs.modal', function() {
                if (table) {
                    table.columns.adjust().draw();
                }
            });

            $('#qrcodeModal1').on('shown.bs.modal', function() {
                if (table1) {
                    table1.columns.adjust().draw();
                }
            });

            $('#myForm button[type="submit"]').click(function() {
                $('#myForm').attr('target', '_blank').submit();
            });



        });
    </script>

@endsection
