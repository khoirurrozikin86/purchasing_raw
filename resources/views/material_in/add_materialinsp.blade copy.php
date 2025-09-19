@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content mt-5">

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="row">

                            <div class="container">

                                <form action="{{ route('store.materialinsp') }}" method="POST">
                                    @csrf
                                    <!-- Purchase Request Fields -->

                                    <div class="text-center">
                                        Material IN Information
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

                                                    <div class="input-group">
                                                        <input type="hidden" class="form-control supplier_id"
                                                            id="supplier_id" name="supplier_id">
                                                        <input type="text" class="form-control supplier_name"
                                                            id="supplier_name" name="supplier_name">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-secondary supplier_search"
                                                                id="supplier_search" type="button">
                                                                <i class="feather-10" data-feather="search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-group row">
                                                <label for="no_sj" class="col-sm-4 col-form-label">no_sj</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="no_sj"
                                                        name="no_sj">
                                                </div>
                                            </div>
                                           

                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group row">
                                                <label for="recived_by" class="col-sm-4 col-form-label">Reciver</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="recived_by"
                                                        name="recived_by">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="location" class="col-sm-4 col-form-label">Location</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="location"
                                                        name="location">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="courier" class="col-sm-4 col-form-label">courier</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="courier" name="courier"
                                                        required>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <hr>

                                    <!-- Purchase Request Details Fields -->

                                    <div class="row">

                                        <div>
                                            <h6>PO Items</h6>
                                            <table class="table" id="items-table1">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>ID PO</th>
                                                        <th>PO</th>
                                                        <th>ID Item</th>
                                                        <th>Item Code</th>
                                                        <th>Item Name</th>
                                                        <th>Unit</th>
                                                        <th>Color</th>
                                                        <th>Size</th>
                                                        <th>Quantity</th>
                                                        <th>Remark</th>
                                                        <th>Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>

                                        <hr>

                                        <div class="">
                                            {{-- <button type="button" class="btn btn-secondary btn-sm mb-2"
                                                id="add-detail">Add
                                                Detail</button> --}}

                                            <h6>IN Items</h6>

                                            <table class="table table-bordered" id="details-table">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>ID PO</th>
                                                        <th>PO</th>
                                                        <th>ID Item</th>
                                                        <th>Item Code</th>
                                                        <th>Item Name</th>
                                                        <th>Unit</th>
                                                        <th>Color</th>
                                                        <th>Size</th>
                                                        <th>Quantity</th>
                                                        <th>Remark</th>
                                                        <th>Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody id="details-containerx">

                                                </tbody>
                                            </table>

                                        </div>

                                    </div>

                                    <button type="submit" class="btn btn-primary mt-2">Submit</button>
                                </form>
                            </div>

                        </div>

                    </div>
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


            // Add event listeners for calculation on all detail rows
            $('.detail-row').each(function() {
                addEventListeners($(this));
            });




            // Event listener for clicking on supplier_name input
            $(document).on('click', '.supplier_search', function() {
                selectedSupplierInput = $(this); // Store the input element
                $('#supplierModal').modal('show'); // Show the modal
                loadSuppliers(); // Load suppliers data
            });

            function loadSuppliers() {
                $('#supplier-table tbody').empty();

                $.ajax({
                    url: '{{ route('get.purchaseordersupplier') }}', // Sesuaikan dengan route yang benar
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        // Inisialisasi DataTable

                        // console.log(data);


                        table = $('#suppliers-table').DataTable({
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
                            selectedSupplierInput.val(); // Mengisi supplier name
                            $('#supplier_name').val(supplier.supplier_name);
                            $('#supplier_id').val(supplier.id); // Mengisi supplier id

                            loadItems1();



                            $('#supplierModal').modal('hide');




                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }




            function loadItems1() {
                $('#items-table1 tbody').empty();



                // var id1 = $('#purchase_order_id').val();
                var id2 = $('#supplier_id').val();

                $.ajax({
                    url: '{{ route('get.purchaseorderitem') }}', // Sesuaikan dengan route yang benar
                    method: 'GET',
                    data: {

                        id2: id2
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        var itemsTableBody = $('#items-table1 tbody');
                        itemsTableBody.empty();

                        data.forEach(function(item) {
                            item.detailorder.forEach(function(detail) {


                                var row = `<tr>
                                    <td>${detail.id}</td>
                                    <td>${detail.purchase_order_id}</td>
                                    <td>${item.purchase_order_no}|| PO TIN : ${item.remarksx}</td>
                                    <td>${detail.item_id}</td>
                                    <td>${detail.item.item_code}</td>
                                    <td>${detail.item.item_name}</td>
                                    <td>${detail.item.unit.unit_code ? detail.item.unit.unit_code : ''}</td>
                                    <td>${detail.color ? detail.color : ''}</td>
                                    <td>${detail.size ? detail.size : ''}</td>
                                    <td>${detail.qty}</td>
                            
                                    <td>${detail.remark ? detail.remark : ''}</td>
                                    <td><button type="button" class="btn btn-danger btn-sm select-detail">Select</button></td>
                                </tr>`;
                                itemsTableBody.append(row);
                            });
                        });

                        $('.select-detail').on('click', function() {
                            var row = $(this).closest('tr'); // Get the clicked row




                            var detail = {
                                id: row.find('td:eq(0)').text(),
                                po_id: row.find('td:eq(1)').text(),
                                po_number: row.find('td:eq(2)').text(),
                                item_id: row.find('td:eq(3)').text(),

                                item: {
                                    item_code: row.find('td:eq(4)')
                                        .text(), // Extract item code from the third cell
                                    item_name: row.find('td:eq(5)')
                                        .text(), // Extract item name from the fourth cell
                                    unit: {
                                        unit_code: row.find('td:eq(6)')
                                            .text() // Extract unit code from the ninth cell
                                    }
                                },
                                color: row.find('td:eq(7)')
                                    .text(), // Extract color from the fifth cell   
                                size: row.find('td:eq(8)')
                                    .text(), // Extract size from the sixth cell
                                total: row.find('td:eq(9)')
                                    .text(), // Extract quantity from the seventh cell
                                remark: row.find('td:eq(10)')
                                    .text() // Extract remark from the tenth cell
                            };

                            // console.log(detail);



                            var newRowx = `<tr class="detail-row">
                                <td><input type="text" class="form-control po-id" name="details[${detail.id}][po_id]" value="${detail.id}" required></td>
                                <td><input type="text" class="form-control po-id" name="details[${detail.id}][po_id]" value="${detail.po_id}" required></td>
                                <td><input type="text" class="form-control po-number" name="details[${detail.id}][po_number]" value="${detail.po_number}" required></td>
                                <td><input type="text" class="form-control item-id" name="details[${detail.id}][item_id]" value="${detail.item_id}" required></td>
                                <td><input type="text" class="form-control item-code" name="details[${detail.id}][item_code]" value="${detail.item.item_code}" required></td>
                                <td><input type="text" class="form-control item-name" name="details[${detail.id}][item_name]" value="${detail.item.item_name}" required></td>
                                   <td><input type="text" class="form-control unit" name="details[${detail.id}][unit]" value="${detail.item.unit.unit_code}"></td>
                                <td><input type="text" class="form-control color-id" name="details[${detail.id}][color]" value="${detail.color ? detail.color : ''}"></td>
                                <td><input type="text" class="form-control size-id" name="details[${detail.id}][size]" value="${detail.size ? detail.size : ''}"></td>
                             
                                <td><input type="text" class="form-control qty" name="details[${detail.id}][qty]" value="${detail.total}" required></td>
                
                                <td><input type="text" class="form-control" name="details[${detail.id}][remark]" value="${detail.remark ? detail.remark : ''}"></td>
                                <td><button type="button" class="btn btn-danger btn-sm remove-detail">Remove</button></td>
                      
            
                            </tr>`;

                            $('#details-containerx').append(
                                newRowx); // Append new row to details container
                            const newlyAddedRow = $('#details-containerx').find('.detail-row')
                                .last();

                            // Attach event listeners to newly added row
                            // addEventListeners(newlyAddedRow);


                            $(this).closest('tr').remove();


                        });

                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }










            function loadItemsBySupplier(supplierId) {
                $.ajax({
                    url: '/get/purchaseorderitem/' +
                        supplierId, // Sesuaikan dengan route yang benar di Laravel
                    method: 'GET',
                    success: function(data) {
                        // Lakukan sesuatu dengan data item yang diterima, misalnya memasukkannya ke dalam sebuah tabel atau form
                        console.log(data);

                        // Contoh: menampilkan data item dalam tabel
                        $('#item-table tbody').empty(); // Kosongkan isi tabel terlebih dahulu

                        $.each(data, function(index, item) {
                            var row = '<tr>' +
                                '<td>' + item.id + '</td>' +
                                '<td>' + item.item_name + '</td>' +
                                '<td>' + item.quantity + '</td>' +
                                '<td>' + item.unit_price + '</td>' +
                                '<td><button type="button" class="btn btn-danger btn-sm select-detail">Select</button></td>'
                            '</tr>';
                            $('#item-table tbody').append(row);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }





        });

        $(document).ready(function() {
            $('#upload_pl').on('click', function(e) {
                e.preventDefault();

                var formData = new FormData();
                formData.append('import_file', $('#import_file')[0].files[0]);

                $.ajax({
                    url: '{{ route('import.materialin') }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        var tbody = $('#details-containerx');

                        // Append rows
                        data.rows.forEach(function(row, rowIndex) {
                            var existingRow = tbody.find('tr').eq(rowIndex);

                            if (existingRow.length === 0) {
                                existingRow = $('<tr>');
                                for (var i = 0; i < 11; i++) {
                                    existingRow.append(
                                        '<td><input type="text" class="form-control form-control-sm" readonly></td>'
                                        );
                                }
                                tbody.append(existingRow);
                            }

                            var startIndex = existingRow.children('td').length;
                            data.header.forEach(function(header, index) {
                                if (index + startIndex < 12) return;

                                // Get the value of input with name 'header'
                                var inputValue = row[header] || '';

                                var newCell = $('<td data-name="' + header +
                                    '">' +
                                    '<input type="text" class="form-control form-control-sm" name="details[' +
                                    rowIndex + '][' + header +
                                    ']" value="' + inputValue + '">' +
                                    '</td>');
                                existingRow.append(newCell);
                            });
                        });
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON.error);
                    }
                });
            });
        });
    </script>
@endsection
