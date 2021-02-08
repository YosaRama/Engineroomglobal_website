<?php 
$pixe_footer_template = get_theme_mod( 'select_footer_template' );
$args = array( 'post_type' => 'pixe_templates', 'p' => $pixe_footer_template );
$pixe_footer_layout = get_theme_mod('footer_layout_type','footer-1'); ?>
<footer>
<?php if($pixe_footer_layout == 'footer-1'){
	$footer_text = get_theme_mod( 'footer_copy_text', get_bloginfo( 'description' ) ); ?>
	<div class="footer-copyrights">
		<div class="uk-container">
			<?php echo wp_kses_post( $footer_text ); ?>
		</div>
	</div>
<?php 
}else{
	$loop = new WP_Query( $args ); 
    while ( $loop->have_posts() ) : $loop->the_post();
        the_content();
    endwhile;
    wp_reset_postdata();  
} ?>
</footer>
