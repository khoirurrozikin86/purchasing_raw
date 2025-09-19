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
                                    <h6 class="card-title text-center">Item All</h6>
                                </div>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="javascript:void(0)" class="btn btn-primary" id="btn-create-item"><i class="feather-10" data-feather="plus"></i>  &nbsp;Add</a>
                                    {{-- <a href="{{ route('print.item') }}" class="btn btn-primary"><i class="feather-10"
                                            data-feather="printer"></i> &nbsp;Print</a> --}}
                                    <a href="{{ route('import.items') }}" class="btn btn-primary"><i class="feather-10"
                                            data-feather="upload"></i> &nbsp;Import</a>
                                    <a href="{{ route('export.item') }}" class="btn btn-primary"><i class="feather-10"
                                            data-feather="download"></i> &nbsp;Export</a>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">

                            <table id="itemTable" class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ITEM CODE</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Category</th>
                                        <th>Unit</th>
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

                    <form id="itemForm" name="itemForm">
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        <input type="hidden" name="item_idx" id="item_idx">

                        <div class="row">
                            <!-- Kolom Pertama -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="item_code" class="form-label">Item Code:</label>
                                    <input type="text" class="form-control" id="item_code" name="item_code" autofocus required>
                                </div>
                                <div class="mb-3">
                                    <label for="item_name" class="form-label">Name:</label>
                                    <input type="text" class="form-control" id="item_name" name="item_name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description:</label>
                                    <input type="text" class="form-control" id="description" name="description" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Category</label>
                                    <select id="category_id" name="category_id" class="js-example-basic-single form-select"
                                        style="width: 100%">
                                        <!-- Options will be added dynamically -->
                                    </select>
                                </div>
                            </div>

                            
                            <!-- Kolom Kedua -->
                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label class="form-label">Unit</label>
                                    <select id="unit_id" name="unit_id" class="js-example-basic-single form-select"
                                        style="width: 100%">
                                        <!-- Options will be added dynamically -->
                                    </select>
                                </div>
                               
                                <div class="mb-3">
                                    <label for="remark" class="form-label">Remark:</label>
                                    <input type="text" class="form-control" id="remark" name="remark">
                                </div>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save</button>
                </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            input_number();
            get_category();
            get_unit();

        });

        function input_number() {

            $('#quantity_on_hand, #reorder_level').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            $('#itemForm').on('submit', function(e) {
                var quantityOnHand = $('#quantity_on_hand').val();
                var reorderLevel = $('#reorder_level').val();

                if (quantityOnHand === '' || reorderLevel === '' || parseInt(quantityOnHand) < 0 ||
                    parseInt(reorderLevel) < 0) {
                    alert('Quantity on Hand and Reorder Level must be non-negative integers.');
                    e.preventDefault(); // prevent form from submitting
                }
            });

        }

        function get_category() {

            $.ajax({
                url: "{{ route('get.categoryglobal') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var select = $('#category_id');
                    select.empty(); // Clear existing options
                    data.forEach(function(category) {
                        select.append($('<option>', {
                            value: category.id,
                            text: category.name
                        }));
                    });
                }
            });

        }

        function get_unit() {
            $.ajax({
                url: "{{ route('get.unitglobal') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var select = $('#unit_id');
                    select.empty(); // Clear existing options
                    data.forEach(function(unit) {
                        select.append($('<option>', {
                            value: unit.id,
                            text: unit.unit_code
                        }));
                    });
                }
            });

        }


        $(function() {

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });

            $('#modal-create').on('shown.bs.modal', function() {
                $(this).find('[autofocus]').focus();
            });

            $('#remark').val('0');




            var table = $('#itemTable').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: "{{ route('get.item') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'

                    },
                    {
                        data: 'item_code',
                        name: 'item_code'
                    },
                    {
                        data: 'item_name',
                        name: 'item_name'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },


                    {
                        data: 'unit',
                        name: 'unit'
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

            $('#btn-create-item').click(function() {

                $('#saveBtn').html("save");
                $(this).find('form').trigger('reset');
                $('#itemForm').find(".print-error-msg").find("ul").find("li").remove();
                $('#itemForm').find(".print-error-msg").css('display', 'none');

                $('#saveBtn').val("create-item");
                $('#itemForm').trigger("reset");
                $('#exampleModalLabel').html("Create New item");
                $('#item_idx').val('');
                $('#modal-create').modal('show');
                $('#item_code').attr("readonly", false)
                $(this).find('[autofocus]').focus();

            });


            /*------------------------------------------

            --------------------------------------------

            Create Product item_id

            --------------------------------------------

            --------------------------------------------*/

            $('#saveBtn').click(function(e) {

                e.preventDefault();

                $(this).html('Sending..');



                $.ajax({

                    data: $('#itemForm').serialize(),

                    url: "{{ route('store.item') }}",

                    type: "POST",

                    dataType: 'json',

                    success: function(data) {

                        $('#itemForm').trigger("reset");
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

                        $('#itemForm').find(".print-error-msg").find("ul").html('');
                        $('#itemForm').find(".print-error-msg").css('display', 'block');
                        $.each(data.responseJSON.errors, function(key, value) {
                            $('#itemForm').find(".print-error-msg").find("ul")
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


            $('body').on('click', '.editItem', function() {

                var item_idx = $(this).data('id');
               

                $.get("/edit/item/" + item_idx, function(
                    data) {
                    $('#exampleModalLabel').html("Edit item");
                    $('#saveBtn').html("edit");
                    $('#modal-create').modal('show');
                    $('#item_idx').val(data.id);
                    $('#item_code').val(data.item_code);
                    $('#item_name').val(data.item_name);
                    $('#description').val(data.description);
          
                    $('#quantity_on_hand').val(data.quantity_on_hand);
                    $('#reorder_level').val(data.reorder_level);
                    $('#remark').val(data.remark);

                     // Menampilkan kategori yang sesuai
                    $.ajax({
                        url: "{{ route('get.categoryglobal') }}", // Pastikan URL ini sesuai dengan rute yang benar untuk mendapatkan kategori
                        type: 'GET',
                        dataType: 'json',
                        success: function(categories) {
                            var selectCategory = $('#category_id');
                            selectCategory.empty(); // Kosongkan select
                            categories.forEach(function(category) {
                                selectCategory.append($('<option>', {
                                    value: category.id,
                                    text: category.name
                                }));
                            });

                            // Pilih kategori yang sesuai dari data item
                            $('#category_id').val(data.category_id).trigger(
                                'change'); // Set kategori yang dipilih

                        }
                    });

                    // Menampilkan unit yang sesuai
                    $.ajax({
                        url: "{{ route('get.unitglobal') }}", // Pastikan URL ini sesuai dengan rute yang benar untuk mendapatkan unit
                        type: 'GET',
                        dataType: 'json',
                        success: function(units) {
                            var selectUnit = $('#unit_id');
                            selectUnit.empty(); // Kosongkan select
                            units.forEach(function(unit) {
                                selectUnit.append($('<option>', {
                                    value: unit.id,
                                    text: unit.unit_code
                                }));
                            });

                            // Pilih unit yang sesuai dari data item
                            $('#unit_id').val(data.unit_id).trigger(
                                'change'); // Set unit yang dipilih
                        }
                    });

                    // Menjaga agar item_code tidak bisa diubah
                    $('#item_code').attr("readonly", true);

                    // Clear any existing error messages
                    $('#itemForm').find(".print-error-msg").find("ul").find("li").remove();
                    $('#itemForm').find(".print-error-msg").css('display', 'none');
                });

             

            });

            /*------------------------------------------

            --------------------------------------------

            Delete Product item_id

            --------------------------------------------

            --------------------------------------------*/


            $('body').on('click', '.deleteItem', function() {



                var item_id = $(this).data("id");

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
                            url: "/delete/item/" + item_id,
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
