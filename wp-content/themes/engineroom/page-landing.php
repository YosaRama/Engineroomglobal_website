<?php
/**
 * Template Name: Landing Page
 *
 * @package gentium
 */

get_header(); ?>
<div id="primary" class="page-builder-template page-landing">
    <div class="page-builder-row">
        <?php
        while ( have_posts() ) : the_post();

            get_template_part( 'components/page/content', 'page' );

        endwhile; // End of the loop.
        ?>
    </div>
</div>
<?php
get_footer();
