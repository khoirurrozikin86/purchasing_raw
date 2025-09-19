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
                                    <nav class="page-breadcrumb">
                                        <ol class="breadcrumb">

                                        </ol>
                                    </nav>
                                </div>

                                <div class="col">
                                    <h6 class="card-title text-center">MUTATION BY CODE</h6>
                                </div>
                                <div class="col">
                                    <h6 class="card-title text-center"></h6>
                                </div>
                            </div>

                        </div>

                        <div class="table-responsive">

                            <table id="colorTable" class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>tanggal</th>
                                        <th>code</th>
                                        <th>Name</th>
                                        <th>size</th>
                                        <th>color code</th>
                                        <th>color name</th>
                                        <th>category</th>
                                        <th>unit</th>
                                        <th>IN</th>
                                        <th>OUT</th>
                                        <th>RETURN</th>

                                        <th>BALANCE</th>

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




            var table = $('#colorTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('get.stockmutation') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
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
                        data: 'size',
                        name: 'size'
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
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'unit',
                        name: 'unit'
                    },
                    {
                        data: 'in_qty',
                        name: 'in_qty'
                    },
                    {
                        data: 'out_qty',
                        name: 'out_qty'
                    },
                    {
                        data: 'return_qty',
                        name: 'return_qty'
                    },
                    {
                        data: 'balance',
                        name: 'balance'
                    },







                ]
            });







        });
    </script>
@endsection
