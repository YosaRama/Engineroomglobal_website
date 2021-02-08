jQuery(document).ready(function($) {
  
  spinnerselect = $( '#cf7-custom-spinner-type-select' ).unslider( { nav: false, index: current_spinner } );
  
  $( '#cf7-custom-spinner-type-select li' ).css( 'color', current_fore_color );
  $( '#cf7-custom-spinner-type-select li' ).css( 'background-color', current_back_color );
  
  $( '#cf7-custom-spinner-size-preview' ).addClass( current_size_class );
  
  spinnerselect.on('unslider.change', function(event, index, slide) {
    $( '#cf7cs_type' ).val( jQuery( '#cf7-custom-spinner-type-select ul li' ).eq( index ).find( '.cf7cs-spinner' ).data( 'spinner' ) );
  } );
  
  $( '#cf7-custom-spinner-size-select select' ).change( function(){
    $( '#cf7-custom-spinner-size-preview' ).removeClass().addClass( $( this ).find(':selected').data( 'size-class' ) );
    $( '#cf7cs_size' ).val( $( this ).find(':selected').data( 'size-px' ) );
  } );
  
  $( '#cf7-custom-spinner-color-select li input' ).change( function() {
    $( '#cf7-custom-spinner-type-select li' ).css( 'color', $( this ).data( 'color' ) );
    $( '#cf7-custom-spinner-type-select li' ).css( 'background-color', $( this ).data( 'bg' ) );
    $( '#cf7cs_color' ).val( $( this ).data( 'color' ) );
  } );
  
  $( '#cf7-custom-spinner-admin' ).show();
   
});