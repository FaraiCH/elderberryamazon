$(document).ready(function(){

    $('.tabledownload_desc').DataTable( {
        "searching" : true,
        "bLengthChange": false,
        "autoWidth": false,
        "pageLength": 25,
        "order": [[ 0, "desc" ]],
        "scrollX": true,
    } );

} );


function additemjs(batch, jobcard, controlsheet){
    var itemcount = $( "#table-body tr" ).length;
    var item = '<input name="controlsheet" type="hidden" value="'+ controlsheet +'">' +
        '<td width="20%">' +
            '<input type="hidden" name="stickerCount_" value="'+ itemcount +'">' +
            '<div class="row">' +
                '<div class="col-md-6 col-sm-6 col-xs-6">' +
                    '<input class="form-control" type="number" data-request="onCheckNum" data-track-input="" name="sticker_id" id="sticker_id">' +
                '</div>'+
                '<div class="col-md-6 col-sm-6 col-xs-6">' +
                    '<input class="form-control" type="number" data-request="onCheckNum" data-track-input="" name="counter" id="counter">' +
                '</div>'+

            '</div>' +
            '<div id="sticker_no_" >' +
            '</div>' +
        '</td>';
    item += '<td width="10%"><input class="form-control" type="number" name="unit_length" id="unit_length" placeholder="Input Length" step="0.01"/></td>';
    item += '<td width="10%"><input class="form-control" type="number" name="unit_weight" id="unit_weight" placeholder="Input Weight" step="0.01"/></td>';
    item += '<td width="10%"> <select class="form-control custom-select" name="is_scrap" id="is_scrap">'+
                '<option value="0">No</option>' +
                '<option value="1">Yes</option>' +
            '</select></td>';
    item += '<td width="10%">None</td>';
    item += '<td width="10%"><button class="btn btn-outline-primary" data-request="onSaveStickerEdit">Save</button></td>';
    item = '<tr id="stickerlist_'+itemcount+'" tdcount="'+itemcount+'">'+item+'</tr>';

    $( "#table-body" ).append(  item );
    $('#createsticker').prop( "disabled", true );
    var buttons = document.querySelectorAll('.edit_button');

    // Iterate through each button
    buttons.forEach(function(button) {
        // Check innerHTML before disabling
        if (button.innerHTML === 'Edit') {
            // Disable the button
            button.disabled = true;
        }
        // You can add more conditions as needed
    });
}

function checkSave(id, value){
    $('#createsticker').prop( "disabled", true );

    $( "#"+id ).removeClass( "edit_button" );

    var buttons = document.querySelectorAll('.edit_button');

    // Iterate through each button
    buttons.forEach(function(button) {
        // Check innerHTML before disabling
        if (button.innerHTML === 'Edit') {
            // Disable the button
            button.disabled = true;
        }
        // You can add more conditions as needed
    });
}


