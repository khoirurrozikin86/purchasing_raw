@extends('admin.admin_dashboard')

@section('admin')

    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="container">
                                <form action="{{ route('update.materialreturn', $materialRT->id) }}" method="POST">
                                    @csrf
                                    <!-- Material IN Fields -->
                                    <div class="text-center">
                                        <h3>EDIT MATERIAL RETURN</h3>
                                    </div>
                                    <hr>

                                    @if ($errors->any())
                                        <div class="alert alert-danger" role="alert">
                                            @foreach ($errors->all() as $error)
                                                <p>{{ $error }}</p>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="row">

                                        <div class="col-md-4">

                                            <div class="form-group row">
                                                <label for="material_in_no" class="col-sm-3 col-form-label">MTR RT
                                                    No</label>
                                                <div class="col-sm-9">

                                                    <p>{{ $materialRT->material_return_no }}</p>

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="department" class="col-sm-3 col-form-label">Department</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="department" name="department"
                                                        value="{{ $materialRT->department }}">
                                                </div>
                                            </div>

                                        </div>

                                        <!-- NO SJ Field -->
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label for="person" class="col-sm-3 col-form-label">Person</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="person" name="person" value="{{ $materialRT->person }}">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Location and Courier Fields -->
                                        <div class="col-md-3">

                                            <div class="form-group row">
                                                <label for="remark" class="col-sm-4 col-form-label">Date</label>
                                                <div class="col-sm-5">
                                                    <input type="date" class="form-control" id="remark" name="remark"
                                                        value="{{ $materialRT->remark }}" required>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <hr>

                                    <!-- Material IN Details Fields -->
                                    <div class="row">
                                        <div class="">
                                            <button type="button" class="btn btn-secondary btn-sm mb-2" id="add-detail">Add
                                                Detail</button>

                                            <h6>Return Items</h6>

                                            <div class="table-scrollable">
                                                <table class="table table-bordered" id="details-table">
                                                    <thead>
                                                        <tr>

                                                            <th>ITEM CODE</th>
                                                            <th>ITEM NAME</th>

                                                            <th>COLOR CODE</th>
                                                            <th>COLOR NAME</th>

                                                            <th>SIZE</th>
                                                            <th>UNIT</th>

                                                            <th>QTY</th>

                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="details-containerx">
                                                        @foreach ($materialRT->details as $index => $detail)
                                                            <tr>

                                                                <td><input type="text"
                                                                        name="details[{{ $index }}][item_code]"
                                                                        class="form-control"
                                                                        value="{{ $detail->item_code }}"
                                                                        placeholder="Item Code" required></td>

                                                                <td><input type="text"
                                                                        name="details[{{ $index }}][item_name]"
                                                                        class="form-control"
                                                                        value="{{ $detail->item->item_name }}"
                                                                        placeholder="Item Name" required></td>

                                                                <td><input type="text"
                                                                        name="details[{{ $index }}][color_code]"
                                                                        class="form-control"
                                                                        value="{{ $detail->color_code }}"
                                                                        placeholder="Color Code"></td>
                                                                <td><input type="text"
                                                                        name="details[{{ $index }}][color_name]"
                                                                        class="form-control"
                                                                        value="{{ $detail->color_name }}"
                                                                        placeholder="Color Name"></td>

                                                                <td><input type="text"
                                                                        name="details[{{ $index }}][size]"
                                                                        class="form-control" value="{{ $detail->size }}"
                                                                        placeholder="Size"></td>
                                                                <td><input type="text"
                                                                        name="details[{{ $index }}][unit]"
                                                                        class="form-control"
                                                                        value="{{ $detail->item->unit->unit_name }}"
                                                                        placeholder="Unit"></td>

                                                                <td><input type="text"
                                                                        name="details[{{ $index }}][qty]"
                                                                        class="form-control qty"
                                                                        value="{{ $detail->qty }}" placeholder="Qty">
                                                                </td>

                                                                <td><button type="button"
                                                                        class="btn btn-danger btn-sm remove-detail">Remove</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="row mt-3">
                                                {{-- <div class="col-md-6">
                                                    <h5>Total Rolls: <span id="total-rolls">0</span></h5>
                                                </div> --}}
                                                <div class="col-md-6 text-right">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                    <a href="{{ route('all.materialout') }}"
                                                        class="btn btn-danger">Back</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {


            function updateTotalRolls() {
                let countFilledRows = 0;

                $('#details-containerx tr').each(function() {
                    let rollValue = $(this).find('input[name$="[roll]"]').val().trim();
                    if (rollValue !== '') {
                        countFilledRows++;
                    }
                });

                $('#total-rolls').text(countFilledRows);
            }

            $('#details-table').on('input', '.roll', function() {
                updateTotalRolls();
            });

            $('#add-detail').click(function() {
                let index = $('#details-containerx tr').length;
                let newRow = `
                    <tr>
                    <td><input type="text" name="details[${index}][original_no]" class="form-control original_no" placeholder="Original No" required></td>
                    <td><input type="text" name="details[${index}][receive_date]" class="form-control"></td>
                    <td><input type="text" name="details[${index}][supplier_name]" class="form-control" placeholder="Supplier Name"></td>
                    <td><input type="text" name="details[${index}][item_code]" class="form-control" placeholder="Item Code"></td>
                    <td><input type="text" name="details[${index}][po]" class="form-control" placeholder="PO"></td>
                    <td><input type="text" name="details[${index}][color_code]" class="form-control" placeholder="Color Code"></td>
                    <td><input type="text" name="details[${index}][color_name]" class="form-control" placeholder="Color Name"></td>
                    <td><input type="text" name="details[${index}][batch]" class="form-control" placeholder="Batch"></td>
                    <td><input type="text" name="details[${index}][roll]" class="form-control roll" placeholder="Roll"></td>
                    <td><input type="text" name="details[${index}][gross_weight]" class="form-control" placeholder="Gross Weight"></td>
                    <td><input type="text" name="details[${index}][net_weight]" class="form-control" placeholder="Net Weight"></td>
               
                    <td><input type="text" name="details[${index}][basic_width]" class="form-control" placeholder="Basic Width"></td>
                    <td><input type="text" name="details[${index}][basic_grm]" class="form-control" placeholder="Basic Grm"></td>
          
                    <td><input type="text" name="details[${index}][qty]" class="form-control qty" placeholder="Qty"></td>
             
                    <td><button type="button" class="btn btn-danger btn-sm remove-detail">Remove</button></td>
                    </tr>
                `;
                $('#details-containerx').append(newRow);
                updateTotalRolls();
            });

            $('#details-table').on('click', '.remove-detail', function() {
                $(this).closest('tr').remove();
                updateTotalRolls();
            });

            // Initialize total rolls
            updateTotalRolls();




            function checkDuplicate(originalNo, row) {
                let isDuplicate = false;
                $('#details-containerx tr').each(function() {
                    if ($(this).get(0) === row.get(0)) {
                        return; // Skip the current row
                    }
                    let existingNo = $(this).find('.original_no').val().trim();
                    if (existingNo === originalNo && originalNo !== '') {
                        isDuplicate = true;
                        return false; // Exit loop early
                    }
                });
                return isDuplicate;
            }








            $(document).on('keydown', '.original_no', function(event) {

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger me-2'
                    },
                    buttonsStyling: false,
                })




                if (event.keyCode === 13) { // 13 adalah kode untuk tombol Enter
                    event.preventDefault(); // Mencegah aksi default tombol Enter








                    let originalNo = $(this).val().trim();
                    let row = $(this).closest('tr');

                    let originalNoInput = $(this).closest('tr').find('.original_no').val().trim();
                    let itemCodeInput = $(this).closest('tr').find('.item_code').val().trim();


                    if (originalNoInput && itemCodeInput) {
                        // Move focus to actual_weight
                        row.find('input[name$="[actual_weight]"]').focus();
                    }



                    if (originalNo) {
                        if (checkDuplicate(originalNo, row)) {
                            swalWithBootstrapButtons.fire({
                                title: 'Duplicate!',
                                text: `Duplicate Original No detected!`,
                                icon: 'error',
                                timer: 2000,
                                timerProgressBar: true,
                                willClose: () => {
                                    // Optional: Add any additional actions you want to perform after the alert closes
                                }
                            })
                            $(this).val(''); // Clear the input field
                        } else {
                            $.ajax({
                                url: '/get/qr_codein/' + originalNo,
                                type: 'GET',
                                success: function(response) {
                                    row.find('input[name$="[receive_date]"]').val(response
                                        .received_date || '');
                                    row.find('input[name$="[supplier_name]"]').val(response
                                        .supplier_name || '');
                                    row.find('input[name$="[item_code]"]').val(response
                                        .item_code ||
                                        '');
                                    row.find('input[name$="[po]"]').val(response.po || '');
                                    row.find('input[name$="[color_code]"]').val(response
                                        .color_code || '');
                                    row.find('input[name$="[color_name]"]').val(response
                                        .color_name || '');
                                    row.find('input[name$="[batch]"]').val(response.batch ||
                                        '');
                                    row.find('input[name$="[roll]"]').val(response.roll || '');
                                    row.find('input[name$="[gross_weight]"]').val(response
                                        .gross_weight || '');
                                    row.find('input[name$="[net_weight]"]').val(response
                                        .net_weight || '');
                                    row.find('input[name$="[qty]"]').val(response.qty || '');
                                    row.find('input[name$="[basic_width]"]').val(response
                                        .basic_width || '');
                                    row.find('input[name$="[basic_grm]"]').val(response
                                        .basic_grm ||
                                        '');


                                    // add_row(); 
                                },
                                error: function() {

                                    swalWithBootstrapButtons.fire({
                                        title: 'Not Found!',
                                        text: `Data not found!`,
                                        icon: 'error',
                                        timer: 2000,
                                        timerProgressBar: true,
                                        willClose: () => {
                                            // Optional: Add any additional actions you want to perform after the alert closes
                                        }
                                    })
                                    row.find('input').val('');
                                }
                            });
                        }
                    }
                }
            });

        });
    </script>
@endsection
