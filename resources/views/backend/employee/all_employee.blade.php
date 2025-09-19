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
                                    <h6 class="card-title text-center">employee All</h6>
                                </div>
                              
                            </div>

                        </div>

                        <div class="row">
                            <div class="col">
                            

                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="javascript:void(0)" class="btn btn-primary" id="btn-create-employee"><i class="feather-10" data-feather="plus"></i>  &nbsp;Add</a>
                                    <a href="{{ route('print.employee') }}" class="btn btn-primary"><i class="feather-10" data-feather="printer"></i>  &nbsp;Print</a>  
                                    <a href="{{ route('import.employees') }}"  class="btn btn-primary"><i class="feather-10" data-feather="upload"></i>  &nbsp;Import</a>
                                    <a href="{{ route('export.employee') }}"  class="btn btn-primary"><i class="feather-10" data-feather="download"></i>  &nbsp;Export</a>
                                  </div>
                            </div>
                        </div>


                        <div class="table-responsive">

                            <table id="employeeTable" class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Posisi</th>
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

                    <form id="employeeForm" name="employeeForm">

                        <div class="alert alert-danger print-error-msg" style="display:none">

                            <ul></ul>

                        </div>

                        <input type="hidden" name="employee_id" id="employee_id">
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK:</label>
                            <input type="text" class="form-control" id="nik" name="nik" autofocus>

                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="department" class="form-label">Department:</label>
                            <input type="text" class="form-control" id="department" name="department">
                        </div>

                        <div class="mb-3">
                            <label for="posisi" class="form-label">Posisi:</label>
                            <input type="text" class="form-control" id="posisi" name="posisi">
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




            var table = $('#employeeTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('get.employee') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'

                    },
                    {
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'department',
                        name: 'department'
                    },
                    {
                        data: 'posisi',
                        name: 'posisi'
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
                ],
                
            });




            /*------------------------------------------

            --------------------------------------------

            Click to Button

            --------------------------------------------

            --------------------------------------------*/

            $('#btn-create-employee').click(function() {

                $('#saveBtn').html("save");
                $(this).find('form').trigger('reset');
                $('#employeeForm').find(".print-error-msg").find("ul").find("li").remove();
                $('#employeeForm').find(".print-error-msg").css('display', 'none');

                $('#saveBtn').val("create-employee");
                $('#employeeForm').trigger("reset");
                $('#exampleModalLabel').html("Create New employee");
                $('#employee_id').val('');
                $('#modal-create').modal('show');
                $('#nik').attr("readonly", false)
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

                    data: $('#employeeForm').serialize(),

                    url: "{{ route('store.employee') }}",

                    type: "POST",

                    dataType: 'json',

                    success: function(data) {

                        $('#employeeForm').trigger("reset");
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

                        $('#employeeForm').find(".print-error-msg").find("ul").html('');
                        $('#employeeForm').find(".print-error-msg").css('display', 'block');
                        $.each(data.responseJSON.errors, function(key, value) {
                            $('#employeeForm').find(".print-error-msg").find("ul")
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


            $('body').on('click', '.editEmployee', function() {

                var employee_id = $(this).data('id');
                console.log(employee_id);


                $.get("/edit/employee/" + employee_id, function(
                    data) {
                    $('#exampleModalLabel').html("Edit employee");
                    $('#saveBtn').html("edit");
                    $('#modal-create').modal('show');
                    $('#employee_id').val(data.id);
                    $('#nik').val(data.nik);
                    $('#name').val(data.name);
                    $('#department').val(data.department);
                    $('#posisi').val(data.posisi);

                    $('#nik').attr("readonly", true)

                    $('#employeeForm').find(".print-error-msg").find("ul").find("li").remove();
                    $('#employeeForm').find(".print-error-msg").css('display', 'none');

                })

            });

            /*------------------------------------------

            --------------------------------------------

            Delete Product Code

            --------------------------------------------

            --------------------------------------------*/


            $('body').on('click', '.deleteEmployee', function() {



                var employee_id = $(this).data("id");

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
                            url: "/delete/employee/" + employee_id,
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
