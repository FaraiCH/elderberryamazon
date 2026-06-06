
    $(document).ready(function(){
        checkifscrap();
        checkifcs();
        $( "#savesticker_frm" ).on( "change", 'select#scrap',function() {
            checkifscrap();
        });
        $( "#savesticker_frm" ).on( "change", 'select#cs',function() {
            checkifcs();
        });

        $("#weight").focus(function() {
            if ($(this).val() == 0 || $(this).val() == "0.0") {
                $(this).val('');
            }
        });
    });

    function checkifcs(){

        if($("select#cs").val() > 1){
            $(".havecs").removeClass('hideme');
            $("#h_cs").removeClass('col-xs-12');
            $("#h_cs").addClass('col-xs-8');



        }else{
            $(".havecs").addClass('hideme');

            $("#h_cs").removeClass('col-xs-8');
            $("#h_cs").addClass('col-xs-12');
        }
    }

    function checkifscrap(){

        if($("select#scrap").val() == 1){
            // If scrap
            $("#h_length").hide();
            $("#h_weight").removeClass('col-xs-6');
            $("#h_weight").addClass('col-xs-12');


        }else{
            $("#h_length").show();
            $("#h_weight").removeClass('col-xs-12');
            $("#h_weight").addClass('col-xs-6');
        }
    }
