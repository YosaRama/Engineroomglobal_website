<?php
/**
 * Header Builder Template
 *
 * @package Gentium
 * 
*/ 

$pixe_stheader_template = get_theme_mod( 'select_header_template' );
$args = array( 'post_type' => 'pixe_templates', 'p' => $pixe_stheader_template );
?>

<div class="pixe_header_holder">
    <?php
    $loop = new WP_Query( $args );
        while ( $loop->have_posts() ) : $loop->the_post();
            the_content();
        endwhile;
    wp_reset_postdata();
    ?>
</div>