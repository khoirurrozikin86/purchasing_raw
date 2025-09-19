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
                                                id="btn-create-unit"><i class="feather-16" data-feather="file-plus"></i>
                                                &nbsp;Add Data</a>
                                            {{-- <a href="{{ route('add.unit') }}" class="btn btn-primary mx-1"><i class="feather-16" data-feather="file-plus"></i> &nbsp;Add unit</a> --}}
                                        </ol>
                                    </nav>
                                </div>

                                <div class="col">
                                    <h6 class="card-title text-center">unit All</h6>
                                </div>
                                <div class="col">
                                    <h6 class="card-title text-center"></h6>
                                </div>
                            </div>

                        </div>


                        <div class="table-responsive">

                            <table id="unitTable" class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Code</th>
                                        <th>Name</th>
                                        {{-- <th>QR</th> --}}
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>

                </div>
                <div class="modal-body">

                    <form id="unitForm" name="unitForm">

                        <div class="alert alert-danger print-error-msg" style="display:none">

                            <ul></ul>

                        </div>

                        <input type="hidden" name="unit_id" id="unit_id">
                        <div class="mb-3">
                            <label for="unit_code" class="form-label">Unit Code:</label>
                            <input type="text" class="form-control" id="unit_code" name="unit_code" autofocus>

                        </div>
                        <div class="mb-3">
                            <label for="unit_name" class="form-label">Unit Name:</label>
                            <input type="text" class="form-control" id="unit_name" name="unit_name">
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    <button type="submit" class="btn btn-primary" id="saveBtn" value="create">SIMPAN</button>
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




            var table = $('#unitTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('get.unit') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'

                    },
                    {
                        data: 'unit_code',
                        name: 'unit_code'
                    },
                    {
                        data: 'unit_name',
                        name: 'unit_name'
                    },
                    // {
                    //     data: 'qr_code',
                    //     name: 'qr_code'
                    // },

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

            $('#btn-create-unit').click(function() {

                $('#saveBtn').html("save");
                $(this).find('form').trigger('reset');
                $('#unitForm').find(".print-error-msg").find("ul").find("li").remove();
                $('#unitForm').find(".print-error-msg").css('display', 'none');

                $('#saveBtn').val("create-unit");
                $('#unitForm').trigger("reset");
                $('#exampleModalLabel').html("Create New unit");
                $('#unit_id').val('');
                $('#modal-create').modal('show');
                $('#unit_code').attr("readonly", false)
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

                    data: $('#unitForm').serialize(),

                    url: "{{ route('store.unit') }}",

                    type: "POST",

                    dataType: 'json',

                    success: function(data) {

                        $('#unitForm').trigger("reset");
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

                        $('#unitForm').find(".print-error-msg").find("ul").html('');
                        $('#unitForm').find(".print-error-msg").css('display', 'block');
                        $.each(data.responseJSON.errors, function(key, value) {
                            $('#unitForm').find(".print-error-msg").find("ul").append(
                                '<li>' + value + '</li>');
                        });
                        $('#saveBtn').html('SIMPAN');
                    }

                    // error: function(data) {
                    //     console.log('Error:', data);
                    //     $('#saveBtn').html('Save Changes');
                    // }

                });

            });

            /*------------------------------------------

            --------------------------------------------

            Click to Edit Button

            --------------------------------------------

            --------------------------------------------*/


            $('body').on('click', '.editunit', function() {

                var unit_id = $(this).data('id');
                console.log(unit_id);


                $.get("/edit/unit/" + unit_id, function(
                    data) {
                    $('#exampleModalLabel').html("Edit unit");
                    $('#saveBtn').html("edit");
                    $('#modal-create').modal('show');
                    $('#unit_id').val(data.id);
                    $('#unit_code').val(data.unit_code);
                    $('#unit_name').val(data.unit_name);

                    $('#unit_code').attr("readonly", true)

                    $('#unitForm').find(".print-error-msg").find("ul").find("li").remove();
                    $('#unitForm').find(".print-error-msg").css('display', 'none');

                })

            });

            /*------------------------------------------

            --------------------------------------------

            Delete Product Code

            --------------------------------------------

            --------------------------------------------*/


            $('body').on('click', '.deleteunit', function() {



                var unit_id = $(this).data("id");

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
                    if (result.value) {

                        $.ajax({
                            type: "GET",
                            url: "/delete/unit/" + unit_id,
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
                        // Read more about handling dismissals
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
