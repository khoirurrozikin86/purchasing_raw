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
                                    <h6 class="card-title text-center">PURCHASE REQUEST WAITING All</h6>
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

                                        <th>applicant</th>
                                        <th>Category</th>
                                        <th>Item_code</th>
                                        <th>Item_name</th>

                                        <th>Total</th>
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
            $('#cbdTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('get.purchaserequestwaiting') }}", // Replace with the correct route
                    type: "GET"
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
                                const date = new Date(
                                    data); // Mengonversi string menjadi objek Date
                                const year = date.getFullYear(); // Mendapatkan tahun
                                const month = String(date.getMonth() + 1).padStart(2,
                                    '0'
                                ); // Mendapatkan bulan dan menambah 1 (karena bulan dimulai dari 0)
                                const day = String(date.getDate()).padStart(2,
                                    '0'
                                ); // Mendapatkan tanggal dan menambah 0 jika kurang dari 10

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
                        name: 'tipe'
                    },
                    {
                        data: 'mo',
                        name: 'mo'
                    },

                    {
                        data: 'applicant',
                        name: 'applicant'
                    },
                    {
                        data: 'category',
                        name: 'category'
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
                        data: 'total',
                        name: 'total'
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
        });
    </script>
@endsection
