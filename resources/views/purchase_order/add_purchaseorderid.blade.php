@extends('admin.admin_dashboard')

@section('admin')

    <style>
        .table-scrollable {
            position: relative;
            max-height: 300px;
            /* Sesuaikan tinggi maksimum sesuai kebutuhan */
            overflow-y: auto;
        }

        .table-scrollable thead {
            position: sticky;
            top: 0;
            background-color: white;
            /* Pastikan header memiliki latar belakang agar terlihat */
            z-index: 1;
        }

        .table-scrollable table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-scrollable th,
        .table-scrollable td {
            padding: 5px;
            border: 1px solid #ddd;
            font-size: 0.8em;
            /* Font-size lebih kecil */
        }
    </style>

    <div class="page-content mt-5">

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="row">

                            <div class="container">

                                <form action="{{ route('store.purchaseorder') }}" method="POST">
                                    @csrf
                                    <!-- Purchase Request Fields -->

                                    <div class="text-center">
                                        Purchase Order Information
                                    </div>
                                    <hr>

                                    {{-- <p class="text-danger">Add Purchase Request for CBD ID: {{ $cbdno }}</p> --}}

                                    @if ($errors->any())
                                        <div class="alert alert-danger" role="alert">
                                            @foreach ($errors->all() as $error)
                                                <h3> {{ $error }} </h3>
                                            @endforeach

                                        </div>
                                    @endif

                                    <div class="row">

                                        <div class="col-md-6">

                                            <div class="form-group row">
                                                {{-- <label for="cbd_id" class="col-sm-4 col-form-label">CBD ID</label> --}}
                                                <div class="col-sm-5">
                                                    {{-- <input type="hidden" class="form-control" id="cbd_id" 
                                                        name="cbd_id" value="{{ $cbdId }}" readonly> --}}
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="supplier_id" class="col-sm-4 col-form-label">Supplier</label>
                                                <div class="col-sm-5">

                                                    <input type="hidden" class="form-control purchase_request_id"
                                                        id="purchase_request_id" name="purchase_request_id"
                                                        value="{{ $purchaseRequest->id }}">
                                                    <input type="hidden" class="form-control supplier_id" id="supplier_id"
                                                        name="supplier_id">
                                                    <input type="text" class="form-control supplier_name"
                                                        id="supplier_name" name="supplier_name">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="request_in_house" class="col-sm-4 col-form-label">Request In
                                                    House</label>
                                                <div class="col-sm-5">
                                                    <input type="date" class="form-control" id="request_in_house"
                                                        name="request_in_house" required
                                                        value="{{ $purchaseRequest->time_line }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="terms" class="col-sm-4 col-form-label">Terms</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="terms"
                                                        name="terms">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="payment" class="col-sm-4 col-form-label">Payment</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="payment"
                                                        name="payment">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="shipment_mode" class="col-sm-4 col-form-label">Shipment
                                                    Mode</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="shipment_mode"
                                                        name="shipment_mode">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group row">
                                                <label for="allocation" class="col-sm-4 col-form-label">Allocation</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="allocation"
                                                        name="allocation" required
                                                        value="{{ $purchaseRequest->department }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="applicant" class="col-sm-4 col-form-label">Applicant</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="applicant"
                                                        name="applicant" required value="{{ $purchaseRequest->applicant }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="approval" class="col-sm-4 col-form-label">Approval</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="approval"
                                                        name="approval" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="quotation_no" class="col-sm-4 col-form-label">Quotition
                                                    No</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="quotation_no"
                                                        name="quotation_no">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="delivery_at" class="col-sm-4 col-form-label">Delivery
                                                    At</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="delivery_at"
                                                        name="delivery_at" value="{{ $purchaseRequest->department }}">
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <hr>

                                    <!-- Purchase Request Details Fields -->
                                    <div class="row">

                                        <div>
                                            <h6>Request Items</h6>
                                            <table class="table" id="items-table1">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Item ID</th>
                                                        <th>Item Code</th>
                                                        <th>Item Name</th>
                                                        <th>Color</th>
                                                        <th>Size</th>
                                                        <th>Quantity</th>
                                                        <th>Total</th>
                                                        <th>Unit</th>
                                                        <th>Remark</th>
                                                        <th>Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>

                                        <hr>

                                        <div class="table-scrollable">
                                            {{-- <button type="button" class="btn btn-secondary btn-sm mb-2"
                                                id="add-detail">Add
                                                Detail</button> --}}

                                            <h6>Order Items</h6>
                                            <table class="table table-bordered" id="details-table">
                                                <thead>
                                                    <tr>
                                                        {{-- <th>Item ID</th> --}}

                                                        <th>item ID</th>
                                                        <th>item Code</th>
                                                        <th>Name</th>
                                                        <th>Color</th>
                                                        <th>Size</th>
                                                        <th>UNIT</th>
                                                        <th>QTY</th>
                                                        <th>PIRCE</th>
                                                        <th>TOTAL PRICE</th>

                                                        <th>Remark</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="details-container">

                                                </tbody>
                                            </table>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <textarea class="form-control" rows="3" name="note1" id="note1" placeholder="Enter notes here.."> {{ $purchaseRequest->order_no ? 'For  ORDER NO:' . $purchaseRequest->order_no : '' }} {{ $purchaseRequest->mo ? '/ MO:' . $purchaseRequest->mo : '' }} {{ $purchaseRequest->sample_code ? '/Sample Code:' . $purchaseRequest->sample_code : '' }} {{ $purchaseRequest->item ? '/Item:' . $purchaseRequest->item : '' }} {{ $purchaseRequest->destination ? '/Destination:' . $purchaseRequest->destination : '' }}  </textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- accepted payments column -->
                                        <div class="col-7 mt-5">
                                            <div class="form-group row">
                                                <label for="style" class="col-sm-2 col-form-label">Notes</label>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control" rows="3" name="note2" id="note2" placeholder="Enter notes here.."></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="rule" class="col-sm-2 col-form-label">Rule</label>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control" rows="3" name="rule" id="rule" placeholder="Enter rule here.."></textarea>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- /.col -->
                                        <div class="col-5">

                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm">
                                                    <tr>
                                                        <th style="width:50%">Sub total :</th>
                                                        <td>
                                                            <input type="text"
                                                                class="form-control col-sm-6 form-control-xs"
                                                                name="sub_total" id="sub_total" readonly>
                                                        </td>
                                                    </tr>
                                                      <tr>
                                                        <th style="width:50%">DPP (11/12) :</th>
                                                        <td>
                                                            <input type="text"
                                                                class="form-control col-sm-6 form-control-xs"
                                                                name="dpp" id="dpp" readonly>
                                                        </td>
                                                    </tr>
                                                        
                                                    <tr>
                                                        <th>Rounding :</th>
                                                        <td>
                                                            <input type="text"
                                                                class="form-control col-sm-6 form-control-xs"
                                                                name="rounding" id="rounding" value="0">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Discount :</th>
                                                        <td>
                                                            <input type="text"
                                                                class="form-control col-sm-6 form-control-xs"
                                                                name="discount" id="discount" value="0">
                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <th>
                                                            Tax (%) :
                                                        </th>

                                                        <td id="tax_result">
                                                            <input type="text"
                                                                class="form-control col-sm-6  form-control-xs"
                                                                name="tax" id="tax" required>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                        </th>
                                                        <td id="tax_result">
                                                            <input type="text"
                                                                class="form-control col-sm-6 form-control-xs"
                                                                name="tax_end" id="tax_end" readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Grand Total:</th>
                                                        <td id="grand_total">
                                                            <input type="text"
                                                                class="form-control col-sm-6 form-control-xs"
                                                                name="grand_total_end" id="grand_total_end" readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th id="purchase_amount">Purchase Amount:</th>
                                                        <td>
                                                            <input type="text"
                                                                class="form-control col-sm-6 form-control-xs"
                                                                name="purchase_amount_end" id="purchase_amount_end"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                    </div>

                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="itemModalLabel">Items</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
 					<div class="table-responsive">
                    <table id="items-table" class="table table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Item Code</th>
                                <th>Item Name</th>
                                <th>Unit</th>
                                <th>Category</th>
                                <th>Description</th>

                            </tr>
                        </thead>
                        <tbody id="data_item">
                            <!-- Employee data will be dynamically populated here -->
                        </tbody>
                    </table>
                     </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal for Color Selection -->
    <div class="modal fade" id="colorModal" tabindex="-1" aria-labelledby="colorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="colorModalLabel">Select Color</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-hover" id="colors-table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Color Code</th>
                                <th>Color Name</th>

                            </tr>
                        </thead>
                        <tbody>
                            <!-- Colors will be loaded here by Ajax -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Size Selection -->
    <div class="modal fade" id="sizeModal" tabindex="-1" aria-labelledby="sizeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sizeModalLabel">Select Size</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-hover" id="sizes-table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Size Code</th>
                                <th>Size Name</th>

                            </tr>
                        </thead>
                        <tbody>
                            <!-- Sizes will be loaded here by Ajax -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="supplierModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="supplierModalLabel">Select Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table id="suppliers-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Supplier Name</th>
                                <th>Supplier Address</th>

                                <th>Person</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Supplier rows will be appended here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        setTimeout(function() {
            $('.alert-danger').fadeOut('slow');
        }, 6000);


        $(document).ready(function() {
            var table;


            let selectedSupplierInput;
            let selectedInput;
            let detailIndex = 1;

            function calculateTotalPrice(row) {
                const qty = parseFloat(row.find('.qty').val()) || 0;
                const price = parseFloat(row.find('.price').val()) || 0;
                const totalPrice = qty * price;
                row.find('.total_price').val(totalPrice.toLocaleString(
                    'en-US')); // Format to localized string without decimals

            }



            function addEventListeners(row) {
                row.find('.qty, .price').on('input', function() {
                    calculateTotalPrice(row);




                });
            }




            $('#add-detail').on('click', function() {
                const newDetailRow = `
            <tr class="detail-row">
                <td><input type="text" class="form-control item-id" name="details[${detailIndex}][item_id]" required></td>
                <td><input type="text" class="form-control item-code" name="details[${detailIndex}][item_code]" required></td>
                <td><input type="text" class="form-control item-name" name="details[${detailIndex}][item_name]" required></td>
                <td><input type="text" class="form-control color-id" name="details[${detailIndex}][color]"></td>
                <td><input type="text" class="form-control size-id" name="details[${detailIndex}][size]"></td>
                <td><input type="text" class="form-control unit" name="details[${detailIndex}][unit]"></td>
                <td><input type="text" class="form-control qty" name="details[${detailIndex}][qty]" required  value="0" pattern="[0-9]+"></td>
                <td><input type="text" class="form-control price" name="details[${detailIndex}][price]"  value="0" pattern="[0-9]+"></td>
                <td><input type="text" class="form-control total_price" name="details[${detailIndex}][total_price]" pattern="[0-9]+" readonly></td>
          
                <td><input type="text" class="form-control" name="details[${detailIndex}][remark]"></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-detail">Remove</button></td>
            </tr>`;
                $('#details-container').append(newDetailRow);
                const newRow = $('#details-container').find('.detail-row').last();
                addEventListeners(newRow); // Add event listeners to the new row
                detailIndex++;
            });

            // Remove detail row
            $(document).on('click', '.remove-detail', function() {
                $(this).closest('tr').remove();
            });

            // Calculate total for the initial row
            calculateTotalPrice($('.detail-row'));

            // Add event listeners for calculation on all detail rows
            $('.detail-row').each(function() {
                addEventListeners($(this));
            });




            $(document).on('click', '.item-id', function() {
                selectedInput = $(this); // Store the input element
                $('#itemModal').modal('show');
                loadItems(); // Call function to load items via Ajax


            });

            $(document).on('click', '.color-id', function() {
                selectedInput = $(this);
                $('#colorModal').modal('show');
                loadColors();
            });

            $(document).on('click', '.size-id', function() {
                selectedInput = $(this);
                $('#sizeModal').modal('show');
                loadSizes();
            });

            // Event listener for clicking on supplier_name input
            $(document).on('click', '.supplier_name', function() {
                selectedSupplierInput = $(this); // Store the input element
                $('#supplierModal').modal('show'); // Show the modal
                loadSuppliers(); // Load suppliers data
            });







            function loadSuppliers() {
                $('#supplier-table tbody').empty();
                var idx = $('#purchase_request_id').val();

                $.ajax({
                    url: '{{ route('get.purchaserequestsp') }}', // Sesuaikan dengan route yang benar
                    method: 'GET',
                    data: {
                        idx: idx
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {

                        var tableData = [];

                        data.forEach(function(supplier) {
                            tableData.push({
                                id: supplier.id,
                                supplier_name: supplier.supplier_name,
                                supplier_address: supplier.supplier_address,
                                supplier_person: supplier.supplier_person,
                                remark: supplier.remark
                            });
                        });



                        // Inisialisasi DataTable
                        table = $('#suppliers-table').DataTable({
                            paging: true,
                            searching: true,
                            ordering: true,
                            destroy: true,
                            info: true,
                            data: tableData,
                            columns: [{
                                    title: "ID",
                                    data: "id"
                                },

                                {
                                    title: "supplier_name",
                                    data: "supplier_name",
                                    render: function(data, type, row) {
                                        // Batasi panjang teks maksimal menjadi 50 karakter
                                        if (type === 'display' && data.length > 25) {
                                            return data.substr(0, 25) + '...';
                                        }
                                        return data;
                                    }
                                },

                                {
                                    title: "supplier_address",
                                    data: "supplier_address",
                                    render: function(data, type, row) {
                                        // Batasi panjang teks maksimal menjadi 50 karakter
                                        if (type === 'display' && data.length > 25) {
                                            return data.substr(0, 25) + '...';
                                        }
                                        return data;
                                    }
                                },

                                {
                                    title: "supplier_person",
                                    data: "supplier_person"
                                },
                                {
                                    title: "remark",
                                    data: "remark"
                                }
                            ]
                        });

                        // Tambahkan event handler untuk setiap baris tabel
                        $('#suppliers-table tbody').on('click', 'tr', function() {
                            var supplier = table.row(this).data();
                            selectedSupplierInput.val(supplier
                                .supplier_name); // Mengisi supplier name
                            $('#supplier_id').val(supplier.id); // Mengisi supplier id
                            $('#supplierModal').modal('hide');


                            loadItems1()
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }



            function loadItems1() {
                $('#items-table1 tbody').empty();

                var id1 = $('#purchase_request_id').val();
                var id2 = $('#supplier_id').val();

                $.ajax({
                    url: '{{ route('get.purchaserequestitems') }}', // Sesuaikan dengan route yang benar
                    method: 'GET',
                    data: {
                        id1: id1,
                        id2: id2
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        var itemsTableBody = $('#items-table1 tbody');
                        itemsTableBody.empty();

                        data.forEach(function(item) {
                            var row = `<tr>
                                <td>${item.id}</td>
                                <td>${item.item_id}</td>
                                <td>${item.item.item_code}</td>
                                <td>${item.item.item_name}</td>
                                <td>${item.color?item.color:''}</td>
                                <td>${item.size?item.size:''}</td>F
                                <td>${item.qty}</td>
                                <td>${item.total}</td>
                                <td>${item.item.unit.unit_code ? item.item.unit.unit_code : ''}</td>
                                <td>${item.remark ? item.remark : '' }</td>
                                <td><button type="button" class="btn btn-danger btn-sm select-detail">Select</button></td>
                            </tr>`;
                            itemsTableBody.append(row);
                        });

                        $('.select-detail').on('click', function() {
                            var row = $(this).closest('tr'); // Get the clicked row
                            var detail = {
                                id: row.find('td:eq(0)')
                                    .text(), // Get purchase_request_detail_id from the first cell
                                item_id: row.find('td:eq(1)')
                                    .text(), // Extract item ID from the second cell
                                item: {
                                    item_code: row.find('td:eq(2)')
                                        .text(), // Extract item code from the third cell
                                    item_name: row.find('td:eq(3)')
                                        .text(), // Extract item name from the fourth cell
                                    unit: {
                                        unit_code: row.find('td:eq(8)')
                                            .text() // Extract unit code from the ninth cell
                                    }
                                },
                                color: row.find('td:eq(4)')
                                    .text(), // Extract color from the fifth cell   
                                size: row.find('td:eq(5)')
                                    .text(), // Extract size from the sixth cell
                                total: row.find('td:eq(7)')
                                    .text(), // Extract quantity from the seventh cell
                                remark: row.find('td:eq(9)')
                                    .text() // Extract remark from the tenth cell
                            };

                            // console.log(detail);



                            var newRowx = `<tr class="detail-row">
                                <td><input type="text" class="form-control item-id" name="details[${detail.id}][item_id]" value="${detail.item_id}" required></td>
                                <td><input type="text" class="form-control item-code" name="details[${detail.id}][item_code]" value="${detail.item.item_code}" required></td>
                                <td><input type="text" class="form-control item-name" name="details[${detail.id}][item_name]" value="${detail.item.item_name}" required></td>
                                <td><input type="text" class="form-control color-id" name="details[${detail.id}][color]" value="${detail.color ? detail.color : ''}"></td>
                                <td><input type="text" class="form-control size-id" name="details[${detail.id}][size]" value="${detail.size ? detail.size : ''}"></td>
                                <td><input type="text" class="form-control unit" name="details[${detail.id}][unit]" value="${detail.item.unit.unit_code}"></td>
                                <td><input type="text" class="form-control qty" name="details[${detail.id}][qty]" value="${detail.total}" required></td>
                                <td><input type="text" class="form-control price" name="details[${detail.id}][price]" required></td>
                                <td><input type="text" class="form-control total_price" name="details[${detail.id}][total_price]" readonly></td>
                                <td><input type="text" class="form-control" name="details[${detail.id}][remark]" value="${detail.remark ? detail.remark : ''}"></td>
                                <td><button type="button" class="btn btn-danger btn-sm remove-detail">Remove</button></td>
                            </tr>`;

                            $('#details-container').append(
                                newRowx); // Append new row to details container
                            const newlyAddedRow = $('#details-container').find('.detail-row')
                                .last();

                            // Attach event listeners to newly added row
                            addEventListeners(newlyAddedRow);


                            $(this).closest('tr').remove();
                        });


                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }










            function loadItems() {
                $('#items-table tbody').empty();

                $.ajax({
                    url: '{{ route('get.itemglobal') }}', // Sesuaikan dengan route yang benar
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        // Inisialisasi DataTable
                        table = $('#items-table').DataTable({
                            paging: true,
                            searching: true,
                            ordering: true,
                            destroy: true,
                            info: true,
                            data: data,
                            columns: [{
                                    title: "ID",
                                    data: "id"
                                },
                                {
                                    title: "Item Code",
                                    data: "item_code"
                                },
                                {
                                    title: "Item Name",
                                    data: "item_name"
                                },
                                {
                                    title: "Unit",
                                    data: "unit.unit_code" // Sesuaikan dengan struktur data JSON dari relasi
                                },
                                {
                                    title: "category",
                                    data: "category.name" // Sesuaikan dengan struktur data JSON dari relasi
                                },
                                {
                                    title: "Description",
                                    data: "description"
                                }
                            ]
                        });

                        // Tambahkan event handler untuk setiap baris tabel
                        $('#items-table tbody').on('click', 'tr', function() {
                            var data = table.row(this).data();
                            selectedInput.val(data.id); // Mengambil ID item
                            $(selectedInput).closest('.detail-row').find('.item-code').val(data
                                .item_code);
                            $(selectedInput).closest('.detail-row').find('.item-name').val(data
                                .item_name);
                            $(selectedInput).closest('.detail-row').find('.unit').val(data.unit
                                .unit_code);
                            $('#itemModal').modal('hide');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            function loadColors() {
                $('#colors-table tbody').empty();

                $.ajax({
                    url: '{{ route('get.colorglobal') }}',
                    method: 'GET',
                    success: function(data) {
                        // Inisialisasi DataTable
                        table = $('#colors-table').DataTable({
                            paging: true,
                            searching: true,
                            ordering: true,
                            destroy: true,
                            info: true,
                            data: data,
                            columns: [{
                                    title: "ID",
                                    data: "id"
                                },
                                {
                                    title: "Color Code",
                                    data: "color_code"
                                },
                                {
                                    title: "Color Name",
                                    data: "color_name"
                                },

                            ]
                        });

                        // Tambahkan event handler untuk setiap baris tabel
                        $('#colors-table tbody').on('click', 'tr', function() {
                            var data = table.row(this).data();
                            selectedInput.val(data.color_code); // Mengambil ID item
                            $('#colorModal').modal('hide');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }

                });
            }

            function loadSizes() {
                $('#sizes-table tbody').empty();

                $.ajax({
                    url: '{{ route('get.sizeglobal') }}',
                    method: 'GET',
                    success: function(data) {
                        // Inisialisasi DataTable
                        table = $('#sizes-table').DataTable({
                            paging: true,
                            searching: true,
                            ordering: true,
                            destroy: true,
                            info: true,
                            data: data,
                            columns: [{
                                    title: "ID",
                                    data: "id"
                                },
                                {
                                    title: "Size Code",
                                    data: "size_code"
                                },
                                {
                                    title: "Size Name",
                                    data: "size_name"
                                },

                            ]
                        });

                        // Tambahkan event handler untuk setiap baris tabel
                        $('#sizes-table tbody').on('click', 'tr', function() {
                            var data = table.row(this).data();
                            selectedInput.val(data.size_code); // Mengambil ID item
                            $('#sizeModal').modal('hide');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }

                });
            }





            function calculateTotals() {
                let subTotal = 0;

                // Sum up all total_price values from the detail rows
                $('.detail-row').each(function() {
                    const totalPrice = parseFloat($(this).find('.total_price').val().replace(/,/g, '')) ||
                        0;
                    subTotal += totalPrice;
                });

                // Format and update sub_total input
                $('#sub_total').val(subTotal.toLocaleString('en-US'));

                // Calculate DPP (11/12 * sub_total)
                const dpp = (11 / 12) * subTotal;
                $('#dpp').val(dpp.toLocaleString('en-US'));

                // Get the tax, PPH, and rounding values
                const rounding = parseFloat($('#rounding').val().replace(/,/g, '')) || 0;
                const tax = parseFloat($('#tax').val().replace(/,/g, '')) || 0;
         

                // Calculate tax amount based on DPP
                const taxAmount = dpp * (tax / 100);
                $('#tax_end').val(taxAmount.toLocaleString('en-US'));

              
                // Calculate grand total
                const grandTotal = (subTotal + taxAmount);
                $('#grand_total_end').val(grandTotal.toLocaleString('en-US'));

                // Update purchase amount (if necessary, here it's the same as grand total)
                $('#purchase_amount_end').val(grandTotal.toLocaleString('en-US'));
            }

            // Event listeners for inputs
            $(document).on('input', '.qty, .price, #rounding, #tax', function() {
                calculateTotals();
            });

            // Initial calculation
            calculateTotals();




        });
    </script>
@endsection
