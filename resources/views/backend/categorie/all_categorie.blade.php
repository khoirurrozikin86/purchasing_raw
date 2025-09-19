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
                                    <h6 class="card-title text-center">Category All</h6>
                                </div>
                             
                            </div>

                        </div>
                        <div class="row">
                            <div class="col">
                                <nav class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <a href="javascript:void(0)" class="btn btn-sm btn-primary mx-1"
                                            id="btn-create-category"><i class="feather-16" data-feather="file-plus"></i>
                                            &nbsp;Add Data</a>
                                      
                                    </ol>
                                </nav>
                            </div>
                        </div>


                        <div class="table-responsive">

                            <table id="categoryTable" class="table table-sm">
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

                    <form id="categoryForm" name="categoryForm">

                        <div class="alert alert-danger print-error-msg" style="display:none">

                            <ul></ul>

                        </div>

                        <input type="hidden" name="category_id" id="category_id">
                        <div class="mb-3">
                            <label for="code" class="form-label">Code:</label>
                            <input type="text" class="form-control" id="code" name="code" autofocus>

                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="name" name="name">
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




            var table = $('#categoryTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('get.category') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'

                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'name',
                        name: 'name'
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

            $('#btn-create-category').click(function() {

                $('#saveBtn').html("save");
                $(this).find('form').trigger('reset');
                $('#categoryForm').find(".print-error-msg").find("ul").find("li").remove();
                $('#categoryForm').find(".print-error-msg").css('display', 'none');

                $('#saveBtn').val("create-category");
                $('#categoryForm').trigger("reset");
                $('#exampleModalLabel').html("Create New category");
                $('#category_id').val('');
                $('#modal-create').modal('show');
                $('#code').attr("readonly", false)
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

                    data: $('#categoryForm').serialize(),

                    url: "{{ route('store.category') }}",

                    type: "POST",

                    dataType: 'json',

                    success: function(data) {

                        $('#categoryForm').trigger("reset");
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

                        $('#categoryForm').find(".print-error-msg").find("ul").html('');
                        $('#categoryForm').find(".print-error-msg").css('display', 'block');
                        $.each(data.responseJSON.errors, function(key, value) {
                            $('#categoryForm').find(".print-error-msg").find("ul")
                                .append(
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


            $('body').on('click', '.editCategory', function() {

                var category_id = $(this).data('id');
                console.log(category_id);


                $.get("/edit/category/" + category_id, function(
                    data) {
                    $('#exampleModalLabel').html("Edit category");
                    $('#saveBtn').html("edit");
                    $('#modal-create').modal('show');
                    $('#category_id').val(data.id);
                    $('#code').val(data.code);
                    $('#name').val(data.name);

                    $('#code').attr("readonly", true)

                    $('#categoryForm').find(".print-error-msg").find("ul").find("li").remove();
                    $('#categoryForm').find(".print-error-msg").css('display', 'none');

                })

            });

            /*------------------------------------------

            --------------------------------------------

            Delete Product Code

            --------------------------------------------

            --------------------------------------------*/


            $('body').on('click', '.deleteCategory', function() {



                var category_id = $(this).data("id");

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
                            url: "/delete/category/" + category_id,
                            success: function(data) {
                                table.ajax.reload(null, false);

                                swalWithBootstrapButtons.fire({
                                    title: 'Deleted!',
                                    text: 'Your file has been deleted.',
                                    icon: 'success',
                                    timer: 2000,
                                    timerProgressBar: true,
                                    willClose: () => {
                                        // Optional: Add any additional actions you want to perform after the alert closes
                                    }
                                })
                            },
                            error: function(data) {
                                console.log('Error:', data);

                                // swalWithBootstrapButtons.fire(
                                //     'Cancelled',
                                //     `'There is relation data'.${data.responseJSON.message}`,
                                //     'error'
                                // )

                                swalWithBootstrapButtons.fire({
                                    title: 'Cancelled!',
                                    text: `'There is relation data'.${data.responseJSON.message}`,
                                    icon: 'error',
                                    timer: 2000,
                                    timerProgressBar: true,
                                    willClose: () => {
                                        // Optional: Add any additional actions you want to perform after the alert closes
                                    }
                                })


                            }
                        });


                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {


                        swalWithBootstrapButtons.fire({
                            title: 'Cancelled!',
                            text: 'Your file is safe :)',
                            icon: 'error',
                            timer: 2000,
                            timerProgressBar: true,
                            willClose: () => {
                                // Optional: Add any additional actions you want to perform after the alert closes
                            }
                        })
                    }
                })

            });




        });
    </script>
@endsection
