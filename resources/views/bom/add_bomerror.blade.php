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

        #bomTable td {
            height: 50px;
            /* Tinggi setiap sel data (td) di dalam tabel dengan ID "bomTable" diatur menjadi 50px */
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
                                                <th>COLOR</th>
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

                                        </tbody>
                                    </table>
                                </div>
                                <button id="addItem" class="btn bg-success">Add Item</button>
                                {{-- <button type="button" class="btn btn-sm mt-3" id="addRow">Add Row</button> --}}

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
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
        </div>
    </div>


    <script>
        $(document).ready(function() {
            let itemCounter = 0;
            let additionalColumns = []; // Menyimpan daftar kolom tambahan

            // Add Item Functionality
            $('#addItem').click(function() {
                itemCounter++;
                const newItemRow = `
                            <tr class="item-row" data-item-id="${itemCounter}">
                                <td><input type="text" name="item_id[]" class="item-id form-control" required></td>
                                <td><input type="text" name="item_code[]" class="item-code form-control"></td>
                                <td><input type="text" name="item_name[]" class="item-name form-control"></td>
                                <td><input type="text" name="unit[]" class="unit form-control"></td>
                                <td colspan="10"><button type="button" class="btn add-color bg-success" data-item-id="${itemCounter}">Add Color</button>
                                  <button type="button" class="btn remove-item bg-danger" data-item-id="${itemCounter}">Remove</button>
                                  </td>
                            </tr>
                        `;
                $('#bomTable tbody').append(newItemRow);
            });

            $(document).on('click', '.remove-item', function() {
                const itemId = $(this).data('item-id');

                // Remove the item row and all related color rows
                $(`tr[data-item-id="${itemId}"]`).remove();
            });

            // Add Color to Item Functionality
            $(document).on('click', '.add-color', function() {
                const itemId = $(this).data('item-id');
                let newColorRow = `
                            <tr class="color-row" data-item-id="${itemId}">
                                <td></td>
                                 <td></td>
                                  <td></td>
                                   <td></td>
                            
                       
                                <td><input type="text" class="form-control" name="color[]" class="color-input" placeholder="Enter Color" value="NO COLOR"></td>
                                   <td><input class="form-control" type="text" name="size[null][]" placeholder="Cons"></td>
                                <td><input type="text" class="form-control" name="size[XS][]" placeholder="Cons"></td> 
                                  <td><input type="text" class="form-control" name="size[S][]" placeholder="Cons"></td>
                                <td><input type="text" class="form-control" name="size[M][]" placeholder="Cons"></td>
                                 <td><input type="text" class="form-control" name="size[L][]" placeholder="Cons"></td>
                                <td><input type="text" class="form-control" name="size[XL][]" placeholder="Cons"></td>
                                <td><input type="text" class="form-control" name="size[XXL][]" placeholder="Cons"></td>
                                <td><input type="text" class="form-control" name="size[3XL][]" placeholder="Cons"></td>
                                <td><input type="text" class="form-control" name="size[4XL][]" placeholder="Cons"></td>
                                <td><input type="text" class="form-control" name="size[5XL][]" placeholder="Cons"></td>
                        `;

                // Tambahkan input untuk kolom tambahan
                additionalColumns.forEach(sizeName => {
                    newColorRow +=
                        `<td><input type="text" name="size[${sizeName}][]" placeholder="Cons"></td>`;
                });

                newColorRow += `<td><button type="button" class="btn remove-row">Remove</button></td></tr>`;

                $(`tr[data-item-id="${itemId}"]`).last().after(newColorRow);
            });

            // Add Column Functionality
            $('#addColumn').click(function() {
                const sizeName = prompt('Enter new size name:');
                if (sizeName) {
                    // Tambahkan ke daftar kolom tambahan
                    additionalColumns.push(sizeName);

                    // Add new header after 5XL
                    $('#bomTable thead tr th:nth-child(15)').after(`<th>${sizeName}</th>`);

                    // Add input for each color row after 5XL
                    $('#bomTable tbody tr.color-row').each(function() {
                        $(this).find('td:nth-child(15)').after(
                            `<td><input type="text"  class="form-control" name="size[${sizeName}][]" placeholder="Cons></td>`
                        );
                    });
                }
            });

            // Remove Row Functionality
            $(document).on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
            });


            $('#bomForm').submit(function(e) {
                e.preventDefault();

                // Validasi: Pastikan style dan cbd_id sudah diisi
                if ($('#style').val().trim() === '') {
                    alert('Style is required!');
                    return;
                }
                if ($('#cbd_id').val().trim() === '') {
                    alert('CBD ID is required!');
                    return;
                }

                // Inisialisasi data BOM
                const bomData = {
                    style: $('#style').val(),
                    cbd_id: $('#cbd_id').val(),
                    items: []
                };

                // Loop melalui setiap baris item
                $('#bomTable tbody tr.item-row').each(function() {
                    const itemId = $(this).find('input[name="item_id[]"]').val();
                    const colors = [];

                    // Loop melalui setiap baris color yang terkait dengan item ini
                    $(this).nextUntil(':not(.color-row)').each(function() {
                        const color = $(this).find('input[name="color[]"]').val();
                        const sizes = {};

                        // Loop melalui setiap input size
                        $(this).find('input[name^="size"]').each(function() {
                            const sizeName = $(this).attr('name').match(
                                /\[(.*?)\]/)[1];
                            const consumption = $(this).val().trim();
                            if (consumption !== '') {
                                sizes[sizeName] = consumption;
                            }
                        });

                        // Tambahkan data color dan sizes
                        colors.push({
                            color: color,
                            sizes: sizes
                        });
                    });

                    // Tambahkan item ke bomData
                    bomData.items.push({
                        item_id: itemId,
                        colors: colors
                    });
                });

                console.log('BOM Data:', bomData);

                // Kirim data ke backend
                $.ajax({
                    url: '/store/bom',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(bomData),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert('BOM saved successfully!');
                        console.log(response);
                        // window.location.href =
                        //     "{{ route('all.bom') }}";
                    },
                    error: function(error) {
                        console.error('Error:', error);
                        alert('Error saving BOM.');
                    }
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
                            $(selectedInput).closest('tr').find('.item-code').val(data
                                .item_code);
                            $(selectedInput).closest('tr').find('.item-name').val(data
                                .item_name);
                            $(selectedInput).closest('tr').find('.unit').val(data.unit
                                .unit_code);
                            $('#itemModal').modal('hide');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }


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






        $('#bomForm').submit(function(e) {
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
                return;
            }

            // Prepare BOM data if validation passed
            const bomData = {
                style: $('#style').val(),
                cbd_id: $('#cbd_id').val(),
                items: []
            };

            // Iterate through each item row
            $('#bomTable tbody tr.item-row').each(function() {
                const itemId = $(this).find('input[name="item_id[]"]').val();
                const colors = [];

                // Iterate through each color row associated with this item
                $(this).nextUntil(':not(.color-row)').each(function() {
                    const color = $(this).find('input[name="color[]"]').val();
                    const noSize = $(this).find('input[name="no_size[]"]').val();
                    const sizes = {};

                    // Collect sizes and consumption values
                    $(this).find('input[name^="size"]').each(function() {
                        const sizeName = $(this).attr('name').match(/\[(.*?)\]/)[1];
                        const consumption = $(this).val().trim();
                        if (consumption !== '') {
                            sizes[sizeName] = consumption;
                        }
                    });

                    // Add no_size to sizes
                    sizes['no_size'] = noSize || null; // Jika no_size kosong, set ke null

                    colors.push({
                        color: color,
                        sizes: sizes
                    });
                });

                bomData.items.push({
                    item_id: itemId,
                    colors: colors
                });
            });

            console.log('BOM Data:', bomData);

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
                    // alert('BOM saved successfully!');
                    clearInput(); // Clear form and reset table
                    // console.log(response);
                },
                error: function(error) {
                    console.error(error);
                    alert('Error saving BOM.');
                }
            });
        });

        // Clear Input Functionality
        function clearInput() {
            $('#style').val('');
            $('#cbd_id').val('');
            $('#bomTable tbody').html(`
       
    `);
        }
    </script>
@endsection
