var itemcount = 0;
var second_itemcount = 0;

var itemcountfx = 0;
$(document).ready(function(){
    additemjs();
    checkstatus();
    $('body').on('click','#additemjs',function(){
    	additemjs();
    });

    $('body').on('change','#requestdelivery',function(){
      checkstatus();
    });

    $('body').on('change','#amountdiscount_perc',function(){
      checkstatus();
    });


     $('body').on('click','#addseconditemjs',function(){
      addseconditemjs();
    })


    $("#quotecopy").chosen().change(function(){
      $( "#flterbtn" ).trigger( "click" );
    });


    $('body').on('click','.removeitem',function(){
       var obj = $(this).attr('for');
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
    	itemcount++;
      var item = '<td>'+itemcount+'</td><td><select title="Item '+itemcount+': Product" name="product_'+itemcount+'" id="product_'+itemcount+'" class="select_search itemfrm">'+$("#additem_product").html()+'</select></td>';
      item += '<td><input title="Item '+itemcount+': Unit Length" style="width: 60px;" type="text"  placeholder="0.0" name="unitlength_'+itemcount+'" id="unitlength_'+itemcount+'" class="itemfrm"></td>';
      item += '<td><input style="width:100%; text-align: center;" value="1" title="Item '+itemcount+': Units" name="units_'+itemcount+'" id="units_'+itemcount+'" type="number" class="itemfrm"/></td>';
      item += '<td><input style="width:100%; text-align: center;" value="26.00" title="Item '+itemcount+': Price" step="0.01" name="priceperkg_'+itemcount+'" id="priceperkg_'+itemcount+'" type="number" class="itemfrm"/></td>';
      item += '<td><a for="tritem_'+itemcount+'" class="btn btn-primary btn-sm removeitem py-0" style="color:#fff"><i class="fa fa-trash"></i></a></td>';
      item = '<tr id="tritem_'+itemcount+'">'+item+'</tr>';
      $( "#additemholder" ).append(  item );

      var config = { '.select_search': {} }
      for (var selector in config) {
       $(selector).chosen(config[selector]);
      }
      $(".chosen-container").css({width: '100%' });
    }





    function addseconditemjs(){
      second_itemcount++;
      var item = '<td>'+second_itemcount+'</td><td><select title="Item '+second_itemcount+': Product" name="catalogue_'+second_itemcount+'" id="catalogue_'+second_itemcount+'" class="select_search itemfrm form-control">'+$("#addseconditem_product").html()+'</select></td>';
      
      item += '<td><input style="width:100%; text-align: center;" value="1" title="Item '+second_itemcount+': Units" name="catalogue_units_'+second_itemcount+'" id="catalogue_units_'+second_itemcount+'" type="number" class="itemfrm"/></td>';
      item += '<td><a for="tritem_'+second_itemcount+'" class="btn btn-primary btn-sm removeitem py-0" style="color:#fff"><i class="fa fa-trash"></i></a></td>';
      item = '<tr id="tritem_'+second_itemcount+'">'+item+'</tr>';
      $( "#additionalholder" ).append(  item );
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
          $("#deliveryaddress").prop( "required", true );
       }else{
          $("#deliveryaddress").prop( "required", false );
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

 function additemjs_load(product_id,units,unitlength,priceperkg){
     
      itemcount++;
      var item = '<td>'+itemcount+'</td><td><select title="Item ' +itemcount+': Product" name="product_'+itemcount+'" id="product_'+itemcount+'" class="select_search itemfrm">'+$("#additem_product").html()+'</select></td>';
      item += '<td><input title="Item '+itemcount+': Unit Length" style="width: 60px;" type="text"  placeholder="0.0" name="unitlength_'+itemcount+'" id="unitlength_'+itemcount+'" class="itemfrm"></td>';
      item += '<td><input style="width:100%; text-align: center;" value="1" title="Item '+itemcount+': Units" name="units_'+itemcount+'" id="units_'+itemcount+'" type="number" class="itemfrm"/></td>';
      item += '<td><input style="width:100%; text-align: center;" value="26.00" title="Item '+itemcount+': Price" step="0.01" name="priceperkg_'+itemcount+'" id="priceperkg_'+itemcount+'" type="number" class="itemfrm"/></td>';

      item += '<td><a for="tritem_'+itemcount+'" class="btn btn-primary btn-sm removeitem py-0" style="color:#fff"><i class="fa fa-trash"></i></a></td>';
      item = '<tr id="tritem_'+itemcount+'">'+item+'</tr>';
      $( "#additemholder" ).append(  item );

      $('#product_'+itemcount).val(product_id);
      $('#unitlength_'+itemcount).val(unitlength);
      $('#units_'+itemcount).val(units);
      $('#priceperkg_'+itemcount).val(priceperkg);

      var config = { '.select_search': {} }
      for (var selector in config) {
       $(selector).chosen(config[selector]);
      }
      $(".chosen-container").css({width: '100%' });
    }

function addseconditemjs_load(product_id,units){
      second_itemcount++;
      var item = '<td>'+second_itemcount+'</td><td><select title="Item '+second_itemcount+': Product" name="catalogue_'+second_itemcount+'" id="catalogue_'+second_itemcount+'" class="select_search itemfrm form-control">'+$("#addseconditem_product").html()+'</select></td>';
      
      item += '<td><input style="width:100%; text-align: center;" value="1" title="Item '+second_itemcount+': Units" name="catalogue_units_'+second_itemcount+'" id="catalogue_units_'+second_itemcount+'" type="number" class="itemfrm"/></td>';
      item += '<td><a for="tritem_'+second_itemcount+'" class="btn btn-primary btn-sm removeitem py-0" style="color:#fff"><i class="fa fa-trash"></i></a></td>';
      item = '<tr id="tritem_'+second_itemcount+'">'+item+'</tr>';
      $( "#additionalholder" ).append(  item );


      $('#catalogue_'+second_itemcount).val(product_id);
      $('#catalogue_units_'+second_itemcount).val(units);

      var config = { '.select_search': {} }
      for (var selector in config) {
       $(selector).chosen(config[selector]);
      }
      $(".chosen-container").css({width: '100%' });
     
    }