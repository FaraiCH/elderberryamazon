var itemcount = 0;
var second_itemcount = 0;

var item_name = 0;
var itemcountfx = 0;
$(document).ready(function(){
    additemjs();
    checkstatus();
    $('body').on('click','#additemjs',function(){

        additemjs();
    });
    $('body').on('click','#cleardeliveryjs',function(){
        $( "#additemdeliveryholder" ).empty();
    });
    $('body').on('click','#adddeliveryItem',function(){
        adddeliveryjs();
    })
    $('body').on('click','#addseconditemjs',function(){

        addseconditemjs();
    })

    $('body').on('click','#clearitemjs',function(){
        $( "#additemholder" ).empty();
    });

    $('body').on('change','#requestdelivery',function(){
        checkstatus();
    });

    $('body').on('change','#amountdiscount_perc',function(){
        checkstatus();
    });

    $('body').on('change','#deliveryamounthidden',function(){
        checkstatus();
    });

    $('body').on('change','#deliveryamount',function(){
        checkstatus();
    });


    $('body').on('click','#clearsecondjs',function(){

        $( "#additionalholder" ).empty();
    });


    $("#quotecopy").chosen().change(function(){
        $( "#flterbtn" ).trigger( "click" );
    });


    $('body').on('click','.removeitem',function(){
        var obj = $(this).attr('for');
        alert(obj);
        $("#"+obj).remove();
        $( "#updatepreview" ).trigger( "click" );
    });

    $('body').on('click','#updatepreview',function(){
        var arr = [];
        var error = "";

        itemcountfx++;
        $( "#additemholder .itemfrm" ).each(function( index ) {

            if($(this).val() > 0){
                arr.push($(this).attr('id')+"_"+itemcountfx+":"+$(this).val());
            }else{
                error = $(this).attr('title');
            }
        });
        if(error){
            alert(error+" id required");
        }else{

            $(this).removeAttr('data-request-data');
            $(this).attr('data-request-data',arr.join(','));
        }



    });

    function additemjs(){
        var itemcount = $( "#additemholder tr" ).length + 1;

        if($( "#additemholder tr" ).length > 0){
            itemcount = parseInt($("#additemholder tr:last-child").attr("tdcount")) + 1
        }




        var item = '<td>'+itemcount+'</td><td><select title="Item '+itemcount+': Product" name="product_'+itemcount+'" id="product_'+itemcount+'" class="select_search itemfrm">'+$("#additem_product").html()+'</select></td>';
        item += '<td><input title="Item '+itemcount+': Unit Length" style="width: 60px;" type="text"  placeholder="0.0" name="unitlength_'+itemcount+'" id="unitlength_'+itemcount+'" class="itemfrm"></td>';
        item += '<td><input style="min-width:80px;width:100%; text-align: center;" value="1" title="Item '+itemcount+': Units" name="units_'+itemcount+'" id="units_'+itemcount+'" type="number" class="itemfrm"/></td>';
        item += '<td><input style="min-width:80px;width:100%; text-align: center;" value="38.78" title="Item '+itemcount+': Price" step="0.01" name="priceperkg_'+itemcount+'" id="priceperkg_'+itemcount+'" type="number" class="itemfrm"/></td>';
        item += '<td><a for="tritem_'+itemcount+'" class="btn btn-primary btn-sm removeitem py-0" style="color:#fff"><i class="fa fa-trash"></i></a></td>';
        item = '<tr id="tritem_'+itemcount+'" tdcount="'+itemcount+'">'+item+'</tr>';
        $( "#additemholder" ).append(  item );

        var config = { '.select_search': {} }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
        $(".chosen-container").css({width: '100%' });
    }





    function addseconditemjs(){
        var second_itemcount = $( "#additionalholder tr" ).length + 1;

        if($( "#additionalholder tr" ).length > 0){
            second_itemcount = parseInt($("#additionalholder tr:last-child").attr("tdcount")) + 1
        }

        var item = '<td>'+second_itemcount+'</td><td><select onchange="onChangeItem(this.id,this.value)" attrid="'+second_itemcount+'" title="Item '+second_itemcount+': Product" name="catalogue_'+second_itemcount+'" id="catalogue_'+second_itemcount+'" class="select_search itemfrm form-control">'+$("#addseconditem_product").html()+'</select></td>';
        item += '<td><input style="min-width:180px;width:100%; text-align: center;" required="required" value="0.00" title="Item '+second_itemcount+': Price" step="0.01" name="catunitprice_'+second_itemcount+'" id="catunitprice_'+second_itemcount+'" type="number" class="itemfrm"/></td>';
        item += '<td><input style="width:100px; text-align: center;" value="1" title="Item '+second_itemcount+': Units" name="catalogue_units_'+second_itemcount+'" id="catalogue_units_'+second_itemcount+'" type="number" class="itemfrm"/></td>';

        item += '<td><a for="tritem_'+second_itemcount+'" class="btn btn-primary btn-sm removeitem py-0" style="color:#fff"><i class="fa fa-trash"></i></a></td>';
        item = '<tr id="tritem_'+second_itemcount+'" tdcount="'+second_itemcount+'">'+item+'</tr>';
        $( "#additionalholder" ).append(  item );

        str = $('#catalogue_'+second_itemcount).find("option:first-child").text();
        // Using regex to extract the second number
        var matches = str.match(/\d+(?:\.\d+)?/g); // Extract all numbers
        var secondNumber = matches[2]; // Accessing the second number

        $('#catunitprice_'+second_itemcount).val(secondNumber);


        item_name = 'catalogue_'+second_itemcount;

        var config = { '.select_search': {} }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
        $(".chosen-container").css({width: '100%' });



    }



    function checkstatus(){

        var d = $("#requestdelivery").val();
        var p = $("#amountdiscount_perc").val();

        if( d > 0){
            adddeliveryjs();
        }else{
            $("#deliveryaddress").prop( "required", false );
            $("#quotedivrememeber").hide();
        }

        if( p > 0){
            $("#discountnotes").prop( "required", true );
        }else{
            $("#discountnotes").prop( "required", false );
        }

        if((d+p) > 0){
            $("#set_status_1").prop( "disabled", true );
            $("#set_status_1").prop( "checked", false );
            $("#set_status_1_text").addClass( "text-muted");

        }else{
            $("#set_status_1").prop( "disabled", false );

            $("#set_status_1_text").removeClass( "text-muted");
        }
    }
});

function additemjs_load(product_id, units, unitlength, priceperkg){
    var checkMe = document.getElementById("excludeitems").checked;

    if(checkMe == false)
    {
        itemcount++;
        var item = '<td>'+itemcount+'</td><td><select title="Item ' +itemcount+': Product" name="product_'+itemcount+'" id="product_'+itemcount+'" class="select_search itemfrm">'+$("#additem_product").html()+'</select></td>';
        item += '<td><input title="Item '+itemcount+': Unit Length" style="width: 60px;" type="text"  placeholder="0.0" name="unitlength_'+itemcount+'" id="unitlength_'+itemcount+'" class="itemfrm"></td>';
        item += '<td><input style="min-width:80px;width:100%; text-align: center;" value="1" title="Item '+itemcount+': Units" name="units_'+itemcount+'" id="units_'+itemcount+'" type="number" class="itemfrm"/></td>';
        item += '<td><input style="min-width:80px;width:100%; text-align: center;" value="38.78" title="Item '+itemcount+': Price" step="0.01" name="priceperkg_'+itemcount+'" id="priceperkg_'+itemcount+'" type="number" class="itemfrm"/></td>';

        item += '<td><a for="tritem_'+itemcount+'" class="btn btn-primary btn-sm removeitem py-0" style="color:#fff"><i class="fa fa-trash"></i></a></td>';
        item = '<tr id="tritem_'+itemcount+'" tdcount="'+itemcount+'">'+item+'</tr>';
        $( "#additemholder" ).append(  item );

        $('#product_'+itemcount).val(product_id);
        $('#unitlength_'+itemcount).val(unitlength);
        $('#units_'+itemcount).val(units);
        $('#priceperkg_'+itemcount).val(priceperkg);
    }
    var config = { '.select_search': {} }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
    $(".chosen-container").css({width: '100%' });
}

function addseconditemjs_load(product_id, units, price){
    var second_itemcount = $( "#additionalholder tr" ).length + 1;

    if($( "#additionalholder tr" ).length > 0){
        second_itemcount = parseInt($("#additionalholder tr:last-child").attr("tdcount")) + 1
    }

    var item = '<td>'+second_itemcount+'</td><td><select onchange="onChangeItem(this.id,this.value)" attrid="'+second_itemcount+'" title="Item '+second_itemcount+': Product" name="catalogue_'+second_itemcount+'" id="catalogue_'+second_itemcount+'" class="select_search itemfrm form-control">'+$("#addseconditem_product").html()+'</select></td>';
    item += '<td><input style="min-width:180px;width:100%; text-align: center;" required="required" value="0.00" title="Item '+second_itemcount+': Price" step="0.01" name="catunitprice_'+second_itemcount+'" id="catunitprice_'+second_itemcount+'" type="number" class="itemfrm"/></td>';
    item += '<td><input style="width:100px; text-align: center;" value="1" title="Item '+second_itemcount+': Units" name="catalogue_units_'+second_itemcount+'" id="catalogue_units_'+second_itemcount+'" type="number" class="itemfrm"/></td>';

    item += '<td><a for="tritem_'+second_itemcount+'" class="btn btn-primary btn-sm removeitem py-0" style="color:#fff"><i class="fa fa-trash"></i></a></td>';
    item = '<tr id="tritem_'+second_itemcount+'" tdcount="'+second_itemcount+'">'+item+'</tr>';
    $( "#additionalholder" ).append(  item );

    str = $('#catalogue_'+second_itemcount).find("option:first-child").text();
    // Using regex to extract the second number
    var matches = str.match(/\d+(?:\.\d+)?/g); // Extract all numbers
    var secondNumber = matches[2]; // Accessing the second number

    $('#catunitprice_'+second_itemcount).val(secondNumber);


    item_name = 'catalogue_'+second_itemcount;

    $('#catalogue_'+second_itemcount).val(product_id);
    $('#catunitprice_'+second_itemcount).val(price);
    $('#catalogue_units_'+second_itemcount).val(units);

    var config = { '.select_search': {} }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
    $(".chosen-container").css({width: '100%' });



}

function onChangeItem(id, value){
    str = $('#'+ id).find(":selected").text();
    // Using regex to extract the second number
    // Using split to extract the number after 'R'
    var afterR = str.split("X R")[1]; // Extracting the part after 'R'

// Trimming any extra whitespace
    afterR = afterR.trim();

    var just_id_number =  id.match(/\d+(?:\.\d+)?/g);

    $('#catunitprice_'+just_id_number[0]).val(afterR);
}

function adddeliveryjs(){
    let itemcount = $( "#additemdeliveryholder #deliver-item" ).length + 1;

    if($( "#additemdeliveryholder tr" ).length > 0){
        itemcount = parseInt($("#additemdeliveryholder tr:last-child").attr("tdcount")) + 1
    }

    let item = `
    <tr class="w-100" id="tritem_del_${itemcount}" tdcount="${itemcount}">
      <td>
        <strong>${itemcount}</strong>
      </td>
      <td>
        <div class="row">
          <div class="form-group col-md-4">
            <label for="delivery_type_${itemcount}">Delivery Type:</label>
            <select title="Item ${itemcount}: Delivery Type" name="delivery_type_${itemcount}" id="delivery_type_${itemcount}"  class="form-control select_search itemfrm">${$("#delivery_type").html()}</select>
          </div>

          <div class="form-group col-md-4">
            <label for="destination_${itemcount}">Destination:</label>
            <br />
            <select required title="Item ${itemcount}: Destination" name="destination_${itemcount}" id="destination_${itemcount}"  class="form-control select_search itemfrm">${$("#destination").html()}</select>
          </div>

          <div class="form-group col-md-4">
            <label for="vehicle_type_${itemcount}">Vehicle Type:</label>
            <br />
            <select required title="Item ${itemcount}: Vehicle Type" name="vehicle_type_${itemcount}" id="vehicle_type_${itemcount}"   class="form-control select_search itemfrm">${$("#vehicle_type").html()}</select>
          </div>

          <div class="form-group col-md-4">
            <label for="trip_qty_${itemcount}">Trip Qty:</label>
            <br />
            <select required title="Item ${itemcount}: Vehicle Type" name="trip_qty_${itemcount}" id="trip_qty_${itemcount}"   class="form-control select_search itemfrm">${$("#trip_qty").html()}</select>
          </div>

          <div class="form-group col-md-4">
            <label for="discount_${itemcount}">Discount %:</label>
            <br />
            <input type="number" class="form-control" name="discount_${itemcount}" title="Item ${itemcount}: Discount" value="0" />
          </div>

          <div class="form-group form-check col-md-4" style="display:flex;align-items:end;">
            <div>
              <input type="checkbox" class="hide_quote_${itemcount}" name="hide_quote_${itemcount}" id="hide_quote_${itemcount}">
              <label for="checkbox_${itemcount}">Hide On Quote:</label>
            </div>
          </div>

          <div class="form-group col-md-12">
            <label>Comments:</label>
            <br />
            <textarea class="form-control" id="exampleFormControlTextarea1" name="comment_delivery_${itemcount}" rows="3"></textarea>
          </div>
        </div>
      </td>
      <td><a for="tritem_del_${itemcount}" class="btn btn-primary btn-sm removeitem py-0" style="color:#fff"><i class="fa fa-trash"></i></a></td>
    </tr>
  `;

    $("#additemdeliveryholder").append(item);

    var config = { '.select_search': {} }

    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }

    $(".chosen-container").css({width: '100%' });
}

