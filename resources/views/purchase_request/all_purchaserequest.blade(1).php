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
                                    <h6 class="card-title text-center">PURCHASE REQUEST All</h6>
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
                            <div class="col-md-3 d-flex align-items-end">
                                <button id="filterBtn" class="btn btn-primary me-2">Filter</button>
                                <button id="exportExcel" class="btn btn-success">Export Excel</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">

                                <div class="btn-group" role="group" aria-label="Basic example">

                                    <a href="{{ route('add.purchaserequest') }}" class="btn btn-primary"><i
                                            class="feather-10" data-feather="plus"></i> &nbsp;Add</a>
                                    {{-- <a href="{{ route('export.cbd') }}"  class="btn btn-primary"><i class="feather-10" data-feather="download"></i>  &nbsp;Export</a> --}}
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive mt-2">

                            <table id="cbdTable" class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Request No</th>
                                		<th>Created at</th>
                                        <th>CBD</th>
                                        <th>tipe</th>
                                        <th>Mo</th>
                                        <th>STYLE</th>
                                        <th>destination</th>
                                        <th>applicant</th>
                                        <th>Item_name</th>
                                        <th>Color</th>
                                        <th>Size</th>
                                        <th>Unit</th>
                                        <th>Total</th>
                                        <th>Remark</th>
                                        <th>Status</th>
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
            $('#exportExcel').click(function() {
                var startDate = $('#startDate').val();
                var endDate = $('#endDate').val();

                if (!startDate || !endDate) {
                    Swal.fire({
                        title: 'Invalid Input',
                        text: 'Please select both start and end dates.',
                        icon: 'warning',
                        timer: 2000,
                        timerProgressBar: true
                    });
                    return;
                }

                if (new Date(startDate) > new Date(endDate)) {
                    Swal.fire({
                        title: 'Invalid Date Range',
                        text: 'End date must be greater than or equal to the start date.',
                        icon: 'error',
                        timer: 2000,
                        timerProgressBar: true
                    });
                    return;
                }

                // Redirect ke route export dengan query parameter
                window.location.href = `/export/purchaserequest?startDate=${startDate}&endDate=${endDate}`;
            });
        });
        $(function() {
            // Set up CSRF Token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table;

            // Fungsi untuk inisialisasi DataTable
            function initDataTable(startDate, endDate) {
                // Jika DataTable sudah ada, destroy sebelum membuat ulang
                if ($.fn.DataTable.isDataTable('#cbdTable')) {
                    table.destroy();
                }

                table = $('#cbdTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('get.purchaserequest') }}",
                        data: function(d) {
                            d.startDate = startDate;
                            d.endDate = endDate;
                        },
                        dataSrc: function(json) {
                            if (json.data.length === 0) {
                                Swal.fire({
                                    title: 'No Data',
                                    text: 'No records found for the selected dates.',
                                    icon: 'info',
                                    timer: 2000,
                                    timerProgressBar: true
                                });
                            }
                            return json.data;
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'purchase_request_no',
                            name: 'purchase_request_no'
                        },
                               {
        data: 'created_at',
        name: 'created_at',
        render: function(data, type, row) {
            if (data) {
                const date = new Date(data); // Mengonversi string menjadi objek Date
                const year = date.getFullYear(); // Mendapatkan tahun
                const month = String(date.getMonth() + 1).padStart(2, '0'); // Mendapatkan bulan dan menambah 1 (karena bulan dimulai dari 0)
                const day = String(date.getDate()).padStart(2, '0'); // Mendapatkan tanggal dan menambah 0 jika kurang dari 10
                
                return `${year}-${month}-${day}`; // Format: YYYY-MM-DD
            }
            return ''; // Jika data kosong, kembalikan string kosong
        }
    },
                        {
                            data: 'order_no',
                            name: 'order_no'
                        },
                        {
                            data: 'tipe',
                            name: 'tipe',
                            render: function(data) {
                                return (data === 'Urgent' || data === 'SLT') ?
                                    `<span class="badge bg-danger">${data}</span>` :
                                    data;
                            }
                        },
                        {
                            data: 'mo',
                            name: 'mo'
                        },
                        {
                            data: 'style',
                            name: 'style'
                        },
                        {
                            data: 'destination',
                            name: 'destination'
                        },
                        {
                            data: 'applicant',
                            name: 'applicant'
                        },
                        {
                            data: 'item_name',
                            name: 'item_name',
                           
                        },
                        {
                            data: 'color',
                            name: 'color'
                        },
                        {
                            data: 'size',
                            name: 'size'
                        },
                        {
                            data: 'unit',
                            name: 'unit'
                        },
                        {
                            data: 'total',
                            name: 'total'
                        },
                        {
                            data: 'remark',
                            name: 'remark'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
            }

            // Filter data berdasarkan tanggal
            $('#filterBtn').click(function() {
                var startDate = $('#startDate').val();
                var endDate = $('#endDate').val();

                // Validasi input tanggal
                if (!startDate || !endDate) {
                    Swal.fire({
                        title: 'Invalid Input',
                        text: 'Please select both start and end dates.',
                        icon: 'warning',
                        timer: 2000,
                        timerProgressBar: true
                    });
                    return;
                }

                if (new Date(startDate) > new Date(endDate)) {
                    Swal.fire({
                        title: 'Invalid Date Range',
                        text: 'End date must be greater than or equal to the start date.',
                        icon: 'error',
                        timer: 2000,
                        timerProgressBar: true
                    });
                    return;
                }

                initDataTable(startDate, endDate);
            });

            // Mengecek filter awal saat halaman dimuat
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();

            if (startDate && endDate) {
                initDataTable(startDate, endDate);
            }

            // Hapus data Purchase Request
            $('body').on('click', '.deletePurchaserequest', function() {
                var request_id = $(this).data("id");

                Swal.fire({
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
                            type: "DELETE", // Menggunakan DELETE lebih tepat
                            url: `/delete/purchaserequest/${request_id}`,
                            success: function() {
                                table.ajax.reload(null, false);
                                Swal.fire('Deleted!', 'Your record has been deleted.',
                                    'success');
                            },
                            error: function(xhr) {
                                Swal.fire('Error!', xhr.responseJSON?.message ||
                                    'An error occurred.', 'error');
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire('Cancelled', 'Your record is safe :)', 'info');
                    }
                });
            });
        });
    </script>

    {{-- <script>
        $(function() {

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });

            var table;

            // Fungsi untuk inisialisasi DataTable
            function initDataTable(startDat, endDate) {
                table = $('#cbdTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {


                        url: "{{ route('get.purchaserequest') }}",
                        data: function(d) {
                            d.startDate = startDate; // Ambil Start Date
                            d.endDate = endDate; // Ambil End Date
                        },
                        dataSrc: function(json) {
                            if (json.data.length === 0) {
                                Swal.fire({
                                    title: 'No Data',
                                    text: 'No records found for the selected dates.',
                                    icon: 'info',
                                    timer: 2000,
                                    timerProgressBar: true
                                });
                            }
                            return json.data;
                        }


                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'purchase_request_no',
                            name: 'purchase_request_no'
                        },
                        {
                            data: 'order_no',
                            name: 'order_no'
                        },
                        {
                            data: 'tipe',
                            name: 'tipe',
                            render: function(data, type, row) {
                                if (data == 'Urgent' || data == 'SLT') {
                                    return '<span class="badge bg-danger">' + data + '</span>';
                                }
                                return data;
                            }
                        },
                        {
                            data: 'mo',
                            name: 'mo'
                        },
                        {
                            data: 'style',
                            name: 'style'
                        },
                        {
                            data: 'destination',
                            name: 'destination'
                        },
                        {
                            data: 'applicant',
                            name: 'applicant'
                        },
                        {
                            title: "item_name",
                            data: "item_name",
                            render: function(data, type, row) {
                                // Batasi panjang teks maksimal menjadi 25 karakter
                                if (type === 'display' && data.length > 25) {
                                    return data.substr(0, 25) + '...';
                                }
                                return data;
                            }
                        },
                        {
                            data: 'color',
                            name: 'color'
                        },
                        {
                            data: 'size',
                            name: 'size'
                        },
                        {
                            data: 'unit',
                            name: 'unit'
                        },
                        {
                            data: 'total',
                            name: 'total'
                        },
                        {
                            data: 'remark',
                            name: 'remark'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],

                });

            };




            // Filter data berdasarkan tanggal
            $('#filterBtn').click(function() {
                var startDate = $('#startDate').val();
                var endDate = $('#endDate').val();

                // Validasi input tanggal
                if (!startDate || !endDate) {
                    Swal.fire({
                        title: 'Invalid Input',
                        text: 'Please select both start and end dates.',
                        icon: 'warning',
                        timer: 2000,
                        timerProgressBar: true
                    });
                    return;
                }

                if (new Date(startDate) > new Date(endDate)) {
                    Swal.fire({
                        title: 'Invalid Date Range',
                        text: 'End date must be greater than or equal to the start date.',
                        icon: 'error',
                        timer: 2000,
                        timerProgressBar: true
                    });
                    return;
                }

                // Jika DataTable belum ada, inisialisasi dulu
                if (!table) {
                    initDataTable(startDate, endDate);
                } else {
                    // Jika DataTable sudah ada, cukup reload datanya
                    table.ajax.reload();
                }

                // Tampilkan tabel setelah filter diterapkan
                $('#cbdTable_wrapper').show();
            });

            // Mengecek jika ada filter yang sudah dipilih saat halaman dimuat
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();

            if (startDate && endDate) {
                initDataTable(startDate, endDate);
            }




            $('body').on('click', '.deletePurchaserequest', function() {
                var request_id = $(this).data("id");

                Swal.fire({
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
                            url: "/delete/purchaserequest/" + request_id,
                            success: function(data) {
                                table.ajax.reload(null, false);

                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'Your file has been deleted.',
                                    icon: 'success',
                                    timer: 2000,
                                    timerProgressBar: true,
                                    willClose: () => {
                                        // Optional: Add any additional actions you want to perform after the alert closes
                                    }
                                });
                            },
                            error: function(data) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: data.responseJSON
                                        .message ||
                                        'Something went wrong.',
                                    icon: 'error',
                                    timer: 2000,
                                    timerProgressBar: true,
                                    willClose: () => {
                                        // Optional: Add any additional actions you want to perform after the alert closes
                                    }
                                });
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
                });
            });












        });
    </script> --}}
@endsection
