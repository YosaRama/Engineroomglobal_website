<?php  
/**
 * register Pixerex post types and custom taxonomies.
 *
 * @package pixerex-core/plugins/pixerex-extras
 *
 * @since 1.1.0
*/


/* ----------------------------------------------------- */
/* Registre Portfolio Custom Post Type
/* ----------------------------------------------------- */

// Register Custom Post Type
function pixe_portfolio_cpt() {

	$labels = array(
		'name'                  => _x( 'Portfolio', 'Post Type General Name', 'pixerex' ),
		'singular_name'         => _x( 'Portfolio', 'Post Type Singular Name', 'pixerex' ),
		'add_new_item'          => __( 'Add New Portfolio Item', 'pixerex' ),
		'add_new'               => __( 'Add New Item', 'pixerex' ),
        'new_item'              => __( 'Add New Portfolio Item', 'pixerex' ),
        'all_items'             => __( 'All Portfolios', 'pixerex' ),
		'edit_item'             => __( 'Edit Portfolio Item', 'pixerex' ),
		'view_item'             => __( 'View Item', 'pixerex' ),
		'search_items'          => __( 'Search Portfolio', 'pixerex' ),
		'not_found'             => __( 'Not found', 'pixerex' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'pixerex' ),
	);
	$args = array(
		'label'                 => __( 'Portfolio', 'pixerex' ),
		'description'           => __( 'Add a Portfolio Item', 'pixerex' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-portfolio',
		'can_export'            => true,
		'has_archive'           => true,
        'capability_type'       => 'post',
        'rewrite' => array( 'slug' => 'portfolio' ),
		'show_in_rest'          => true,
	);
	register_post_type( 'portfolio', $args );

}
add_action( 'init', 'pixe_portfolio_cpt');


/* ----------------------------------------------------- */
/* Registre Portfolio Custom Post Type
/* ----------------------------------------------------- */

// Register Custom Post Type
function pixe_templates_cpt() {

	$labels = array(
		'name'                  => _x( 'Theme Templates', 'Post Type General Name', 'pixerex' ),
		'singular_name'         => _x( 'Template', 'Post Type Singular Name', 'pixerex' ),
		'add_new_item'          => __( 'Add New Template', 'pixerex' ),
		'add_new'               => __( 'Add New', 'pixerex' ),
        'new_item'              => __( 'Add New Template', 'pixerex' ),
        'all_items'             => __( 'All Templates', 'jupiterx-core' ),
		'edit_item'             => __( 'Edit Template', 'pixerex' ),
		'view_item'             => __( 'View Template', 'pixerex' ),
		'search_items'          => __( 'Search Template', 'pixerex' ),
		'not_found'             => __( 'No Templates Found', 'pixerex' ),
		'not_found_in_trash'    => __( 'No Templates Found in Trash', 'pixerex' ),
	);
	$args = array(
		'label'                 => __( 'Templates', 'pixerex' ),
		'description'           => __( 'Add a Template', 'pixerex' ),
		'labels'                => $labels,
		'supports' 				=> array( 'title', 'editor', 'thumbnail', 'author', 'elementor' ),
		'hierarchical'          => false,
		'show_in_nav_menus'     => false,
		'public'                => true,
		'show_ui'               => true,
		'exclude_from_search'   => true,
		'menu_position'         => 6,
		'menu_icon'             => 'dashicons-feedback',
		'can_export'            => true,
        'capability_type'       => 'post',
		'rewrite' => array( 'slug' => 'pixe_templates' ),
	);
	register_post_type( 'pixe_templates', $args );

}
add_action( 'init', 'pixe_templates_cpt');

/* ----------------------------------------------------- */
/* Register Taxonomy
/* ----------------------------------------------------- */

function pixe_portfolio_portfolio_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'                       => _x( 'Categories', 'Category General Name', 'pixerex' ),
        'singular_name'              => _x( 'Category', 'Category Singular Name', 'pixerex' ),
        'menu_name'                  => __( 'Categories', 'pixerex' ),
        'all_items'                  => __( 'All Categories', 'pixerex' ),
        'parent_item'                => __( 'Parent Category', 'pixerex' ),
        'parent_item_colon'          => __( 'Parent Category:', 'pixerex' ),
        'new_item_name'              => __( 'New Category Name', 'pixerex' ),
        'add_new_item'               => __( 'Add New Category', 'pixerex' ),
        'edit_item'                  => __( 'Edit Category', 'pixerex' ),
        'update_item'                => __( 'Update Category', 'pixerex' ),
        'view_item'                  => __( 'View Category', 'pixerex' ),
        'separate_items_with_commas' => __( 'Separate categories  with commas', 'pixerex' ),
        'add_or_remove_items'        => __( 'Add or remove categories ', 'pixerex' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'pixerex' ),
        'popular_items'              => __( 'Popular Categories', 'pixerex' ),
        'search_items'               => __( 'Search Categories', 'pixerex' ),
        'not_found'                  => __( 'Not Found', 'pixerex' ),
        'no_terms'                   => __( 'No categories ', 'pixerex' ),
        'items_list'                 => __( 'Categories list', 'pixerex' ),
        'items_list_navigation'      => __( 'Categories list navigation', 'pixerex' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'portfolio-category' ),
	);

	register_taxonomy( 'portfolio_category', array( 'portfolio' ), $args );
}
add_action( 'init', 'pixe_portfolio_portfolio_taxonomies', 0 );

?>