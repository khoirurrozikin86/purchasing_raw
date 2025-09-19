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
                            <input type="hidden" id="bom_id" name="bom_id" value="{{ $bom->id }}">

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="style">Style:</label>
                                    <input type="text" class="form-control" id="style" name="style"
                                        value="{{ $bom->style }}" readonly>
                                </div>
                            </div>

                            <hr />

                            <h6>Material Item</h6>

                            <button type="button" class="btn btn-sm mt-3" id="addColumn">Add Column</button>
                            <div class="table-responsive">
                                <table id="bomTable" class="table table-bordered">
                                    <thead>
                                        <tr id="headerRow">
                                            <th>Item ID</th>
                                            <th>Item Code</th>
                                            <th>Item Name</th>
                                            <th>Unit</th>
                                            <th>Color</th>
                                            @php
                                                $allSizes = collect($allSizes);
                                                if (!$allSizes->contains(null)) {
                                                    $allSizes->prepend(null);
                                                }
                                            @endphp

                                            @foreach ($allSizes as $size)
                                                <th>{{ $size === null ? 'No Size' : $size }}</th>
                                            @endforeach
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bom->details->groupBy(function ($detail) {
            return $detail->item_id . '-' . $detail->remark1;
        }) as $key => $details)
                                            @php
                                                $firstDetail = $details->first();
                                            @endphp
                                            <tr class="detail-row">
                                                <td><input type="text" name="items[{{ $loop->index }}][item_id]"
                                                        class="item-id form-control" value="{{ $firstDetail->item_id }}"
                                                        required>
                                                </td>
                                                <td><input type="text" name="items[{{ $loop->index }}][item_code]"
                                                        class="item-code form-control"
                                                        value="{{ $firstDetail->item->item_code ?? '' }}"></td>
                                                <td><input type="text" name="items[{{ $loop->index }}][item_name]"
                                                        class="item-name form-control"
                                                        value="{{ $firstDetail->item->item_name ?? '' }}" required>
                                                </td>
                                                <td><input type="text" name="items[{{ $loop->index }}][unit]"
                                                        class="unit form-control"
                                                        value="{{ $firstDetail->item->unit->unit_code ?? '' }}" required>
                                                </td>
                                                <td><input type="text" name="items[{{ $loop->index }}][color]"
                                                        class="color form-control"
                                                        value="{{ $firstDetail->remark1 ?? '' }}"></td>

                                                @foreach ($allSizes as $size)
                                                    <td>
                                                        <input class="form-control" type="text"
                                                            name="items[{{ $loop->parent->index }}][sizes][{{ $size }}]"
                                                            value="{{ $details->where('size', $size)->first()->consumption ?? '' }}">
                                                    </td>
                                                @endforeach
                                                <td><button type="button" class="btn btn-danger remove-row">Remove</button>
                                                </td>
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
            let itemCounter = {{ $bom->details->count() }};
            let columnCounter = {{ count($allSizes) }}; // Hitung jumlah kolom awal
            let additionalColumns = [];

            // Add Row Functionality
            $('#addRow').click(function() {
                const newRow = $('#bomTable tbody tr:first').clone();
                newRow.find('input').val('');
                const currentRowCount = $('#bomTable tbody tr').length;

                newRow.attr('id', `row-${currentRowCount + 1}`);
                newRow.find('input').each(function() {
                    const name = $(this).attr('name');
                    if (name) {
                        const updatedName = name.replace(/\[\d+\]/, `[${currentRowCount}]`);
                        $(this).attr('name', updatedName);
                    }
                });

                $('#bomTable tbody').append(newRow);
            });

            // Add Column Functionality
            $('#addColumn').click(function() {
                // Prompt pengguna untuk memasukkan nama kolom baru
                let sizeName = prompt('Enter new size name (optional):');

                // Jika sizeName kosong, gunakan nama default
                if (!sizeName || sizeName.trim() === '') {
                    sizeName = `Column ${additionalColumns.length + 1}`; // Default column name
                }

                // Tambahkan nama kolom baru ke daftar
                additionalColumns.push(sizeName);

                // Cari indeks kolom terakhir sebelum "Actions"
                const actionsIndex = $('#bomTable thead tr th').length;

                // Tambahkan header baru sebelum kolom "Actions"
                $(`#bomTable thead tr th:nth-child(${actionsIndex})`).before(`<th>${sizeName}</th>`);

                // Tambahkan kolom input baru ke setiap baris di tbody sebelum kolom "Actions"
                $('#bomTable tbody tr').each(function() {
                    $(this).find(`td:nth-child(${actionsIndex})`).before(`
                    <td>
                        <input type="text" class="form-control" name="items[${$(this).index()}][sizes][${sizeName}]" placeholder="Consumption">
                    </td>
                `);
                });
            });

            // Remove Row Functionality
            $(document).on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
            });

            // Submit BOM Form
            $('#editBomForm').submit(function(e) {
                e.preventDefault();

                const bomData = {
                    bom_id: $('#bom_id').val(),
                    style: $('#style').val(),
                    items: []
                };

                $('#bomTable tbody tr').each(function() {
                    const row = $(this);
                    const item = {
                        item_id: row.find('.item-id').val(),
                        item_code: row.find('.item-code').val(),
                        item_name: row.find('.item-name').val(),
                        unit: row.find('.unit').val(),
                        color: row.find('.color').val(),
                        sizes: {}
                    };

                    // Ambil semua ukuran (size) dan konsumsi (consumption) untuk baris ini
                    row.find('input[name^="items"]').each(function() {
                        const nameAttr = $(this).attr('name');
                        if (nameAttr) {
                            const sizeMatch = nameAttr.match(/\[sizes\]\[(.*?)\]/);
                            if (sizeMatch) {
                                const sizeName = sizeMatch[1];
                                item.sizes[sizeName] = $(this).val();
                            }
                        }
                    });

                    bomData.items.push(item);
                });

                console.log('BOM Data:', bomData); // Debugging untuk melihat data yang dikirim

                $.ajax({
                    url: "{{ route('update.bom', $bom->id) }}",
                    method: 'POST',
                    data: JSON.stringify(bomData), // Kirim data sebagai JSON
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        alert('BOM updated successfully!');
                        window.location.href = "{{ route('all.bom') }}";
                    },
                    error: function(error) {
                        console.error('Error:', error);
                        alert('Error updating BOM.');
                    },
                });
            });

            // Item Lookup Modal
            $(document).on('click', '.item-id', function() {
                selectedInput = $(this);
                $('#itemModal').modal('show');
                loadItems();
            });

            function loadItems() {
                $('#items-table tbody').empty();

                $.ajax({
                    url: '{{ route('get.itemglobal') }}',
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        const table = $('#items-table').DataTable({
                            paging: true,
                            searching: true,
                            ordering: true,
                            destroy: true,
                            info: true,
                            data: data,
                            columns: [{
                                    title: 'ID',
                                    data: 'id'
                                },
                                {
                                    title: 'Item Code',
                                    data: 'item_code'
                                },
                                {
                                    title: 'Item Name',
                                    data: 'item_name'
                                },
                                {
                                    title: 'Unit',
                                    data: 'unit.unit_code'
                                },
                                {
                                    title: 'Category',
                                    data: 'category.name'
                                },
                                {
                                    title: 'Description',
                                    data: 'description'
                                }
                            ]
                        });

                        $('#items-table tbody').off('click').on('click', 'tr', function() {
                            const data = table.row(this).data();
                            if (!data || typeof data !== 'object') {
                                console.error('Data is undefined or not an object:', data);
                                alert('Failed to fetch item data. Please try again.');
                                return;
                            }
                            selectedInput.val(data.id);
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




    {{-- <script>
        $(document).ready(function() {
            let itemCounter = {{ $bom->details->count() }};
            let columnCounter = {{ count($allSizes) }}; // Hitung jumlah kolom awal
            let additionalColumns = [];

            // Add Row Functionality
            $('#addRow').click(function() {
                const newRow = $('#bomTable tbody tr:first').clone();
                newRow.find('input').val('');
                const currentRowCount = $('#bomTable tbody tr').length;
                newRow.attr('id', `row-${currentRowCount + 1}`);
                newRow.find('input').each(function() {
                    const name = $(this).attr('name');
                    if (name) {
                        const updatedName = name.replace(/\[\d+\]/, `[${currentRowCount}]`);
                        $(this).attr('name', updatedName);
                    }
                });
                $('#bomTable tbody').append(newRow);
            });

            // Add Column Functionality
            $('#addColumn').click(function() {
                // Prompt pengguna untuk memasukkan nama kolom baru
                let sizeName = prompt('Enter new size name (optional):');

                // Jika sizeName kosong, gunakan nama default
                if (!sizeName || sizeName.trim() === '') {
                    sizeName = `Column ${additionalColumns.length + 1}`; // Default column name
                }

                // Tambahkan nama kolom baru ke daftar
                additionalColumns.push(sizeName);

                // Cari indeks kolom terakhir sebelum "Actions"
                const actionsIndex = $('#bomTable thead tr th').length;

                // Tambahkan header baru sebelum kolom "Actions"
                $(`#bomTable thead tr th:nth-child(${actionsIndex})`).before(`<th>${sizeName}</th>`);

                // Tambahkan kolom input baru ke setiap baris di tbody sebelum kolom "Actions"
                $('#bomTable tbody tr').each(function() {
                    $(this).find(`td:nth-child(${actionsIndex})`).before(`
                <td>
                    <input type="text" class="form-control" name="sizes[${sizeName}][]" placeholder="Consumption">
                </td>
            `);
                });
            });

            // Remove Row Functionality
            $(document).on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
            });


            // Submit BOM Form
            $('#editBomForm').submit(function(e) {
                e.preventDefault();

                const bomData = {
                    bom_id: $('#bom_id').val(),
                    style: $('#style').val(),
                    items: []
                };

                $('#bomTable tbody tr').each(function() {
                    const row = $(this);
                    const item = {
                        item_id: row.find('.item-id').val(),
                        item_code: row.find('.item-code').val(),
                        item_name: row.find('.item-name').val(),
                        unit: row.find('.unit').val(),
                        color: row.find('.color').val(),
                        sizes: {}
                    };

                    // Ambil semua ukuran (size) dan konsumsi (consumption) untuk baris ini
                    row.find('input[name^="items"]').each(function() {
                        const sizeName = $(this).attr('name').match(/\[sizes\]\[(.*?)\]/)[
                            1];
                        item.sizes[sizeName] = $(this).val();
                    });

                    bomData.items.push(item);
                });

                console.log('BOM Data:', bomData); // Debugging untuk melihat data yang dikirim

                $.ajax({
                    url: "{{ route('update.bom', $bom->id) }}",
                    method: 'POST',
                    data: JSON.stringify(bomData), // Kirim data sebagai JSON
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        alert('BOM updated successfully!');
                        window.location.href = "{{ route('all.bom') }}";
                    },
                    error: function(error) {
                        console.error('Error:', error);
                        alert('Error updating BOM.');
                    },
                });
            });

            // Item Lookup Modal
            $(document).on('click', '.item-id', function() {
                selectedInput = $(this);
                $('#itemModal').modal('show');
                loadItems();
            });

            function loadItems() {
                $('#items-table tbody').empty();

                $.ajax({
                    url: '{{ route('get.itemglobal') }}',
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        const table = $('#items-table').DataTable({
                            paging: true,
                            searching: true,
                            ordering: true,
                            destroy: true,
                            info: true,
                            data: data,
                            columns: [{
                                    title: 'ID',
                                    data: 'id'
                                },
                                {
                                    title: 'Item Code',
                                    data: 'item_code'
                                },
                                {
                                    title: 'Item Name',
                                    data: 'item_name'
                                },
                                {
                                    title: 'Unit',
                                    data: 'unit.unit_code'
                                },
                                {
                                    title: 'Category',
                                    data: 'category.name'
                                },
                                {
                                    title: 'Description',
                                    data: 'description'
                                }
                            ]
                        });

                        $('#items-table tbody').off('click').on('click', 'tr', function() {
                            const data = table.row(this).data();
                            if (!data || typeof data !== 'object') {
                                console.error('Data is undefined or not an object:', data);
                                alert('Failed to fetch item data. Please try again.');
                                return;
                            }
                            selectedInput.val(data.id);
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
    </script> --}}
@endsection
