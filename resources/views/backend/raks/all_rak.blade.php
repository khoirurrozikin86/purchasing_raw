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
                                    <h6 class="card-title text-center">Rak All</h6>
                                </div>
                              
                            </div>

                        </div>

                        <div class="row">
                            <div class="col">
                               

                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="javascript:void(0)" class="btn btn-primary" id="btn-create-rak"><i class="feather-10" data-feather="plus"></i>  &nbsp;Add</a>
                                    <a href="{{ route('print.rak') }}" class="btn btn-primary"><i class="feather-10" data-feather="printer"></i>  &nbsp;Print</a>  
                                  
                                  </div>
                            </div>
                        </div>


                        <div class="table-responsive">

                            <table id="rakTable" class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Rak Code</th>
                                        <th>Rak Name</th>
                                      
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

                    <form id="rakForm" name="rakForm">

                        <div class="alert alert-danger print-error-msg" style="display:none">

                            <ul></ul>

                        </div>

                        <input type="hidden" name="rak_id" id="rak_id">
                        <div class="mb-3">
                            <label for="rak_code" class="form-label">Code:</label>
                            <input type="text" class="form-control" id="rak_code" name="rak_code" autofocus>

                        </div>
                        <div class="mb-3">
                            <label for="rak_name" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="rak_name" name="rak_name">
                        </div>
                       
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save</button>
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



            var table = $('#rakTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('get.rak') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'

                    },
                    {
                        data: 'rak_code',
                        name: 'rak_code'
                    },
                    {
                        data: 'rak_name',
                        name: 'rak_name'
                    },
                   

                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ],
                
            });




            /*------------------------------------------

            --------------------------------------------

            Click to Button

            --------------------------------------------

            --------------------------------------------*/

            $('#btn-create-rak').click(function() {

                $('#saveBtn').html("save");
                $(this).find('form').trigger('reset');
                $('#rakForm').find(".print-error-msg").find("ul").find("li").remove();
                $('#rakForm').find(".print-error-msg").css('display', 'none');

                $('#saveBtn').val("create-rak");
                $('#rakForm').trigger("reset");
                $('#exampleModalLabel').html("Create New rak");
                $('#rak_id').val('');
                $('#modal-create').modal('show');
                $('#rak_code').attr("readonly", false)
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

                    data: $('#rakForm').serialize(),

                    url: "{{ route('store.rak') }}",

                    type: "POST",

                    dataType: 'json',

                    success: function(data) {

                        $('#rakForm').trigger("reset");
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

                        $('#rakForm').find(".print-error-msg").find("ul").html('');
                        $('#rakForm').find(".print-error-msg").css('display', 'block');
                        $.each(data.responseJSON.errors, function(key, value) {
                            $('#rakForm').find(".print-error-msg").find("ul")
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


            $('body').on('click', '.editRak', function() {

                var rak_id = $(this).data('id');
                console.log(rak_id);


                $.get("/edit/rak/" + rak_id, function(
                    data) {
                    $('#exampleModalLabel').html("Edit rak");
                    $('#saveBtn').html("edit");
                    $('#modal-create').modal('show');
                    $('#rak_id').val(data.id);
                    $('#rak_code').val(data.rak_code);
                    $('#rak_name').val(data.rak_name);

                    $('#rak_code').attr("readonly", true)

                    $('#rakForm').find(".print-error-msg").find("ul").find("li").remove();
                    $('#rakForm').find(".print-error-msg").css('display', 'none');

                })

            });

            /*------------------------------------------

            --------------------------------------------

            Delete Product Code

            --------------------------------------------

            --------------------------------------------*/


            $('body').on('click', '.deleteRak', function() {



                var rak_id = $(this).data("id");

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
                            url: "/delete/rak/" + rak_id,
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
