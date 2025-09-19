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
                                                id="btn-create-color"><i class="feather-16" data-feather="file-plus"></i>
                                                &nbsp;Add Data</a>
                                            {{-- <a href="{{ route('add.color') }}" class="btn btn-primary mx-1"><i class="feather-16" data-feather="file-plus"></i> &nbsp;Add color</a> --}}
                                        </ol>
                                    </nav>
                                </div>

                                <div class="col">
                                    <h6 class="card-title text-center">color All</h6>
                                </div>
                                <div class="col">
                                    <h6 class="card-title text-center"></h6>
                                </div>
                            </div>

                        </div>


                        <div class="table-responsive">

                            <table id="colorTable" class="table table-sm">
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

                    <form id="colorForm" name="colorForm">

                        <div class="alert alert-danger print-error-msg" style="display:none">

                            <ul></ul>

                        </div>

                        <input type="hidden" name="color_id" id="color_id">
                        <div class="mb-3">
                            <label for="color_code" class="form-label">Color Code:</label>
                            <input type="text" class="form-control" id="color_code" name="color_code" autofocus>

                        </div>
                        <div class="mb-3">
                            <label for="color_name" class="form-label">Color Name:</label>
                            <input type="text" class="form-control" id="color_name" name="color_name">
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




            var table = $('#colorTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('get.color') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'

                    },
                    {
                        data: 'color_code',
                        name: 'color_code'
                    },
                    {
                        data: 'color_name',
                        name: 'color_name'
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

            $('#btn-create-color').click(function() {

                $('#saveBtn').html("save");
                $(this).find('form').trigger('reset');
                $('#colorForm').find(".print-error-msg").find("ul").find("li").remove();
                $('#colorForm').find(".print-error-msg").css('display', 'none');

                $('#saveBtn').val("create-color");
                $('#colorForm').trigger("reset");
                $('#exampleModalLabel').html("Create New Color");
                $('#color_id').val('');
                $('#modal-create').modal('show');
                $('#color_code').attr("readonly", false)
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

                    data: $('#colorForm').serialize(),

                    url: "{{ route('store.color') }}",

                    type: "POST",

                    dataType: 'json',

                    success: function(data) {

                        $('#colorForm').trigger("reset");
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

                        $('#colorForm').find(".print-error-msg").find("ul").html('');
                        $('#colorForm').find(".print-error-msg").css('display', 'block');
                        $.each(data.responseJSON.errors, function(key, value) {
                            $('#colorForm').find(".print-error-msg").find("ul").append(
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


            $('body').on('click', '.editColor', function() {

                var color_id = $(this).data('id');
                console.log(color_id);


                $.get("/edit/color/" + color_id, function(
                    data) {
                    $('#exampleModalLabel').html("Edit color");
                    $('#saveBtn').html("edit");
                    $('#modal-create').modal('show');
                    $('#color_id').val(data.id);
                    $('#color_code').val(data.color_code);
                    $('#color_name').val(data.color_name);

                    $('#color_code').attr("readonly", true)

                    $('#colorForm').find(".print-error-msg").find("ul").find("li").remove();
                    $('#colorForm').find(".print-error-msg").css('display', 'none');

                })

            });

            /*------------------------------------------

            --------------------------------------------

            Delete Product Code

            --------------------------------------------

            --------------------------------------------*/


            $('body').on('click', '.deleteColor', function() {



                var color_id = $(this).data("id");

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
                            url: "/delete/color/" + color_id,
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
