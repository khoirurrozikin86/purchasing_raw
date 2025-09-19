@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content mt-5">

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div>
                            <div class="row">
                                <div class="col">
                                    <nav class="page-breadcrumb">
                                        <ol class="breadcrumb">
                                            <a href="javascript:void(0)" class="btn btn-sm btn-primary mx-1"
                                                id="btn-create-supplier"><i class="feather-16" data-feather="file-plus"></i>
                                                &nbsp;Add Data</a>
                                        </ol>
                                    </nav>
                                </div>

                                <div class="col">
                                    <h6 class="card-title text-center">Supplier All</h6>

                                </div>
                                <div class="col">
                                    <h6 class="card-title text-center"></h6>
                                </div>
                            </div>

                        </div>

                        <div class="table-responsive">

                            <table id="supplierTable" class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>NPWP</th>
                                        <th>FAX</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>Nation</th>
                                        <th>Person</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Remark</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <br />
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>

                </div>
                <div class="modal-body">

                    <form id="supplierForm" name="supplierForm">

                        <div class="alert alert-danger print-error-msg" style="display:none">

                            <ul></ul>

                        </div>

                        <div class="row">

                            <div class="col">

                                <input type="hidden" name="supplier_id" id="supplier_id">
                                <div class="mb-3">
                                    <label for="supplier_code" class="form-label">Supplier Code:</label>
                                    <input type="text" class="form-control supplier_code" id="supplier_code"
                                        name="supplier_code" autofocus>

                                </div>
                                <div class="mb-3">
                                    <label for="supplier_name" class="form-label">Name:</label>
                                    <input type="text" class="form-control" id="supplier_name" name="supplier_name">
                                </div>
                                <div class="mb-3">
                                    <label for="supplier_npwp" class="form-label">NPWP:</label>
                                    <input type="text" class="form-control" id="supplier_npwp" name="supplier_npwp">
                                </div>
                                <div class="mb-3">
                                    <label for="supplier_fax" class="form-label">FAX:</label>
                                    <input type="text" class="form-control" id="supplier_fax" name="supplier_fax">
                                </div>
                                <div class="mb-3">
                                    <label for="supplier_address" class="form-label">Address:</label>
                                    <input type="text" class="form-control" id="supplier_address"
                                        name="supplier_address">
                                </div>
                                <div class="mb-3">
                                    <label for="supplier_city" class="form-label">City:</label>
                                    <input type="text" class="form-control" id="supplier_city" name="supplier_city">
                                </div>
                            </div>

                            <div class="col">

                                <div class="mb-3">
                                    <label for="supplier_nation" class="form-label">National:</label>
                                    <input type="text" class="form-control" id="supplier_nation" name="supplier_nation">
                                </div>
                                <div class="mb-3">
                                    <label for="supplier_person" class="form-label">Person:</label>
                                    <input type="text" class="form-control" id="supplier_person"
                                        name="supplier_person">
                                </div>
                                <div class="mb-3">
                                    <label for="supplier_phone" class="form-label">Phone:</label>
                                    <input type="text" class="form-control" id="supplier_phone"
                                        name="supplier_phone">
                                </div>
                                <div class="mb-3">
                                    <label for="supplier_email" class="form-label">Email:</label>
                                    <input type="email" class="form-control" id="supplier_email"
                                        name="supplier_email">
                                </div>
                                <div class="mb-3">
                                    <label for="remark" class="form-label">Remark:</label>
                                    <select class="js-example-basic-single form-select" id="remark" name="remark">
                                        <option value="Local">Local</option>
                                        <option value="Import">Import</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });

            $('#modal-create').on('shown.bs.modal', function() {
                $(this).find('[autofocus]').focus();
            });




            var table = $('#supplierTable').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: "{{ route('get.supplier') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'

                    },

                    {
                        data: 'supplier_code',
                        name: 'supplier_code'
                    },
                    {
                        title: "supplier_name",
                        data: "supplier_name",
                        render: function(data, type, row) {
                            // Batasi item_name menjadi maksimal 25 karakter
                            if (type === 'display' && data.length > 30) {
                                return data.substring(0, 30) + '...';
                            } else {
                                return data;
                            }
                        }
                    },
                    {
                        data: 'supplier_npwp',
                        name: 'supplier_npwp'
                    },
                    {
                        data: 'supplier_fax',
                        name: 'supplier_fax'
                    },
                    {
                        title: "supplier_address",
                        data: "supplier_address",
                        render: function(data, type, row) {
                            // Batasi item_name menjadi maksimal 25 karakter
                            if (type === 'display' && data.length > 30) {
                                return data.substring(0, 30) + '...';
                            } else {
                                return data;
                            }
                        }
                    },
                    {
                        data: 'supplier_city',
                        name: 'supplier_city'
                    },
                    {
                        data: 'supplier_nation',
                        name: 'supplier_nation'
                    },
                    {
                        data: 'supplier_person',
                        name: 'supplier_person'
                    },
                    {
                        data: 'supplier_phone',
                        name: 'supplier_phone'
                    },
                    {
                        data: 'supplier_email',
                        name: 'supplier_email'
                    },
                    {
                        data: 'remark',
                        name: 'remark'
                    },


                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });




            /*------------------------------------------

            --------------------------------------------

            Click to Button

            --------------------------------------------

            --------------------------------------------*/

            $('#btn-create-supplier').click(function() {

                $(this).find('form').trigger('reset');
                $('#supplierForm').find(".print-error-msg").find("ul").find("li").remove();
                $('#supplierForm').find(".print-error-msg").css('display', 'none');

                $('#saveBtn').val("create-supplier");
                $('#supplierForm').trigger("reset");
                $('#supplier_id').val('');
                $('#exampleModalLabel').html("Create New supplier");
                $('#modal-create').modal('show');
                $('#supplier_code').attr("readonly", false);
                $(this).find('[autofocus]').focus();


            });


            /*------------------------------------------

            --------------------------------------------

            Create Product Code

            --------------------------------------------

            --------------------------------------------*/

            $('#saveBtn').click(function(e) {

                e.preventDefault();

                $(this).html('Sending..');



                $.ajax({

                    data: $('#supplierForm').serialize(),

                    url: "{{ route('store.supplier') }}",

                    type: "POST",

                    dataType: 'json',

                    success: function(data) {

                        $('#supplierForm').trigger("reset");
                        $('#modal-create').modal('hide');
                        table.ajax.reload(null, false);
                        $('#saveBtn').html('SIMPAN');

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });

                        Toast.fire({
                            icon: 'success',
                            title: data.message
                        })
                    },

                    error: function(data) {

                        $('#supplierForm').find(".print-error-msg").find("ul").html('');
                        $('#supplierForm').find(".print-error-msg").css('display', 'block');
                        $.each(data.responseJSON.errors, function(key, value) {
                            $('#supplierForm').find(".print-error-msg").find("ul")
                                .append(
                                    '<li>' + value + '</li>');
                        });
                        $('#saveBtn').html('SIMPAN');
                    }



                });

            });

            /*------------------------------------------

            --------------------------------------------

            Click to Edit Button

            --------------------------------------------

            --------------------------------------------*/


            $('body').on('click', '.editsupplier', function() {

                var supplier_id = $(this).data('id');

                $.get("/edit/supplier/" + supplier_id, function(
                    data) {
                    $('#exampleModalLabel').html("Edit supplier");
                    $('#saveBtn').html("edit");
                    $('#modal-create').modal('show');
                    $('#supplier_id').val(data.id);
                    $('#supplier_code').val(data.supplier_code);
                    $('#supplier_name').val(data.supplier_name);
                    $('#supplier_npwp').val(data.supplier_npwp);
                    $('#supplier_npwp').val(data.supplier_fax);
                    $('#supplier_address').val(data.supplier_address);
                    $('#supplier_city').val(data.supplier_city);
                    $('#supplier_nation').val(data.supplier_nation);
                    $('#supplier_person').val(data.supplier_person);
                    $('#supplier_phone').val(data.supplier_phone);
                    $('#supplier_email').val(data.supplier_email);

                    $('#supplier_code').attr("readonly", true);

                })

            });


            /*------------------------------------------

            --------------------------------------------

            Delete Product Code

            --------------------------------------------

            --------------------------------------------*/


            $('body').on('click', '.deletesupplier', function() {

                var supplier_id = $(this).data("id");

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger me-2'
                    },
                    buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "GET",
                            url: "/delete/supplier/" + supplier_id,
                            success: function(data) {
                                table.ajax.reload(null, false);


                                swalWithBootstrapButtons.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success',
                                )
                            },
                            error: function(data) {
                                console.log('Error:', data);
                                swalWithBootstrapButtons.fire(
                                    'Cancelled',
                                    `'There is relation data'.${data.responseJSON.message}`,
                                    'error'
                                )
                            }
                        });


                    } else if (
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            'Your file is safe :)',
                            'error'
                        )
                    }
                })

            });




        });
    </script>
@endsection
