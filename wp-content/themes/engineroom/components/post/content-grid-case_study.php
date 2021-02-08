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
$content_link = 'href="'.esc_url(get_permalink()).'"';
$client_logo = get_field('client_logo');
$article_class = ($content_link != '') ? ['pixe-post-item'] : ['disable-click','pixe-post-item'];
if($client_logo && $client_logo != '') array_push($article_class, 'article-client-logo');
?>

<div class="grid-item item uk-width-1-3@m uk-width-1-2@s">
	<article id="post-<?php the_ID(); ?>" <?php post_class($article_class); ?>>
		<div class="post-wrap">
			<?php if ( has_post_thumbnail() ) : ?>
				<a <?= $content_link ?>>
					<?php if($client_logo && $client_logo != ''): ?>	
						<div class="post-thumb post-thumb-logo">
							<img class="attachment-pixe-grid-image size-pixe-grid-image wp-post-image" src="<?=$client_logo['sizes']['medium']?>" alt="<?php the_title(); ?>">
						</div>
					<?php else: ?>
						<div class="post-thumb">
							<?php the_post_thumbnail( 'pixe-grid-image' ); ?>	
						</div>
					<?php endif; ?>
				</a>
			<?php endif; ?>
			<div class="post-content">
				<<?php echo esc_attr( $heading ); ?> class="blog-entry-title entry-title">
					<a <?= $content_link ?> title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
				</<?php echo esc_attr( $heading ); ?>>
				<div class="post-entry">
					<?php //echo '<pre>'; print_r(get_field('statistic')); echo '</pre>'; die(); ?>
					<?php $statistic = get_field('statistic'); ?>
					<?php if($statistic && $statistic != ''): ?>
						<?php if($statistic['statistic_1_number'] && $statistic['statistic_1_number'] != ''): ?>
							<div class="case-study-stats" style="background:<?=$statistic['color']?>!important;">
								<div class="case-study-stats-number"><?=$statistic['statistic_1_number']?></div>
								<div class="case-study-stats-label"><?=$statistic['statistic_1_description']?></div>
							</div>
						<?php endif; ?>
						<?php if($statistic['statistic_2_number'] && $statistic['statistic_2_number'] != ''): ?>
							<div class="case-study-stats" style="background:<?=$statistic['color']?>!important;">
								<div class="case-study-stats-number"><?=$statistic['statistic_2_number']?></div>
								<div class="case-study-stats-label"><?=$statistic['statistic_2_description']?></div>
							</div>
						<?php endif; ?>
					<?php endif; ?>
					<p><?=get_field('short_description').'...'?></p>
				</div>
				<div class="entry-meta">
					<span class="author"><?php esc_html_e( 'Services Offered : ', 'gentium' ); ?> <span class="text-orange"><?php echo get_field('services_offered'); ?></span></span>
				</div>
			</div>
		</div>
	</article><!-- #post-## -->
</div>
