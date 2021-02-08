<?php

/**
 * The CF7 Custom Spinner Plugin
 *
 * Customize the spinning Loader Animation of Contact Form 7
 *
 * @wordpress-plugin
 * Plugin Name: Custom Spinner for Contact Form 7
 * Plugin URI: https://petersplugins.com/free-wordpress-pluginscf7-custom-spinner
 * Description: Customize the spinning Loader Animation of Contact Form 7
 * Version: 2
 * Author: Peter Raschendorfer
 * Author URI: https://petersplugins.com
 * Text Domain: cf7-custom-spinner
 * License: GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


// If this file is called directly, abort
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * Loader
 */
require_once( plugin_dir_path( __FILE__ ) . '/loader.php' );


?>