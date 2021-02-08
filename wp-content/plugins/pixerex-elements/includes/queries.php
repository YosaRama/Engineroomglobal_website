<?php 

if (!defined('ABSPATH')) exit;

function pr_navbar_menu_choices() {
	$menus = wp_get_nav_menus();
	$items = array();
	$i     = 0;
	foreach ( $menus as $menu ) {
		if ( $i == 0 ) {
			$default = $menu->slug;
			$i ++;
		}
		$items[ $menu->slug ] = $menu->name;
	}

	return $items;
}

remove_filter( 'nav_menu_description', 'strip_tags' );


function pr_get_post_data($args){
    $defaults = array(
        'posts_per_page'   => 5,
        'offset'           => 0,
        'category'         => '',
        'category_name'    => '',
        'orderby'          => 'date',
        'order'            => 'DESC',
        'include'          => '',
        'exclude'          => '',
        'meta_key'         => '',
        'meta_value'       => '',
        'post_type'        => 'post',
        'post_mime_type'   => '',
        'post_parent'      => '',
        'author'	   => '',
        'author_name'	   => '',
        'post_status'      => 'publish',
        'suppress_filters' => true
    );

    $atts = wp_parse_args($args,$defaults);

    $posts = get_posts($atts);

    return $posts;
}


function pr_get_post_types(){
    
    $pr_cpts = get_post_types( array( 'public'   => true, 'show_in_nav_menus' => true ) );
    $pr_exclude_cpts = array( 'elementor_library', 'attachment', 'product' );

    foreach ( $pr_exclude_cpts as $exclude_cpt ) {
        unset($pr_cpts[$exclude_cpt]);
    }
    
    $post_types = array_merge($pr_cpts);
    return $post_types;
}

function pr_get_all_types_post(){
    $posts_args = array(
        'post_type' => 'any',
        'post_style' => 'all_types',
        'post_status' => 'publish',
        'posts_per_page' => '-1',
    );
}


function pr_get_post_settings($settings){
    $post_args['post_type'] = $settings['pr_post_type'];

    if($settings['pr_post_type'] == 'post'){
        $post_args['category'] = $settings['category'];
    }

    $post_args['posts_per_page'] = $settings['pr_posts_count'];
    $post_args['offset'] = $settings['pr_post_offset'];
    $post_args['post_except'] = $settings['pr_post_except'];
    $post_args['orderby'] = $settings['pr_post_orderby'];
    $post_args['order'] = $settings['pr_post_order'];

    return $post_args;
}

function pr_get_excerpt_by_id($post_id,$excerpt_length){
    $the_post = get_post($post_id); //Gets post ID

    $the_excerpt = null;
    if ($the_post)
    {
        $the_excerpt = $the_post->post_excerpt ? $the_post->post_excerpt : $the_post->post_content;
    }

    $the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
    $words = explode(' ', $the_excerpt, $excerpt_length + 1);

     if(count($words) > $excerpt_length) :
         array_pop($words);
         array_push($words, '…');
         $the_excerpt = implode(' ', $words);
     endif;

     return $the_excerpt;
}

function pr_get_thumbnail_sizes(){
    $sizes = get_intermediate_image_sizes();
    foreach($sizes as $s){
        $ret[$s] = $s;
    }

    return $ret;
}

function pr_get_post_orderby_options(){
    $orderby = array(
        'ID' => 'Post ID',
        'author' => 'Post Author',
        'title' => 'Title',
        'date' => 'Date',
        'modified' => 'Last Modified Date',
        'parent' => 'Parent Id',
        'rand' => 'Random',
        'comment_count' => 'Comment Count',
        'menu_order' => 'Menu Order',
    );

    return $orderby;
}

function pr_post_type_categories(){
    $terms = get_terms( array( 
        'taxonomy' => 'category',
        'hide_empty' => true,
    ));
    
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
    foreach ( $terms as $term ) {
        $options[ $term->term_id ] = $term->name;
    }
    }
    
    return $options;
}

function pr_portfolio_categories(){
    $terms = get_terms( array( 
        'taxonomy' => 'portfolio_category',
        'hide_empty' => true,
    ));
    
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
    foreach ( $terms as $term ) {
        $options[ $term->term_id ] = $term->name;
    }
    }
    
    return $options;
}

// Get all elementor page templates
if ( !function_exists('pr_get_page_templates') ) {
    function pr_get_page_templates(){
        $page_templates = get_posts( array(
            'post_type'         => 'elementor_library',
            'posts_per_page'    => -1
        ));

        $options = array();

        if ( ! empty( $page_templates ) && ! is_wp_error( $page_templates ) ){
            foreach ( $page_templates as $post ) {
                $options[ $post->ID ] = $post->post_title;
            }
        }
        return $options;
    }
}

/**
 * Post Settings Parameter
 * @param  array $settings
 * @return array
 */
function pr_get_post_settings_arr( $settings ){
    foreach( $settings as $key => $value ) {
        if( in_array( $key, pr_posts_args() ) ) {
            $post_args[ $key ] = $value;
        }
    }

    $post_args['post_status'] = 'publish';

    return $post_args;
}


/**
 * For All Settings Key Need To Use in Markup and as WP_Query Arguments!
 *
 * @return array for filtering the huge settings array which is given by the Elementor!
 */
if( ! function_exists( 'pr_posts_args' ) ) : 
    function pr_posts_args(){
        return array(
            // query_args
            'post_type',
            'post__in',
            'posts_per_page',
            'post_style',
            'tax_query',
            'post__not_in',
            'offset',
            'orderby',
            'order',
        );
    }
endif;


// Get Contact Form 7 forms

if ( function_exists( 'wpcf7' ) ) {
function pr_select_contact_form(){
    $wpcf7_form_list = get_posts(array(
        'post_type' => 'wpcf7_contact_form',
        'showposts' => 999,
    ));
    $posts = array();
    
    if ( ! empty( $wpcf7_form_list ) && ! is_wp_error( $wpcf7_form_list ) ){
    foreach ( $wpcf7_form_list as $post ) {
        $options[ $post->ID ] = $post->post_title;
    } 
    return $options;
    }
}
}

