<?php
/**
 * Header Builder Template
 *
 * @package Gentium
 * 
*/ 

$args = array( 'post_type' => 'pixe_templates', 'name' => 'header-white' );
?>

<div class="pixe_header_holder header-menu-white">
    <?php
    $loop = new WP_Query( $args );
        while ( $loop->have_posts() ) : $loop->the_post();
            the_content();
        endwhile;
    wp_reset_postdata();
    ?>
</div>