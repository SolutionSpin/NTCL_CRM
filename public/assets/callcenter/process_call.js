$(document).ready( function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //console.log("test");
    // fetch data
    var table = $('#process_call_datya').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/agent/call-center/fatch-process-call",
            data: function (d) {
              }
          },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'name', name: 'name'},
            { data: 'dir_name', name: 'dir_name'},
            { data: 'designation', name: 'designation'},
            { data: 'phone', name: 'phone'},
            { data: 'call_status', name: 'call_status'},
            { data: 'action', name: 'action'}

        ],
        order: [[0, 'asc']],
        responsive: true,
        sorting: true,
        scrollX: true,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: 'lfBrtip',
        buttons:
        [
            {
                extend: 'colvis',
                postfixButtons: [ 'colvisRestore' ]
            },
            {
                extend: 'excel',
                title: 'Goods Receive Notes Report',
                exportOptions: {
                    columns: 'th:not(:last-child)'
                }
            },
            {
                extend: 'csv',
                title: 'Goods Receive Notes Report',
                exportOptions: {
                    columns: 'th:not(:last-child)'
                }
            },
            {
                extend: 'pdf',
                title: 'Goods Receive Notes Report',
                exportOptions: {
                    columns: 'th:not(:last-child)'
                }
            },
            {
                extend: 'print',
                title: 'Goods Receive Notes Report',
                exportOptions: {
                    columns: 'th:not(:last-child)'
                }
            },
            {
                extend: 'copy',
                title: 'Goods Receive Notes Report',
                exportOptions: {
                    columns: 'th:not(:last-child)'
                }
            }
        ],
        columnDefs: [
            {
                className: "dt-center",
                targets: [-1,-2,-3,-4]
            }

        ]
    });

    $('#filter').click(function(){
        //console.log("test");
        
        table.draw();
    });
});



$("#exportExcel").on("click", function() {
    $('.buttons-excel').click()
});
$("#exportPrint").on("click", function() {
    $('.buttons-print').click()
});
$("#exportCsv").on("click", function() {
    $('.buttons-csv').click()
});
$("#exportPdf").on("click", function() {
    $('.buttons-pdf').click()
});
$("#exportCopy").on("click", function() {
    $('.buttons-copy').click()
});
