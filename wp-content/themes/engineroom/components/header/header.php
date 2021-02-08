<?php
/**
 * Header Template
 *
 * @package Gentium
 * 
*/

$pixe_header_layout = get_theme_mod('header_layout_type','header-1'); 
$pixe_sticky_header = get_theme_mod('show_sticky_header', false);
$page_menu_layout = get_post_meta( get_the_ID(), 'pixe_page_menu_layout', true );

?>


	<header id="masthead" class="site-header" itemscope="itemscope" itemtype="https://schema.org/WPHeader">
		<div class="pixe_header_holder">
			<?php 
				if($pixe_header_layout == 'header-1'){ 
					get_template_part( 'components/header/header', '1' );
				}
				else if($page_menu_layout == 'white'){ 
					get_template_part( 'components/header/header', 'builder-white' );
				}
				else if($page_menu_layout == 'phone'){ 
					get_template_part( 'components/header/header', 'builder-phone' );
				}
				else{
					get_template_part( 'components/header/header', 'builder' );
				} 
			?>
		</div>
	    <?php 
		 if($pixe_sticky_header == true){ 
			get_template_part( 'components/header/sticky', 'header' );
		} ?>
	</header>
<?php 