
    $(document).ready(function(){
        $( ".datepicker" ).datepicker({
            dateFormat: 'yy-mm-dd',
        onSelect: function(datetext) {
            var d = new Date(); // for now

            var h = d.getHours();
            h = (h < 10) ? ("0" + h) : h ;

            var m = d.getMinutes();
            m = (m < 10) ? ("0" + m) : m ;

            var s = d.getSeconds();
            s = (s < 10) ? ("0" + s) : s ;

            datetext = datetext + " " + h + ":" + m + ":00";

            $(this).val(datetext);
        },
            changeYear: true 
        });

    $( ".startpicker" ).datepicker({
            dateFormat: 'yy-mm-dd',
        onSelect: function(datetext) {
            var d = new Date(); // for now

            var h = d.getHours();
            h = (h < 10) ? ("0" + h) : h ;

            var m = d.getMinutes();
            m = (m < 10) ? ("0" + m) : m ;

            var s = d.getSeconds();
            s = (s < 10) ? ("0" + s) : s ;

            datetext = datetext + " " + "00" + ":" + "00" + ":00";

            $(this).val(datetext);
        },
            changeYear: true 
        });
    $( ".endpicker" ).datepicker({
            dateFormat: 'yy-mm-dd',
        onSelect: function(datetext) {
            var d = new Date(); // for now

            var h = d.getHours();
            h = (h < 10) ? ("0" + h) : h ;

            var m = d.getMinutes();
            m = (m < 10) ? ("0" + m) : m ;

            var s = d.getSeconds();
            s = (s < 10) ? ("0" + s) : s ;

            datetext = datetext + " " + "23" + ":" + "59" + ":59";

            $(this).val(datetext);
        },
            changeYear: true 
        });



        $( ".datetimepicker" ).datepicker({
            dateFormat: 'yy-mm-dd',
        onSelect: function(datetext) {
            var d = new Date(); // for now

            var h = d.getHours();
            // h = (h < 10) ? ("0" + h) : h ;

            var m = d.getMinutes();
            // m = (m < 10) ? ("0" + m) : m ;

            var s = d.getSeconds();
            // s = (s < 10) ? ("0" + s) : s ;

            datetext = datetext + " " + h + ":" + m + ":00";

            $(this).val(datetext);
            $(this).trigger('keyup')
        },
            changeYear: true 
        });
			        
       
    });

