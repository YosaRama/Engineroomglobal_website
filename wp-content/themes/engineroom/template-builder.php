<?php
/**
 * Template Name: Page Builder
 *
 * @package gentium
 */

get_header(); ?>
<div id="primary" class="page-builder-template">
    <div class="page-builder-row">
        <?php
        while ( have_posts() ) : the_post();

            get_template_part( 'components/page/content', 'page' );

            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;

        endwhile; // End of the loop.
        ?>
    </div>
</div>
<?php
get_footer();
