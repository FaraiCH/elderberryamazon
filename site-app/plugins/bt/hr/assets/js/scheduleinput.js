
    $(document).ready(function(){

       $('body').on('click','#clearsearch',function(){
          $("#previewquote").empty();
      });


        $( "#previewquote" ).on( "change", '.form-control',function() {
  			 $(this).parent("td").css( "background", "yellow" );
  			 var id = $(this).closest("form").attr("id");
  			 $("#"+id+" .btsubmit").removeClass("autosubmit");
  			 $("#"+id+" .btsubmit").addClass("btn-muted");
  			 $("#"+id+" .btsubmit").addClass("btn-primary");
  			 $("#btn_updatedids").show("slow");

		});        
		$( "#previewquote" ).on( "click", '#btn_updatedids',function() {

			$( ".autosubmit" ).each(function() {
			  // $( this ).addClass( "btn-danger" );
			  $( this ).trigger( "click" );

			});

		});   
		
       
    });

