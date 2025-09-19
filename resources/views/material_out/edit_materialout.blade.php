 @extends('admin.admin_dashboard')

 @section('admin')

     <div class="page-content">
         <div class="row">
             <div class="col-md-12 grid-margin stretch-card">
                 <div class="card">
                     <div class="card-body">
                         <div class="row">

                             <div class="container">
                                 <form action="{{ route('update.materialout', $materialOUT->id) }}" method="POST">
                                     @csrf
                                     <!-- Material IN Fields -->
                                     <div class="text-center">
                                         <h3>EDIT MATERIAL OUT</h3>
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

                                         <div class="col-md-3">

                                             <div class="form-group row">
                                                 <label for="material_in_no" class="col-sm-3 col-form-label">OUT
                                                     No</label>
                                                 <div class="col-sm-9">

                                                     <p>{{ $materialOUT->material_out_no }}</p>

                                                 </div>
                                             </div>

                                         </div>

                                         <div class="col-md-3">
                                             <div class="form-group row">
                                                 <label for="allocation" class="col-sm-3  col-form-label">Allocat</label>
                                                 <div class="col-sm-9">
                                                     <select class="form-select form-select-sm" style="width: 100%;"
                                                         id="allocation" name="allocation">
                                                         <option value="RELAX"
                                                             {{ $materialOUT->allocation == 'RELAX' ? 'selected' : '' }}>
                                                             RELAX</option>
                                                         <option value="DISPOSE"
                                                             {{ $materialOUT->allocation == 'DISPOSE' ? 'selected' : '' }}>
                                                             DISPOSE</option>
                                                         <option value="RETURN SUPPLIER"
                                                             {{ $materialOUT->allocation == 'RETURN SUPPLIER' ? 'selected' : '' }}>
                                                             RETURN SUPPLIER</option>
                                                     </select>
                                                 </div>
                                             </div>
                                         </div>

                                         <!-- NO SJ Field -->
                                         <div class="col-md-3">
                                             <div class="form-group row">
                                                 <label for="person" class="col-sm-3 col-form-label">Person</label>
                                                 <div class="col-sm-9">
                                                     <input type="text" class="form-control form-control-sm"
                                                         id="person" name="person" value="{{ $materialOUT->person }}">
                                                 </div>
                                             </div>
                                         </div>

                                         <!-- Location and Courier Fields -->
                                         <div class="col-md-3">

                                             <div class="form-group row">
                                                 <label for="remark" class="col-sm-4 col-form-label">Date</label>
                                                 <div class="col-sm-5">
                                                     <input type="date" class="form-control" id="remark"
                                                         name="remark" value="{{ $materialOUT->remark }}" required>
                                                 </div>
                                             </div>

                                         </div>
                                     </div>
                                     <hr>

                                     <!-- Material IN Details Fields -->
                                     <div class="row">
                                         <div class="">
                                             <button type="button" class="btn btn-secondary btn-sm mb-2"
                                                 id="add-detail">Add
                                                 Detail</button>

                                             <h6>OUT Items</h6>
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

                                                             <th>MO</th>

                                                             <th>STYLE</th>

                                                             <th>QTY</th>

                                                             <th>Action</th>
                                                         </tr>
                                                     </thead>
                                                     <tbody id="details-containerx">
                                                         @foreach ($materialOUT->details as $index => $detail)
                                                             <tr>

                                                                 <td><input type="text"
                                                                         name="details[{{ $index }}][item_code]"
                                                                         class="form-control item_code"
                                                                         value="{{ $detail->item_code }}"
                                                                         placeholder="Item Code" required></td>

                                                                 <td><input type="text"
                                                                         name="details[{{ $index }}][item_name]"
                                                                         class="form-control item_name"
                                                                         value="{{ $detail->item->item_name }}"
                                                                         placeholder="Item Name" required></td>

                                                                 <td><input type="text"
                                                                         name="details[{{ $index }}][color_code]"
                                                                         class="form-control color_code"
                                                                         value="{{ $detail->color_code }}"
                                                                         placeholder="Color Code"></td>
                                                                 <td><input type="text"
                                                                         name="details[{{ $index }}][color_name]"
                                                                         class="form-control color_name"
                                                                         value="{{ $detail->color_name }}"
                                                                         placeholder="Color Name"></td>

                                                                 <td><input type="text"
                                                                         name="details[{{ $index }}][size]"
                                                                         class="form-control size"
                                                                         value="{{ $detail->size }}" placeholder="Size">
                                                                 </td>
                                                                 <td><input type="text"
                                                                         name="details[{{ $index }}][unit]"
                                                                         class="form-control unit"
                                                                         value="{{ $detail->item->unit->unit_name }}"
                                                                         placeholder="Unit"></td>

                                                                 <td><input type="text"
                                                                         name="details[{{ $index }}][mo]"
                                                                         class="form-control mo"
                                                                         value="{{ $detail->mo }}" placeholder="MO">
                                                                 </td>

                                                                 <td><input type="text"
                                                                         name="details[{{ $index }}][style]"
                                                                         class="form-control style"
                                                                         value="{{ $detail->style }}" placeholder="style">
                                                                 </td>

                                                                 <td><input type="text"
                                                                         name="details[{{ $index }}][qty]"
                                                                         class="form-control qty"
                                                                         value="{{ $detail->qty }}">
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

     <div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="itemModalLabel">Items</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                     <table id="items-table" class="table table-hover">
                         <thead>
                             <tr>
                                 <th>No</th>
                                 <th>Item Code</th>
                                 <th>Item Name</th>
                                 <th>Color Code</th>
                                 <th>Color Name</th>
                                 <th>Size</th>
                                 <th>Unit</th>
                                 <th>Category</th>

                             </tr>
                         </thead>
                         <tbody id="data_item">
                             <!-- Employee data will be dynamically populated here -->
                         </tbody>
                     </table>
                 </div>

             </div>
         </div>
     </div>

     <script>
         $(document).ready(function() {


             setTimeout(function() {
                 $('.alert-danger').fadeOut('slow');
             }, 6000);


             $(document).ready(function() {
                 let rowIndex = 1;
                 //  update_totals();

                 $('#add-detail').click(function() {
                     add_row();
                 });

                 $(document).on('click', '.remove-detail', function() {
                     $(this).closest('tr').remove();
                     update_totals();
                 });

                 function add_row() {

                     let newRow = `
               <tr class="detail-row">
                    <td><input type="text" name="details[${rowIndex}][item_code]" class="form-control item_code" placeholder="item_code" required></td>
                    <td><input type="text" name="details[${rowIndex}][item_name]" class="form-control item_name" placeholder="Item Name"></td>
                    <td><input type="text" name="details[${rowIndex}][unit]" class="form-control unit" placeholder="unit"></td>
                    <td><input type="text" name="details[${rowIndex}][color_code]" class="form-control color_code" placeholder="Color Code"></td>
                    <td><input type="text" name="details[${rowIndex}][color_name]" class="form-control color_name" placeholder="Color Name"></td>
                   
                    <td><input type="text" name="details[${rowIndex}][size]" class="form-control size" placeholder="size"></td>
        
                    <td><input type="text" name="details[${rowIndex}][qty]" class="form-control qty" placeholder="Qty"></td>
                 
                    <td><input type="text" name="details[${rowIndex}][style]" class="form-control style" placeholder="STYLE"></td>
                    <td><input type="text" name="details[${rowIndex}][mo]" class="form-control mo" placeholder="MO"></td>
                 
             
                    <td><button type="button" class="btn btn-danger btn-sm remove-detail">Remove</button></td>
                </tr>
            `;
                     $('#details-containerx').append(newRow);
                     rowIndex++;
                     $('#details-containerx').find('tr:last .item_code').focus();
                     // update_totals();

                 }

                 function checkDuplicate(originalNo, row) {
                     let isDuplicate = false;
                     $('#details-containerx tr').each(function() {
                         if ($(this).get(0) === row.get(0)) {
                             return; // Skip the current row
                         }
                         let existingNo = $(this).find('.item_code').val().trim();
                         if (existingNo === originalNo && originalNo !== '') {
                             isDuplicate = true;
                             return false; // Exit loop early
                         }
                     });
                     return isDuplicate;
                 }




                 $(document).on('click', '.item_code', function() {
                     selectedInput = $(this); // Store the input element
                     $('#itemModal').modal('show');
                     loadItems(); // Call function to load items via Ajax


                 });




                 //  $(document).on('blur', 'input[name$="[qty]"]', function() {
                 //      let row = $(this).closest('tr');
                 //      let qty = parseFloat($(this).val()) || 0;
                 //      let stok = parseFloat(row.find('input[name$="[stok]"]').val()) || 0;

                 //      if (qty > stok) {
                 //          const swalWithBootstrapButtons = Swal.mixin({
                 //              customClass: {
                 //                  confirmButton: 'btn btn-success',
                 //                  cancelButton: 'btn btn-danger me-2'
                 //              },
                 //              buttonsStyling: false,
                 //          });

                 //          swalWithBootstrapButtons.fire({
                 //              title: 'Insufficient Stock!',
                 //              text: 'Quantity exceeds available stock!',
                 //              icon: 'error',
                 //              timer: 2000,
                 //              timerProgressBar: true,
                 //              willClose: () => {
                 //                  // Optional: Add any additional actions you want to perform after the alert closes
                 //              }
                 //          });

                 //          $(this).val(''); // Clear the quantity field
                 //      }
                 //  });






                 // $(document).on('keydown', '.rak_relax', function(e) {
                 //     if (e.key === 'Enter') {
                 //         e.preventDefault(); // Prevent form submission on Enter key
                 //         add_row();
                 //     }
                 // });



                 // $(document).on('input', '.rak_relax', function(e) {
                 //     update_totals();
                 // });

                 // $(document).on('input', '.original_no', function(e) {
                 //     update_totals();
                 // });


                 // $(document).on('input', '.roll, .qty', function() {
                 //     update_totals();
                 // });

                 function update_totals() {
                     let totalRolls = 0;
                     let totalQty = 0;

                     let countFilledRows = 0; // Initialize counter for rows with filled original_no

                     // $('#details-containerx tr').each(function() {
                     //     let originalNoValue = $(this).find('input[name$="[original_no]"]').val().trim();
                     //     let qtyValue = parseFloat($(this).find('input[name$="[qty]"]').val());

                     //     if (originalNoValue) {
                     //         countFilledRows++; // Increment count if original_no is filled
                     //     }

                     //     if (!isNaN(qtyValue)) {
                     //         totalQty += qtyValue;
                     //     }
                     // });

                     // $('#total-rolls').text(countFilledRows);
                     // $('#total-qty').text(totalQty.toFixed(2));
                 }


             });

             function loadItems() {
                 $('#items-table tbody').empty();

                 $.ajax({
                     url: '{{ route('get.stockglobal') }}', // Sesuaikan dengan route yang benar
                     method: 'GET',
                     headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                     success: function(data) {
                         // Inisialisasi DataTable
                         table = $('#items-table').DataTable({
                             paging: true,
                             searching: true,
                             ordering: true,
                             destroy: true,
                             info: true,
                             data: data,
                             columns: [{
                                     title: "No", // Change column title to "No"
                                     data: null, // Use `null` since this column doesn't pull from the data source
                                     render: function(data, type, row, meta) {
                                         return meta.row +
                                             1; // `meta.row` gives the current row index, starting from 0
                                     }
                                 },
                                 {
                                     title: "Item Code",
                                     data: "item_code"
                                 },
                                 {
                                     title: "Item Name",
                                     data: "item.item_name"
                                 },
                                 {
                                     title: "color code",
                                     data: "color_code"
                                 },
                                 {
                                     title: "color name",
                                     data: "color_name"
                                 },
                                 {
                                     title: "Unit",
                                     data: "item.unit.unit_code" // Sesuaikan dengan struktur data JSON dari relasi
                                 },
                                 {
                                     title: "category",
                                     data: "item.category.name" // Sesuaikan dengan struktur data JSON dari relasi
                                 },
                                 {
                                     title: "Stock",
                                     data: "stok"
                                 }
                             ]
                         });

                         // Tambahkan event handler untuk setiap baris tabel
                         $('#items-table tbody').on('click', 'tr', function() {

                             var data = table.row(this).data();
                             console.log(data.item.item_name);
                             // selectedInput.val(data.id); // Mengambil ID item
                             $(selectedInput).closest('.detail-row').find('.item_code').val(data
                                 .item_code);
                             $(selectedInput).closest('.detail-row').find('.item_name').val(data
                                 .item
                                 .item_name);
                             $(selectedInput).closest('.detail-row').find('.color_code').val(data
                                 .color_code);
                             $(selectedInput).closest('.detail-row').find('.color_name').val(data
                                 .color_name);
                             $(selectedInput).closest('.detail-row').find('.size').val(data
                                 .size);
                             $(selectedInput).closest('.detail-row').find('.unit').val(data.item
                                 .unit
                                 .unit_code);
                             $(selectedInput).closest('.detail-row').find('.stok').val(data
                                 .stok);
                             $('#itemModal').modal('hide');
                         });
                     },
                     error: function(xhr, status, error) {
                         console.error(xhr.responseText);
                     }
                 });
             }










             //  $(document).on('keydown', '.original_no', function(event) {

             //      const swalWithBootstrapButtons = Swal.mixin({
             //          customClass: {
             //              confirmButton: 'btn btn-success',
             //              cancelButton: 'btn btn-danger me-2'
             //          },
             //          buttonsStyling: false,
             //      })




             //      if (event.keyCode === 13) { // 13 adalah kode untuk tombol Enter
             //          event.preventDefault(); // Mencegah aksi default tombol Enter








             //          let originalNo = $(this).val().trim();
             //          let row = $(this).closest('tr');

             //          let originalNoInput = $(this).closest('tr').find('.original_no').val().trim();
             //          let itemCodeInput = $(this).closest('tr').find('.item_code').val().trim();


             //          if (originalNoInput && itemCodeInput) {
             //              // Move focus to actual_weight
             //              row.find('input[name$="[actual_weight]"]').focus();
             //          }



             //          if (originalNo) {
             //              if (checkDuplicate(originalNo, row)) {
             //                  swalWithBootstrapButtons.fire({
             //                      title: 'Duplicate!',
             //                      text: `Duplicate Original No detected!`,
             //                      icon: 'error',
             //                      timer: 2000,
             //                      timerProgressBar: true,
             //                      willClose: () => {
             //                          // Optional: Add any additional actions you want to perform after the alert closes
             //                      }
             //                  })
             //                  $(this).val(''); // Clear the input field
             //              } else {
             //                  $.ajax({
             //                      url: '/get/qr_codein/' + originalNo,
             //                      type: 'GET',
             //                      success: function(response) {
             //                          row.find('input[name$="[receive_date]"]').val(response
             //                              .received_date || '');
             //                          row.find('input[name$="[supplier_name]"]').val(response
             //                              .supplier_name || '');
             //                          row.find('input[name$="[item_code]"]').val(response
             //                              .item_code ||
             //                              '');
             //                          row.find('input[name$="[po]"]').val(response.po || '');
             //                          row.find('input[name$="[color_code]"]').val(response
             //                              .color_code || '');
             //                          row.find('input[name$="[color_name]"]').val(response
             //                              .color_name || '');
             //                          row.find('input[name$="[batch]"]').val(response.batch ||
             //                              '');
             //                          row.find('input[name$="[roll]"]').val(response.roll || '');
             //                          row.find('input[name$="[gross_weight]"]').val(response
             //                              .gross_weight || '');
             //                          row.find('input[name$="[net_weight]"]').val(response
             //                              .net_weight || '');
             //                          row.find('input[name$="[qty]"]').val(response.qty || '');
             //                          row.find('input[name$="[basic_width]"]').val(response
             //                              .basic_width || '');
             //                          row.find('input[name$="[basic_grm]"]').val(response
             //                              .basic_grm ||
             //                              '');
             //                          row.find('input[name$="[mo]"]').val(response.mo || '');

             //                          row.find('input[name$="[actual_weight]"]').focus();

             //                          // add_row(); 
             //                      },
             //                      error: function() {

             //                          swalWithBootstrapButtons.fire({
             //                              title: 'Not Found!',
             //                              text: `Data not found!`,
             //                              icon: 'error',
             //                              timer: 2000,
             //                              timerProgressBar: true,
             //                              willClose: () => {
             //                                  // Optional: Add any additional actions you want to perform after the alert closes
             //                              }
             //                          })
             //                          row.find('input').val('');
             //                      }
             //                  });
             //              }
             //          }
             //      }
             //  });

         });
     </script>
 @endsection
