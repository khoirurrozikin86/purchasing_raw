@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content mt-5">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <form id="consumptionForm" action="{{ route('update.consumption', $consumption->id) }}"
                                method="POST">
                                @csrf
                                @method('POST')

                                <div class="text-center">
                                    <h3>Edit Consumption</h3>
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger" role="alert">
                                        @foreach ($errors->all() as $error)
                                            <h3>{{ $error }}</h3>
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
                                                        id="cbd_id" name="cbd_id"
                                                        value="{{ $consumption->cbd_detail_id }}">

                                                    @foreach ($cbdDetails as $cbd)
                                                        <input type="text" class="form-control form-control-sm cbd_name"
                                                            id="cbd_name" name="cbd_name"
                                                            value="{{ $cbd->cbd->sample_code }}">
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="width" class="col-sm-3 col-form-label">Width</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" id="width"
                                                    name="width" value="{{ $consumption->width }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <table id="selectedCbdTable" class="table table-striped mt-3">
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
                                        @foreach ($cbdDetails as $cbd)
                                            <tr>
                                                <td>{{ $cbd->id }}</td>
                                                <td>{{ $cbd->order_no }}</td>
                                                <td>{{ $cbd->cbd->sample_code }}</td>
                                                <td>{{ $cbd->cbd->year . ' ' . $cbd->cbd->planning_ssn }}</td>
                                                <td>{{ $cbd->color_code }}</td>
                                                <td>{{ $cbd->color }}</td>
                                                <td>{{ $cbd->size }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <hr />

                                <div class="row">
                                    <h6>Consumption Detail</h6>

                                    <div class="col-md-12 mt-3">
                                        <table id="consumptionDetailsTable" class="table table-striped mt-3">
                                            <thead>
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Amount</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($details as $index => $detail)
                                                    <tr data-id="{{ $detail->id }}">
                                                        <td><input type="text" name="details[{{ $index }}][type]"
                                                                class="form-control form-control-sm"
                                                                value="{{ $detail->type }}" required></td>
                                                        <td><input type="number" step="0.01"
                                                                name="details[{{ $index }}][amount]"
                                                                class="form-control form-control-sm amount"
                                                                value="{{ $detail->amount }}" required></td>
                                                        <td><button type="button"
                                                                class="btn btn-danger btn-sm remove-detail">Remove</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group row mt-3">
                                        <label for="total_amount" class="col-sm-4 col-form-label">Total Consumption:</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control form-control-sm" id="total_amount"
                                                name="total_amount" value="{{ $consumption->total_amount }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <button type="button" id="addDetail" class="btn btn-secondary">Add Details</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include necessary scripts for handling dynamic rows -->
    <script>
        $(document).ready(function() {
            let detailIndex = {{ count($details) }};

            // Function to add new detail input fields
            $('#addDetail').click(function() {
                const newDetail = `
                        <tr>
                            <td>
                                <input type="text" name="details[${detailIndex}][type]" class="form-control form-control-sm" required>
                            </td>
                            <td>
                                <input type="number" step="0.01" name="details[${detailIndex}][amount]" class="form-control form-control-sm amount" required>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm removeDetail">Remove</button>
                                <input type="hidden" name="details[${detailIndex}][id]" value="">
                            </td>
                        </tr>
                    `;
                $('#consumptionDetailsTable tbody').append(newDetail);
                detailIndex++;
            });

            $('#consumptionDetailsTable').on('click', '.remove-detail', function() {
                $(this).closest('tr').remove();
                calculateTotalConsumption(); // Recalculate total if needed
            });


            // Function to calculate total consumption
            function calculateTotalConsumption() {
                let total = 0;
                $('#consumptionDetailsTable .amount').each(function() {
                    const amount = parseFloat($(this).val()) || 0;
                    total += amount;
                });
                $('#total_amount').val(total.toFixed(2));
            }

            // Add event listeners to update total consumption when amounts change
            $('#consumptionDetailsTable').on('input', '.amount', function() {
                calculateTotalConsumption();
            });

            $('#consumptionDetailsTable').on('input', 'input[name$="[type]"]', function() {
                $(this).val($(this).val().toUpperCase());
            });

            // Initialize total amount calculation on page load (if any pre-filled values exist)
            calculateTotalConsumption();

            // Initialize DataTables for CBD Detail Table
            var cbdDetailTable = $('#cbdDetailTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('get.cbddetail') }}",
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

            $('#cbdDetailTable tbody').on('click', 'tr', function() {
                var data = cbdDetailTable.row(this).data();
                var cbdId = data.id;

                // Set the cbd_id value in the main form
                $('.cbd_id').val(cbdId);
                $('.cbd_name').val(data.sample_code);

                // Add the selected CBD details to the selectedCbdTable
                $('#selectedCbdTable tbody').empty();
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

                $('#selectedCbdTable').removeClass('d-none');
                $('#cbdModal').modal('hide');
            });

            // Remove detail row
            $('#consumptionDetailsTable').on('click', '.removeDetail', function() {
                $(this).closest('tr').remove();
                calculateTotalConsumption();
            });
        });
    </script>

@endsection
