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

                                <form action="{{ route('store.materialreturn') }}" method="POST">
                                    @csrf
                                    <!-- Purchase Request Fields -->

                                    <div class="text-center">
                                        <h4>ADD MATERIAL RETURN</h4>
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
                                                <label for="department"
                                                    class="col-sm-3 col-form-label">Department</label>
                                                <div class="col-sm-9">
                                                    <input type="text"
                                                        class="form-control form-control-sm form-control form-control-sm-sm"
                                                        style="width: 100%;" id="department" name="department">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-4">

                                            <div class="form-group row">
                                                <label for="person" class="col-sm-3 col-form-label">PIC</label>
                                                <div class="col-sm-9">
                                                    <input type="text"
                                                        class="form-control form-control-sm form-control form-control-sm-sm"
                                                        style="width: 100%;" id="person" name="person">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label for="remark" class="col-sm-3 col-form-label">Remark</label>
                                                <div class="col-sm-9">
                                                    <input type="text"
                                                        class="form-control form-control-sm form-control form-control-sm-sm"
                                                        style="width: 100%;" id="remark" name="remark">
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

                                            <h6>RETURN Items</h6>

                                            <div class="table-scrollable">

                                                <table class="table table-bordered" id="details-table">
                                                    <thead>
                                                        <tr>
                                                            <th>ORIGINAL NO</th>
                                                            <th>RECEIVE</th>
                                                            <th>SUPPLIER</th>
                                                            <th>FAB CODE</th>
                                                            <th>PO</th>
                                                            <th>COLOR CODE</th>
                                                            <th>COLOR NAME</th>
                                                            <th>BATCH</th>
                                                            <th>ROLL</th>
                                                            <th>GW</th>
                                                            <th>NW</th>

                                                            <th>BASIC WIDTH</th>
                                                            <th>BASIC GRM</th>

                                                            <th>QTY</th>

                                                            <th>Action</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody id="details-containerx">
                                                        <tr>
                                                            <td><input type="text" name="details[0][original_no]"
                                                                    class="form-control original_no"
                                                                    placeholder="Original No" required>
                                                            </td>
                                                            <td><input type="text" name="details[0][receive_date]"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="details[0][supplier_name]"
                                                                    class="form-control" placeholder="Supplier Name">
                                                            </td>
                                                            <td><input type="text" name="details[0][item_code]"
                                                                    class="form-control" placeholder="Item Code"
                                                                    required>
                                                            </td>
                                                            <td><input type="text" name="details[0][po]"
                                                                    class="form-control" placeholder="PO"></td>
                                                            <td><input type="text" name="details[0][color_code]"
                                                                    class="form-control" placeholder="Color Code">
                                                            </td>
                                                            <td><input type="text" name="details[0][color_name]"
                                                                    class="form-control" placeholder="Color Name">
                                                            </td>

                                                            <td><input type="text" name="details[0][batch]"
                                                                    class="form-control" placeholder="Batch"></td>
                                                            <td><input type="text" name="details[0][roll]"
                                                                    class="form-control" placeholder="Roll" required>
                                                            </td>
                                                            <td><input type="text" name="details[0][gross_weight]"
                                                                    class="form-control" placeholder="Gross Weight">
                                                            </td>
                                                            <td><input type="text" name="details[0][net_weight]"
                                                                    class="form-control" placeholder="Net Weight">
                                                            </td>

                                                            <td><input type="text" name="details[0][basic_width]"
                                                                    class="form-control" placeholder="Basic Width">
                                                            </td>
                                                            <td><input type="text" name="details[0][basic_grm]"
                                                                    class="form-control" placeholder="Basic Grm"></td>

                                                            <td><input type="text" name="details[0][qty]"
                                                                    class="form-control qty" placeholder="Qty"
                                                                    required>
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
                                    <a href="{{ route('all.materialreturn') }}" class="btn btn-danger mt-2">Back</a>
                                </form>
                            </div>

                        </div>

                    </div>
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
                    <td><input type="text" name="details[${rowIndex}][original_no]" class="form-control original_no" placeholder="Original No" required></td>
                    <td><input type="text" name="details[${rowIndex}][receive_date]" class="form-control"></td>
                    <td><input type="text" name="details[${rowIndex}][supplier_name]" class="form-control" placeholder="Supplier Name"></td>
                    <td><input type="text" name="details[${rowIndex}][item_code]" class="form-control" placeholder="Item Code"></td>
                    <td><input type="text" name="details[${rowIndex}][po]" class="form-control" placeholder="PO"></td>
                    <td><input type="text" name="details[${rowIndex}][color_code]" class="form-control" placeholder="Color Code"></td>
                    <td><input type="text" name="details[${rowIndex}][color_name]" class="form-control" placeholder="Color Name"></td>
                    <td><input type="text" name="details[${rowIndex}][batch]" class="form-control" placeholder="Batch"></td>
                    <td><input type="text" name="details[${rowIndex}][roll]" class="form-control roll" placeholder="Roll"></td>
                    <td><input type="text" name="details[${rowIndex}][gross_weight]" class="form-control" placeholder="Gross Weight"></td>
                    <td><input type="text" name="details[${rowIndex}][net_weight]" class="form-control" placeholder="Net Weight"></td>
               
                    <td><input type="text" name="details[${rowIndex}][basic_width]" class="form-control" placeholder="Basic Width"></td>
                    <td><input type="text" name="details[${rowIndex}][basic_grm]" class="form-control" placeholder="Basic Grm"></td>
              
                    <td><input type="text" name="details[${rowIndex}][qty]" class="form-control qty" placeholder="Qty"></td>
      
             
                    <td><button type="button" class="btn btn-danger btn-sm remove-detail">Remove</button></td>
                </tr>
            `;
                $('#details-containerx').append(newRow);
                rowIndex++;
                $('#details-containerx').find('tr:last .original_no').focus();
                update_totals();

            }

            function checkDuplicate(originalNo, row) {
                let isDuplicate = false;
                $('#details-containerx tr').each(function() {
                    if ($(this).get(0) === row.get(0)) {
                        return; // Skip the current row
                    }
                    let existingNo = $(this).find('.original_no').val().trim();
                    if (existingNo === originalNo && originalNo !== '') {
                        isDuplicate = true;
                        return false; // Exit loop early
                    }
                });
                return isDuplicate;
            }



            $(document).on('keydown', '.original_no', function(event) {




                if (event.keyCode === 13) { // 13 adalah kode untuk tombol Enter
                    event.preventDefault(); // Mencegah aksi default tombol Enter



                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger me-2'
                        },
                        buttonsStyling: false,
                    })


                    let originalNo = $(this).val().trim();
                    let row = $(this).closest('tr');


                    if (originalNo) {
                        if (checkDuplicate(originalNo, row)) {
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
                            $(this).val(''); // Clear the input field
                        } else {
                            $.ajax({
                                url: '/get/materialinoriginal/' + originalNo,
                                type: 'GET',
                                success: function(response) {
                                    if (response.material_in_detail) {
                                        row.find('input[name$="[receive_date]"]').val(response
                                            .material_in_detail.receive_date || '');
                                        row.find('input[name$="[supplier_name]"]').val(response
                                            .material_in_detail.supplier_name || '');
                                        row.find('input[name$="[item_code]"]').val(response
                                            .material_in_detail.item_code || '');
                                        row.find('input[name$="[po]"]').val(response
                                            .material_in_detail.po || '');
                                        row.find('input[name$="[color_code]"]').val(response
                                            .material_in_detail.color_code || '');
                                        row.find('input[name$="[color_name]"]').val(response
                                            .material_in_detail.color_name || '');
                                        row.find('input[name$="[batch]"]').val(response
                                            .material_in_detail.batch || '');
                                        row.find('input[name$="[roll]"]').val(response
                                            .material_in_detail.roll || '');
                                        row.find('input[name$="[gross_weight]"]').val(response
                                            .material_in_detail.gross_weight || '');
                                        row.find('input[name$="[net_weight]"]').val(response
                                            .material_in_detail.net_weight || '');

                                        row.find('input[name$="[basic_width]"]').val(response
                                            .material_in_detail.basic_width || '');
                                        row.find('input[name$="[basic_grm]"]').val(response
                                            .material_in_detail.basic_grm || '');

                                    }



                                    row.find('input[name$="[qty]"]').focus();
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






            // $(document).on('blur', 'input[name$="[qty]"]', function() {
            //     let row = $(this).closest('tr');
            //     let qty = parseFloat($(this).val()) || 0;
            //     let stok = parseFloat(row.find('input[name$="[stok]"]').val()) || 0;

            //     if (qty > stok) {
            //         const swalWithBootstrapButtons = Swal.mixin({
            //             customClass: {
            //                 confirmButton: 'btn btn-success',
            //                 cancelButton: 'btn btn-danger me-2'
            //             },
            //             buttonsStyling: false,
            //         });

            //         swalWithBootstrapButtons.fire({
            //             title: 'Insufficient Stock!',
            //             text: 'Quantity exceeds available stock!',
            //             icon: 'error',
            //             timer: 2000,
            //             timerProgressBar: true,
            //             willClose: () => {
            //                 // Optional: Add any additional actions you want to perform after the alert closes
            //             }
            //         });

            //         $(this).val(''); // Clear the quantity field
            //     }
            // });






            $(document).on('keydown', '.qty', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); // Prevent form submission on Enter key
                    add_row();
                    update_totals();
                }
            });



            $(document).on('input', '.rak_relax', function(e) {
                update_totals();
            });

            $(document).on('input', '.original_no', function(e) {
                update_totals();
            });


            $(document).on('input', '.roll, .qty', function() {
                update_totals();
            });

            function update_totals() {
                let totalRolls = 0;
                let totalQty = 0;

                let countFilledRows = 0; // Initialize counter for rows with filled original_no

                $('#details-containerx tr').each(function() {
                    let originalNoValue = $(this).find('input[name$="[original_no]"]').val().trim();
                    let qtyValue = parseFloat($(this).find('input[name$="[qty]"]').val());

                    if (originalNoValue) {
                        countFilledRows++; // Increment count if original_no is filled
                    }

                    if (!isNaN(qtyValue)) {
                        totalQty += qtyValue;
                    }
                });

                $('#total-rolls').text(countFilledRows);
                $('#total-qty').text(totalQty.toFixed(2));
            }


        });



        function isDuplicate(originalNo) {
            let isDuplicate = false;
            $('#details-containerx tr').each(function() {
                let existingNo = $(this).find('.original_no').val().trim();
                if (originalNo === existingNo && originalNo !== '') {
                    isDuplicate = true;
                    return false; // Exit loop early
                }
            });
            return isDuplicate;
        }
    </script>
    {{-- @endsection --}}

</body>

</html>

<script src="{{ asset('backend/assets/vendors/feather-icons/feather.min.js') }}"></script>
