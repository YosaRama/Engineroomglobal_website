<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Gentium
 */
$excerpt_lenghth = get_theme_mod('post_excerpt_length',30);
$heading = get_theme_mod( 'blog_heading_tag', 'h2' );
$content_link = (get_field('clickable') && get_field('clickable') == 'yes') ? 'href="'.esc_url(get_permalink()).'"' : '';
$is_clickable = ($content_link != '') ? ['pixe-post-item'] : ['disable-click','pixe-post-item'];
?>

<div class="grid-item item uk-width-1-3@m uk-width-1-2@s">
	<article id="post-<?php the_ID(); ?>" <?php post_class($is_clickable); ?>>
		<div class="post-wrap">
			<?php if ( has_post_thumbnail() ) : ?>
				<a <?= $content_link ?>>
					<div class="post-thumb">
						<?php the_post_thumbnail( 'pixe-grid-image' ); ?>	
					</div><!-- .post-thumbnail -->
				</a>
			<?php endif; ?>
			<div class="post-content">
				<<?php echo esc_attr( $heading ); ?> class="blog-entry-title entry-title">
					<a <?= $content_link ?> title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
				</<?php echo esc_attr( $heading ); ?>><!-- .blog-entry-title -->
				<div class="post-entry">
				<p><?php echo pixe_words_limit(get_the_excerpt(), $excerpt_lenghth); ?></p>
				</div>
				<div class="entry-meta">
					<span class="author"><?php esc_html_e( 'By', 'gentium' ); ?> <?php the_author_posts_link(); ?></span>
					<span class="date"><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></span>
				</div>
			</div>
		</div>
	</article><!-- #post-## -->
</div>
