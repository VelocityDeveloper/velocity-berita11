jQuery(function($) {
    $(window).scroll(function() {    
        var scroll = $(window).scrollTop();
        if (scroll >= 200) {
            $(".header-position").addClass("fixedHeader");
        } else {
            $(".header-position").removeClass("fixedHeader");
        }
    });
});