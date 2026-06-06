
    $(document).ready(function(){

        
        $( ".popthis" ).prepend( "<a class='popbtn btn btn-default oc-icon-expand'><i class='fa fa-expand' aria-hidden='true'></i></a>" );

         $('body').on('click','.popbtn.oc-icon-expand',function(){ 
                  
            $(this).removeClass("oc-icon-expand");
            $(this).addClass("oc-icon-window-close");
            $(this).empty().append('<i class="fa fa-times" aria-hidden="true"></i>');
            $(this).parent().closest('.popthis').addClass("popout");
        });

         $('body').on('click','.popbtn.oc-icon-window-close',function(){
            $(this).addClass("oc-icon-expand");
            $(this).removeClass("oc-icon-window-close");
            $(this).parent().closest('.popthis').removeClass("popout");
             $(this).empty().append("<i class='fa fa-expand' aria-hidden='true'></i>");
        });

     

     
    });

  