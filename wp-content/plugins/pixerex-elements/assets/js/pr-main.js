(function($){

    //PR Progress Bar Handler
    var PRProgressBarWidgetHandler = function ($scope,$){
        var progressbarElement = $scope.find('.pr-progressbar-progress-bar').each(function(){
            
            var settings = $(this).data('settings');
            
            var length  = settings['progress_length'];
            
            $(this).animate({width: length + '%'} , length * 25);
        });
    };
    //PR Progress Bar on Scroll Handler
    var PRProgressBarScrollWidgetHandler = function ($scope,$){
        elementorFrontend.waypoint($scope, function (direction) {
            PRProgressBarWidgetHandler($(this), $);
        }, {
            offset: $.waypoints('viewportHeight') - 150,
            triggerOnce: true
        });
    };

    //PR Grid Handler
    var WidgetPRPostGridHandler = function ($scope, $) {

        var $grid =  $scope.find('.pr-post-grid');
    
         $grid.imagesLoaded( function() {
    
          $grid.masonry({
              itemSelector: '.pr-grid-post',
              percentPosition: true,
              columnWidth: '.pr-post-grid-column'
            });
    
          });
    
    };
    
    //PR Testimonials Carousel Handler
    var WidgetPRTestimonialsSliderHandler = function ($scope, $) {
      
        var testimonials_elem = $scope.find('.pr-testimonial-slider').eq(0);
  
        var settings = testimonials_elem.data('settings');
        var a = 0;
  
        testimonials_elem.slick({
            autoplay: settings['pr_testimonial_slider_autoplay'],
            infinite: settings['pr_testimonial_slide_infinite'],
            speed: settings['pr_testimonial_slide_speed'],
            slidesToShow: settings['pr_testimonial_max_items'],
            slidesToScroll: settings['pr_testimonial_slide_item'],
            arrows: settings['pr_arrows'],
            appendArrows: $('.pr-nav-id-'+settings['pr-nav-id']),
            nextArrow: '<i class="icon icon-arrow-right"></i>',
            prevArrow: '<i class="icon icon-arrow-left"></i>',
            dots: settings['pr_dots'],
            pauseOnHover: settings['pr_testimonial_slider_pause_hover'],
            draggable: settings['pr_testimonial_slide_draggable'],
            responsive: [
                {
                  breakpoint: 1024,
                  settings: {
                    slidesToShow: settings['pr_testimonial_max_tab_item'],
                    slidesToScroll: 1
                  }
                },
                {
                  breakpoint: 768,
                  settings: {
                    slidesToShow: settings['pr_testimonial_max_mobile_item'],
                    slidesToScroll: 1
                  }
                }
              ]
        });
  
  
    };

    //PR Post Carousel Handler
    var WidgetPRPostCarouselHandler = function ($scope, $) {
        var Pr_Blog_Carousel   = $scope.find('.blog-slider').eq(0),
            settings = Pr_Blog_Carousel.data('settings'),
            $autoplay = settings['pr_blog_carousel_autoplay'],
            $pause_on_hover = settings['pr_blog_carousel_pause_hover'];

		var PrBlogCarousel = new Swiper( Pr_Blog_Carousel, {
			direction     : 'horizontal',
			speed         : settings['pr_blog_carousel_speed'],
			effect        : 'slide',
			centeredSlides: settings['pr_blog_carousel_center_mode'],
			slidesPerView : settings['pr_blog_carousel_max_items'],
			spaceBetween  : settings['pr_blog_carousel_gap'],
			grabCursor    : settings['pr_blog_carousel_grab'],
			autoHeight    : true,
			loop          : settings['pr_blog_carousel_infinite'],
			autoplay: {
				delay: settings['pr_blog_carousel_autoplay_speed'],
			},
			pagination: {
				el       :'.swiper-pagination',
				clickable: true,
			},
			breakpoints: {
				480: {
					slidesPerView: settings['pr_blog_carousel_mobile_items'],
					spaceBetween : settings['pr_blog_carousel_mobile_gap']
				},
				768: {
					slidesPerView: settings['pr_blog_carousel_tab_items'],
					spaceBetween : settings['pr_blog_carousel_tab_gap']
				}
			}
        });
        
        if(!$autoplay) {
			PrBlogCarousel.autoplay.stop();
        }
        
        if($pause_on_hover && $autoplay) {
            Pr_Blog_Carousel.on('mouseenter', function() {
                PrBlogCarousel.autoplay.stop();
            });
            Pr_Blog_Carousel.on('mouseleave', function() {
                PrBlogCarousel.autoplay.start();
            });
        }
    };

    //PR Team Carousel Handler
    var WidgetPRPersonCarouselHandler = function ($scope, $) {
    
        var testimonials_elem = $scope.find('.pr-team-slider').eq(0);
    
        var settings = testimonials_elem.data('settings');
    
        testimonials_elem.slick({
            autoplay: settings['pr_team_slider_autoplay'],
            infinite: settings['pr_team_slide_infinite'],
            speed: settings['pr_team_slide_speed'],
            slidesToShow: settings['pr_team_slider_max_items'],
            slidesToScroll: settings['pr_team_slide_item'],
            arrows: settings['pr_team_arrows'],
            dots: settings['pr_team_dots'],
            pauseOnHover: settings['pr_team_slider_pause_hover'],
            draggable: settings['pr_team_slide_draggable'],
            centerMode: settings['pr_team_slide_center_mode'],
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                    slidesToShow: settings['pr_team_max_tab_item'],
                    slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                    slidesToShow: settings['pr_team_max_mobile_item'],
                    slidesToScroll: 1
                    }
                }
                ]
        });
    
    };

     //PR Image Carousel Handler
     var WidgetPRImageCarouselHandler = function ($scope, $) {
    
        var testimonials_elem = $scope.find('.pr-main-adv-carousel').eq(0);
    
        var settings = testimonials_elem.data('settings');
    
        testimonials_elem.slick({
            autoplay: settings['pr_carousel_image_autoplay'],
            infinite: settings['pr_carousel_image_infinite'],
            speed: settings['pr_carousel_image_speed'],
            slidesToShow: settings['pr_carousel_image_max_items'],
            slidesToScroll: settings['pr_carousel_image_slide_item'],
            arrows: settings['pr_carousel_image_arrows'],
            dots: settings['pr_carousel_image_dots'],
            pauseOnHover: settings['pr_carousel_image_pause_hover'],
            draggable: settings['pr_carousel_image_draggable'],
            centerMode: settings['pr_carousel_image_center_mode'],
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                    slidesToShow: settings['pr_carousel_image_max_tab_item'],
                    slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                    slidesToShow: settings['pr_carousel_image_max_mobile_item'],
                    slidesToScroll: 1
                    }
                }
                ]
        });
    
    };

    //PR Grid Handler
    var PRGridWidgetHandler = function($scope,$){    
        if ($().isotope === undefined) {
            return;
        }
        var gridElement = $scope.find('.pr-img-portfolio');
        if (gridElement.length === 0) {
            return;
        }
        var htmlContent = $scope.find('.pr-portfolio-container');
        var isotopeOptions = htmlContent.data('settings');
        if(isotopeOptions['img_size'] === 'original'){
            htmlContent.isotope({
            // options
                itemSelector: '.pr-portfolio-item',
                percentPosition: true,
                animationOptions: {
                    duration: 750,
                    easing: 'linear',
                    queue: false
                }
            });
            htmlContent.imagesLoaded(function () {
                htmlContent.isotope({layoutMode: 'masonry'});
            });
        } else if(isotopeOptions['img_size'] === 'one_size'){
            
            htmlContent.isotope({
            // options
                itemSelector: '.pr-portfolio-item',
                percentPosition: true,
                animationOptions: {
                    duration: 750,
                    easing: 'linear',
                    queue: false
                }
            });
            htmlContent.imagesLoaded(function () {
                htmlContent.isotope({layoutMode: 'fitRows'});
            });
        }
        $scope.find('.pr-portfolio-cats-container li a').click(function(e){
            e.preventDefault();        
            $scope.find('.pr-portfolio-cats-container li .active').removeClass('active');
            $(this).addClass('active');
            var selector = $(this).attr('data-filter');
            htmlContent.isotope({filter: selector});
            return false;
        });
    };

    //PR Fancy Text Handler

	//PR Countdown Handler
    var PRCountDownHandler = function ($scope,$){
        var countDownElement = $scope.find('.pr-countdown').each(function(){
            var countDownSettings = $(this).data('settings');
            var label1 = countDownSettings['label1'],
                label2 = countDownSettings['label2'],
                newLabe1 = label1.split(','),
                newLabe2 = label2.split(',');
                if(countDownSettings['event'] === 'onExpiry'){
                    $(this).find('.pr-countdown-init').pr_countdown({
                        labels 		: newLabe2,
                        labels1 	: newLabe1,
                        until 		: new Date( countDownSettings['until'] ),
                        format 		: countDownSettings['format'],
                        padZeroes	: true,
                        onExpiry    : function() {
                            $(this).html(countDownSettings['text']);
                        },
                        serverSync : function() { return new Date(countDownSettings['serverSync']); }
                    });
                } else if(countDownSettings['event'] === 'expiryUrl') {
                    $(this).find('.pr-countdown-init').pr_countdown({
                        labels 		: newLabe2,
                        labels1 	: newLabe1,
                        until 		: new Date( countDownSettings['until'] ),
                        format 		: countDownSettings['format'],
                        padZeroes	: true,
                        expiryUrl   : countDownSettings['text'],
                        serverSync : function() { return new Date(countDownSettings['serverSync']); }
                    });
                }
                times = $(this).find('.pr-countdown-init').pr_countdown('getTimes');
                function runTimer( el ) {
                    return el == 0;
                    }
                if( times.every( runTimer ) ) {
                    if( countDownSettings['event'] === 'onExpiry' ){
                        $(this).find('.pr-countdown-init').html(countDownSettings['text']);
                    }
                    if( countDownSettings['event'] === 'expiryUrl' ){
                        var editMode = $('body').find('#elementor').length;
                        if( editMode > 0 ) {
                            $(this).find('.pr-countdown-init').html( '<h1>You can not redirect url from elementor Editor!!</h1>' );
                        } else {
                            window.location.href = countDownSettings['text'];
                        }
                    }				
                }
            });
        };
        
    //Elementor JS Hooks
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/pr-img-gallery.default',PRGridWidgetHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/pr-countdown-timer.default',PRCountDownHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/pr-testimonialslider.default', WidgetPRTestimonialsSliderHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/pr-personcarousel.default', WidgetPRPersonCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/pr-imagecarousel.default', WidgetPRImageCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/pr-postgrid.default', WidgetPRPostGridHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/pr-postcarousel.default', WidgetPRPostCarouselHandler);
        if(elementorFrontend.isEditMode()){
            elementorFrontend.hooks.addAction('frontend/element_ready/pr-progressbar.default', PRProgressBarWidgetHandler);
        } else {
            elementorFrontend.hooks.addAction('frontend/element_ready/pr-progressbar.default', PRProgressBarScrollWidgetHandler);
        }
    });
})(jQuery);
