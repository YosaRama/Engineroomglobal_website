<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package gentium
 */

get_header(); ?>

    <?php
        $pixe_default_page_layout = get_post_meta( get_the_ID(), "pixe_default_page_layout", true );
        if($pixe_default_page_layout == '' || $pixe_default_page_layout == 'full'){
            $pixe_sidebar_page_full = 'uk-width-1-1';
        }else{
            $pixe_sidebar_page_full = 'uk-width-2-3@m uk-width-1-1@s';
        }

        $sidebar_class='';
        if($pixe_default_page_layout == 'left'){

             $sidebar_class = 'sidebar-left';

        }
    ?>

	<div id="primary" class="uk-container <?php echo esc_attr($sidebar_class); ?>">
        <div class="page-row uk-grid-large uk-flex" data-uk-grid>

            <main id="main" class="<?php echo esc_attr($pixe_sidebar_page_full); ?>" role="main">

                <?php
                while ( have_posts() ) : the_post();

                    get_template_part( 'components/page/content', 'page' );

                    // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :  ?>
                        <div class="post-comment-warp">
                            <div class="uk-width-1-1">
                                <?php comments_template(); ?>
                            </div>
                        </div>
                <?php endif; 

                endwhile; // End of the loop.
                ?>

            </main>

            <?php if($pixe_default_page_layout == 'right' ||$pixe_default_page_layout == 'left'): ?>
                <div class="uk-width-1-3@m uk-width-1-1@s side-col">
                    <?php get_sidebar(); ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
<?php
get_footer();
