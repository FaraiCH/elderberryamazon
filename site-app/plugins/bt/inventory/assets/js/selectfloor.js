$(document).ready(function () {
    
        $('body').on('click','.boxoveryes',function(){          
            $('.boxoveryes').empty();
            $('.boxoveryes').removeClass("boxselected");
             $(this).addClass("boxselected");
            $(this).empty().html('<i class="fa fa-check"></i>');
            $("#floorblock").val( $(this).data("id"));
        });




});


    $(document).ready(function(){
        $( ".datepicker" ).datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true 
        }).attr('readonly', 'readonly');

			        
       
    });



