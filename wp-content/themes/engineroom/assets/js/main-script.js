(function( $ ) {
    "use strict";
/*----------------------------------------------------------------------*/
/* =  Menu Smooth scrolling
/*----------------------------------------------------------------------*/
    // var scrollLink = $('ul.pr-main-menu li a, .page-template-template-one-page-builder .pr__mobile__nav .menu .ul-menu > li >a');
    var scrollLink = $('body.home ul.pr-main-menu li a, .home.page-template-template-one-page-builder .pr__mobile__nav .menu .ul-menu > li >a');
        
    // Smooth scrolling
    scrollLink.click(function() {
        console.log('scroll masuk');
        if (!$(this).parent().hasClass('menu-item-has-children'))
        {
        $('body,html').animate({
            scrollTop: $(this.hash).offset().top-68
        }, 800, 'easeInExpo' );
        }
    });
/*----------------------------------------------------------------------*/
/* =  Mobile Menu Toggle
/*----------------------------------------------------------------------*/

    $('<div class="mobile-navigation-overlay"></div>').insertBefore('.mobile-navigation');
    $('.nav-toggle, .close-tigger, .mobile-navigation-overlay').on('click', function() {
        $('body, .mobile-navigation, .mobile-navigation-inner, .mobile-navigation-overlay').toggleClass('mobile-menu-opened');
    });

/*----------------------------------------------------------------------*/
/* =  Mobile Menu List
/*----------------------------------------------------------------------*/
    
    $(".pr__mobile__nav .ul-menu ul").slideUp(600);
        
    $(".pr__mobile__nav .ul-menu > li.menu-item-has-children > a").on("click", function (e) {
        $(".pr__mobile__nav .ul-menu ul").slideUp(600);
        if (!$(this).next().is(":visible")) {
            $(this).next().slideDown(600);
        }
        e.preventDefault();
    });
    $(".pr__mobile__nav .ul-menu > li.menu-item-has-children > ul > li.menu-item-has-children > a").on("click", function (e) {
        $(".pr__mobile__nav .ul-menu ul ul").slideUp(600);
        if (!$(this).next().is(":visible")) {
            $(this).next().slideDown(600);
        }
        e.preventDefault();
    });

/*----------------------------------------------------------------------*/
/* =  Add parent class If submenu goes outside
/*----------------------------------------------------------------------*/
function menus_dropdown_conditionally_open() {
    $(".primary-navigation .sub-menu .menu-item.menu-item-has-children").each(function(){ 
      if($(this).children('ul').length == 1) {
        var parent = $(this);
        var child_menu = $(this).children('ul');
        if( $(parent).offset().left + $(parent).width() + $(child_menu).width() > $(window).width() ){
          $(child_menu).addClass('pixe-left-align-sub-menu');
        } 
      }
    });
  };
  menus_dropdown_conditionally_open();

/*----------------------------------------------------------------------*/
/* =  Sticky Header Initialisation
/*----------------------------------------------------------------------*/
var sticky_nav = $('.pixe_sticky_header_holder .pr-primary-navigation > nav > ul.pr-main-menu');

var sticky = $('.pixe_sticky_header_holder');
UIkit.util.on(sticky, 'active', function () {
    sticky.addClass('show_sticky');
    UIkit.scrollspyNav(sticky_nav, {
        "offset": 0, 
        "closest": 'li', 
        "scroll": true,
    });

});
 
UIkit.util.on(sticky, 'inactive', function () {
    sticky.removeClass("show_sticky");
    UIkit.scrollspyNav(sticky_nav).$destroy();
});

var off_canvas = $('#navbar-mobile');

UIkit.util.on(off_canvas, 'shown', function () {
    off_canvas.addClass('offcanvas_anime')
});
UIkit.util.on(off_canvas, 'hidden', function () {
    off_canvas.removeClass('offcanvas_anime')
});

})(jQuery);