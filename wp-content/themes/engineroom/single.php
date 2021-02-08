<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package gentium
 */

get_header(); 

$heading = get_theme_mod( 'single_heading_tag', 'h1' );
?>

    <div id="primary" class="pixe-single-full">
        <main id="main" class="uk-width-1-1" role="main">
        <?php while ( have_posts() ) : the_post(); ?>
            <?php $post_banner = (wp_get_attachment_image_url(get_post_thumbnail_id(), 'full')) ? wp_get_attachment_image_url(get_post_thumbnail_id(), 'full') : '/wp-content/uploads/2020/03/er-bi-gc-small.jpg'; ?>
            <header class="pixe-single-post-header-full uk-background-cover" data-src="<?= $post_banner; ?>" data-uk-img data-uk-parallax="bgy: -200">
                <div class="single-post-heade-container uk-container">
                    <div class="single-post-heade-content uk-margin-auto uk-width-xxlarge">
                        <div class="category"><?php the_category(', '); ?></div>
                        <<?php echo esc_attr( $heading ); ?> class="entry-title uk-h1"><?php the_title(); ?></<?php echo esc_attr( $heading ); ?>>
                    </div>
                </div>
            </header>
            <div class="single-post-content uk-container" >
                <article>
                    <div class="outer uk-grid-large uk-flex" data-uk-grid>
                        <div class="entry-content-inner uk-width-expand">
                            <div class="entry-body clrfix">
                            <?php the_content(); ?>
                            <?php
                            // Split Pages Pagination
                            wp_link_pages(array(
                                'before'        => '<div class="pixe-split-pages">',
                                'after'         => '</div>',
                                'link_before'   => '<span>',
                                'link_after'    => '</span>'
                            ));?>
                            </div>
                            <?php 
                            // Comments
                            if ( comments_open() || get_comments_number() ) { 
                                 if(!post_password_required()) { ?>
                                    <div class="post-comment-warp uk-flex">
                                        <div class="uk-width-1-1">
                                        <?php
                                        // If comments are open or we have at least one comment, load up the comment template.
                                            comments_template(); ?>
                                        </div>
                                    </div>
                                <?php }} ?>
                        </div>
                        <div class="entry-sidebar uk-width-1-5@m uk-flex-first@m uk-first-column">
                            <div class="post-enty-meta">
                                <ul class="content uk-list uk-list-divider">
                                    <li class="author">
                                        <strong><?php esc_html_e( 'Written by:', 'gentium' ); ?></strong>
                                        <span><?php the_author(); ?></span>
                                    </li>
                                    <li class="date">
                                        <strong><?php esc_html_e( 'Posted on:', 'gentium' ); ?></strong>
                                        <span><?php echo get_the_date(); ?></span>
                                    </li>
                                    <?php if(has_tag()) { ?>
                                        <li class="tags">
                                            <strong><?php esc_html_e( 'Tags:', 'gentium' ); ?></strong>
                                            <span><?php the_tags('',', ',''); ?></span>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <?php if(function_exists('pixe_post_share')){?>
                                <div class="post-share-container">
                                    <?php pixe_post_share(); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div><!-- .entry-content -->
                </article><!-- #post-## -->
            </div>
            <?php endwhile; // End of the loop.?>
        </main>
	</div>
<?php
get_footer();
