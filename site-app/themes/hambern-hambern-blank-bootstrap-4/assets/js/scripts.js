$(document).ready(function () {
    new WOW().init();
      var x = 0;

        $('#main-menu a').each (function(){
            x++;
            var link = $(this).attr('href');
            if (!/^(f|ht)tps?:\/\//i.test(link)) {
              link = document.location.origin + link;
            }

            var str = $(location).attr('href'); 
            var res = str.match(link);
            if(x < 2){
              res = null;
            }
           
            if (link == $(location).attr('href') || res ){
              $(this).addClass('active');
              $(this).parent("li").addClass('active');
              $(this).parents("li.dropdown").addClass('active');
              $(this).parents("ul.sidenav-second-level").addClass('show');
                
            }else
                $(this).addClass('not_selected').removeClass('selected');
      });


});

function goBack() {
  window.history.back();
}
