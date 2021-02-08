<?php

/**
 * Kirki-fallback.
 */
require get_template_directory() . '/inc/core/customizer/kirki-fallback.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/core/customizer/customizer.php';

/**
 * Custom Theme Functions.
 */
require get_template_directory() . '/inc/core/theme-functions.php';

/**
 * Custom Theme Metaboxs.
 */
require get_template_directory() . '/inc/core/metabox.php';

/**
 * Woocommerce.
 */
if ( class_exists( 'woocommerce' ) ) {
require get_template_directory() . '/inc/core/woocommerce.php';
}
/**
 * Demo import.
 */
require get_template_directory() . '/inc/core/demo-import.php';

/**
 * Inlcude TGM Plugins
 */
require get_template_directory() . '/inc/core/tgm-load-plugins.php';

/**
* Load Additional Scripts for Customizer
*/
require get_template_directory() . '/inc/core/additional-scripts.php';
