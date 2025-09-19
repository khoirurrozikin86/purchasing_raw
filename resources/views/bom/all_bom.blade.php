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
                                    <h6 class="card-title text-center">BOM All</h6>
                                </div>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col">

                                <div class="btn-group" role="group" aria-label="Basic example">

                                    <a href="{{ route('add.bom') }}" class="btn btn-primary"><i class="feather-10"
                                            data-feather="plus"></i> &nbsp;Add BOM</a>

                                    <a href="{{ route('export.bom') }}" class="btn btn-success"><i class="feather-10"
                                            data-feather="download"></i> &nbsp;Export BOM</a>

                                </div>
                            </div>
                        </div>

                        <div class="table-responsive mt-2">

                            <table id="bomTable" class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>BOM NO</th>
                                        <th>STYLE</th>
                                        <th>SIZE</th>
                                        <th>COLOR</th>
                                        <th>ITEM CODE</th>
                                        <th>ITEM NAME</th>
                                        <th>CATEGORY</th>
                                        <th>UNIT</th>
                                        <th>CONSUMPTION</th>
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

    <script>
        $(function() {

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });




            var table = $('#bomTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('get.bom') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'bom_no',
                        name: 'bom_no'
                    },
                    {
                        data: 'style',
                        name: 'style'
                    },
                    {
                        data: 'size',
                        name: 'size'
                    },
                    {
                        data: 'remark1',
                        name: 'remark1'
                    },
                    {
                        data: 'item_code',
                        name: 'item_code',
                    },
                    {
                        data: 'item_name',
                        name: 'item_name'
                    },
                    {
                        data: 'unit',
                        name: 'unit'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'consumption',
                        name: 'consumption',
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ],

            });






            $('body').on('click', '.deleteBom', function() {



                var bom_id = $(this).data("id");

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
                            url: "/delete/bom/" + bom_id,
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
