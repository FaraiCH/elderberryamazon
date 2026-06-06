  $(document).ready(function(){
        $( ".datepicker" ).datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true 
        }).attr('readonly', 'readonly');

                    
       
    });
  
 function updateclickcheck(idname){
        var linkobj = $("#"+idname); 
        var array = $("#updatehole").val().split(",");
        var id = linkobj.data("id");
        if(linkobj.is(":checked")){
            array.push(id);
            $("#updatehole").val(array.join(",")); 
        }else{
            var next = [];
            for( var i = 0; i < array.length; i++){ 
               if ( array[i] != id) {

                 next.push(array[i]);

               }
            }

            $("#updatehole").val(next.join(","));
            
        }
        
        var array2 = $("#updatehole").val().split(",");
        
        var next = [];
        for( var i = 0; i < array2.length; i++){ 
          
           if ( array2[i] > 0) {
             next.push(array2[i]);

           }
        }
        $("#updatehole").val(next.join(","));

        return false;
}