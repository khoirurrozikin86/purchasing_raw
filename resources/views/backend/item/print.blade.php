@extends('admin.admin_dashboard')

@section('admin')




    <div class="page-content">




        <div class="row profile-body">

            <!-- left wrapper end -->
            <!-- middle wrapper start -->
            <div class="col-md-12 col-xl-12 middle-wrapper">
                <div class="row">
                    <div class="card">
                        <div class="card-body">

                            <h6 class="card-title">Print Barcode</h6>



                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    @foreach ($errors->all() as $error)
                                        <h3> {{ $error }} </h3>
                                    @endforeach

                                </div>
                            @endif




                            <form id="myForm" class="forms-sample" method="POST" action="{{route('pdf.item')}}" enctype="multipart/form-data">
                                @csrf

                                <div class="mt-3">
                                    <label for="">POSISI</label>
                                </div>
                                <div class="input-group">

                                    <div class="form-outline" data-mdb-input-init>

                                        <input type="search" id="posisi" name="posisi" class="form-control" placeholder="Search" />

                                    </div>
                                    <button type="button" class="btn btn-primary" data-mdb-ripple-init
                                        id="showitemModal">
                                        <i class="feather-16" data-feather="search"></i>
                                    </button>
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary"> <i class="feather-16" data-feather="printer"></i> Print</button>
                                    <a href="{{route('all.item')}}" class="btn btn-danger">Back</a>
                                </div>


                                
                            </form>

                        </div>
                    </div>

                </div>
            </div>
            <!-- middle wrapper end -->
            <!-- right wrapper start -->

            <!-- right wrapper end -->
        </div>

    </div>





    <!-- Modal for displaying item details -->
    <div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="itemModalLabel">item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="dataTableExamples" class="table table-hover">
                        <thead>
                            <tr>

                                <th>posisi</th>
                            </tr>
                        </thead>
                        <tbody id="itemData">
                            <!-- item data will be dynamically populated here -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- Add additional buttons if needed -->
                </div>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function() {
            // Initialize the DataTable

            $('#posisi').val('');
            var table;

            // CSRF token for secure requests
            var token = $('meta[name="csrf-token"]').attr('content');

            // Function to load data via AJAX and populate the DataTable
            function loaditemData() {
                $.ajax({
                    url: "{{ route('get.posisi') }}", // Adjust to your route
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    success: function(response) {
                        if (table) {
                            table.clear().rows.add(response.map(function(posisi) {
                                return [posisi];
                            })).draw();
                        } else {
                            table = $('#dataTableExamples').DataTable({
                                paging: true,
                                searching: true,
                                ordering: true,
                                info: true,
                                data: response.map(function(posisi) {
                                    return [posisi];
                                }),
                                columns: [{
                                    title: "posisi"
                                }]
                            });

                            // Add click event listener to table rows
                            $('#dataTableExamples tbody').on('click', 'tr', function() {
                                var data = table.row(this).data();
                                $('#posisi').val(data[0]);
                                $('#itemModal').modal('hide'); // Hide modal after selection
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            // Show the modal and load data when the button is clicked
            $('#showitemModal').click(function() {
                $('#itemModal').modal('show');
                loaditemData();
            });

            // Adjust columns once the modal is fully shown
            $('#itemModal').on('shown.bs.modal', function() {
                if (table) {
                    table.columns.adjust().draw();
                }
            });

            $('#myForm button[type="submit"]').click(function() {
            $('#myForm').attr('target', '_blank').submit();
        });

           

        });
    </script>




@endsection
