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

                                <form action="{{ route('store.relaxin') }}" method="POST">
                                    @csrf
                                    <!-- Purchase Request Fields -->

                                    <div class="text-center">
                                        <h4>ADD RELAX IN</h4>
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
                                                <label for="material_out_id" class="col-sm-3 col-form-label">Material
                                                    Out</label>
                                                <div class="col-sm-9">

                                                    <div class="input-group">
                                                        <input type="hidden"
                                                            class="form-control form-control-sm form-control material_out_id"
                                                            id="material_out_id" name="material_out_id">
                                                        <input type="text"
                                                            class="form-control form-control-sm form-control material_out_no"
                                                            id="material_out_no" name="material_out_no">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-secondary btn-sm material_out_search"
                                                                id="material_out_search" type="button">
                                                                <i class="feather-10" data-feather="search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="col-md-4">

                                            <div class="form-group row">
                                                <label for="person" class="col-sm-3 col-form-label">PIC</label>
                                                <div class="col-sm-9">
                                                    <input type="text"
                                                        class="form-control form-control-sm form-control"
                                                        style="width: 100%;" id="person" name="person">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label for="remark" class="col-sm-3 col-form-label">Remark</label>
                                                <div class="col-sm-9">
                                                    <input type="text"
                                                        class="form-control form-control-sm form-control"
                                                        style="width: 100%;" id="remark" name="remark">
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <hr>

                                    <!-- Purchase Request Details Fields -->

                                    <div class="row">

                                        <div class="">
                                            {{-- <button type="button" class="btn btn-secondary btn-sm mb-2"
                                                id="add-detail">Add
                                                Detail</button> --}}

                                            <h6>RELAX IN Items</h6>

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

                                                            <th>Style</th>
                                                            <th>MO#</th>
                                                            <th>Fabric Pcs</th>
                                                            <th>Inspec Machine No</th>
                                                            <th>ACT WIDTH Front</th>
                                                            <th>ACT WIDTH Center</th>
                                                            <th>ACT WIDTH Back</th>
                                                            <th>Panjang Actual</th>
                                                            <th>Hasil Fabric Ins</th>
                                                            <th>Kotor</th>
                                                            <th>Crease Mark</th>
                                                            <th>Knot</th>
                                                            <th>Hole</th>
                                                            <th>Missing Yarn</th>
                                                            <th>Foreign Yarn</th>
                                                            <th>Benang Tebal</th>
                                                            <th>Kontaminasi</th>
                                                            <th>Shinning Others</th>
                                                            <th>Maxim OK Point</th>
                                                            <th>Pass or NG</th>
                                                            <th>Relaxing Rack No</th>
                                                            <th>B-Roll Rack No</th>
                                                            <th>Reason</th>
                                                            <th>Selisih</th>
                                                            <th>Sambungan di Meter</th>

                                                            <th>Action</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody id="details-containerx">
                                                        <tr>
                                                            <td><input type="text" name="details[0][original_no]"
                                                                    class="form-control original_no"
                                                                    placeholder="Original No" required></td>
                                                            <td><input type="text" name="details[0][receive_date]"
                                                                    class="form-control"></td>
                                                            <td><input type="text" name="details[0][supplier_name]"
                                                                    class="form-control" placeholder="Supplier Name">
                                                            </td>
                                                            <td><input type="text" name="details[0][item_code]"
                                                                    class="form-control" placeholder="Item Code"
                                                                    required></td>
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
                                                                    class="form-control roll" placeholder="Roll"></td>
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
                                                                    required></td>

                                                            <td><input type="text" name="details[0][style]"
                                                                    class="form-control style" placeholder="STYLE">
                                                            </td>
                                                            <td><input type="text" name="details[0][mo_number]"
                                                                    class="form-control mo_number" placeholder="MO#">
                                                            </td>
                                                            <td><input type="text" name="details[0][fabric_pcs]"
                                                                    class="form-control fabric_pcs"
                                                                    placeholder="Fabric Pcs"></td>
                                                            <td><input type="text"
                                                                    name="details[0][inspec_machine_no]"
                                                                    class="form-control inspec_machine_no"
                                                                    placeholder="Inspec Machine No"></td>
                                                            <td><input type="text" step="0.01"
                                                                    name="details[0][act_width_front]"
                                                                    class="form-control act_width_front"
                                                                    placeholder="ACT WIDTH Front"></td>
                                                            <td><input type="text" step="0.01"
                                                                    name="details[0][act_width_center]"
                                                                    class="form-control act_width_center"
                                                                    placeholder="ACT WIDTH Center"></td>
                                                            <td><input type="text" step="0.01"
                                                                    name="details[0][act_width_back]"
                                                                    class="form-control act_width_back"
                                                                    placeholder="ACT WIDTH Back"></td>
                                                            <td><input type="text" step="0.01"
                                                                    name="details[0][panjang_actual]"
                                                                    class="form-control panjang_actual"
                                                                    placeholder="Panjang Actual"></td>
                                                            <td><input type="text"
                                                                    name="details[0][hasil_fabric_ins]"
                                                                    class="form-control hasil_fabric_ins"
                                                                    placeholder="Hasil Fabric Ins"></td>
                                                            <td><input type="text" name="details[0][kotor]"
                                                                    class="form-control kotor"></td>
                                                            <td><input type="text" name="details[0][crease_mark]"
                                                                    class="form-control crease_mark"></td>
                                                            <td><input type="text" name="details[0][knot]"
                                                                    class="form-control knot"></td>
                                                            <td><input type="text" name="details[0][hole]"
                                                                    class="form-control hole"></td>
                                                            <td><input type="text" name="details[0][missing_yarn]"
                                                                    class="form-control missing_yarn"></td>
                                                            <td><input type="text" name="details[0][foreign_yarn]"
                                                                    class="form-control foreign_yarn"></td>
                                                            <td><input type="text" name="details[0][benang_tebal]"
                                                                    class="form-control benang_tebal"></td>
                                                            <td><input type="text" name="details[0][kontaminasi]"
                                                                    class="form-control kontaminasi"></td>
                                                            <td><input type="text"
                                                                    name="details[0][shinning_others]"
                                                                    class="form-control shinning_others"></td>
                                                            <td><input type="text"
                                                                    name="details[0][maxim_ok_point]"
                                                                    class="form-control maxim_ok_point"
                                                                    placeholder="Maxim OK Point"></td>
                                                            <td>
                                                                <select name="details[0][pass_ng]"
                                                                    class="form-control pass_ng">
                                                                    <option value="pass">Pass</option>
                                                                    <option value="ng">NG</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="text"
                                                                    name="details[0][relaxing_rack_no]"
                                                                    class="form-control relaxing_rack_no"
                                                                    placeholder="Relaxing Rack No"></td>
                                                            <td><input type="text"
                                                                    name="details[0][b_roll_rack_no]"
                                                                    class="form-control b_roll_rack_no"
                                                                    placeholder="B-Roll Rack No"></td>
                                                            <td><input type="text" name="details[0][reason]"
                                                                    class="form-control reason" placeholder="Reason">
                                                            </td>
                                                            <td><input type="text" name="details[0][selisih]"
                                                                    class="form-control selisih"
                                                                    placeholder="Selisih"></td>
                                                            <td><input type="text"
                                                                    name="details[0][sambungan_di_meter]"
                                                                    class="form-control sambungan_di_meter"
                                                                    placeholder="Sambungan di Meter"></td>
                                                            <td><button type="button"
                                                                    class="btn btn-danger btn-sm remove-detail">Remove</button>
                                                            </td>
                                                        </tr>

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
                                    <a href="{{ route('all.relaxin') }}" class="btn btn-danger mt-2">Back</a>
                                </form>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="materialOutModal" tabindex="-1" role="dialog"
        aria-labelledby="materialOutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="materialOutModalLabel">Select Material Out</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="materialOutTable" class="table table-bordered table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Material No</th>
                                <th>Created At</th>
                                <th>Allocation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated by DataTables -->
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


            $('#material_out_search').click(function() {
                $('#materialOutModal').modal('show');
            });



            // Initialize DataTable
            var table = $('#materialOutTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/get/materialout', // Replace with your API endpoint
                    type: 'GET'
                },
                columns: [{
                        data: 'material_out_no',
                        name: 'material_out_no'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'allocation',
                        name: 'allocation'
                    }
                ]
            });

            // Handle row click
            $('#materialOutTable tbody').on('click', 'tr', function() {
                var data = table.row(this).data();
                $('#material_out_id').val(data.id);
                $('#material_out_no').val(data.material_out_no);
                $('#materialOutModal').modal('hide');






                $.ajax({
                    url: '/get/materialoutid/' + data.id,
                    method: 'GET',
                    success: function(response) {


                        // if (!response.is_relax) {
                        //     alert('Allocation is not RELAX');
                        //     return; // Stop further processing if allocation is not RELAX
                        // }




                        if (response.material_out_detail) {
                            var details = response.material_out_detail.details;

                            // Clear the existing rows if needed
                            $('#details-table tbody').empty();

                            // Iterate over each detail and create new rows
                            details.forEach(function(detail, index) {
                                var newRow = `
                      <tr>
                            <td><input class="form-control form-control-sm original-no" name="details[${index}][original_no]" type="text" value="${detail.material_in_detail.original_no || ''}"></td>
                            <td><input class="form-control form-control-sm receive-date" name="details[${index}][receive_date]" type="text" value="${detail.material_in_detail.received_date || ''}"></td>
                            <td><input class="form-control form-control-sm supplier-name" name="details[${index}][supplier_name]" type="text" value="${detail.material_in_detail.supplier_name || ''}"></td>
                            <td><input class="form-control form-control-sm item-code" name="details[${index}][item_code]" type="text" value="${detail.item.item_code || ''}"></td>
                            <td><input class="form-control form-control-sm po" name="details[${index}][po]" type="text" value="${detail.material_in_detail.po || ''}"></td>
                            <td><input class="form-control form-control-sm color-code" name="details[${index}][color_code]" type="text" value="${detail.material_in_detail.color_code || ''}"></td>
                            <td><input class="form-control form-control-sm color-name" name="details[${index}][color_name]" type="text" value="${detail.material_in_detail.color_name || ''}"></td>
                            <td><input class="form-control form-control-sm batch" name="details[${index}][batch]" type="text" value="${detail.material_in_detail.batch || ''}"></td>
                            <td><input class="form-control form-control-sm roll" name="details[${index}][roll]" type="text" value="${detail.material_in_detail.roll || ''}"></td>
                            <td><input class="form-control form-control-sm gross-weight" name="details[${index}][gross_weight]" type="text" value="${detail.material_in_detail.gross_weight || ''}"></td>
                            <td><input class="form-control form-control-sm net-weight" name="details[${index}][net_weight]" type="text" value="${detail.material_in_detail.net_weight || ''}"></td>
                     
                            <td><input class="form-control form-control-sm basic-width" name="details[${index}][basic_width]" type="text" value="${detail.material_in_detail.basic_width || ''}"></td>
                            <td><input class="form-control form-control-sm basic-grm" name="details[${index}][basic_grm]" type="text" value="${detail.material_in_detail.basic_grm || ''}"></td>
                     
                         
                                   <td><input class="form-control form-control-sm qty" name="details[${index}][qty]" type="text" value="${detail.qty || ''}"></td>







                               <td><input type="text" name="details[${index}][style]" class="form-control style" placeholder="STYLE"></td>
                    <td><input type="text" name="details[${index}][mo_number]" class="form-control mo_number" placeholder="MO#"></td>
                    <td><input type="text" name="details[${index}][fabric_pcs]" class="form-control fabric_pcs" placeholder="Fabric Pcs"></td>
                    <td><input type="text" name="details[${index}][inspec_machine_no]" class="form-control inspec_machine_no" placeholder="Inspec Machine No"></td>
                    <td><input type="text" name="details[${index}][act_width_front]" class="form-control act_width_front" placeholder="ACT WIDTH Front"></td>
                    <td><input type="text" name="details[${index}][act_width_center]" class="form-control act_width_center" placeholder="ACT WIDTH Center"></td>
                    <td><input type="text" name="details[${index}][act_width_back]" class="form-control act_width_back" placeholder="ACT WIDTH Back"></td>
                    <td><input type="text" name="details[${index}][panjang_actual]" class="form-control panjang_actual" placeholder="Panjang Actual"></td>
                    <td><input type="text" name="details[${index}][hasil_fabric_ins]" class="form-control hasil_fabric_ins" placeholder="Hasil Fabric Ins"></td>
                    <td><input type="text" name="details[${index}][kotor]" class="form-control kotor"></td>
                    <td><input type="text" name="details[${index}][crease_mark]" class="form-control crease_mark"></td>
                    <td><input type="text" name="details[${index}][knot]" class="form-control knot"></td>
                    <td><input type="text" name="details[${index}][hole]" class="form-control hole"></td>
                    <td><input type="text" name="details[${index}][missing_yarn]" class="form-control missing_yarn"></td>
                    <td><input type="text" name="details[${index}][foreign_yarn]" class="form-control foreign_yarn"></td>
                    <td><input type="text" name="details[${index}][benang_tebal]" class="form-control benang_tebal"></td>
                    <td><input type="text" name="details[${index}][kontaminasi]" class="form-control kontaminasi"></td>
                    <td><input type="text" name="details[${index}][shinning_others]" class="form-control shinning_others"></td>
                    <td><input type="text" name="details[${index}][maxim_ok_point]" class="form-control maxim_ok_point" placeholder="Maxim OK Point"></td>
                    <td>
                        <select name="details[${index}][pass_ng]" class="form-control pass_ng">
                            <option value="pass">Pass</option>
                            <option value="ng">NG</option>
                        </select>
                    </td>
                    <td><input type="text" name="details[${index}][relaxing_rack_no]" class="form-control relaxing_rack_no" placeholder="Relaxing Rack No"></td>
                    <td><input type="text" name="details[${index}][b_roll_rack_no]" class="form-control b_roll_rack_no" placeholder="B-Roll Rack No"></td>
                    <td><input type="text" name="details[${index}][reason]" class="form-control reason" placeholder="Reason"></td>
                    <td><input type="text" step="0.01" name="details[${index}][selisih]" class="form-control selisih" placeholder="Selisih"></td>
                    <td><input type="text" step="0.01" name="details[${index}][sambungan_di_meter]" class="form-control sambungan_di_meter" placeholder="Sambungan di Meter"></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-detail">Remove</button></td>

                        </tr>
                    `;

                                // Append the new row to the table body
                                $('#details-table tbody').append(newRow);

                            });


                            // update_totals();
                        } else {
                            console.log('No material_out_detail data found.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX Error: ' + error);
                    }
                });



            });
        });


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
                    <td><input type="text" name="details[${rowIndex}][item_code]" class="form-control" placeholder="Item Code" required></td>
                    <td><input type="text" name="details[${rowIndex}][po]" class="form-control" placeholder="PO"></td>
                    <td><input type="text" name="details[${rowIndex}][color_code]" class="form-control" placeholder="Color Code"></td>
                    <td><input type="text" name="details[${rowIndex}][color_name]" class="form-control" placeholder="Color Name"></td>
                    <td><input type="text" name="details[${rowIndex}][batch]" class="form-control" placeholder="Batch"></td>
                    <td><input type="text" name="details[${rowIndex}][roll]" class="form-control roll" placeholder="Roll"></td>
                    <td><input type="text" name="details[${rowIndex}][gross_weight]" class="form-control" placeholder="Gross Weight"></td>
                    <td><input type="text" name="details[${rowIndex}][net_weight]" class="form-control" placeholder="Net Weight"></td>
                    <td><input type="text" name="details[${rowIndex}][basic_width]" class="form-control" placeholder="Basic Width"></td>
                    <td><input type="text" name="details[${rowIndex}][basic_grm]" class="form-control" placeholder="Basic Grm"></td>
             
                    <td><input type="text" name="details[${rowIndex}][qty]" class="form-control qty" placeholder="Qty" required></td>
                    <td><input type="text" name="details[${rowIndex}][style]" class="form-control style" placeholder="STYLE"></td>
                    <td><input type="text" name="details[${rowIndex}][mo_number]" class="form-control mo_number" placeholder="MO#"></td>
                    <td><input type="text" name="details[${rowIndex}][fabric_pcs]" class="form-control fabric_pcs" placeholder="Fabric Pcs"></td>
                    <td><input type="text" name="details[${rowIndex}][inspec_machine_no]" class="form-control inspec_machine_no" placeholder="Inspec Machine No"></td>
                    <td><input type="text" name="details[${rowIndex}][act_width_front]" class="form-control act_width_front" placeholder="ACT WIDTH Front"></td>
                    <td><input type="text" name="details[${rowIndex}][act_width_center]" class="form-control act_width_center" placeholder="ACT WIDTH Center"></td>
                    <td><input type="text" name="details[${rowIndex}][act_width_back]" class="form-control act_width_back" placeholder="ACT WIDTH Back"></td>
                    <td><input type="text" name="details[${rowIndex}][panjang_actual]" class="form-control panjang_actual" placeholder="Panjang Actual"></td>
                    <td><input type="text" name="details[${rowIndex}][hasil_fabric_ins]" class="form-control hasil_fabric_ins" placeholder="Hasil Fabric Ins"></td>
                    <td><input type="text" name="details[${rowIndex}][kotor]" class="form-control kotor"></td>
                    <td><input type="text" name="details[${rowIndex}][crease_mark]" class="form-control crease_mark"></td>
                    <td><input type="text" name="details[${rowIndex}][knot]" class="form-control knot"></td>
                    <td><input type="text" name="details[${rowIndex}][hole]" class="form-control hole"></td>
                    <td><input type="text" name="details[${rowIndex}][missing_yarn]" class="form-control missing_yarn"></td>
                    <td><input type="text" name="details[${rowIndex}][foreign_yarn]" class="form-control foreign_yarn"></td>
                    <td><input type="text" name="details[${rowIndex}][benang_tebal]" class="form-control benang_tebal"></td>
                    <td><input type="text" name="details[${rowIndex}][kontaminasi]" class="form-control kontaminasi"></td>
                    <td><input type="text" name="details[${rowIndex}][shinning_others]" class="form-control shinning_others"></td>
                    <td><input type="text" name="details[${rowIndex}][maxim_ok_point]" class="form-control maxim_ok_point" placeholder="Maxim OK Point"></td>
                    <td>
                        <select name="details[${rowIndex}][pass_ng]" class="form-control pass_ng">
                            <option value="pass">Pass</option>
                            <option value="ng">NG</option>
                        </select>
                    </td>
                    <td><input type="text" name="details[${rowIndex}][relaxing_rack_no]" class="form-control relaxing_rack_no" placeholder="Relaxing Rack No"></td>
                    <td><input type="text" name="details[${rowIndex}][b_roll_rack_no]" class="form-control b_roll_rack_no" placeholder="B-Roll Rack No"></td>
                    <td><input type="text" name="details[${rowIndex}][reason]" class="form-control reason" placeholder="Reason"></td>
                    <td><input type="text" step="0.01" name="details[${rowIndex}][selisih]" class="form-control selisih" placeholder="Selisih"></td>
                    <td><input type="text" step="0.01" name="details[${rowIndex}][sambungan_di_meter]" class="form-control sambungan_di_meter" placeholder="Sambungan di Meter"></td>
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






            // $(document).on('keydown', '.original_no', function(event) {
            //     if (event.keyCode === 13) { // 13 is the code for the Enter key
            //         event.preventDefault(); // Prevent the default Enter key action

            //         const swalWithBootstrapButtons = Swal.mixin({
            //             customClass: {
            //                 confirmButton: 'btn btn-success',
            //                 cancelButton: 'btn btn-danger me-2'
            //             },
            //             buttonsStyling: false,
            //         });

            //         let originalNo = $(this).val().trim();
            //         let row = $(this).closest('tr');

            //         if (originalNo) {
            //             if (checkDuplicate(originalNo, row)) {
            //                 swalWithBootstrapButtons.fire({
            //                     title: 'Duplicate!',
            //                     text: 'Duplicate Original No detected!',
            //                     icon: 'error',
            //                     timer: 2000,
            //                     timerProgressBar: true,
            //                     willClose: () => {
            //                         // Optional: Add any additional actions you want to perform after the alert closes
            //                     }
            //                 });
            //                 $(this).val(''); // Clear the input field
            //             } else {
            //                 $.ajax({
            //                     url: '/get/materialinoriginal/' + originalNo,
            //                     type: 'GET',
            //                     success: function(response) {
            //                         if (response.stock && response.stock.stok < 1) {
            //                             swalWithBootstrapButtons.fire({
            //                                 title: 'Out of Stock!',
            //                                 text: 'Stock is 0!',
            //                                 icon: 'error',
            //                                 timer: 2000,
            //                                 timerProgressBar: true,
            //                                 willClose: () => {
            //                                     // Optional: Add any additional actions you want to perform after the alert closes
            //                                 }

            //                             });

            //                             $(this).val('');


            //                             return;
            //                         }

            //                         if (response.material_in_detail) {

            //                             row.find('input[name$="[receive_date]"]').val(response
            //                                 .material_in_detail.receive_date || '');
            //                             row.find('input[name$="[supplier_name]"]').val(response
            //                                 .material_in_detail.supplier_name || '');
            //                             row.find('input[name$="[item_code]"]').val(response
            //                                 .material_in_detail.item_code || '');
            //                             row.find('input[name$="[po]"]').val(response
            //                                 .material_in_detail.po || '');
            //                             row.find('input[name$="[color_code]"]').val(response
            //                                 .material_in_detail.color_code || '');
            //                             row.find('input[name$="[color_name]"]').val(response
            //                                 .material_in_detail.color_name || '');
            //                             row.find('input[name$="[batch]"]').val(response
            //                                 .material_in_detail.batch || '');
            //                             row.find('input[name$="[roll]"]').val(response
            //                                 .material_in_detail.roll || '');
            //                             row.find('input[name$="[gross_weight]"]').val(response
            //                                 .material_in_detail.gross_weight || '');
            //                             row.find('input[name$="[net_weight]"]').val(response
            //                                 .material_in_detail.net_weight || '');
            //                             row.find('input[name$="[qty]"]').val(response
            //                                 .material_in_detail.qty || '');
            //                             row.find('input[name$="[basic_width]"]').val(response
            //                                 .material_in_detail.basic_width || '');
            //                             row.find('input[name$="[basic_grm]"]').val(response
            //                                 .material_in_detail.basic_grm || '');
            //                             // row.find('input[name$="[mo]"]').val(response
            //                             //     .material_in_detail.mo || '');
            //                             row.find('input[name$="[actual_weight]"]').val(response
            //                                 .material_in_detail.actual_weight || '');
            //                             row.find('input[name$="[rak]"]').val(response
            //                                 .material_in_detail.rak || '');
            //                         }

            //                         if (response.stock) {
            //                             row.find('input[name$="[stok]"]').val(response.stock
            //                                 .stok || '');



            //                             let qtyInput = row.find('input[name$="[qty]"]');
            //                             let qty = parseFloat(qtyInput.val()) || 0;

            //                             if (response.stock && qty > response.stock.stok) {
            //                                 swalWithBootstrapButtons.fire({
            //                                     title: 'Insufficient Stock!',
            //                                     text: 'Quantity exceeds available stock!',
            //                                     icon: 'error',
            //                                     timer: 2000,
            //                                     timerProgressBar: true,
            //                                     willClose: () => {
            //                                         // Optional: Add any additional actions you want to perform after the alert closes
            //                                     }
            //                                 });
            //                                 qtyInput.val(''); // Clear the quantity field
            //                                 return;
            //                             }




            //                         }

            //                         row.find('input[name$="[mo]"]').focus();

            //                         // add_row();
            //                     },
            //                     error: function() {
            //                         swalWithBootstrapButtons.fire({
            //                             title: 'Not Found!',
            //                             text: 'Data not found!',
            //                             icon: 'error',
            //                             timer: 2000,
            //                             timerProgressBar: true,
            //                             willClose: () => {
            //                                 // Optional: Add any additional actions you want to perform after the alert closes
            //                             }
            //                         });
            //                         row.find('input').val('');
            //                     }
            //                 });
            //             }
            //         }
            //     }
            // });



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






            $(document).on('keydown', '.rak_relax', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); // Prevent form submission on Enter key
                    add_row();
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
