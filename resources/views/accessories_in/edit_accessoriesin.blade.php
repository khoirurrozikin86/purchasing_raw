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
                                <form action="{{ route('update.materialin', $materialIN->id) }}" method="POST">
                                    @csrf
                                    <!-- Material IN Fields -->
                                    <div class="text-center">
                                        <h3>EDIT MATERIAL IN</h3>
                                    </div>
                                    <hr>

                                    @if ($errors->any())
                                        <div class="alert alert-danger" role="alert">
                                            @foreach ($errors->all() as $error)
                                                <p>{{ $error }}</p>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="row">

                                        <div class="col-md-4">

                                            <div class="form-group row">
                                                <label for="material_in_no" class="col-sm-3 col-form-label">MTR IN
                                                    No</label>
                                                <div class="col-sm-9">

                                                    <p>{{ $materialIN->material_in_no }}</p>

                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="supplier_id"
                                                    class="col-sm-3 col-form-label">Supplier</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input type="hidden"
                                                            class="form-control form-control-sm supplier_id"
                                                            id="supplier_id" name="supplier_id"
                                                            value="{{ $materialIN->supplier_id }}">
                                                        <input type="text"
                                                            class="form-control form-control-sm supplier_name"
                                                            id="supplier_name" name="supplier_name"
                                                            value="{{ $materialIN->supplier->supplier_name }}"
                                                            readonly>
                                                        {{-- <div class="input-group-append">
                                                        <button class="btn btn-secondary btn-sm supplier_search"
                                                            id="supplier_search" type="button">
                                                            <i class="feather-10" data-feather="search"></i>
                                                        </button>
                                                    </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- NO SJ Field -->
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label for="no_sj" class="col-sm-3 col-form-label">NO SJ</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="no_sj" name="no_sj" value="{{ $materialIN->no_sj }}">
                                                </div>
                                            </div>

                                            <!-- Receiver Field -->
                                            <div class="form-group row">
                                                <label for="recived_by" class="col-sm-3 col-form-label">Receiver</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="recived_by" name="recived_by"
                                                        value="{{ $materialIN->received_by }}">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Location and Courier Fields -->
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label for="location" class="col-sm-3 col-form-label">Location</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="location" name="location"
                                                        value="{{ $materialIN->location }}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="courier" class="col-sm-3 col-form-label">Courier</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="courier" name="courier"
                                                        value="{{ $materialIN->courier }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                    <!-- Material IN Details Fields -->
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
                                                            <th>QTY</th>
                                                            <th>BASIC WIDTH</th>
                                                            <th>BASIC GRM</th>
                                                            <th>MO</th>
                                                            <th>ACT WEIGHT</th>
                                                            <th>RAK</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="details-containerx">
                                                        @foreach ($materialIN->details as $index => $detail)
                                                            <tr>
                                                                <td><input type="text"
                                                                        name="details[{{ $index }}][original_no]"
                                                                        class="form-control original_no"
                                                                        value="{{ $detail->original_no }}"
                                                                        placeholder="Original No" required></td>
                                                                <td><input type="text"
                                                                        name="details[{{ $index }}][receive_date]"
                                                                        class="form-control"
                                                                        value="{{ $detail->receive_date }}">
                                                                </td>
                                                                <td><input type="text"
                                                                        name="details[{{ $index }}][supplier_name]"
                                                                        class="form-control"
                                                                        value="{{ $detail->supplier_name }}"
                                                                        placeholder="Supplier Name"></td>
                                                                <td><input type="text"
                                                                        name="details[{{ $index }}][item_code]"
                                                                        class="form-control"
                                                                        value="{{ $detail->item_code }}"
                                                                        placeholder="Item Code" required></td>
                                                                <td><input type="text"
                                                                        name="details[{{ $index }}][po]"
                                                                        class="form-control"
                                                                        value="{{ $detail->po }}" placeholder="PO">
                                                                </td>
                                                                <td><input type="text"
                                                                        name="details[{{ $index }}][color_code]"
                                                                        class="form-control"
                                                                        value="{{ $detail->color_code }}"
                                                                        placeholder="Color Code"></td>
                                                                <td><input type="text"
                                                                        name="details[{{ $index }}][color_name]"
                                                                        class="form-control"
                                                                        value="{{ $detail->color_name }}"
                                                                        placeholder="Color Name"></td>
                                                                <td><input type="text"
                                                                        name="details[{{ $index }}][batch]"
                                                                        class="form-control"
                                                                        value="{{ $detail->batch }}"
                                                                        placeholder="Batch"></td>
                                                                <td><input type="text"
                                                                        name="details[{{ $index }}][roll]"
                                                                        class="form-control roll"
                                                                        value="{{ $detail->roll }}"
                                                                        placeholder="Roll">
                                                                </td>
                                                                <td><input type="text"
                                                                        name="details[{{ $index }}][gross_weight]"
                                                                        class="form-control"
                                                                        value="{{ $detail->gross_weight }}"
                                                                        placeholder="Gross Weight"></td>
                                                                <td><input type="text"
                                                                        name="details[{{ $index }}][net_weight]"
                                                                        class="form-control"
                                                                        value="{{ $detail->net_weight }}"
                                                                        placeholder="Net Weight"></td>
                                                                <td><input type="text"
                                                                        name="details[{{ $index }}][qty]"
                                                                        class="form-control qty"
                                                                        value="{{ $detail->qty }}"
                                                                        placeholder="Qty">
                                                                </td>
                                                                <td><input type="text"
                                                                        name="details[{{ $index }}][basic_width]"
                                                                        class="form-control"
                                                                        value="{{ $detail->basic_width }}"
                                                                        placeholder="Basic Width"></td>
                                                                <td><input type="text"
                                                                        name="details[{{ $index }}][basic_grm]"
                                                                        class="form-control"
                                                                        value="{{ $detail->basic_grm }}"
                                                                        placeholder="Basic Grm"></td>
                                                                <td><input type="text"
                                                                        name="details[{{ $index }}][mo]"
                                                                        class="form-control"
                                                                        value="{{ $detail->mo }}" placeholder="MO">
                                                                </td>
                                                                <td><input type="text"
                                                                        name="details[{{ $index }}][actual_weight]"
                                                                        class="form-control mo"
                                                                        value="{{ $detail->actual_weight }}"
                                                                        placeholder="MO"></td>
                                                                <td><input type="text"
                                                                        name="details[{{ $index }}][rak]"
                                                                        class="form-control"
                                                                        value="{{ $detail->rak }}" placeholder="MO">
                                                                </td>
                                                                <td><button type="button"
                                                                        class="btn btn-danger btn-sm remove-detail">Remove</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <h5>Total Rolls: <span id="total-rolls">0</span></h5>
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                    <a href="{{ route('all.materialin') }}"
                                                        class="btn btn-danger">Back</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {


            function updateTotalRolls() {
                let countFilledRows = 0;

                $('#details-containerx tr').each(function() {
                    let rollValue = $(this).find('input[name$="[roll]"]').val().trim();
                    if (rollValue !== '') {
                        countFilledRows++;
                    }
                });

                $('#total-rolls').text(countFilledRows);
            }

            $('#details-table').on('input', '.roll', function() {
                updateTotalRolls();
            });

            $('#add-detail').click(function() {
                let index = $('#details-containerx tr').length;
                let newRow = `
                    <tr>
                        <td><input type="text" name="details[${index}][original_no]" class="form-control original_no" placeholder="Original No" required></td>
                        <td><input type="text" name="details[${index}][receive_date]" class="form-control"></td>
                        <td><input type="text" name="details[${index}][supplier_name]" class="form-control" placeholder="Supplier Name"></td>
                        <td><input type="text" name="details[${index}][item_code]" class="form-control" placeholder="Item Code" required></td>
                        <td><input type="text" name="details[${index}][po]" class="form-control" placeholder="PO"></td>
                        <td><input type="text" name="details[${index}][color_code]" class="form-control" placeholder="Color Code"></td>
                        <td><input type="text" name="details[${index}][color_name]" class="form-control" placeholder="Color Name"></td>
                        <td><input type="text" name="details[${index}][batch]" class="form-control" placeholder="Batch"></td>
                        <td><input type="text" name="details[${index}][roll]" class="form-control roll" placeholder="Roll"></td>
                        <td><input type="text" name="details[${index}][gross_weight]" class="form-control" placeholder="Gross Weight"></td>
                        <td><input type="text" name="details[${index}][net_weight]" class="form-control" placeholder="Net Weight"></td>
                        <td><input type="text" name="details[${index}][qty]" class="form-control qty" placeholder="Qty"></td>
                        <td><input type="text" name="details[${index}][basic_width]" class="form-control" placeholder="Basic Width"></td>
                        <td><input type="text" name="details[${index}][basic_grm]" class="form-control" placeholder="Basic Grm"></td>
                        <td><input type="text" name="details[${index}][mo]" class="form-control mo" placeholder="MO"></td>
                        <td><input type="text" name="details[${index}][actual_weight]" class="form-control actual_weight" placeholder="ACTUAL WEIGHT"></td>
                        <td><input type="text" name="details[${index}][rak]" class="form-control" placeholder="RAK"></td>
                        <td><button type="button" class="btn btn-danger btn-sm remove-detail">Remove</button></td>
                    </tr>
                `;
                $('#details-containerx').append(newRow);
                updateTotalRolls();
            });

            $('#details-table').on('click', '.remove-detail', function() {
                $(this).closest('tr').remove();
                updateTotalRolls();
            });

            // Initialize total rolls
            updateTotalRolls();




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

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger me-2'
                    },
                    buttonsStyling: false,
                })



                if (event.keyCode === 13) { // 13 adalah kode untuk tombol Enter
                    event.preventDefault(); // Mencegah aksi default tombol Enter

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
                            $(this).val(''); // Kosongkan field input
                        } else {
                            $.ajax({
                                url: '/get/qr_codein/' + originalNo,
                                type: 'GET',
                                success: function(response) {
                                    row.find('input[name$="[receive_date]"]').val(response
                                        .received_date || '');
                                    row.find('input[name$="[supplier_name]"]').val(response
                                        .supplier_name || '');
                                    row.find('input[name$="[item_code]"]').val(response
                                        .item_code || '');
                                    row.find('input[name$="[po]"]').val(response.po || '');
                                    row.find('input[name$="[color_code]"]').val(response
                                        .color_code || '');
                                    row.find('input[name$="[color_name]"]').val(response
                                        .color_name || '');
                                    row.find('input[name$="[batch]"]').val(response.batch ||
                                        '');
                                    row.find('input[name$="[roll]"]').val(response.roll || '');
                                    row.find('input[name$="[gross_weight]"]').val(response
                                        .gross_weight || '');
                                    row.find('input[name$="[net_weight]"]').val(response
                                        .net_weight || '');
                                    row.find('input[name$="[qty]"]').val(response.qty || '');
                                    row.find('input[name$="[basic_width]"]').val(response
                                        .basic_width || '');
                                    row.find('input[name$="[basic_grm]"]').val(response
                                        .basic_grm || '');
                                    row.find('input[name$="[mo]"]').val(response.mo || '');

                                    row.find('input[name$="[actual_weight]"]').focus();
                                    updateTotalRolls();
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
        });
    </script>
    {{-- @endsection

 --}}

</body>

</html>

<script src="{{ asset('backend/assets/vendors/feather-icons/feather.min.js') }}"></script>
