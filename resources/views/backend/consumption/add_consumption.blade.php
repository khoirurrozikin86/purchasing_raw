@extends('admin.admin_dashboard')

@section('admin')

    {{-- <style>
        .modal-content {
            margin: auto;
            padding: 0px;
        }

        .modal-body {
            padding: 0px;
        }

        .table-hover {
            width: 80%;
            margin: 10px auto;
        }
    </style> --}}

    <div class="page-content mt-5">

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="container">

                            <form id="consumptionForm" action="{{ route('store.consumption') }}" method="POST">
                                @csrf

                                <div class="text-center">
                                    <h5>
                                        Add Consumption
                                    </h5>

                                </div>

                                {{-- <p class="text-danger">Add Purchase Request for CBD ID: {{ $cbdno }}</p> --}}

                                @if ($errors->any())
                                    <div class="alert alert-danger" role="alert">
                                        @foreach ($errors->all() as $error)
                                            <h3> {{ $error }} </h3>
                                        @endforeach

                                    </div>
                                @endif

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="cbd_id" class="col-sm-3 col-form-label">CBD</label>
                                            <div class="col-sm-6">

                                                <div class="input-group">
                                                    <input type="hidden" class="form-control form-control-sm cbd_id"
                                                        id="cbd_id" name="cbd_id">
                                                    <input type="text" class="form-control form-control-sm cbd_name"
                                                        id="cbd_name" name="cbd_name">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-secondary cbd_search" id="cbd_search"
                                                            type="button">
                                                            <i class="feather-10" data-feather="search"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">
                                            <label for="width" class="col-sm-3 col-form-label">Width</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="width" name="width">
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <table id="selectedCbdTable" class="table table-striped mt-3 d-none">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Order No</th>
                                            <th>Sample Code</th>
                                            <th>Planning Season</th>
                                            <th>Color Code</th>
                                            <th>Color</th>
                                            <th>Size</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Selected CBD details will be displayed here -->
                                    </tbody>
                                </table>

                                <hr />
                                {{-- 
                                <div class="row">
                                    <h6>Consumption Detail</h6>

                                    <div class="col-md-12 mt-3">

                                        <!-- Container for dynamic consumption details -->
                                        <div id="consumptionDetails">
                                            <div class="consumption-detail">

                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="type">Type:</label>
                                                            <input type="text" name="details[0][type]"
                                                                class="form-control form-control-sm" required>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="amount">Amount:</label>
                                                            <input type="number" step="0.01" name="details[0][amount]"
                                                                class="form-control form-control-sm amount" required>
                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                </div> --}}

                                <div class="row">
                                    <h5>Consumption Detail</h5>
                                    <div class="col-md-12 mt-3">
                                        <table id="consumptionDetails" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Amount</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input type="text" name="details[0][type]"
                                                            class="form-control form-control-sm" required></td>
                                                    <td><input type="number" step="0.01" name="details[0][amount]"
                                                            class="form-control form-control-sm amount" required></td>
                                                    <td><button type="button"
                                                            class="btn btn-danger btn-sm remove-detail">Remove</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group row mt-3">
                                        <label for="total_amount" class="col-sm-4 col-form-label">Total Consumption:</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control form-control-sm" id="total_amount"
                                                name="total_amount" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <!-- Button to add more details -->
                                    <button type="button" id="addDetail" class="btn btn-secondary">Add Details</button>

                                    <!-- Total Amount Consumption -->

                                    <button type="submit" class="btn btn-primary">Submit</button>

                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="cbdModal" tabindex="-1" aria-labelledby="cbdModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cbdModalLabel">CBD & CBD Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="container">

                        <table id="cbdDetailTable" class="table table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Order No</th>
                                    <th>Sample Code</th>
                                    <th>Planning Season</th>
                                    <th>Color Code</th>
                                    <th>Color</th>
                                    <th>Size</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded here by DataTables -->
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let detailIndex = 1;

            // Function to add new detail input fields
            $('#addDetail').click(function() {
                const newDetail = `
        <tr>
            <td><input type="text" name="details[${detailIndex}][type]" class="form-control form-control-sm" required></td>
            <td><input type="number" step="0.01" name="details[${detailIndex}][amount]" class="form-control form-control-sm amount" required></td>
            <td><button type="button" class="btn btn-danger  btn-sm remove-detail">Remove</button></td>
        </tr>
    `;
                $('#consumptionDetails tbody').append(newDetail);
                detailIndex++;
            });

            // Function to calculate total consumption
            function calculateTotalConsumption() {
                let total = 0;
                $('.amount').each(function() {
                    const amount = parseFloat($(this).val()) ||
                        0; // Ensure parsing to float and default to 0 if NaN
                    total += amount;
                });
                $('#total_amount').val(total.toFixed(2));
            }

            // Add event listeners to update total consumption when amounts change
            $('#consumptionDetails').on('input', '.amount', function() {
                calculateTotalConsumption();
            });

            // Add event listener to remove a detail row
            $('#consumptionDetails').on('click', '.remove-detail', function() {
                $(this).closest('tr').remove();
                calculateTotalConsumption();
            });

            $('#consumptionDetails').on('input', 'input[name$="[type]"]', function() {
                $(this).val($(this).val().toUpperCase());
            });

            // Initialize total amount calculation on page load (if any pre-filled values exist)
            calculateTotalConsumption();

            // Initialize DataTables for CBD Detail Table
            var cbdDetailTable = $('#cbdDetailTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('get.cbddetail') }}", // Adjust this route to your needs
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'order_no',
                        name: 'order_no'
                    },
                    {
                        data: 'sample_code',
                        name: 'sample_code'
                    },
                    {
                        data: 'planning_ssn',
                        name: 'planning_ssn'
                    },
                    {
                        data: 'color_code',
                        name: 'color_code'
                    },
                    {
                        data: 'color',
                        name: 'color'
                    },
                    {
                        data: 'size',
                        name: 'size'
                    }
                ]
            });

            // Show Modal and Fetch Data on Search Button Click
            $('#cbd_search').click(function() {
                $('#cbdModal').modal('show');
                cbdDetailTable.ajax.reload();
            });

            // Handle row click in CBD Detail Table
            $('#cbdDetailTable tbody').on('click', 'tr', function() {
                var data = cbdDetailTable.row(this).data();
                var cbdId = data.id; // Get the cbd_id from the clicked row

                // Set the cbd_id value in the main form
                $('.cbd_id').val(cbdId);
                $('.cbd_name').val(data
                    .sample_code); // Optionally set the CBD name or other details if needed

                // Add the selected CBD details to the selectedCbdTable
                $('#selectedCbdTable tbody').empty(); // Clear previous data
                $('#selectedCbdTable tbody').append(`
        <tr>
            <td>${data.id}</td>
            <td>${data.order_no}</td>
            <td>${data.sample_code}</td>
            <td>${data.planning_ssn}</td>
            <td>${data.color_code}</td>
            <td>${data.color}</td>
            <td>${data.size}</td>
        </tr>
    `);

                // Show the selected CBD details table
                $('#selectedCbdTable').removeClass('d-none');

                // Hide the modal
                $('#cbdModal').modal('hide');
            });
        });
    </script>
@endsection
