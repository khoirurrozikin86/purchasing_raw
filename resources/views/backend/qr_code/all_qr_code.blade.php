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
                                    <h6 class="card-title text-center">qr_code All</h6>
                                </div>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col">

                                <div class="btn-group" role="group" aria-label="Basic example">

                                    <a href="{{ route('import.qr_codes') }}" class="btn btn-primary"><i class="feather-10"
                                            data-feather="upload"></i> &nbsp;Import</a>
                                    <a href="{{ route('print.qr_code') }}" class="btn btn-primary"><i class="feather-10"
                                            data-feather="printer"></i> &nbsp;Print</a>

                                    <a href="{{ route('export.qr_code') }}" class="btn btn-primary"><i class="feather-10"
                                            data-feather="download"></i> &nbsp;Export</a>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">

                            <table id="qr_codeTable" class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ORIGINAL NO</th>
                                        <th>RECEIVE DATE</th>
                                        <th>SUPPLIER_NAME</th>
                                        <th>ITEM_CODE</th>
                                        <th>PO</th>
                                        <th>COLOR CODE</th>
                                        <th>COLOR NAME</th>
                                        <th>BATCH</th>
                                        <th>ROLL</th>
                                        <th>GROSS WEIGHT</th>
                                        <th>NET WEIGHT</th>
                                        <th>QTY</th>
                                        <th>BASIC WIDTH</th>
                                        <th>BASIC GRM</th>
                                        <th>MO</th>
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

            $('#modal-create').on('shown.bs.modal', function() {
                $(this).find('[autofocus]').focus();
            });




            var table = $('#qr_codeTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('get.qr_code') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'original_no',
                        name: 'original_no'
                    },
                    {
                        data: 'received_date',
                        name: 'received_date'
                    },
                    {
                        data: 'supplier_name',
                        name: 'supplier_name'
                    },
                    {
                        data: 'item_code',
                        name: 'item_code'
                    },
                    {
                        data: 'po',
                        name: 'po'
                    },
                    {
                        data: 'color_code',
                        name: 'color_code'
                    },
                    {
                        data: 'color_name',
                        name: 'color_name'
                    },
                    {
                        data: 'batch',
                        name: 'batch'
                    },
                    {
                        data: 'roll',
                        name: 'roll'
                    },
                    {
                        data: 'gross_weight',
                        name: 'gross_weight'
                    },
                    {
                        data: 'net_weight',
                        name: 'net_weight'
                    },
                    {
                        data: 'qty',
                        name: 'qty'
                    },
                    {
                        data: 'basic_width',
                        name: 'basic_width'
                    },
                    {
                        data: 'basic_grm',
                        name: 'basic_grm'
                    },
                    {
                        data: 'mo',
                        name: 'mo'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [1, 'asc']
                ]

            });





            $('body').on('click', '.deleteQr', function() {



                var qr_code_id = $(this).data("id");

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
                            url: "/delete/qr_code/" + qr_code_id,
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
