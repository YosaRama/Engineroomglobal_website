<?php
/**
 * Default Header Style
 *
 * @package Gentium
 */

if ( is_page_template('template-one-page-builder.php') ){
    $menu_location = 'menu-one-page';
}else{
    $menu_location = 'menu-1';
}

?>
<div class="uk-container">
    <div class="header-wrap">
        <div class="branding">
            <?php 
                if( function_exists( 'the_custom_logo' ) && has_custom_logo() ) : 
                $custom_logo_id 	= get_theme_mod( 'custom_logo' );
                $custom_logo 		= wp_get_attachment_image_src( $custom_logo_id , 'full' );		
            ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                <img src="<?php echo esc_url( $custom_logo[0] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
            </a>
            <?php else : ?>
            <h2 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <?php bloginfo( 'name' ); ?></a></h2>
            <?php endif; ?>
        </div>
        <div class="primary-navigation">
            <?php if ( has_nav_menu( $menu_location ) ) : ?>
            <?php wp_nav_menu( array(
                'container_class' => 'main-nav',
                'theme_location' => $menu_location,
            )); ?>
            <?php else : ?>
            <?php echo sprintf( __('<div class="menu-notice">You have to create a menu then select Primary Menu location using&nbsp;<a href="%s">Menu Builder</a></div>', 'gentium'), admin_url('nav-menus.php') ) ?>
            <?php endif; ?>
            <div class="nav-mobile hidden-lg hidden-md"></div>
        </div>
    </div>
</div>