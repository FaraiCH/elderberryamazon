/*
 * This is a sample JavaScript file used by InputCurrency
 *
 * You can delete this file if you want
 */

  $(document).ready(function(){

        $('body').on('change','input.inputcurrencymin',function(){
            inputcurrencyvaluemin($(this));
        });
    });

function inputcurrencymin(){
            
    $('input.inputcurrencymin').each(function(){
       
        inputcurrencyvaluemin($(this));
     });
}


 function inputcurrencyvaluemin(obj){
        obj.val(obj.val().replace(/\s|R|,/g, ''));
        if(obj.val() && obj.val() > 0 ){
                obj.val("R "+parseFloat( obj.val(), 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString().split(".")[0]);
        }else{
            obj.val("");
        }
}
          