<?php

/**
 * The CF7 Custom Spinner Plugin Loader
 *
 * @since 1
 *
 **/
 
// If this file is called directly, abort
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * Load files
 */
require_once( plugin_dir_path( __FILE__ ) . '/inc/class-cf7-custom-spinner.php' );
require_once( plugin_dir_path( __FILE__ ) . '/inc/class-cf7-custom-spinner-settings.php' );
require_once( plugin_dir_path( __FILE__ ) . '/inc/class-cf7-custom-spinner-frontend.php' );

if ( is_admin() ) {
  
  // load files only if in admin
  // @since 2
  require_once( plugin_dir_path( __FILE__ ) . '/inc/class-cf7-custom-spinner-spinners.php' );
  require_once( plugin_dir_path( __FILE__ ) . '/inc/class-cf7-custom-spinner-colors.php' );
  require_once( plugin_dir_path( __FILE__ ) . '/inc/class-cf7-custom-spinner-sizes.php' );
  require_once( plugin_dir_path( __FILE__ ) . '/inc/class-cf7-custom-spinner-admin.php' );
  require_once( plugin_dir_path( __FILE__ ) . '/inc/class-cf7-custom-spinner-uninstall.php' );
  
}


/**
 * Main Function
 */
function pp_cf7_custom_spinner() {

  return PP_CF7_Custom_Spinner::getInstance( array(
    'file'    => __DIR__ . '/cf7-custom-spinner.php',
    'slug'    => basename( __DIR__ ),
    'name'    => 'CF7 Custom Spinner',
    'version' => '2'
  ) );
    
}


/**
 * Run the Plugin
 */
pp_cf7_custom_spinner();


?>