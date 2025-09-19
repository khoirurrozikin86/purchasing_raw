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
                                                id="btn-create-size"><i class="feather-16" data-feather="file-plus"></i>
                                                &nbsp;Add Data</a>
                                            {{-- <a href="{{ route('add.size') }}" class="btn btn-primary mx-1"><i class="feather-16" data-feather="file-plus"></i> &nbsp;Add size</a> --}}
                                        </ol>
                                    </nav>
                                </div>

                                <div class="col">
                                    <h6 class="card-title text-center">Size All</h6>
                                </div>
                                <div class="col">
                                    <h6 class="card-title text-center"></h6>
                                </div>
                            </div>

                        </div>


                        <div class="table-responsive">

                            <table id="sizeTable" class="table table-sm">
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

                    <form id="sizeForm" name="sizeForm">

                        <div class="alert alert-danger print-error-msg" style="display:none">

                            <ul></ul>

                        </div>

                        <input type="hidden" name="size_id" id="size_id">
                        <div class="mb-3">
                            <label for="size_code" class="form-label">Size Code:</label>
                            <input type="text" class="form-control" id="size_code" name="size_code" autofocus>

                        </div>
                        <div class="mb-3">
                            <label for="size_name" class="form-label">Size Name:</label>
                            <input type="text" class="form-control" id="size_name" name="size_name">
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




            var table = $('#sizeTable').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: "{{ route('get.size') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'

                    },
                    {
                        data: 'size_code',
                        name: 'size_code'
                    },
                    {
                        data: 'size_name',
                        name: 'size_name'
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

            $('#btn-create-size').click(function() {

                $('#saveBtn').html("save");
                $(this).find('form').trigger('reset');
                $('#sizeForm').find(".print-error-msg").find("ul").find("li").remove();
                $('#sizeForm').find(".print-error-msg").css('display', 'none');

                $('#saveBtn').val("create-size");
                $('#sizeForm').trigger("reset");
                $('#exampleModalLabel').html("Create New size");
                $('#size_id').val('');
                $('#modal-create').modal('show');
                $('#size_code').attr("readonly", false)
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

                    data: $('#sizeForm').serialize(),

                    url: "{{ route('store.size') }}",

                    type: "POST",

                    dataType: 'json',

                    success: function(data) {

                        $('#sizeForm').trigger("reset");
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

                        $('#sizeForm').find(".print-error-msg").find("ul").html('');
                        $('#sizeForm').find(".print-error-msg").css('display', 'block');
                        $.each(data.responseJSON.errors, function(key, value) {
                            $('#sizeForm').find(".print-error-msg").find("ul").append(
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


            $('body').on('click', '.editsize', function() {

                var size_id = $(this).data('id');
                console.log(size_id);


                $.get("/edit/size/" + size_id, function(
                    data) {
                    $('#exampleModalLabel').html("Edit size");
                    $('#saveBtn').html("edit");
                    $('#modal-create').modal('show');
                    $('#size_id').val(data.id);
                    $('#size_code').val(data.size_code);
                    $('#size_name').val(data.size_name);

                    $('#size_code').attr("readonly", true)

                    $('#sizeForm').find(".print-error-msg").find("ul").find("li").remove();
                    $('#sizeForm').find(".print-error-msg").css('display', 'none');

                })

            });

            /*------------------------------------------

            --------------------------------------------

            Delete Product Code

            --------------------------------------------

            --------------------------------------------*/


            $('body').on('click', '.deletesize', function() {



                var size_id = $(this).data("id");

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
                            url: "/delete/size/" + size_id,
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
