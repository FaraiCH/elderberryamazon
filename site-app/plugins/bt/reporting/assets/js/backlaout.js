$(document).ready(function(){
   
     $('body').on('click','.intab',function(){
     
         $('.content-tabs').ocTab('goTo', '\''+$(this).attr("href")+'\'');
    });
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



    $(".dt-button").addClass("btn");
    $(".dt-button").addClass("btn-info");
    $(".dt-button").addClass("btn-sm");
    $(".dt-buttons").addClass("pull-left");
} );
