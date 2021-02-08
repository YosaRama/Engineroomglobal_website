jQuery(document).ready(function($) {
  
  $( '.pp-cf7cs-admin-notice' ).on( 'click', '.notice-dismiss', function ( event ) {
    event.preventDefault();
		data = {
			action: 'pp_cf7cs_dismiss_admin_notice',
		};
		$.post( ajaxurl, data );
		return false;
	});
   
});