$(function() {
    
    $.ajaxSetup({cache: false});

    function supports_history_api() {
      return !!(window.history && history.pushState);
    }

    function swapPhoto(link) {
        $(".carousel-content").animate({opacity:0}, 200, function(){
            $.ajax(
                {
                   type:'POST',
                   url:'item.php',
                   cache: false,
                   data:"nombre-famoso=" + link.href.split("/").pop() + "&timestamp=" + new Date().getTime(),
                   success: function(data){
                        $(".carousel-content").animate({opacity:1}, 300);    
                        $(".carousel-content").html(data);
                        FB.XFBML.parse();
                        twttr.widgets.load()
                        return true;
                   }
                }
             );
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
    
    $(document).on("swipeleft", ".carousel-content, .foto, .stage, #carousel-image", function(){
        $(".slide-right").click();
    });
    $(document).on("swiperight", ".carousel-content, .foto, .stage, #carousel-image", function(){
        $(".slide-left").click();
    });

    if (!supports_history_api()) { 
        return; 
    }
    
});