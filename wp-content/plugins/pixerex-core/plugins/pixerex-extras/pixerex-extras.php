<?php

/*
Plugin Name: Pixerex Extras
Description: Extras Functionality For Pixerex Themes.
Plugin URI: https://themeforest.net/user/style-themes/portfolio
Author: Pixerex
Version: 1.0.0
Author URI: https://themeforest.net/user/style-themes/portfolio
*/

if( !defined( 'ABSPATH' ) ) exit; // No access of directly access

define( 'PIXE_EXTRAS_VERSION', '1.0.0' );
define( 'PIXE_EXTRAS_URL', plugins_url('/', __FILE__ ) );
define( 'PIXE_EXTRAS_PATH', plugin_dir_path( __FILE__ ) );
define( 'PIXE_EXTRAS_FILE', __FILE__ );
define( 'PIXE_EXTRAS_BASENAME', plugin_basename(__FILE__));


/*
* Enqueue all frontend stylesheets
*/

function pixe_extras_scripts(){

	if(is_single()){
		wp_enqueue_script( 'pixe-share-window', PIXE_EXTRAS_URL . '/js/social.js', array( 'jquery' ), '0.5', false );
	}
}

add_action( 'wp_enqueue_scripts', 'pixe_extras_scripts');

//Breadcrumbs
require_once PIXE_EXTRAS_PATH. 'breadcrumbs.php';
//Single Post Social Share
require_once PIXE_EXTRAS_PATH. 'share.php';
//Portfolio Custom Post Type
require_once PIXE_EXTRAS_PATH. 'portfolio-cpt.php';