@extends('admin.admin_dashboard')

@section('admin')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

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
                        <h6 class="card-title text-center">Edit BOM</h6>
                        <form id="editBomForm" class="mt-3">
                            @csrf
                            <input type="hidden" name="cbd_id" id="cbd_id" value="{{ $bom->cbd_id }}">
                            <div class="form-group">
                                <label for="style">Style</label>
                                <input type="text" name="style" id="style" class="form-control"
                                    value="{{ $bom->style }}" required>
                            </div>
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
                                            @php
                                                // Tambahkan "No Size" jika belum ada
                                                $allSizes = collect($allSizes);
                                                if (!$allSizes->contains(null)) {
                                                    $allSizes->prepend(null);
                                                }
                                            @endphp

                                            @foreach ($allSizes as $size)
                                                <th>{{ $size === null ? 'No Size' : $size }}</th>
                                                <!-- Ganti null dengan No Size -->
                                            @endforeach
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bom->details->groupBy('item_id') as $itemId => $details)
                                            <tr class="detail-row">
                                                <td><input type="text" name="items[{{ $loop->index }}][item_id]"
                                                        class="item-id form-control" value="{{ $itemId }}" required>
                                                </td>
                                                <td><input type="text" name="items[{{ $loop->index }}][item_code]"
                                                        class="item-code form-control"
                                                        value="{{ $details->first()->item->item_code ?? '' }}"></td>
                                                <td><input type="text" name="items[{{ $loop->index }}][item_name]"
                                                        class="item-name form-control"
                                                        value="{{ $details->first()->item->item_name ?? '' }}" required>
                                                </td>
                                                <td><input type="text" name="items[{{ $loop->index }}][unit]"
                                                        class="unit form-control"
                                                        value="{{ $details->first()->item->unit->unit_code ?? '' }}"
                                                        required></td>


                                                @foreach ($allSizes as $size)
                                                    <td>
                                                        <input class="form-control" type="text"
                                                            name="items[{{ $loop->parent->index }}][sizes][{{ $size }}]"
                                                            value="{{ $details->where('size', $size)->first()->consumption ?? '' }}">
                                                    </td>
                                                @endforeach
                                                <td><button type="button" class="btn remove-row">Remove</button></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" class="btn btn-sm mt-3" id="addRow">Add Row</button>
                            <br><br>
                            <button type="submit" class="btn bg-primary">Update BOM</button>
                        </form>
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

    <script>
        $(document).ready(function() {
            $('#addRow').click(function() {
                // Clone row pertama
                const newRow = $('#bomTable tbody tr:first').clone();

                // Reset nilai input di baris baru
                newRow.find('input').val('');

                // Ambil jumlah baris yang ada
                const currentRowCount = $('#bomTable tbody tr').length;

                // Tetapkan ID unik untuk baris baru
                newRow.attr('id', `row-${currentRowCount + 1}`);

                // Perbarui atribut `name` untuk setiap input di baris baru
                newRow.find('input').each(function() {
                    const name = $(this).attr('name');
                    if (name) {
                        const updatedName = name.replace(/\[\d+\]/, `[${currentRowCount}]`);
                        $(this).attr('name', updatedName);
                    }
                });

                // Tambahkan row ke dalam tbody
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



            $(document).on('click', '.remove-row', function() {
                if ($('#bomTable tbody tr').length > 1) {
                    $(this).closest('tr').remove();
                } else {
                    alert('At least one row must be present.');
                }
            });





            $('#editBomForm').submit(function(e) {
                e.preventDefault();

                const data = $(this).serializeArray();
                $.ajax({
                    url: "{{ route('update.bom', $bom->id) }}",
                    method: "POST",
                    data: data,
                    success: function(response) {
                        alert(response.message);
                        window.location.href = "{{ route('all.bom') }}";
                    },
                    error: function(error) {
                        alert('Error updating BOM.');
                        console.error(error);
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



























        });
    </script>
@endsection
