@extends('admin.admin_dashboard')

@section('admin')
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;

            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .btn {

            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }
    </style>

    <div class="page-content mt-5">

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div>
                            <div class="row">

                                <div class="col">
                                    <h6 class="card-title text-center">BOM Add</h6>
                                </div>

                            </div>

                        </div>

                        <div class="row">





                            <form id="bomForm" class="mt-3">


                                <div class="row">
                                    <div class="col-md-6">

                                        <label for="style">Style:</label>
                                        <div class="input-group">

                                            <input type="hidden" class="form-control form-control-sm cbd_id" id="cbd_id"
                                                name="cbd_id">
                                            <input type="text" class="form-control form-control-sm style" id="style"
                                                name="style">
                                            <div class="input-group-append">
                                                <button class="btn btn-secondary cbd_search" id="cbd_search" type="button">
                                                    <i class="feather-10" data-feather="search"></i>
                                                </button>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                                <hr />





                                <h6>Material Item</h6>


                                <button type="button" class="btn btn-sm mt-3" id="addColumn">Add Column</button>
                                <div class="table table-responsive">
                                    <table id="bomTable">
                                        <thead>
                                            <tr id="headerRow">
                                                <th>Item ID</th>
                                                <th>Item Code</th>
                                                <th>Item Name</th>
                                                <th>Unit</th>
                                                <th>No Size</th>
                                                <th>XS</th>
                                                <th>S</th>
                                                <th>M</th>
                                                <th>L</th>
                                                <th>XL</th>
                                                <th>XXL</th>
                                                <th>3XL</th>
                                                <th>4XL</th>
                                                <th>5XL</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="detail-row">
                                                <td><input type="text" name="item_id[]" class="item-id form-control"
                                                        required>
                                                </td>
                                                <td><input type="text" name="item_code[]" class="item-code form-control">
                                                </td>
                                                <td><input type="text" name="item_name[]" class="item-name form-control"
                                                        required>
                                                </td>
                                                <td><input type="text" name="unit[]" class="unit form-control" required>
                                                </td>
                                                <td><input class="form-control" type="text" name="size[null][]"
                                                        placeholder="Consumption"></td>
                                                <td><input class="form-control" type="text" name="size[XS][]"
                                                        placeholder="Consumption">
                                                </td>
                                                <td><input class="form-control" type="text" name="size[S][]"
                                                        placeholder="Consumption">
                                                </td>
                                                <td><input class="form-control" type="text" name="size[M][]"
                                                        placeholder="Consumption">
                                                </td>
                                                <td><input class="form-control" type="text" name="size[L][]"
                                                        placeholder="Consumption">
                                                </td>
                                                <td><input class="form-control" type="text" name="size[XL][]"
                                                        placeholder="Consumption">
                                                </td>
                                                <td><input class="form-control" type="text" name="size[XXL][]"
                                                        placeholder="Consumption">
                                                </td>
                                                <td><input class="form-control" type="text" name="size[3XL][]"
                                                        placeholder="Consumption">
                                                </td>
                                                <td><input class="form-control" type="text" name="size[4XL][]"
                                                        placeholder="Consumption">
                                                </td>
                                                <td><input class="form-control" type="text" name="size[5XL][]"
                                                        placeholder="Consumption">
                                                </td>
                                                <td><button type="button" class="btn remove-row">Remove</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <button type="button" class="btn btn-sm mt-3" id="addRow">Add Row</button>

                                <br><br>
                                <button type="submit" class="btn bg-primary">Save BOM</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="cbdModal" tabindex="-1" aria-labelledby="cbdModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cbdModalLabel">CBD & CBD Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="container">

                                <table id="cbdDetailTable" class="table table-hover" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Order No</th>
                                            <th>Sample Code / Style</th>

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

            <div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="itemModalLabel">Items</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table id="items-table" class="table table-hover table-bordered" style="width: 100%;">
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


            <script>
                $(document).ready(function() {

                    clearInput();
                    // Add Row Functionality
                    $('#addRow').click(function() {
                        const newRow = $('#bomTable tbody tr:first').clone();
                        newRow.find('input').val(''); // Clear input values
                        $('#bomTable tbody').append(newRow);
                    });

                    // Add Column Functionality
                    $('#addColumn').click(function() {
                        const sizeName = prompt('Enter Size Name:');
                        if (sizeName) {
                            // Add new header
                            $('#headerRow').find('th:last').before(`<th>${sizeName}</th>`);

                            // Add input for each row
                            $('#bomTable tbody tr').each(function() {
                                $(this).find('td:last').before(
                                    `<td><input type="text" name="size[${sizeName}][]" placeholder="Consumption" class="form-control"></td>`
                                );
                            });
                        }
                    });

                    // Remove Row Functionality
                    $(document).on('click', '.remove-row', function() {
                        if ($('#bomTable tbody tr').length > 1) {
                            $(this).closest('tr').remove();
                        } else {
                            alert('At least one row must be present.');
                        }
                    });







                    $('#bomForm').submit(function(e) {
                        e.preventDefault();

                        const bomData = {
                            style: $('#style').val(),
                            cbd_id: $('#cbd_id').val(),
                            items: []
                        };

                        $('#bomTable tbody tr').each(function() {
                            const item = {
                                item_id: $(this).find('input[name="item_id[]"]').val(),
                                sizes: {}
                            };

                            $(this).find('input[name^="size"]').each(function() {
                                const sizeName = $(this).attr('name').match(/\[(.*?)\]/)[1];
                                const value = $(this).val().trim();

                                item.sizes[sizeName] = value === '' || value === '0' ? null :
                                    value; // Kirim null jika kosong atau 0
                            });

                            bomData.items.push(item);
                        });

                        console.log('Data sent to backend:', bomData); // Debug data yang dikirim

                        $.ajax({
                            url: '/store/bom',
                            method: 'POST',
                            contentType: 'application/json',
                            data: JSON.stringify(bomData),
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                alert('BOM updated successfully!');
                                console.log(response);
                                window.location.href = "{{ route('all.bom') }}";
                            },
                            error: function(error) {
                                alert('Error updating BOM.');
                                console.error('Error:', error);
                            }
                        });
                    });


                    $('#bomFormx').submit(function(e) {
                        e.preventDefault();

                        let hasConsumption = false; // Default: tidak ada konsumsi yang diisi

                        // Validate Style and CBD ID
                        if ($('#style').val().trim() === '') {
                            alert('Style is required!');
                            return; // Stop form submission
                        }

                        if ($('#cbd_id').val().trim() === '') {
                            alert('CBD ID is required!');
                            return; // Stop form submission
                        }

                        // Validate consumption in table inputs
                        $('#bomTable tbody tr').each(function() {
                            $(this).find('input[name^="size"]').each(function() {
                                if ($(this).val().trim() !== '') {
                                    hasConsumption = true; // Ada konsumsi yang diisi
                                    return false; // Break out of the input loop
                                }
                            });

                            if (hasConsumption) {
                                return false; // Break out of the row loop
                            }
                        });

                        if (!hasConsumption) {
                            alert('At least one consumption must be filled!');
                            return; // Stop form submission
                        }

                        // Prepare BOM data if validation passed
                        const bomData = {
                            style: $('#style').val(),
                            cbd_id: $('#cbd_id').val(),
                            items: []
                        };

                        const itemIDs = $('input[name="item_id[]"]').map(function() {
                            return $(this).val();
                        }).get();

                        const sizes = $('#headerRow th').not(':first, :last').map(function() {
                            return $(this).text();
                        }).get();

                        itemIDs.forEach(function(itemID, rowIndex) {
                            const sizeData = {};
                            sizes.forEach(function(size) {
                                const consumption = $(`input[name="size[${size}][]"]`).eq(rowIndex)
                                    .val();
                                sizeData[size] = consumption || null;
                            });

                            bomData.items.push({
                                item_id: itemID,
                                sizes: sizeData
                            });
                        });

                        console.log(bomData);

                        // Send data to backend
                        $.ajax({
                            url: '/store/bom',
                            method: 'POST',
                            contentType: 'application/json',
                            data: JSON.stringify(bomData),
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content') // Add CSRF token if using Laravel
                            },
                            success: function(response) {
                                alert('BOM saved successfully!');
                                clearInput(); // Clear form and reset table
                                console.log(response);
                            },
                            error: function(error) {
                                console.error(error);
                                alert('Error saving BOM.');
                            }
                        });
                    });






                    // Initialize DataTables for CBD Detail Table
                    var cbdDetailTable = $('#cbdDetailTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{ route('get.cbddetaillimit') }}", // Adjust this route to your needs
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

                        ]
                    });



                    function clearInput() {
                        $('#style').val('');
                        $('#cbd_id').val('');

                        $('#bomTable tbody tr').each(function() {
                            $(this).find('input').val(''); // Kosongkan semua input di setiap baris
                        });


                        $('#bomTable tbody').html(`
                    <tr class="detail-row">
                        <td><input type="text" name="item_id[]" class="item-id form-control" required></td>
                           <td><input type="text" name="item_code[]" class="item-code form-control"></td>
                        <td><input type="text" name="item_name[]" class="item-name form-control"></td>
                         <td><input type="text" name="unit[]" class="unit form-control"></td>
                        <td><input class="form-control" type="text" name="size[null][]" placeholder="Consumption"></td>
                        <td><input class="form-control" type="text" name="size[XS][]" placeholder="Consumption"></td>
                        <td><input class="form-control" type="text" name="size[S][]" placeholder="Consumption"></td>
                        <td><input class="form-control" type="text" name="size[M][]" placeholder="Consumption"></td>
                        <td><input class="form-control" type="text" name="size[L][]" placeholder="Consumption"></td>
                        <td><input class="form-control" type="text" name="size[XL][]" placeholder="Consumption"></td>
                        <td><input class="form-control" type="text" name="size[XXL][]" placeholder="Consumption"></td>
                        <td><input class="form-control" type="text" name="size[3XL][]" placeholder="Consumption"></td>
                        <td><input class="form-control" type="text" name="size[4XL][]" placeholder="Consumption"></td>
                        <td><input class="form-control" type="text" name="size[5XL][]" placeholder="Consumption"></td>
                        <td><button type="button" class="btn remove-row">Remove</button></td>
                    </tr>
                    `);
                    }











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
                        $('.style').val(data
                            .sample_code); // Optionally set the CBD name or other details if needed



                        // Add the selected CBD details to the selectedCbdTable
                        $('#selectedCbdTable tbody').empty(); // Clear previous data
                        $('#selectedCbdTable tbody').append(`
                        <tr>
                            <td>${data.id}</td>
                            <td>${data.order_no}</td>
                            <td>${data.sample_code}</td>
                 
                        </tr>
                    `);

                        // Show the selected CBD details table
                        $('#selectedCbdTable').removeClass('d-none');

                        // Hide the modal
                        $('#cbdModal').modal('hide');
                    });
                });



                $(document).on('click', '.item-id', function() {
                    selectedInput = $(this); // Store the input element
                    $('#itemModal').modal('show');
                    loadItems(); // Call function to load items via Ajax


                });



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
            </script>
        @endsection
