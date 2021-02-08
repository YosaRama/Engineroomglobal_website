<?php

get_header(); ?>
<div id="primary" class="page-builder-template">
    <div class="page-builder-row">
        <?php
        while ( have_posts() ) : the_post();

            get_template_part( 'components/page/content', 'page' );

        endwhile; // End of the loop.
        ?>
        <?php get_template_part( 'components/footer/contact' ); ?>
    </div>
</div>
<?php
get_footer();
