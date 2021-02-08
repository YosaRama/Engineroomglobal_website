<?php
/*
Plugin Name: Pixerex Core
Description: Core functions for Pixerex Themes.
Version: 1.0.0
Author: Pixerex
Author URI: https://themeforest.net/user/Pixerex/portfolio/
*/


if ( ! defined( 'PR_CORE_VERSION' ) ) {
	define( 'PR_CORE_VERSION', '1.0.0' );
}

//Load customizer.
include_once( dirname( __FILE__ ) . '/plugins/customizer/kirki.php' );

//Load Metaboxes.
include_once( dirname( __FILE__ ) . '/plugins/cmb2/init.php' );

// //Load Extras.
include_once( dirname( __FILE__ ) . '/plugins/pixerex-extras/pixerex-extras.php' );