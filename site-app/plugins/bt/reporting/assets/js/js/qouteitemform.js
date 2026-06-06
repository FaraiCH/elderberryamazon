var itemcount = 0;
var itemcountfx = 0;
$(document).ready(function(){
 
    $('body').on('change','#quote_status_id',function(){
    	$(".fhide").hide();
      
      if($(this).val() == 4){
        $("#deliveryamount_holder").show();
      }

      if($(this).val() == 6){
        $("#amountdiscount_holder").show();
      }

      if($(this).val() ==9 || $(this).val() == 10 || $(this).val() == 13){
        $("#supporting_file_holder").show();
      }

      if($(this).val() == 13){
        $("#amountpaid_holder").show();
      }

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

    
});
