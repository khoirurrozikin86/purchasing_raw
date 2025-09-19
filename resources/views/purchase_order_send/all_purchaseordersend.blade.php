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
                                    <h6 class="card-title text-center">PURCHASE ORDER SEND EMAIL </h6>
                                </div>

                            </div>

                        </div>

                        <div class="row mb-3 mt-3">
                            <div class="col-md-5">
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="date" id="startDate" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="endDate" class="form-label">End Date</label>
                                <input type="date" id="endDate" class="form-control">
                            </div>
                            <div class="col-md-3 d-flex align-items-end ">
                                <a href="{{ route('add.purchaseordersend') }}" class="btn btn-info me-2">&nbsp;Add
                                    Data</a>
                                <button id="filterBtn" class="btn btn-primary me-2">Filter</button>
                                <button id="exportExcelBtn" class="btn btn-success">
                                    Export to Excel
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">

                                <div class="btn-group" role="group" aria-label="Basic example">

                                    {{-- <a href="{{ route('add.purchaseorder') }}"  class="btn btn-primary"><i class="feather-10" data-feather="plus"></i>  &nbsp;Add</a> --}}
                                    {{-- <a href="{{ route('export.cbd') }}"  class="btn btn-primary"><i class="feather-10" data-feather="download"></i>  &nbsp;Export</a> --}}
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
                                        <th>MO /Style</th>
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
            // Menginisialisasi tanggal hari ini dan besok
            function setDefaultDates() {
                var today = new Date();
                var tomorrow = new Date(today);
                tomorrow.setDate(tomorrow.getDate() + 1);

                var formatDate = function(date) {
                    var dd = String(date.getDate()).padStart(2, '0');
                    var mm = String(date.getMonth() + 1).padStart(2, '0');
                    var yyyy = date.getFullYear();
                    return yyyy + '-' + mm + '-' + dd; // Format: YYYY-MM-DD
                };

                $('#startDate').val(formatDate(today));
                $('#endDate').val(formatDate(tomorrow));
            }

            // Set default dates saat halaman dimuat
            setDefaultDates();




            // Fungsi untuk menginisialisasi DataTable dengan filter tanggal
            // Initialize DataTable
            var table = $('#cbdTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('get.purchaseordersendall') }}',
                    type: 'GET',
                    data: function(d) {
                        d.startDate = $('#startDate').val();
                        d.endDate = $('#endDate').val();
                    }
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

            // Handle Filter (Ketika tombol filter diklik)
            $('#filterBtn').click(function() {
                var startDate = $('#startDate').val();
                var endDate = $('#endDate').val();

                // Validasi input tanggal
                if (!startDate || !endDate) {
                    showAlert('Invalid Input', 'Please select both start and end dates.', 'warning');
                    return;
                }

                if (new Date(startDate) > new Date(endDate)) {
                    showAlert('Invalid Date Range',
                        'End date must be greater than or equal to the start date.', 'error');
                    return;
                }

                // Reload DataTable with new date filter
                table.ajax.reload();
            });

            // Function to display alerts
            function showAlert(title, message, type) {
                Swal.fire({
                    icon: type,
                    title: title,
                    text: message,
                    timer: 3000,
                    showConfirmButton: false
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

            // Handle Export Excel Button
            $('#exportExcelBtn').click(function() {
                var startDate = $('#startDate').val();
                var endDate = $('#endDate').val();

                // Validasi input tanggal
                if (!startDate || !endDate) {
                    showAlert('Invalid Input', 'Please select both start and end dates before exporting.',
                        'warning');
                    return;
                }

                if (new Date(startDate) > new Date(endDate)) {
                    showAlert('Invalid Date Range',
                        'End date must be greater than or equal to the start date.', 'error');
                    return;
                }

                // Redirect to export URL dengan parameter
                window.location.href =
                    `{{ route('export.purchaseordersend') }}?startDate=${startDate}&endDate=${endDate}`;
            });
        });
    </script>
@endsection
