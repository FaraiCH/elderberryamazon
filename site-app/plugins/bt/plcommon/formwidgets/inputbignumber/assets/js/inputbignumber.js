/*
 * This is a sample JavaScript file used by inputbignumber
 *
 * You can delete this file if you want
 */

  $(document).ready(function(){

        $('body').on('change','input.inputbignumber',function(){
            inputbignumbervalue($(this));
        });
    });

function inputbignumber(){
            
    $('input.inputbignumber').each(function(){
       
        inputbignumbervalue($(this));
     });
}


 function inputbignumbervalue(obj){
        obj.val(obj.val().replace(/\s|R|,/g, ''));
        if(obj.val() && obj.val() > 0 ){
                obj.val(Number( obj.val(), 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString().split(".")[0]);
        }else{
            obj.val("");
        }
}
         