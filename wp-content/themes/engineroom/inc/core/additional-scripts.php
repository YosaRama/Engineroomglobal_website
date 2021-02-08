<?php
if(get_theme_mod( 'custom_scripts') != ''):
    function pixe_custom_scripts() {
       wp_add_inline_script( 'pixe-scripts', ''.esc_js(get_theme_mod( 'custom_scripts')).'' );
    }
    add_action( 'wp_enqueue_scripts', 'pixe_custom_scripts' );
endif;
