
    $(document).ready(function(){



  			 $(".bg_red").parent("td").css( "background", "red" );
  			 $(".bg_yellow").parent("td").css( "background", "orange" );


  			 $(".maketooltip").tooltip({
                position: {
                    my: "left+15 top",
                    at: "left top"
                }
            }).tooltip("open");

       $('body').on('click','#clearsearch',function(){
          $("#previewquote").empty();
      });

        $( "#previewquote" ).on( "click", 'input.form-control',function() {
                
                if ($(this).val() == 0 || $(this).val() == "0.00") {
                    $(this).val('');
                }

        });
        
        $( "#previewquote" ).on( "keyup", 'input.form-control',function() {

        		$.request('onSaveCTItem',{data: {value: $(this).val(),citemid: $(this).attr('data-id'),mat_id: $(this).attr('data-mat_id'),name: $(this).attr('name')}}

        			);

  			 $(this).parent("td").css( "background", "yellow" );


		});

        $( "#previewquote" ).on( "change", 'select.form-control',function() {

        		$.request('onSaveCTItem',{data: {value: $(this).val(),citemid: $(this).attr('data-id'),mat_id: $(this).attr('data-mat_id'),name: $(this).attr('name')}}

        			);

  			 $(this).parent("td").css( "background", "yellow" );


		});
         $( "#previewquote" ).on( "change", 'input.datetimepicker',function() {

        		$.request('onSaveCTItem',{data: {value: $(this).val(),citemid: $(this).attr('data-id'),mat_id: $(this).attr('data-mat_id'),name: $(this).attr('name')}}

        			);

  			 $(this).parent("td").css( "background", "yellow" );


		});
		$( "#previewquote" ).on( "click", '#btn_updatedids',function() {

			$( ".autosubmit" ).each(function() {
			  // $( this ).addClass( "btn-danger" );
			  $( this ).trigger( "click" );

			});

		});


    });

