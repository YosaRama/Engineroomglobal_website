var mobileWidthThreshold = 1000;

document.addEventListener( 'wpcf7mailsent', function( event ) {
    location = '/thank-you/';
}, false );




jQuery(document).ready(function($){

    // Uncomment this section to enable one page scroll feature
    // Homepage One Page Scroll
    /*
    if($('body.home').length){
        $('#top .elementor-element.elementor-element-5e488ad9 > .elementor-container').addClass('show-caption');
        if($(window).width() > mobileWidthThreshold){
            $(".elementor-23 > .elementor-inner > .elementor-section-wrap").onepage_scroll({
                sectionContainer: ".fullpage-section",
                easing: "ease-in-out",               
                animationTime: 700,             
                pagination: false,               
                updateURL: false,               
                beforeMove: function(index) {
                    // console.log('before : '+index);
                    if(index > 1){
                        $('header > .pixe_header_holder').removeClass('show-header show-fast');
                    }
                    else{
                        $('.pixe_sticky_header_holder').removeClass('uk-active show_sticky uk-sticky-below uk-sticky-fixed');
                    }
                },
                afterMove: function(index) {
                    // console.log('after : '+index);
                    if(index == 1){
                        $('header > .pixe_header_holder').addClass('show-header show-fast');
                    }
                    else{
                        $('.pixe_sticky_header_holder').addClass('uk-active show_sticky uk-sticky-below uk-sticky-fixed');
                    }
                    if(index == 2){
                        $('.pricing-service-item:not(.pricing-service-item-no-border)').addClass('pricing-service-item-show');
                    }
                    if(index == 3){
                        $('.client-logo-list .client-logo-item section').addClass('show-logo');
                    }
                },   
                loop: false,
                keyboard: true,
                responsiveFallback: false,
                direction: "vertical"
            });
        }
        else{
            $('body').addClass('disabled-onepage-scroll');
        }
    }
    */

    // Uncomment this section to disable one page scroll feature
    if($(window).width() > mobileWidthThreshold){
        $('body').addClass('disabled-onepage-scroll no-onepage-scroll');
        $('#top .elementor-element.elementor-element-5e488ad9 > .elementor-container').addClass('show-caption');
        $('.pricing-service-item:not(.pricing-service-item-no-border)').addClass('pricing-service-item-show');
        $('html, body').on('scroll', function(){
            var scroll = $('body').scrollTop();
            if(scroll > 100) {
                $('header > .pixe_header_holder').removeClass('show-header show-fast');
                $('.pixe_sticky_header_holder').addClass('uk-active show_sticky uk-sticky-below uk-sticky-fixed');
            }
            else{
                $('header > .pixe_header_holder').addClass('show-header show-fast');
                $('.pixe_sticky_header_holder').removeClass('uk-active show_sticky uk-sticky-below uk-sticky-fixed');
            }
        });
    }
    else{
        $('body').addClass('disabled-onepage-scroll');
    }

    $('.portfolio-list-selector-button').on('click', function(){
        var group = $(this).attr('data-list');
        if($(this).hasClass('active')){
            $(this).removeClass('active');
            $('.portfolio-list-items').addClass('hide');
            $('.portfolio-list-items.portfolio-list-items-all').removeClass('hide');
            $('.portfolio-gallery').attr('data-list','all');
        }
        else{
            $('.portfolio-list-selector-button').removeClass('active');
            $(this).addClass('active');
            $('.portfolio-list-items').addClass('hide');
            $('.portfolio-list-items.portfolio-list-items-'+group).removeClass('hide');
            $('.portfolio-gallery').attr('data-list',group);
        }
    });

    $('.portfolio-item-popup').on('click', function(){
        showGalleryImage(this);
        $('.portfolio-gallery').addClass('active');
    });
    
    $('.portfolio-gallery-close').on('click', function(){
        $('.portfolio-gallery').removeClass('active');
    });

    $('.portfolio-gallery-nav-button').on('click', function(){
        var index = parseInt($('.portfolio-gallery').attr('data-index'));
        var count = parseInt($('.portfolio-gallery').attr('data-count'));
        var list = $('.portfolio-gallery').attr('data-list');
        if($(this).hasClass('portfolio-gallery-nav-prev')){
            index--;
            if(index < 0) index = count - 1;
        }
        else index = (index + 1) % count;
        $('.portfolio-list-items-'+list+' .portfolio-item-popup').each(function(){
            if($(this).attr('data-index') == index) showGalleryImage(this);
        });
    });

    $('.banner-button-cta-form').on('click', function(){
        var ctaForm = $(this).attr('data-form');
        $(ctaForm).addClass('active');
        $('header').attr('style', 'display: none !important');
    });
    
    $('.contact-form-modal-close-cta').on('click', function(){
        $('header').removeAttr('style');
    });

    $('.pricing-lp-btn').on('click', function(){
        var ctaForm = $(this).attr('data-form');
        $(ctaForm).addClass('active');
        $('header').attr('style', 'display: none !important');
    });

    $('.contact-form-modal-close').on('click',function(){
        $('.contact-form-modal').removeClass('active');
    })
    
    $('.contact-form-modal-close-cta').on('click', function(){
        $('header').removeAttr('style');
    });
    
    function showGalleryImage(element){
        $('.portfolio-gallery-image').hide();
        var image = $(element).find('.portfolio-bg').attr('src');
        var label = $(element).find('.portfolio-bg').attr('alt');
        var count = $(element).parents('.portfolio-list-items').find('.portfolio-item').length;
        $('.portfolio-gallery').attr('data-index',$(element).attr('data-index'));
        $('.portfolio-gallery').attr('data-count',count);
        $('.portfolio-gallery-image').attr('src',image);
        $('.portfolio-gallery-label').html(label);
        $('.portfolio-gallery-image').fadeIn();
    }

    $('.widget-call-button-cta').on('click', function(){
        if($('.widget-call-button').hasClass('popup')){
            $('.widget-call-button').removeClass('popup');
            $('.widget-call-greeting-text').removeClass('show');
            // $('.widget-call-button-box-footer').removeClass('show');
        }
        else{
            $('.widget-call-button').addClass('popup');
            setTimeout(function(){
                var d = new Date();
                var hour = d.getHours();
                var minute = (d.getMinutes()<10?'0':'') + d.getMinutes();
                $('.widget-call-greeting-text-date').html(hour+':'+minute);
                $('.widget-call-greeting-text').addClass('show');
                // $('.widget-call-button-box-footer').addClass('show');
            }, 1500);   
        }

    });
    

});





if(document.querySelector('body.home')){

    // Home Banner Arrow Down
    // let bannerNav = '<div class="contact-cta-button contact-menu-button button-orange">Contact Us</div><div class="contact-cta-button button-skip-animation button-black-transparent active">Skip Animation</div><div class="content-section-down"><div class="arrow-down"></div></div>';
    let bannerNav = '<a href="/services/" class="contact-cta-button button-orange">What We Do</a><div class="contact-cta-button button-skip-animation button-black-transparent active">Skip Animation</div><div class="content-section-down"><div class="arrow-down"></div></div>';
    let homepageBanner = document.querySelector('section.homepage-banner');
    homepageBanner.innerHTML = homepageBanner.innerHTML + bannerNav;

    // Home Banner Video Transition
    if(screen.width > mobileWidthThreshold){
        var bannerVid = document.querySelector('.elementor-background-video-hosted.elementor-html5-video');
        if(bannerVid){
            bannerVid.onended = function() {
                endHomeVideo();
            };
        }
        else{
            endHomeVideo();
        }
    }
    else{
        endHomeVideo();
    }

    // Client Logo Transition
    var clientLogo = document.querySelectorAll('.client-logo-list section img');
    clientLogo.forEach(function(item, index){
        item.removeAttribute('srcset');
    });
    if(document.querySelectorAll('.client-logo-list section.replacer').length > 0){
        var imageNum = document.querySelectorAll('.client-logo-list section:not(.replacer)').length;
        for (var a=[],i=0;i<imageNum;++i){
            a[i]=((2*i)+2)%(imageNum+1);
        }
        var imageReplacerNum = document.querySelectorAll('.client-logo-list section.replacer').length;
        // a = shuffle(a);
        // console.log(a);
        var indexIncrement = 1;
        setInterval(function(){
            var index = indexIncrement % imageNum;
            var indexReplacer = (indexIncrement % imageReplacerNum) + imageNum + 1;
            var indexChange = a[index];
            imageLogoClass = getLogoName(document.querySelector('.client-logo-list section:nth-child('+indexChange+')'));
            replacerLogoClass = getLogoName(document.querySelector('.client-logo-list section.replacer:nth-child('+indexReplacer+')'));
            indexImage = document.querySelector('.client-logo-list section:nth-child('+indexChange+') img').getAttribute('src');
            replacerImage = document.querySelector('.client-logo-list section.replacer:nth-child('+indexReplacer+') img').getAttribute('src');
            document.querySelector('.client-logo-list section.replacer:nth-child('+indexReplacer+') img').setAttribute('src',indexImage);
            document.querySelector('.client-logo-list section.replacer:nth-child('+indexReplacer+')').classList.remove(replacerLogoClass);
            document.querySelector('.client-logo-list section.replacer:nth-child('+indexReplacer+')').classList.add(imageLogoClass);
            document.querySelector('.client-logo-list section:nth-child('+indexChange+')').classList.remove('changed');
            document.querySelector('.client-logo-list section:nth-child('+indexChange+')').classList.add('change');
            setTimeout(function(){
                document.querySelector('.client-logo-list section:nth-child('+indexChange+')').classList.remove(imageLogoClass);
                document.querySelector('.client-logo-list section:nth-child('+indexChange+')').classList.add(replacerLogoClass);
                document.querySelector('.client-logo-list section:nth-child('+indexChange+') img').setAttribute('src',replacerImage);
                document.querySelector('.client-logo-list section:nth-child('+indexChange+')').classList.remove('change');
                document.querySelector('.client-logo-list section:nth-child('+indexChange+')').classList.add('changed');
            }, 400);
            indexIncrement++;
        }, 2000);
    }

    // Skip animation button
    document.querySelector('.button-skip-animation').addEventListener('click', function(e){
        endHomeVideo();
    });

    // Fullpage scroll
    // new fullpage('#post-23', {
    //     sectionSelector: '.fullpage-section',
    //     css3: true,
    //     easing: 'easeInOutCubic',
    //     easingcss3: 'ease'
    // });

}
else{
    document.querySelector('body').classList.add('show-homepage-banner');
}


// Contact Form Open Button
var contactButtonOpen = document.querySelectorAll('.contact-menu-button, .contact-menu-button a');
contactButtonOpen.forEach(function(el){
    el.addEventListener('click', function(e){
        e.preventDefault();
        document.querySelector('.contact-form-modal').classList.add('active');
    });
});


// Contact Form Close Button
document.querySelector('.contact-form-modal-close').addEventListener('click', function(){
    document.querySelector('.contact-form-modal').classList.remove('active');
});


// Change menu link on one page menu
if(document.querySelector('body.page-template-template-one-page-builder')){
    if(!document.querySelector('body.home')){
        document.querySelector('#menu-onepage-menu li:first-child a').addEventListener('click', function(e){
            e.preventDefault();
            this.setAttribute('href', '/');
            window.location = '/';
        });
        document.querySelector('#menu-onepage-menu-1 li:first-child a').addEventListener('click', function(event){
            event.preventDefault();
            this.setAttribute('href', '/');
            window.location = '/';
        });
        document.querySelector('#menu-onepage-menu-2 li:first-child a').addEventListener('click', function(event){
            event.preventDefault();
            this.setAttribute('href', '/');
            window.location = '/';
        });
    }
}



function getLogoName(element){
    var logoName = '';
    var itemClassName = element.classList;
    itemClassName.forEach(function(item, index){
        if(item.match(/logo-/g)) logoName = item;
    });
    return logoName;
}


function endHomeVideo(){
    var bannerVid = document.querySelector('.elementor-background-video-hosted.elementor-html5-video');
    if(bannerVid) bannerVid.style.display = 'none';
    document.querySelector('body').classList.add('show-homepage-banner');
    document.querySelector('.button-skip-animation').classList.remove('active');
    setTimeout(function(){
        document.querySelector('.content-section-down .arrow-down').classList.add('arrow-white');
        document.querySelector('.contact-cta-button').classList.add('active');
    }, 3000);
    if(jQuery(window).width() > mobileWidthThreshold){
        document.querySelector('header > .pixe_header_holder').classList.add('show-header');
        document.querySelector('header > .pixe_header_holder').classList.add('show-fast');
    }
}



