<?php

/*-----------------------------------------------------------------------------------*/
# Excerpt
/*-----------------------------------------------------------------------------------*/


function pixe_excerpt_length( $length ) {
	$exc_length = get_theme_mod( 'post_excerpt_length' , 40);
	return $exc_length;
}
add_filter( 'excerpt_length', 'pixe_excerpt_length', 999 );


function pixe_words_limit($string, $word_limit)
{
	$words = explode(' ', $string, ($word_limit + 1));
	
	if(count($words) > $word_limit) {
		array_pop($words);
	}
	
	return implode(' ', $words);
}

/*-----------------------------------------------------------------------------------*/
# Read More Functions
/*-----------------------------------------------------------------------------------*/
function pixe_remove_excerpt( $more ) {
	return '&hellip;';
}
add_filter('excerpt_more', 'pixe_remove_excerpt');


/*--------------------------------------------------------------*/
/*  Add Support For Elementor Header/Footer
/*--------------------------------------------------------------*/

$pixe_header_layout = get_theme_mod('header_layout_type','header-1'); 
if($pixe_header_layout == 'custom'){ 

function pixe_header_buider_style() {
	$pixe_stheader_template = get_theme_mod( 'select_header_template' );

	if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
		$css_file = new \Elementor\Core\Files\CSS\Post( $pixe_stheader_template );
	} elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
		$css_file = new \Elementor\Post_CSS_File( $pixe_stheader_template );
	}

	$css_file->enqueue();
}
add_action('wp_enqueue_scripts', 'pixe_header_buider_style');
}

/*--------------------------------------------------------------*/
/*  Preloader
/*--------------------------------------------------------------*/
$pixe_preloader = get_theme_mod('show_preloader', true); 
if($pixe_preloader == true){ 

	function pixe_preloader_scripts() {

		wp_enqueue_style('preloader-css', get_template_directory_uri() .'/assets/css/preloader.css');
		wp_enqueue_script( 'preloader-js', get_template_directory_uri() . '/assets/js/preloader.js', array(), '1.0', true );
	}
	add_action('wp_enqueue_scripts', 'pixe_preloader_scripts');
}
/*--------------------------------------------------------------*/
/*  Pagination
/*--------------------------------------------------------------*/
if(!function_exists('pixe_pagination')){
	function pixe_pagination() {
    
        $pagination = get_theme_mod( 'blog_pagination_type', 'numric' );
        if( $pagination == 'numric' ){
            pixe_numeric_pagination();
        } else{
            # Load More Pagination ----------
            global $wp_query; // you can remove this line if everything works for you
 
			// don't display the button if there are not enough posts
			if (  $wp_query->max_num_pages > 1 )
				echo '<a id="load-more-archives" class="container-wrapper loadMore"><span class="text">'. esc_html__( 'Load More Posts', 'gentium') .'</span><span class="spinner"></span></a>'; // you can use <a> as well
        }
    }
}

function pixe_numeric_pagination($numpages = '', $pagerange = '', $paged='') {
    if (empty($pagerange)) {
      $pagerange = 2;
    }
    global $paged;
    if (empty($paged)) {
      $paged = 1;
    }
    if ($numpages == '') {
      global $wp_query;
      $numpages = $wp_query->max_num_pages;
      if(!$numpages) {
          $numpages = 1;
      }
    }
    $pagination_args = array(
      'base'            => get_pagenum_link(1) . '%_%',
      'total'           => $numpages,
      'current'         => $paged,
      'show_all'        => False,
      'end_size'        => 1,
      'mid_size'        => $pagerange,
      'prev_next'       => True,
      'prev_text'       => esc_html__('&laquo;', 'gentium'),
      'next_text'       => esc_html__('&raquo;', 'gentium'),
      'type'            => 'plain',
      'add_args'        => false,
      'add_fragment'    => ''
    );
    $paginate_links = paginate_links($pagination_args);
  
    if ($paginate_links) {
      echo "<nav class='custom-pagination'>";
        echo $paginate_links;
      echo "</nav>";
    }
}

function pixe_loadmore_ajax_handler(){
 
	// prepare our arguments for the query
	$args = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
	$args['post_status'] = 'publish';
	$pixe_blog_style = get_theme_mod('blog_listing_style', 'grid');
	// it is always better to use WP_Query but not here
	query_posts( $args );
 
	if( have_posts() ) :
 
		// run the loop
		while( have_posts() ): the_post();
 
		if($pixe_blog_style == 'grid'){
			get_template_part( 'components/post/content', 'grid' );
		}else{
			get_template_part( 'components/post/content', 'chess' );
		}

		endwhile;
 
	endif;
	die; // here we exit the script and even no wp_reset_query() required!
}
 
add_action('wp_ajax_loadmore', 'pixe_loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_loadmore', 'pixe_loadmore_ajax_handler'); // wp_ajax_nopriv_{action}

/*--------------------------------------------------------------*/
/*  layout display
/*--------------------------------------------------------------*/
if(!function_exists('pixe_layouts')){
	function pixe_layouts() {
        $pixe_page_layout = get_post_meta( get_the_ID(), "pixe_page_layout", true );
        if ( $pixe_page_layout == '' || $pixe_page_layout == 'default' ) {
            $pixe_page_layout = get_theme_mod( 'layout_type', 'wide' );
        }
        
        echo esc_html($pixe_page_layout);
    }
}

if ( ! function_exists( 'pixe_title' ) ) {

	function pixe_title() {

		// Default title is null
		$title = NULL;
	
		// Homepage - display blog description if not a static page
		if ( is_front_page() && ! is_singular( 'page' ) ) {
			
			if ( get_bloginfo( 'description' ) ) {
				$title = get_bloginfo( 'description' );
			} else {
				return esc_html__( 'Recent Posts', 'gentium' );
			}

		// Homepage posts page
		} elseif ( is_home() && ! is_singular( 'page' ) ) {

			$title = get_the_title( get_option( 'page_for_posts', true ) );

		}

		// Search needs to go before archives
		elseif ( is_search() ) {
			global $wp_query;
			$title = '<span id="search-results-count">'. $wp_query->found_posts .'</span> '. esc_html__( 'Search Results Found', 'gentium' );
		}
			
		// Archives
		elseif ( is_archive() ) {

			// Author
			if ( is_author() ) {
				$title = get_the_archive_title();
			}

			// Post Type archive title
			elseif ( is_post_type_archive() ) {
				$title = post_type_archive_title( '', false );
			}

			// Daily archive title
			elseif ( is_day() ) {
				$title = sprintf( esc_html__( 'Daily Archives: %s', 'gentium' ), get_the_date() );
			}

			// Monthly archive title
			elseif ( is_month() ) {
				$title = sprintf( esc_html__( 'Monthly Archives: %s', 'gentium' ), get_the_date( esc_html_x( 'F Y', 'Page title monthly archives date format', 'gentium' ) ) );
			}

			// Yearly archive title
			elseif ( is_year() ) {
				$title = sprintf( esc_html__( 'Yearly Archives: %s', 'gentium' ), get_the_date( esc_html_x( 'Y', 'Page title yearly archives date format', 'gentium' ) ) );
			}

			// Categories/Tags/Other
			else {

				// Get term title
				$title = single_term_title( '', false );

			}

		} // End is archive check

		// 404 Page
		elseif ( is_404() ) {

			$title = esc_html__( '404: Page Not Found', 'gentium' );

		}

		// Last check if title is empty
		$title = $title ? $title : get_the_title();

		return $title ;
		
	}

}

/*-----------------------------------------------------------------------------------*/
# COMMENTS LAYOUT
/*-----------------------------------------------------------------------------------*/

function pixe_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
        
        <div id="comment-<?php comment_ID() ?>" class="thecomment">
                    
            <div class="comment-author vcard">
                <?php echo get_avatar($comment,$args['avatar_size']); ?>
            </div>
            
            <div class="comment-content">
                <div class="comment-meta">
                    <h6 class="author"><?php echo get_comment_author_link(); ?></h6>
                    <span class="date"><?php printf(esc_html__('%1$s at %2$s', 'gentium'), get_comment_date(),  get_comment_time()) ?></span>
                </div>
                <?php if ($comment->comment_approved == '0') : ?>
                    <em><?php esc_html_e('Comment awaiting approval', 'gentium'); ?></em>
                    <br />
                <?php endif; ?>
                <div class="comment-text">
                    <?php comment_text(); ?>
                </div>
                <div class="reply">
                    <?php comment_reply_link(array_merge( $args, array('reply_text' => esc_html__('Reply', 'gentium'), 'depth' => $depth, 'max_depth' => $args['max_depth'])), $comment->comment_ID); ?>
                    <?php edit_comment_link(esc_html__('Edit', 'gentium')); ?>
                </div>
            </div>
                    
        </div>
        
        
    </li>

    <?php 
}