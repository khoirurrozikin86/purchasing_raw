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
                                    <h6 class="card-title text-center">CBD All</h6>
                                </div>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col">

                                <div class="btn-group" role="group" aria-label="Basic example">

                                    <a href="{{ route('import.cbds') }}" class="btn btn-primary"><i class="feather-10"
                                            data-feather="upload"></i> &nbsp;Import</a>
                                   
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive mt-2">

                            <table id="cbdTable" class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Order No</th>
                                        <th>UQ PO</th>
                                        <th>SPLR MAT</th>
                                        <th>Item</th>
                                        <th>Sample / Style</th>
                                        <th>MO</th>
                                        <th>Color Code</th>
                                        <th>Color</th>
                                        <th>Size Code</th>
                                        <th>Size</th>
                                        <th>Qty</th>
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
                                            
                                              <!-- Modal Edit Trim Supplier -->
    <div class="modal fade" id="editTrimSupplierModal" tabindex="-1" aria-labelledby="editTrimSupplierModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTrimSupplierModalLabel">Edit UQ PO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editTrimSupplierForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="editCbdId" name="cbd_id">
                        <!-- Input untuk PO UQ -->
                        <div class="mb-3">
                            <label for="po_uq" class="form-label">PO UQ</label>
                            <input type="text" class="form-control" id="po_uq" name="po_uq">
                        </div>

                        <!-- Input untuk PO UQ Date -->
                        <div class="mb-3">
                            <label for="po_uq_date" class="form-label">PO UQ Date</label>
                            <input type="date" class="form-control" id="po_uq_date" name="po_uq_date">
                        </div>
                    </div>




                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
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




            var table = $('#cbdTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('get.cbd') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'order_no',
                        name: 'order_no'
                    },
                            {
                        data: 'po_uq',
                        name: 'po_uq'
                    },
                    {
                        data: 'supplier_raw_material_code',
                        name: 'supplier_raw_material_code'
                    },
                    {
                        data: 'item',
                        name: 'item'
                    },
                    {
                        data: 'sample_code',
                        name: 'sample_code'
                    },
                    {
                        data: 'payment_terms',
                        name: 'payment_terms'
                    },
                    {
                        data: 'color_code',
                        name: 'color_code'
                    },
                    {
                        data: 'color',
                        name: 'color'
                    },
                    {
                        data: 'size_code',
                        name: 'size_code'
                    },
                    {
                        data: 'size',
                        name: 'size'
                    },
                    {
                        data: 'qty',
                        name: 'qty'
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
                ],

            });






            $('body').on('click', '.deleteCbd', function() {



                var cbd_id = $(this).data("id");

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
                            url: "/delete/cbd/" + cbd_id,
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
        
        
          $('body').on('click', '.editCbd', function() {
                var cbd_id = $(this).data('id'); // Get CBD ID from clicked item
                var po_uq = $(this).data('po_uq'); // Get po_uq from clicked item
                var po_uq_date = $(this).data('po_uq_date'); // Get po_uq_date from clicked item

                // Set the values to modal form inputs
                $('#editTrimSupplierModal #editCbdId').val(cbd_id);
                $('#editTrimSupplierModal #po_uq').val(po_uq);
                $('#editTrimSupplierModal #po_uq_date').val(po_uq_date);

                // Open the modal
                $('#editTrimSupplierModal').modal('show');
            });






            $('#editTrimSupplierForm').on('submit', function(e) {
                e.preventDefault(); // Mencegah form agar tidak submit biasa

                var cbdId = $('#editCbdId').val();
                var poUq = $('#po_uq').val(); // Ambil po_uq
                var poUqDate = $('#po_uq_date').val(); // Ambil po_uq_date

                // Kirim data ke server menggunakan AJAX
                $.ajax({
                    url: '/update/cbd/' + cbdId,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        po_uq: poUq, // Kirimkan po_uq
                        po_uq_date: poUqDate, // Kirimkan po_uq_date
                    },
                    success: function(response) {
                        // Tutup modal setelah sukses
                        $('#editTrimSupplierModal').modal('hide');

                        // Reload tabel DataTable
                        $('#cbdTable').DataTable().ajax.reload();

                        // Tampilkan pesan sukses
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Trim Supplier and Trim Item No updated successfully.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr, status, error) {
                        // Tampilkan pesan error jika gagal
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Something went wrong, please try again later.',
                        });
                    }
                });
            });





        });
    </script>
@endsection
