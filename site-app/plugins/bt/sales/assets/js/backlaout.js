$(document).ready(function(){
    //  $('.table').DataTable();

    $('.tablesimple').DataTable( {
        "pageLength": 25
    } );

    $('.tabledownload').DataTable( {
        "pageLength": 25,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: ':contains("Office")'
                }
            },
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    } );


    $('.tabledownload_desc').DataTable( {
        "pageLength": 25,
        "order": [[ 0, "desc" ]],
        "scrollX": true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: ':contains("Office")'
                }
            },
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],

    } );

    $('.tabledownload_desc tbody')
        .on( 'mouseenter', 'td', function () {
            var colIdx = table.cell(this).index().column;
            $( table.cells().nodes() ).removeClass( 'highlight' );
        } );

    $(".dt-button").addClass("btn");
    $(".dt-button").addClass("btn-info");
    $(".dt-button").addClass("btn-sm");
    $(".dt-buttons").addClass("pull-left");
} );

// In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.pickme').select2();
});
