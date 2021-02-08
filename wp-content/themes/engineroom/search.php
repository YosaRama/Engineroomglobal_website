<?php
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
            <?php  if ( have_posts() ) : ?> 
                <div class="blog-posts-listing <?php echo esc_attr($pixe_blog_style_class); ?>" <?php echo esc_attr($pixe_blog_grid_attr); ?>>
                    <?php

                        while ( have_posts() ) : the_post();

                            if($pixe_blog_style == 'grid'){
                                get_template_part( 'components/post/content', 'grid' );
                            }else{
                                get_template_part( 'components/post/content', 'chess' );
                            }

                        endwhile; ?>

                </div>
            <?php else : ?> 
                <div class="inner">
                    <?php get_template_part( 'components/post/content', 'none' ); ?>
                </div>
            <?php endif; ?>
                <div class="pagination-container">
                    <?php pixe_pagination(); ?>
                </div>
        </main>
	</div>

<?php
get_footer();