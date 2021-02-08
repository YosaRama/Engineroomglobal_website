<?php

function pixe_post_share(){

global $post;

$post_title = get_the_title();
$post_id    = get_the_ID();
$post_url   = get_permalink( $post_id );
$pin_image  = wp_get_attachment_url( get_post_thumbnail_id($post->ID));
$protocol	= is_ssl() ? 'https' : 'http';

?>

<div class="meta-share">
	<a href="https://twitter.com/share?text=<?php echo wp_strip_all_tags( $post_title ); ?>&amp;url=<?php echo rawurlencode( esc_url( $post_url  ) ); ?>" data-uk-tooltip="<?php esc_attr_e( 'Share on Twitter', 'pixerex' ); ?>" onclick="pss_onClick( this.href );return false;">
		<i class="fa fa-twitter"></i>
	</a>
	<a href="https://www.facebook.com/sharer.php?u=<?php echo rawurlencode( esc_url( $post_url  ) ); ?>" data-uk-tooltip="<?php esc_attr_e( 'Share on Facebook', 'pixerex' ); ?>" onclick="pss_onClick( this.href );return false;">
		<i class="fa fa-facebook-official"></i>
	</a>
	<a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo rawurlencode( esc_url( $post_url  ) ); ?>&amp;title=<?php echo wp_strip_all_tags( $post_title ); ?>&amp;summary=<?php echo urlencode( wp_trim_words( strip_shortcodes( get_the_content( $post_id ) ), 40 ) ); ?>&amp;source=<?php echo esc_url( home_url( '/' ) ); ?>" data-uk-tooltip="<?php esc_attr_e( 'Share on Linkedin', 'pixerex' ); ?>" onclick="pss_onClick( this.href );return false;">
		<i class="fa fa-linkedin"></i>
	</a>
</div>

<?php } ?>