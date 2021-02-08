<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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