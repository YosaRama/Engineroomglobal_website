//Go Between the Tabs
( function ( $ ){
    "use strict";
    $(".settings-tabs").tabs();
    
    
    $("a.tab-list-item").on("click", function () {
        var tabHref = $(this).attr('href');
        window.location.hash = tabHref;
        $("html , body").scrollTop(tabHref);
    });
    
    $(".pr-checkbox").on("click", function(){
       if($(this).prop("checked") == true) {
           $(".elements-table input").prop("checked", 1);
       }else if($(this).prop("checked") == false){
           $(".elements-table input").prop("checked", 0);
       }
    });
   
    $( 'form#pr-settings' ).on( 'submit', function(e) {
		e.preventDefault();
		$.ajax( {
			url: settings.ajaxurl,
			type: 'post',
			data: {
				action: 'pr_save_admin_addons_settings',
				fields: $( 'form#pr-settings' ).serialize(),
			},
            success: function( response ) {
				swal(
				  'Settings Saved!',
				  'Click OK to continue',
				  'success'
				);
			},
			error: function() {
				swal(
				  'Oops...',
				  'Something Wrong!',
				);
			}
		} );

	} );
    
} )(jQuery);