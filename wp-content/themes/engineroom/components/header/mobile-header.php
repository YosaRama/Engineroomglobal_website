<?php
/**
 * Mobile Header Template
 *
 * @package Gentium
 * 
*/ 

$heading = get_theme_mod( 'mobile_logo_heading_tag', 'h2' );
$sticky_mobile_header = get_theme_mod('sticky_mobile_header_on',false);
$offset = get_theme_mod('stm_header_offset', 30);
$animation = get_theme_mod('stm_header_animation', 'uk-animation-fade');
$show_on_up_attr = '';
$admin_bar_offset = '';
$show_on_up = get_theme_mod('stm_header_on_scroll_up', false);
if( $show_on_up == true){
    $show_on_up_attr = "show-on-up: true";
}
if( is_admin_bar_showing()){
    $admin_bar_offset = "offset: 32;";
}

$page_menu_layout = get_post_meta( get_the_ID(), 'pixe_page_menu_layout', true );

if ( is_page_template('template-one-page-builder.php') ){
    $menu_location = 'menu-one-page';
}elseif ( has_nav_menu( 'menu-2' ) ){
    $menu_location = 'menu-2';
}else{
    $menu_location = 'menu-1';
}

if($page_menu_layout == 'white') $header_mobile_class = 'page-menu-white';
else if($page_menu_layout == 'phone') $header_mobile_class = 'page-menu-phone';
else $header_mobile_class = '';

?>
<header id="mobile-header" class="<?=$header_mobile_class?> uk-hidden@l"
<?php if($sticky_mobile_header == true) { ?>
     data-uk-sticky="top: <?php echo esc_attr($offset) ?>vh; animation: <?php echo esc_attr($animation) ?>; <?php echo esc_attr($admin_bar_offset); echo esc_attr($show_on_up_attr) ?>"
<?php } ?>>
    <div class="page-mobile-header">
        <div class="uk-container">
            <div class="inner">
                <div class="uk-width-1-1">
                    <div class="header-wrap">
                        <div class="branding">
                            <div class="mobile-logo">
                            <?php 
                                $pixe_mobile_logo = get_theme_mod( 'mobile_logo_img','');
                                if($pixe_mobile_logo !='' || function_exists( 'the_custom_logo' ) && has_custom_logo()){ 

                                    if($pixe_mobile_logo !=''){ ?>
                                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                            <img src="<?php echo esc_url( $pixe_mobile_logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
                                        </a>
                                    <?php } else{ 
                                        if( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {  
                                        $mobile_logo_id 	= get_theme_mod( 'custom_logo' );
                                        $mobile_logo 		= wp_get_attachment_image_src( $mobile_logo_id , 'full' );?>
                                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                            <img src="<?php echo esc_url($mobile_logo[0]); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
                                        </a>		
                                    <?php }
                                    }
                                
                                } else { ?>
                                <<?php echo esc_attr( $heading ); ?> class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"
                                rel="home"><?php bloginfo( 'name' ); ?></a></<?php echo esc_attr( $heading ); ?>>
                            <?php } ?>
                            </div>
                        </div>
                        <div class="header-right">
                            <?php if ( has_nav_menu( $menu_location ) ) : ?>
                                <div class="toggle-icon" data-uk-toggle="target: #navbar-mobile">
                                    <i></i>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div><!-- .row END -->
        </div><!-- .container END -->
    </div>
</header><!-- End header section -->
<!-- <div class="mobile-navigation-overlay"></div> -->
<div class="pr__mobile__nav" id="navbar-mobile" data-uk-offcanvas="overlay: true; flip:true; mode:none;">
    <div class="uk-offcanvas-bar">

        <a class="uk-offcanvas-close" data-uk-close="ratio: 2;"></a>
        <nav class="menu" data-uk-scrollspy-nav="offset: 0; closest: li; scroll: false">
        <?php 
        $mobile_menu_args = array(
            'container'       => 'ul',
            'theme_location'  => $menu_location,
            'menu_class'      => 'ul-menu',
            'items_wrap'      => '<ul data-uk-scrollspy="target: > li; cls:uk-animation-slide-right; delay: 100; repeat: true;" class="%2$s" id="%1$s">%3$s</ul>',
        );
        $mobile_menu_phone_args = array(
            'container'       => 'ul',
            'menu'            => 'header-with-phone',
            'menu_class'      => 'ul-menu',
            'items_wrap'      => '<ul data-uk-scrollspy="target: > li; cls:uk-animation-slide-right; delay: 100; repeat: true;" class="%2$s" id="%1$s">%3$s</ul>',
        );
        
        if ( has_nav_menu( $menu_location ) ) :
            if ($page_menu_layout == 'phone'){
                wp_nav_menu( $mobile_menu_phone_args ); 
            }
            else{
                wp_nav_menu( $mobile_menu_args ); 
            }
        endif; 
        ?>
        </nav>

    </div><!-- Off Canvas Bar End --> 
</div><!-- Mobile Nav End -->
