// npm package: datatables.net-bs5
// github link: https://github.com/DataTables/Dist-DataTables-Bootstrap5
// $(document).ready(function () {
//   var table = $('#dataTableExample').DataTable({
//     dom: 'Bfrtip',
//     lengthChange: false,
//     buttons: ['excel','colvis']
//   });

//   table.buttons().container()
//     .appendTo('#example_wrapper .col-md-6:eq(0)');
// });


$(function() {
  'use strict';

  $(function() {
    var table = $('#dataTableExample').DataTable({
      responsive: true,

      
   
      
      // columnDefs: [{ width: 200, targets: 4 }],
    // fixedColumns: true,
    // paging: false,
    // scrollCollapse: true,
    // scrollX: true,
    // scrollY: 300
     
      // dom: 'Bfrtip',
      // "aLengthMenu": [
      //   [10, 30, 50, -1],
      //   [10, 30, 50, "All"]
      // ],
      // buttons: [ {extend:'excel' ,exportOptions: {stripHtml: true }},'pdf' ],
      // "iDisplayLength": 10,
      // "language": {
      //   search: ""
      // }
    });


    $('#dataTableExample').each(function() {
      var datatable = $(this);
      // SEARCH - Add the placeholder for Search and Turn this into in-line form control
      var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
      search_input.attr('placeholder', 'Search');
      search_input.removeClass('form-control-sm');
      // LENGTH - Inline-Form control
      var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
      length_sel.removeClass('form-control-sm');
    });
  });

});