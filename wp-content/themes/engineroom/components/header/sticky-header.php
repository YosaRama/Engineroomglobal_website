<?php
/**
 * Header Builder Template
 *
 * @package Gentium
 * 
*/ 

$pixe_stheader_template = get_theme_mod( 'select_stheader_template');
$page_menu_layout = get_post_meta( get_the_ID(), 'pixe_page_menu_layout', true );
if($page_menu_layout == 'phone'){ 
    $args = array( 'post_type' => 'pixe_templates', 'name' => 'sticky-header-phone' );
}
else{
    $args = array( 'post_type' => 'pixe_templates', 'p' => $pixe_stheader_template );
}
$offset = get_theme_mod('stheader_offset', 50);
$animation = get_theme_mod('stheader_animation', 'uk-animation-fade');
$show_on_up_attr = '';
$admin_bar_offset = '';
$show_on_up = get_theme_mod('stheader_on_scroll_up', false);
if( $show_on_up == true){
    $show_on_up_attr = "show-on-up: true";
}
if( is_admin_bar_showing()){
    $admin_bar_offset = "offset: 32;";
}
$loop = new WP_Query( $args ); ?>
<div class="pixe_sticky_header_holder" data-uk-sticky="top: <?php echo esc_attr($offset) ?>vh; animation: <?php echo esc_attr($animation) ?>; <?php echo esc_attr($admin_bar_offset); echo esc_attr($show_on_up_attr) ?>">
    <?php    
    while ( $loop->have_posts() ) : $loop->the_post();
        the_content();
    endwhile;
    wp_reset_postdata();
    ?>
</div>