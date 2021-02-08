<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Gentium
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="preload" href="/wp-content/themes/engineroom/assets/fonts/ITCAvantGardeStd-Bold.woff2" as="font" type="font/woff2" crossorigin="anonymous">
<link rel="preload" href="/wp-content/themes/engineroom/assets/fonts/OpenSansCondensed-Bold.woff2" as="font" type="font/woff2" crossorigin="anonymous">
<link rel="preload" href="/wp-content/themes/engineroom/assets/fonts/OpenSans-Bold.woff2" as="font" type="font/woff2" crossorigin="anonymous">
<link rel="preload" href="/wp-content/themes/engineroom/assets/fonts/OpenSans-Regular.woff2" as="font" type="font/woff2" crossorigin="anonymous">
<link rel="preload" href="/wp-content/plugins/elementor/assets/lib/font-awesome/fonts/fontawesome-webfont.woff2?v=4.7.0" as="font" type="font/woff2" crossorigin="anonymous">
<link rel="profile" href="https://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php if(defined('WP_LIVE') && WP_LIVE): ?>
  <!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-NMRW33Z');</script>
	<!-- End Google Tag Manager -->
<?php endif; ?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php if(defined('WP_LIVE') && WP_LIVE): ?>
  <!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NMRW33Z"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
<?php endif; ?>

<?php
$preloader_title = get_theme_mod( 'preloader_loading_text', esc_html__( 'Loading', 'gentium' ) );
$pixe_preloader = get_theme_mod('show_preloader', true); 
if($pixe_preloader == true){
?>
<div id="loader" class="preloader pr__dark">
	<span class="loading">
		<span class="txt"><?php echo wp_kses_post( $preloader_title ); ?></span>
		<span class="progress">
			<span class="bar-loading"></span>
		</span>
	</span>
</div><!-- Preloader End -->
<?php } ?>
<div id="site-wrapper" class="site <?php pixe_layouts(); ?>" data-post-type="<?=get_post_type()?>">

	<?php 
		get_template_part( 'components/header/header' );
		get_template_part( 'components/header/mobile', 'header' );
		if(!is_404() && !is_page_template('page-thank-you.php') && get_post_type() != 'case_study'){
			get_template_part( 'components/section-titles/section', 'title');
		}	
	?>

	<div id="content" class="site-content">
