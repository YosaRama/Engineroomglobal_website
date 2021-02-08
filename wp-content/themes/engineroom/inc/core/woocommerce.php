<?php 

/*-----------------------------------------------------------------------------------*/
# WOOCOMMERCE
/*-----------------------------------------------------------------------------------*/

function pixe_wc_setup() {
	add_theme_support( 'woocommerce', array(
		'gallery_thumbnail_image_width' => 560,
		'thumbnail_image_width' => 560,
		'single_image_width' => 560,
	) );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}

add_action( 'after_setup_theme', 'pixe_wc_setup' );

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * Enqueues WooCommerce assets.
 */
function pixe_wc_enqueue_scripts() {

	// Register WooCommerce styles.
	wp_register_style( 'pixe_css_wc', get_template_directory_uri() . '/assets/css/woocommerce.css', false, '1.0' );

	// Enqueue WooCommerce styles.
	wp_enqueue_style( 'pixe_css_wc' );

}

add_action( 'wp_enqueue_scripts', 'pixe_wc_enqueue_scripts' );


/**
 * Add 'woocommerce-active' class to the body tag.
 */
function pixe_wc_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}

add_filter( 'body_class', 'pixe_wc_active_body_class' );

/**
 * Define WooCommerce image sizes
 */
function pixe_wc_after_switch_theme() {

	if ( get_option( 'pixe_wc_image_sizes_set' ) ) {
		return;
	}

	$catalog = array(
		'width'     => '560',
		'height'    => '560',
		'crop'      => true,
	);
	$single = array(
		'width'     => '560',
		'height'    => '560',
		'crop'      => true,
	);
	$thumbnail = array(
		'width'     => '90',
		'height'    => '90',
		'crop'      => true,
	);

	update_option( 'shop_catalog_image_size', $catalog );
	update_option( 'shop_single_image_size', $single );
	update_option( 'shop_thumbnail_image_size', $thumbnail );

	update_option( 'pixe_wc_image_sizes_set', true );
}

add_action( 'after_switch_theme', 'pixe_wc_after_switch_theme' );

/**
 * Remove Default WooCommerce Page Title
 */
function pixe_wc_show_page_title() {
	if ( is_shop() ) {
		return false;
	}
}
add_filter( 'woocommerce_show_page_title', 'pixe_wc_show_page_title' );

/**
 * Related Products Args.
 */
function pixe_wc_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 4,
		'columns'        => 4,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}

add_filter( 'woocommerce_output_related_products_args', 'pixe_wc_related_products_args' );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'pixe_wc_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 */
	function pixe_wc_wrapper_before() {
		?>
			<div id="primary" class="uk-container">
        	<main id="main" class="uk-width-1-1" role="main">
		<?php
	}
}

add_action( 'woocommerce_before_main_content', 'pixe_wc_wrapper_before' );

if ( ! function_exists( 'pixe_wc_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
function pixe_wc_wrapper_after() {
	?>
	</main><!-- #main -->
	</div><!-- #primary -->
	<?php
}
}
add_action( 'woocommerce_after_main_content', 'pixe_wc_wrapper_after' );

/**
 * Loop
 */
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/**
 * Open Thumbnail Wrap
 */
function pixe_wc_before_shop_loop_item() {
	?>
	<div class="product-thumbnail">
<?php
}
add_action( 'woocommerce_before_shop_loop_item', 'pixe_wc_before_shop_loop_item', 5 );

/**
 * Close Link
 */
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 15 );

/**
 * Add To Cart Button
 */
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 20 );

/**
 * Close Thumbnail Wrap
 */
function pixe_wc_before_shop_loop_item_title() {
	?>
	</div>
<?php
}
add_action( 'woocommerce_before_shop_loop_item_title', 'pixe_wc_before_shop_loop_item_title', 25 );

/**
 * Open Link
 */
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 30 );

/**
 * Adds classes to <body> tag
 *
 * @param array $classes is an array of all body classes.
 */
function pixe_wc_body_class( $classes ) {
	if ( is_shop() || is_product_category() || is_product_tag() ) {
		$classes[] = 'wc-col-4';
	}
	if ( is_product() ) {
		$classes[] = 'wc-col-4';
	}
	return $classes;
}
add_filter( 'body_class', 'pixe_wc_body_class' );

/**
 * Override pagination
 */
function pixe_wc_woocommerce_pagination() {

	global $wp_query;

	if ( $wp_query->max_num_pages <= 1 ) {
		return;
	}

	?>

	<nav class='custom-pagination'>

	<?php
	the_posts_pagination(
		apply_filters(
			'woocommerce_pagination_args', array(
				'base'         => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
				'format'       => '',
				'add_args'     => false,
				'current'      => max( 1, get_query_var( 'paged' ) ),
				'total'        => $wp_query->max_num_pages,
				'prev_text'       => esc_html__('&laquo;', 'gentium'),
      			'next_text'       => esc_html__('&raquo;', 'gentium'),
				'end_size'     => 3,
				'mid_size'     => 3,
			)
		)
	);
	?>

	</nav>

	<?php
}


remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
add_action( 'woocommerce_after_shop_loop', 'pixe_wc_woocommerce_pagination', 10 );