/*
 * This is a sample JavaScript file used by InputCurrency
 *
 * You can delete this file if you want
 */

  $(document).ready(function(){

        $('body').on('change','input.inputcurrency',function(){
            inputcurrencyvalue($(this));
        });
    });

function inputcurrency(){
            
    $('input.inputcurrency').each(function(){
       
        inputcurrencyvalue($(this));
     });
}


 function inputcurrencyvalue(obj){
        obj.val(obj.val().replace(/\s|R|,/g, ''));
        if(obj.val() && obj.val() > 0 ){
                obj.val("R "+parseFloat( obj.val(), 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
        }else{
            obj.val("");
        }
}
         