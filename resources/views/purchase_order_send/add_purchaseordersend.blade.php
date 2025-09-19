@extends('admin.admin_dashboard')

@section('admin')
    <style>
        .custom-height {
            height: 40px;
            /* Atur tinggi input sesuai keinginan */
            font-size: 1.25rem;
            /* Ukuran font lebih besar */
        }
    </style>

    <div class="page-content mt-5">

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div>
                            <div class="row">

                                <div class="col">
                                    <h6 class="card-title text-center">PURCHASE ORDER SEND EMAIL </h6>
                                </div>

                            </div>

                        </div>

                        <hr />

                        <form id="posendForm" name="posendForm" class="w-100 mt-3">
                            <div class="alert alert-danger print-error-msg" style="display:none">
                                <ul></ul>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-3 col-md-3 mb-3">
                                    <!-- Label placed above input -->
                                    <label for="purchase_order_no" class="form-label text-center">Scan Barcode PO
                                        disini!</label>

                                    <!-- Input field for barcode with larger height -->
                                    <div class="input-group">
                                        <input type="text" class="form-control custom-height" id="purchase_order_no"
                                            name="purchase_order_no" placeholder="purchase_order_no" autofocus required style="text-transform:uppercase;" oninput="this.value = this.value.toUpperCase();">

                                    </div>

                                    <!-- Supplier name display -->
                                    <p class="txt-counts text-center mt-3" id="txt-supplier_name">-</p>
                                </div>
                            </div>

                        </form>

                        <div class="row">
                            <div class="col">

                                <div class="btn-group" role="group" aria-label="Basic example">
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive mt-2">

                            <table id="cbdTable" class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Purchase No</th>
                                        <th>Status</th>
                                        <th>Request No</th>
                                        <th>MO</th>
                                        <th>Supplier</th>
                                        <th>SPL RMK</th>
                                        <th>Date in House</th>
                                        {{-- <th>applicant</th> --}}
                                        <th>Category</th>
                                        <th>Item_code</th>
                                        <th>Item_name</th>
                                        <th>Color</th>
                                        <th>Size</th>
                                        <th>Unit</th>
                                        <th>qty</th>
                                        <th>Price</th>

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
        $(document).ready(function() {


            loadPurchaseOrderSendData();

            clear_input();



            // Function to clear the input fields
            function clear_input() {
                $('#purchase_order_no').val('');
                $('#txt-supplier_name').text('-');
            }







            // When user presses enter after scanning the barcode or entering PO number
            $('#purchase_order_no').on('keypress', function(e) {
                if (e.which === 13) { // Check if the Enter key (keyCode 13) is pressed
                    e.preventDefault(); // Prevent automatic form submission

                    var purchase_order_no = $(this).val();

                    // Ensure PO No has at least 3 characters
                    if (purchase_order_no.length >= 3) {
                        // Set the supplier check message to 'Checking...'
                        $('#txt-supplier_name').text('Checking...');

                        // AJAX request to get supplier data based on PO No
                        $.ajax({
                            url: '{{ route('get.purchaseordersup') }}', // Update with correct route
                            method: 'GET',
                            data: {
                                purchase_order_no: purchase_order_no,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Show the supplier name if found
                                    $('#txt-supplier_name').text(response.supplier_name);

                                    // Save Purchase Order Send as soon as PO is found
                                    savePurchaseOrder(response);
                                } else {
                                    // $('#txt-supplier_name').text('Supplier not found.');

                                    Swal.fire({
                                        icon: 'error',
                                        title: 'PO + Supplier not found!',
                                        showConfirmButton: false,
                                        timer: 1000,
                                        timerProgressBar: true,
                                    });

                                    clear_input();
                                }
                            },
                            error: function() {
                                // Handle error and ensure input remains usable after failure
                                $('#txt-supplier_name').text('Error fetching supplier data.');
                                alert('Error fetching supplier data.');
                            }
                        });
                    } else {
                        $('#txt-supplier_name').text('PO No should be at least 3 characters.');
                    }
                }
            });

            // Function to save the purchase order data
            function savePurchaseOrder(data) {
                $.ajax({
                    url: '{{ route('store.purchaseordersend') }}', // Endpoint to save data
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        purchase_order_no: $('#purchase_order_no').val(),
                        supplier_id: data.supplier_id,
                        details: data.details // Send PO details
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Transaksi berhasil disimpan!',
                                showConfirmButton: false,
                                timer: 1000,
                                timerProgressBar: true,
                            });

                            // Reload Purchase Order Send data
                            loadPurchaseOrderSendData();

                            // Clear input fields
                            clear_input();

                            $('#purchase_order_no').focus(); // Set focus back to PO input field
                        } else {
                            alert('Data gagal disimpan atau duplikat PO!');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Duplikat Input',
                            showConfirmButton: false,
                            timer: 1000,
                            timerProgressBar: true,
                        });

                        clear_input();
                    }
                });
            }


            function loadPurchaseOrderSendData() {
            
             if ($.fn.dataTable.isDataTable('#cbdTable')) {
        // Destroy the existing DataTable
        $('#cbdTable').DataTable().destroy();
    }
            
            
            
                var table = $('#cbdTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('get.purchaseordersend') }}',
                        type: 'GET',

                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'purchase_order_no',
                            name: 'purchase_order_no'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'purchase_request_no',
                            name: 'purchase_request_no'
                        },
                          {
                        data: 'mo',
                        name: 'mo',
                        render: function(data, type, row) {
                            if (type === 'display' && data) {
                                if (data.length > 6) {
                                    return data.substr(0, 6) + '...'; // Show first 6 characters followed by '...'
                                }
                            }
                            return data || ''; // Handle null or undefined gracefully
                        }
                    },
                        {
                            data: 'supplier_name',
                            name: 'supplier_name'
                        },
                        {
                            data: 'supplier_remark',
                            name: 'supplier_remark'
                        },
                        {
                            data: 'date_in_house',
                            name: 'date_in_house'
                        },
                        {
                            "data": "category",
                            "name": "category",
                            "render": function(data, type, row) {
                                if (Array.isArray(row.item_details) && row.item_details.length >
                                    0) {
                                    var items = '<ul>';
                                    row.item_details.forEach(function(item) {
                                        items += '<li>' + item.category + '</li>';
                                    });
                                    items += '</ul>';
                                    return items;
                                } else {
                                    return '';
                                }
                            }
                        },

                        {
                            "data": "item_code",
                            "name": "item_code",
                            "render": function(data, type, row) {
                                if (Array.isArray(row.item_details) && row.item_details.length >
                                    0) {
                                    var items = '<ul>';
                                    row.item_details.forEach(function(item) {
                                        items += '<li>' + item.item_code + '</li>';
                                    });
                                    items += '</ul>';
                                    return items;
                                } else {
                                    return '';
                                }
                            }
                        },
                        {
                            "data": "item_name",
                            "name": "item_name",
                            "render": function(data, type, row) {
                                if (Array.isArray(row.item_details) && row.item_details.length >
                                    0) {
                                    var items = '<ul>';
                                    row.item_details.forEach(function(item) {
                                        items += '<li>' + item.item_name + '</li>';
                                    });
                                    items += '</ul>';
                                    return items;
                                } else {
                                    return '';
                                }
                            }
                        },
                        {
                            "data": "color",
                            "name": "color",
                            "render": function(data, type, row) {
                                if (Array.isArray(row.item_details) && row.item_details.length >
                                    0) {
                                    var colors = '<ul>';
                                    row.item_details.forEach(function(item) {
                                        colors += (item.color ? '<li>' + item.color +
                                            '</li>' :
                                            '');
                                    });
                                    colors += '</ul>';
                                    return colors;
                                } else {
                                    return '';
                                }
                            }
                        },
                        {
                            "data": "size",
                            "name": "size",
                            "render": function(data, type, row) {
                                if (Array.isArray(row.item_details) && row.item_details.length >
                                    0) {
                                    var sizes = '<ul>';
                                    row.item_details.forEach(function(item) {
                                        sizes += (item.size ? '<li>' + item.size + '</li>' :
                                            '');
                                    });
                                    sizes += '</ul>';
                                    return sizes;
                                } else {
                                    return '';
                                }
                            }
                        },
                        {
                            "data": "unit",
                            "name": "unit",
                            "render": function(data, type, row) {
                                if (Array.isArray(row.item_details) && row.item_details.length >
                                    0) {
                                    var sizes = '<ul>';
                                    row.item_details.forEach(function(item) {
                                        sizes += (item.unit_code ? '<li>' + item.unit_code +
                                            '</li>' : '');
                                    });
                                    sizes += '</ul>';
                                    return sizes;
                                } else {
                                    return '';
                                }
                            }
                        },
                        {
                            "data": "qty",
                            "name": "qty",
                            "render": function(data, type, row) {
                                if (Array.isArray(row.item_details) && row.item_details.length >
                                    0) {
                                    var qtys = '<ul>';
                                    row.item_details.forEach(function(item) {
                                        qtys += '<li>' + item.qty + '</li>';
                                    });
                                    qtys += '</ul>';
                                    return qtys;
                                } else {
                                    return '';
                                }
                            }
                        },
                        {
                            "data": "price",
                            "name": "price",
                            "render": function(data, type, row) {
                                if (Array.isArray(row.item_details) && row.item_details.length >
                                    0) {
                                    var prices = '<ul>';
                                    row.item_details.forEach(function(item) {
                                        prices += '<li>' + item.price + '</li>';
                                    });
                                    prices += '</ul>';
                                    return prices;
                                } else {
                                    return '';
                                }
                            }
                        },


                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    order: [
                        [1, 'desc']
                    ],
                    drawCallback: function(settings) {
                        // Update DataTable on drawing
                    }
                });
            }
                                        
                $('body').on('click', '.deletePurchaseOrderSend', function() {



                var request_id = $(this).data("id");

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
                            url: "/delete/purchaseordersend/" + request_id,
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







            function deletePurchaseOrderSendx(poSendId) {
                // Menampilkan konfirmasi sebelum menghapus
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kirim request AJAX untuk menghapus data
                        $.ajax({
                            url: `/delete/purchaseordersend/${poSendId}`, // Ganti dengan URL API yang sesuai

                            success: function(response) {
                                // Tampilkan pesan sukses dan hapus baris tabel yang terkait
                                if (response.success) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Purchase Order Send has been deleted.',
                                        'success'
                                    );
                                    // Hapus baris terkait dari tabel
                                    $(`button[data-id='${poSendId}']`).closest('tr').remove();
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'There was a problem deleting the purchase order send.',
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr) {
                                console.error('Error deleting purchase order send', xhr);
                                Swal.fire(
                                    'Error!',
                                    'There was a problem deleting the purchase order send.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            }


        });
    </script>
@endsection
