{{-- @extends('admin.admin_dashboard')

@section('admin') --}}

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
    <meta name="author" content="NobleUI">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords"
        content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <title>APP - TIMW</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- End fonts -->

    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/datatables.net-bs5/buttons.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/core/core.css') }}">

    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/flatpickr/flatpickr.min.css') }}">

    <link rel="stylesheet" href="{{ asset('backend/assets/fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/sweetalert2/sweetalert2.min.css') }}">

    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/demo1/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/custom.css') }}">
    <!-- End layout styles -->

    <link rel="stylesheet" href="{{ asset('css/toastr.css') }}">

    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.png') }}" />

    <!-- DataTables Buttons CSS -->
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css"> --}}

    <!-- javascript -->

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/core/core.js') }}"></script>

    <script src="{{ asset('backend/assets/js/template.js') }}"></script>

    {{-- <script src="{{ asset('backend/assets/js/dashboard-dark.js') }}"></script> --}}
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/datatables.net-bs5/jszip.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/datatables.net-bs5/pdfmake.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/datatables.net-bs5/vfs_fonts.js') }}"></script>
    {{-- <script src="{{ asset('backend/assets/vendors/datatables.net-bs5/buttons.html5.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('backend/assets/vendors/datatables.net-bs5/buttons.print.min.js') }}"></script> --}}

    <script src="{{ asset('backend/assets/js/data-table.js') }}"></script>

    {{-- <script src="{{ asset('js/sweatalert.js') }}"></script> --}}

    <script src="{{ asset('backend/assets/js/code.js') }}"></script>

    <script src="{{ asset('js/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ asset('js/pusher.min.js') }}"></script>

</head>

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

<body class="settings-open sidebar-dark">

    <div class="page-content">

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="row">

                            <div class="container">

                                <form action="{{ route('store.materialin') }}" method="POST">
                                    @csrf
                                    <!-- Purchase Request Fields -->

                                    <div class="text-center">
                                        <h4>ADD MATERIAL IN</h4>
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

                                        <div class="col-md-4">

                                            <div class="form-group row">
                                                <label for="supplier_id"
                                                    class="col-sm-3 col-form-label">Supplier</label>
                                                <div class="col-sm-9">

                                                    <div class="input-group">
                                                        <input type="text"
                                                            class="form-control form-control-sm form-control supplier_id"
                                                            id="supplier_id" name="supplier_id">
                                                        <input type="text"
                                                            class="form-control form-control-sm form-control supplier_name"
                                                            id="supplier_name" name="supplier_name">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-secondary btn-sm supplier_search"
                                                                id="supplier_search" type="button">
                                                                <i class="feather-10" data-feather="search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-md-4">

                                            <div class="form-group row">
                                                <label for="no_sj" class="col-sm-3 col-form-label">NO SJ</label>
                                                <div class="col-sm-9">
                                                    <input type="text"
                                                        class="form-control form-control-sm form-control form-control-sm-sm"
                                                        style="width: 100%;" id="no_sj" name="no_sj">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="recived_by" class="col-sm-3 col-form-label">Reciver</label>
                                                <div class="col-sm-9">
                                                    <input type="text"
                                                        class="form-control form-control-sm form-control form-control-sm-sm"
                                                        style="width: 100%;" id="recived_by" name="recived_by">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label for="location" class="col-sm-3 col-form-label">Location</label>
                                                <div class="col-sm-9">
                                                    <input type="text"
                                                        class="form-control form-control-sm form-control form-control-sm-sm"
                                                        style="width: 100%;" id="location" name="location">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="courier" class="col-sm-3 col-form-label">courier</label>
                                                <div class="col-sm-9">
                                                    <input type="text"
                                                        class="form-control form-control-sm form-control form-control-sm-sm"
                                                        style="width: 100%;" id="courier" name="courier" required>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <hr>

                                    <!-- Purchase Request Details Fields -->

                                    <div class="row">

                                        <div class="">
                                            <button type="button" class="btn btn-secondary btn-sm mb-2"
                                                id="add-detail">Add
                                                Detail</button>

                                            <h6>IN Items</h6>

                                            <div class="table-scrollable">

                                                <table class="table table-bordered" id="details-table">
                                                    <thead>
                                                        <tr>

                                                            <th>ITEM CODE</th>
                                                            <th>DESC</th>
                                                            <th>SUPPLIER</th>
                                                            <th>PO</th>
                                                            <th>COLOR CODE</th>
                                                            <th>COLOR NAME</th>
                                                            <th>SIZE</th>
                                                            <th>MO</th>

                                                            <th>QTY</th>
                                                            <th>Action</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody id="details-containerx">
                                                        <tr>

                                                            <td><input type="text" name="details[0][item_code]"
                                                                    class="form-control item_code"
                                                                    placeholder="Item Code" required>
                                                            </td>
                                                            <td><input type="text" name="details[0][item_name]"
                                                                    class="form-control" placeholder="item name"></td>

                                                            <td><input type="text" name="details[0][po]"
                                                                    class="form-control" placeholder="PO"></td>

                                                            <td><input type="text" name="details[0][supplier_name]"
                                                                    class="form-control" placeholder="Supplier Name">
                                                            </td>
                                                            <td><input type="text" name="details[0][color_code]"
                                                                    class="form-control" placeholder="Color Code">
                                                            </td>
                                                            <td><input type="text" name="details[0][color_name]"
                                                                    class="form-control" placeholder="Color Name">
                                                            </td>

                                                            <td><input type="text" name="details[0][size]"
                                                                    class="form-control" placeholder="Size">
                                                            </td>

                                                            <td><input type="text" name="details[0][mo]"
                                                                    class="form-control" placeholder="MO"></td>
                                                            <td><input type="text" name="details[0][qty]"
                                                                    class="form-control" placeholder="Qty" required>
                                                            </td>

                                                            <td>
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm remove-detail">Remove</button>
                                                            </td>

                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <h5>Total Rolls: <span id="total-rolls">0</span></h5>
                                                </div>
                                                {{-- <div class="col-md-6">
                                                    <h5>Total Quantity: <span id="total-qty">0</span></h5>
                                                </div> --}}
                                            </div>

                                        </div>

                                    </div>

                                    <button type="submit" class="btn btn-primary mt-2">Submit</button>
                                    <a href="{{ route('all.materialin') }}" class="btn btn-danger mt-2">Back</a>
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
            let rowIndex = 1;
            update_totals();

            $('#add-detail').click(function() {
                add_row();
            });

            $(document).on('click', '.remove-detail', function() {
                $(this).closest('tr').remove();
                update_totals();
            });

            function add_row() {

                let newRow = `
               <tr>

                 
                    <td><input type="text" name="details[${rowIndex}][item_code]" class="form-control item_code" placeholder="Item Code"></td>
                    <td><input type="text" name="details[${rowIndex}][item_name]" class="form-control" placeholder="Item Name"></td>
                    <td><input type="text" name="details[${rowIndex}][supplier_name]" class="form-control" placeholder="Supplier Name"></td>
                    <td><input type="text" name="details[${rowIndex}][po]" class="form-control" placeholder="PO"></td>
                    <td><input type="text" name="details[${rowIndex}][color_code]" class="form-control" placeholder="Color Code"></td>
                    <td><input type="text" name="details[${rowIndex}][color_name]" class="form-control" placeholder="Color Name"></td>
                    <td><input type="text" name="details[${rowIndex}][size]" class="form-control" placeholder="size"></td>
                    <td><input type="text" name="details[${rowIndex}][mo]" class="form-control" placeholder="MO"></td>
                  
                   
                    <td><input type="text" name="details[${rowIndex}][qty]" class="form-control qty" placeholder="Qty"></td>
                  
                    <td><button type="button" class="btn btn-danger btn-sm remove-detail">Remove</button></td>
                </tr>
            `;
                $('#details-containerx').append(newRow);
                rowIndex++;
                $('#details-containerx').find('tr:last .item_code').focus();
                update_totals();

            }

            function checkDuplicate(itemCode, row) {
                let isDuplicate = false;
                $('#details-containerx tr').each(function() {
                    if ($(this).get(0) === row.get(0)) {
                        return; // Skip the current row
                    }
                    let existingNo = $(this).find('.item_code').val().trim();
                    if (existingNo === itemCode && itemCode !== '') {
                        isDuplicate = true;
                        return false; // Exit loop early
                    }
                });
                return isDuplicate;
            }



            $(document).on('keydown', '.item_code', function(event) {

                console.log('ini diklik item code');

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger me-2'
                    },
                    buttonsStyling: false,
                })




                if (event.keyCode === 13) { // 13 adalah kode untuk tombol Enter
                    event.preventDefault(); // Mencegah aksi default tombol Enter

                    let itemCode = $(this).val().trim();
                    let row = $(this).closest('tr');

                    if (itemCode) {
                        if (checkDuplicate(itemCode, row)) {

                            swalWithBootstrapButtons.fire({
                                title: 'Duplicate!',
                                text: `Duplicate Original No detected!`,
                                icon: 'error',
                                timer: 2000,
                                timerProgressBar: true,
                                willClose: () => {
                                    // Optional: Add any additional actions you want to perform after the alert closes
                                }
                            })

                            $(this).val(''); // Kosongkan field input
                        } else {
                            $.ajax({
                                url: '/get/purchaseorderid/' + itemCode,
                                type: 'GET',
                                success: function(response) {

                                    row.find('input[name$="[supplier_name]"]').val(response
                                        .supplier_name || '');
                                    row.find('input[name$="[item_code]"]').val(response
                                        .item_code || '');
                                    row.find('input[name$="[po]"]').val(response.po || '');
                                    row.find('input[name$="[color_code]"]').val(response
                                        .color_code || '');
                                    row.find('input[name$="[color_name]"]').val(response
                                        .color_name || '');



                                    row.find('input[name$="[qty]"]').val(response.qty || '');

                                    row.find('input[name$="[mo]"]').val(response.mo || '');


                                    update_totals();
                                },
                                error: function() {






                                    swalWithBootstrapButtons.fire({
                                        title: 'Not Found!',
                                        text: `Data not found!`,
                                        icon: 'error',
                                        timer: 2000,
                                        timerProgressBar: true,
                                        willClose: () => {
                                            // Optional: Add any additional actions you want to perform after the alert closes
                                        }
                                    })

                                    row.find('input').val('');
                                }
                            });
                        }
                    }
                }
            });


            $(document).on('input', '.qty', function() {
                update_totals();
            });

            function update_totals() {
                let totalRolls = 0;
                let totalQty = 0;

                let countFilledRows = 0; // Initialize counter for rows with filled item_code

                $('#details-containerx tr').each(function() {
                    let itemCodeValue = $(this).find('input[name$="[item_code]"]').val().trim();
                    let qtyValue = parseFloat($(this).find('input[name$="[qty]"]').val());

                    if (itemCodeValue) {
                        countFilledRows++; // Increment count if item_code is filled
                    }

                    if (!isNaN(qtyValue)) {
                        totalQty += qtyValue;
                    }
                });

                $('#total-rolls').text(countFilledRows);
                $('#total-qty').text(totalQty.toFixed(2));
            }


        });



        function isDuplicate(itemCode) {
            let isDuplicate = false;
            $('#details-containerx tr').each(function() {
                let existingNo = $(this).find('.item_code').val().trim();
                if (itemCode === existingNo && itemCode !== '') {
                    isDuplicate = true;
                    return false; // Exit loop early
                }
            });
            return isDuplicate;
        }



        $(document).on('click', '.supplier_search', function() {
            selectedInput = $(this);
            $('#supplierModal').modal('show'); // Show the modal
            loadSuppliers();
        });



        function loadSuppliers() {
            $('#supplier-table tbody').empty();

            $.ajax({
                url: '{{ route('get.supplierglobal') }}', // Sesuaikan dengan route yang benar
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    // Inisialisasi DataTable
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
                                    // Batasi panjang teks maksimal menjadi 25 karakter
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
                        // selectedInput.val(supplier.id); 
                        $('#supplier_id').val(supplier.id);
                        $('#supplier_name').val(supplier.supplier_name);
                        // $(selectedInput).closest('.detail-row').find('.supplier-name').val(
                        //     supplier
                        //     .supplier_name);
                        $('#supplierModal').modal('hide');




                        fetchAndPopulatePOItems(supplier.id);

                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function fetchAndPopulatePOItems(supplier_id) {
            $.ajax({
                url: '/get/purchaseorderid/' + supplier_id,
                type: 'GET',
                success: function(data) {

                    console.log(data);



                    if (data.length === 0) {
                        Swal.fire({
                            title: 'No Items Found',
                            text: 'No Purchase Order items found for the selected supplier.',
                            icon: 'info',
                            timer: 2000,
                            timerProgressBar: true,
                        });
                        return;
                    }

                    // Optionally, clear existing rows before populating
                    // $('#details-containerx').empty();
                    // Alternatively, append to existing rows

                    data.forEach(function(item) {
                        let newRow = `
                        <tr>
                            <td>
                                <input type="text" name="details[${rowIndex}][item_code]" class="form-control item_code" placeholder="Item Code" value="${item.item_code}" required>
                            </td>
                            <td>
                                <input type="text" name="details[${rowIndex}][item_name]" class="form-control" placeholder="Description" value="${item.item_name}">
                            </td>
                            <td>
                                <input type="text" name="details[${rowIndex}][supplier_name]" class="form-control" placeholder="Supplier Name" value="${item.supplier_name}">
                            </td>
                            <td>
                                <input type="text" name="details[${rowIndex}][po]" class="form-control" placeholder="PO" value="${item.po}">
                            </td>
                            <td>
                                <input type="text" name="details[${rowIndex}][color_code]" class="form-control" placeholder="Color Code" value="${item.color_code}">
                            </td>
                            <td>
                                <input type="text" name="details[${rowIndex}][color_name]" class="form-control" placeholder="Color Name" value="${item.color_name}">
                            </td>
                            <td>
                                <input type="text" name="details[${rowIndex}][size]" class="form-control" placeholder="Size" value="${item.size}">
                            </td>
                            <td>
                                <input type="text" name="details[${rowIndex}][mo]" class="form-control" placeholder="MO" value="${item.mo}">
                            </td>
                            <td>
                                <input type="text" name="details[${rowIndex}][qty]" class="form-control qty" placeholder="Qty" value="${item.qty}" required>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-detail">Remove</button>
                            </td>
                        </tr>
                    `;
                        $('#details-containerx').append(newRow);
                        rowIndex++;
                    });

                    update_totals();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        title: 'Error!',
                        text: `Unable to fetch PO items.`,
                        icon: 'error',
                        timer: 2000,
                        timerProgressBar: true,
                    });
                }
            });
        }
    </script>
    {{-- @endsection --}}

</body>

</html>

<script src="{{ asset('backend/assets/vendors/feather-icons/feather.min.js') }}"></script>
