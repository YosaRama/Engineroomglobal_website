<?php

/* Template Name: Archive Case Study */

/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package gentium
 */

get_header();

$pixe_blog_style = get_theme_mod('blog_listing_style', 'grid');
$pixe_blog_style_class = 'blog-posts-grid-layout';
$pixe_blog_grid_attr = 'data-uk-grid=masonry:true';
if($pixe_blog_style == 'chess'){
    $pixe_blog_style_class = 'chess-blog-listing-style uk-grid-collapse';
    $pixe_blog_grid_attr = 'data-uk-grid uk-height-match=target:.chess';
}

?>


	<div id="primary" class="uk-container">
        <main id="main" class="uk-width-1-1" role="main">
            <?php $post_query = new WP_Query('post_type=case_study');?>
            <?php  if ( $post_query->have_posts() ) : ?> 
                <div class="blog-posts-listing <?php echo esc_attr($pixe_blog_style_class); ?>" <?php echo esc_attr($pixe_blog_grid_attr); ?>>
                    <?php
                        while ( $post_query->have_posts() ) : $post_query->the_post();
                            get_template_part( 'components/post/content', 'grid-case_study' );
                        endwhile; 
                    ?>
                </div>
                <?php if($wp_query->max_num_pages > 1):?>
                    <div class="pagination-container">
                        <?php pixe_pagination(); ?>
                    </div>
                <?php endif; ?>
            <?php else : ?> 
                <div class="inner">
                    <?php get_template_part( 'components/post/content', 'none' ); ?>
                </div>
            <?php endif; ?>
        </main>
	</div>

<?php
get_footer();