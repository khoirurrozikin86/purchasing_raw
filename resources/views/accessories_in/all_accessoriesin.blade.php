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
                                    <h6 class="card-title text-center">ACCESSORIES IN</h6>
                                </div>

                            </div>

                        </div>

                        <hr>

                        <div class="row">
                            <div class="col">

                                <div class="btn-group" role="group" aria-label="Basic example">

                                </div>
                            </div>
                        </div>

                        <div class="row mb-3 px-6">

                            <div class="col-md-4 d-flex align-items-center">
                                <label for="startDate" class="col-sm-3">FROM</label>
                                <input type="date" id="startDate" name="start_date" class="form-control"
                                    placeholder="Start Date" required>
                            </div>
                            <div class="col-md-4 d-flex align-items-center">
                                <label for="endDate" class="col-sm-3">TO</label>
                                <input type="date" id="endDate" class="form-control" name="end_date"
                                    placeholder="End Date" required>
                            </div>
                            <div class="col-md-4">
                                <button id="filterBtn" class="btn btn-primary">Filter</button>
                                <button id="exportBtn" class="btn btn-success"> &nbsp;Export Excel</button>
                                {{-- <a href="{{ route('add.materialinsp') }}" class="btn btn-primary"> &nbsp;Add Data</a> --}}
                            </div>
                        </div>

                        <div class="table-responsive mt-2" id="cbdTablex" style="display: none;">

                            <table id="cbdTable" class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>IN No</th>
                                        <th>SUPPLIER</th>
                                        <th>Item Code</th>
                                        <th>Item Name</th>
                                        <th>Unit</th>
                                        <th>Col Code</th>
                                        <th>Color Name</th>
                                        <th>Size</th>

                                        <th>Batch</th>
                                        <th>No Roll</th>
                                        <th>qty</th>
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



            var table = $('#cbdTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('get.materialin') }}",
                    data: function(d) {
                        d.startDate = $('#startDate').val();
                        d.endDate = $('#endDate').val();
                    },
                    dataSrc: function(json) {
                        // Show table once data is loaded
                        $('#cbdTablex').show();
                        return json.data;
                    }
                },

                columns: [{
                        "data": "DT_RowIndex",
                        "name": "DT_RowIndex",
                        "searchable": false
                    },
                    {
                        "data": "material_in_no",
                        "name": "material_in_no"
                    },
                    // {
                    //     "data": "supplier_name",
                    //     "name": "supplier_name",
                    //     "render": function(data, type, row) {
                    //         // Limit the supplier name to 25 characters
                    //         if (type === 'display' && data.length > 10) {
                    //             return data.substr(0, 10) + '...';
                    //         }
                    //         return data;
                    //     }
                    // },
                    // {
                    //     "data": "created_at",
                    //     "name": "date_in_house",
                    //     "render": function(data, type, row) {
                    //         var date = new Date(data);
                    //         var year = date.getFullYear();
                    //         var month = ("0" + (date.getMonth() + 1)).slice(-
                    //             2); // Adding leading zero
                    //         var day = ("0" + date.getDate()).slice(-2); // Adding leading zero
                    //         return year + '-' + month + '-' + day;
                    //     }
                    // },
                    // {
                    //     "data": "no_sj",
                    //     "name": "no_sj"
                    // },
                    // {
                    //     "data": "received_by",
                    //     "name": "received_by"
                    // },
                    // {
                    //     "data": "location",
                    //     "name": "location"
                    // },
                    // {
                    //     "data": "courier",
                    //     "name": "courier"
                    // },


                    {
                        "data": "supplier_name",
                        "name": "supplier_name",
                        "render": function(data, type, row) {
                            if (Array.isArray(row.item_details) && row.item_details.length > 0) {
                                var suppliers = '<ul>';
                                row.item_details.forEach(function(item) {
                                    suppliers += (item.supplier_name ? '<li>' + item
                                        .supplier_name + '</li>' :
                                        '');
                                });
                                suppliers += '</ul>';
                                return suppliers;
                            } else {
                                return '';
                            }
                        }
                    },
                    {
                        "data": "item_code",
                        "name": "item_code",
                        "render": function(data, type, row) {
                            if (Array.isArray(row.item_details) && row.item_details.length > 0) {
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
                            if (Array.isArray(row.item_details) && row.item_details.length > 0) {
                                var items = '<ul>';
                                row.item_details.forEach(function(item) {
                                    var itemName = item.item_name;
                                    if (itemName.length > 10) {
                                        itemName = itemName.substring(0, 10) + '...';
                                    }
                                    items += '<li>' + itemName + '</li>';
                                });
                                items += '</ul>';
                                return items;
                            } else {
                                return '';
                            }
                        }
                    },
                    {
                        "data": "unit",
                        "name": "unit",
                        "render": function(data, type, row) {
                            if (Array.isArray(row.item_details) && row.item_details.length > 0) {
                                var sizes = '<ul>';
                                row.item_details.forEach(function(item) {
                                    sizes += '<li>' + (item.unit_code ? item.unit_code :
                                        '-') + '</li>';
                                });
                                sizes += '</ul>';
                                return sizes;
                            } else {
                                return '';
                            }
                        }
                    },
                    {
                        "data": "color_code",
                        "name": "color_code",
                        "render": function(data, type, row) {
                            if (Array.isArray(row.item_details) && row.item_details.length > 0) {
                                var color_codes = '<ul>';
                                row.item_details.forEach(function(item) {
                                    color_codes += (item.color_code ? '<li>' + item
                                        .color_code + '</li>' :
                                        '');
                                });
                                color_codes += '</ul>';
                                return color_codes;
                            } else {
                                return '';
                            }
                        }
                    },
                    {
                        "data": "color_name",
                        "name": "color_name",
                        "render": function(data, type, row) {
                            if (Array.isArray(row.item_details) && row.item_details.length > 0) {
                                var color_names = '<ul>';
                                row.item_details.forEach(function(item) {
                                    color_names += (item.color_name ? '<li>' + item
                                        .color_name + '</li>' :
                                        '');
                                });
                                color_names += '</ul>';
                                return color_names;
                            } else {
                                return '';
                            }
                        }
                    },
                    {
                        "data": "size",
                        "name": "size",
                        "render": function(data, type, row) {
                            if (Array.isArray(row.item_details) && row.item_details.length > 0) {
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
                        "data": "batch",
                        "name": "batch",
                        "render": function(data, type, row) {
                            if (Array.isArray(row.item_details) && row.item_details.length > 0) {
                                var items = '<ul>';
                                row.item_details.forEach(function(item) {
                                    items += (item.batch ? '<li>' + item.batch + '</li>' :
                                        '');
                                });
                                items += '</ul>';
                                return items;
                            } else {
                                return '-';
                            }
                        }
                    },
                    {
                        "data": "roll",
                        "name": "roll",
                        "render": function(data, type, row) {
                            if (Array.isArray(row.item_details) && row.item_details.length > 0) {
                                var items = '<ul>';
                                row.item_details.forEach(function(item) {
                                    items += (item.roll ? '<li>' + item.roll +
                                        '</li>' : '');
                                });
                                items += '</ul>';
                                return items;
                            } else {
                                return '';
                            }
                        }
                    },
                    {
                        "data": "qty",
                        "name": "qty",
                        "render": function(data, type, row) {
                            if (Array.isArray(row.item_details) && row.item_details.length > 0) {
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
                        "data": "mo",
                        "name": "mo",
                        "render": function(data, type, row) {
                            if (Array.isArray(row.item_details) && row.item_details.length > 0) {
                                var items = '<ul>';
                                row.item_details.forEach(function(item) {
                                    items += (item.mo ? '<li>' + item.mo + '</li>' : '');
                                });
                                items += '</ul>';
                                return items;
                            } else {
                                return '';
                            }
                        }
                    },




                    {
                        "data": "action",
                        "name": "action",
                        "orderable": false,
                        "searchable": false
                    }
                ],

                "initComplete": function(settings, json) {
                    // Hide the table until the filter button is clicked
                    $('#cbdTablex').hide();
                }
            });

            $('#filterBtn').click(function() {
                var startDate = $('#startDate').val();
                var endDate = $('#endDate').val();

                if (startDate && endDate) {
                    table.ajax.reload(); // Reload data with the new filter
                } else {
                    alert('Please select both start date and end date.');
                }
            });

            $('#cbdTablex').hide();





            $('#exportBtn').click(function() {
                var startDate = $('#startDate').val();
                var endDate = $('#endDate').val();
                if (startDate && endDate) {
                    $.ajax({
                        url: "{{ route('export.materialin') }}",
                        type: 'GET',
                        data: {
                            start_date: startDate,
                            end_date: endDate
                        },
                        xhrFields: {
                            responseType: 'blob'
                        },
                        success: function(response) {
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(response);
                            link.download = 'material_in_' + startDate + '_to_' + endDate +
                                '.xlsx';
                            link.click();
                        },
                        error: function() {
                            alert('Error exporting data.');
                        }
                    });
                } else {
                    alert('Please select both start date and end date.');
                }
            });








            $('body').on('click', '.deleteMaterialin', function() {



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
                            url: "/delete/materialin/" + request_id,
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
