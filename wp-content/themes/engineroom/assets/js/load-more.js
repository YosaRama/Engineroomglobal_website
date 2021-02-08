(function( $ ) {
	"use strict";

	$('#load-more-archives').on('click', function(){

		var $gridLayout = $('.blog-posts-listing');
 
		var button = $(this),
		    data = {
			'action': 'loadmore',
			'query': pixe_loadmore.posts, // that's how we get params from wp_localize_script() function
			'page' : pixe_loadmore.current_page
		};

		$.ajax({
			url : pixe_loadmore.ajaxurl, // AJAX handler
			data : data,
			type : 'POST',
			beforeSend : function ( xhr ) {
				button.addClass('loading'); // change the button text, you can also add a preloader image
			},
			success : function( data ){
				if( data ) { 
					button.removeClass('loading');
					$gridLayout.append(data);
					pixe_loadmore.current_page++;
 
					if ( pixe_loadmore.current_page == pixe_loadmore.max_page ) 
						button.remove(); // if last page, remove the button
 
				} else {
					button.remove(); // if no data, remove the button as well
				}
			}
		});
	});
	
})(jQuery);