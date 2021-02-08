<?php
/**
 * Gentium functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Gentium
 * @since 1.0.0
 */

if ( ! function_exists( 'pixe_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function pixe_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on components, use a find and replace
	 * to change 'gentium' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'gentium', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'pixe-featured-image', 1024, 420 , true );
	add_image_size( 'pixe-standard-large', 980, 735 );
	add_image_size( 'pixe-grid-image', 720, 500 , true );
	add_image_size( 'pixe-small-thumb'	,100,  90,  true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1'        => esc_html__( 'Primary Menu', 'gentium' ),
		'menu-2'        => esc_html__( 'Mobile Menu (Optional)', 'gentium' ),
		'menu-one-page' => esc_html__( 'One Page Menu', 'gentium' ),
	));

	/**
	 * Add support for core custom logo.
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 200,
		'width'       => 200,
		'flex-width'  => true,
		'flex-height' => true,
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

    add_theme_support( "custom-header" );
    add_editor_style();

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'pixe_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'pixe_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function pixe_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'pixe_content_width', 1170 );
}
add_action( 'after_setup_theme', 'pixe_content_width', 0 );

/**
 * Return early if Custom Logos are not available.
 *
 * @todo Remove after WP 4.7
 */
function pixe_the_custom_logo() {
	if ( ! function_exists( 'the_custom_logo' ) ) {
		return;
	} else {
		the_custom_logo();
	}
}

/**
 * Register widget area.
 *
 */
function pixe_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'gentium' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__('This sidebar will be visible on the pages with default template option.' , 'gentium'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'pixe_widgets_init' );

/*-----------------------------------------------------------------------------------*/
/*  SCRIPTS & STYLES
/*-----------------------------------------------------------------------------------*/
function pixe_scripts() {

	global $wp_query; 

	//All necessary CSS
	wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/icons/font-awesome/css/font-awesome.min.css' );
	wp_enqueue_style('uikit', get_template_directory_uri() .'/assets/css/uikit.min.css');
	wp_enqueue_style('pixe-main-style', get_stylesheet_uri(), array());

	//All Necessary Script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	wp_enqueue_script( 'anime-js', get_template_directory_uri() . '/assets/js/anime.min.js', array(), '2.2', true );
	wp_enqueue_script( 'jquery-easing', get_template_directory_uri() . '/assets/js/jquery.easing.js', array(), '1.3', true );
	wp_enqueue_script( 'uikit', get_template_directory_uri() . '/assets/js/uikit.min.js', array(), '3.0', true );
	wp_enqueue_script( 'pixe-load-more-script', get_template_directory_uri() . '/assets/js/load-more.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'pixe-scripts', get_template_directory_uri() . '/assets/js/main-script.js', array('jquery'), '1.1', true );

	wp_localize_script( 'pixe-load-more-script', 'pixe_loadmore', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
		'posts' => json_encode( $wp_query->query_vars ), // everything about your loop is here
		'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
		'max_page' => $wp_query->max_num_pages
	) );
	
}
add_action('wp_enqueue_scripts', 'pixe_scripts');

/*-------------------------------------------------*/
/*  Load Files
/*-------------------------------------------------*/
require get_template_directory() . '/inc/core/theme-core.php';

require_once(get_template_directory().'/functions-theme.php');