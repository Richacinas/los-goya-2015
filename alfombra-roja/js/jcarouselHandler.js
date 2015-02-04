$(function() {
    
    $.ajaxSetup({cache: false});

    function supports_history_api() {
      return !!(window.history && history.pushState);
    }

    function swapPhoto(link) {
        $(".carousel-content").animate({opacity:0}, 300, function(){
            $.ajax(
                {
                   type:'POST',
                   url:'item.php',
                   cache: false,
                   data:"nombre-famoso=" + link.href.split("/").pop() + "&timestamp=" + new Date().getTime(),
                   success: function(data){
                        $(".carousel-content").animate({opacity:1}, 500);    
                        $(".carousel-content").html(data);
                        $(".carousel-content").fadeIn('slow');
                        FB.XFBML.parse();
                        twttr.widgets.load()
                        return true;
                   }
                }
             );
          
          
//        var req = new XMLHttpRequest();
//        req.open("GET",
//                 "item.php?nombre-famoso=" + link.href.split("/").pop() + "&timestamp=" + new Date().getTime(),
//                 true);
//        req.send(null);
//        req.onreadystatechange=function() 
//        {
//            if ((req.status == 200) && (req.readyState == 4)) {
//              $(".carousel-content").animate({opacity:1}, 500);    
//              $(".carousel-content").html(req.responseText);
//              $(".carousel-content").fadeIn('slow');
//              FB.XFBML.parse();
//              twttr.widgets.load()
//              return true;
//            }
//        }
      });
      return true;
    }
    
    $(document).on('click', ".slide-left, .slide-right, .slide-pager-option", function(e){
        if (swapPhoto(this.children[0])) {
          //$(".carousel-content").animate({opacity:1},1000);
          history.pushState(null, null, this.children[0].href);
          e.preventDefault();
          return false;
        }
    });

    if (!supports_history_api()) { 
        return; 
    }
    
});