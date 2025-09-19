@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content mt-5">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <form id="itemForm" name="itemForm" action="" method="POST">
                                @csrf
                                <div class="alert alert-danger print-error-msg" style="display: none;">
                                    <ul></ul>
                                </div>
                                <input type="hidden" name="item_idx" id="item_idx">

                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>ITEM</h5>
                                        <hr>
                                        <div class="row mb-3">
                                            <label class="form-label col-md-3 col-form-label" for="item_name">Code:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="item_code" name="item_code" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="form-label col-md-3 col-form-label" for="item_name">Name:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="item_name" name="item_name" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="form-label col-md-3 col-form-label" for="description">Description:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="description" name="description">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="form-label col-md-3 col-form-label">Category</label>
                                            <div class="col-sm-9">
                                                <select id="category" name="category_id" class="js-example-basic-single form-select" style="width: 100%">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="form-label col-md-3 col-form-label">Unit</label>
                                            <div class="col-sm-9">
                                                <select id="unit" name="unit_id" class="js-example-basic-single form-select" style="width: 100%">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="form-label col-md-3 col-form-label" for="reorder_level">Reorder Level:</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" id="reorder_level" name="reorder_level" min="0" required>
                                            </div>
                                        </div>
                                    </div>

                              
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
            $('#itemForm').on('submit', function(e) {
                var reorderLevel = $('#reorder_level').val();
                var invalid = false;

                $('#variantsTable tbody tr').each(function() {
                    var qtyOnHand = $(this).find('input[name*="[quantity_on_hand]"]').val();
               

                    if (qtyOnHand === '' || parseFloat(qtyOnHand) < 0 || unitPrice === '' || parseFloat(unitPrice) < 0) {
                        invalid = true;
                    }
                });

                if (reorderLevel === '' || parseFloat(reorderLevel) < 0 || invalid) {
                    alert('All numeric fields must be non-negative numbers.');
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
                    var select = $('#category');
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
                    var select = $('#unit');
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
    </script>
@endsection
