<?php
/**
 * Template part for displaying posts.
 *
 * Chess Style
 * 
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Gentium
 */

$excerpt_lenghth = get_theme_mod('post_excerpt_length',30);
$heading = get_theme_mod( 'blog_heading_tag', 'h2' );
$content_link = (get_field('clickable') && get_field('clickable') == 'yes') ? 'href="'.esc_url(get_permalink()).'"' : '';
$is_clickable = ($content_link != '') ? '' : 'disable-click';
?>
<div class="chess-item item uk-width-1-3@l uk-width-1-3@m uk-animation-slide-bottom">
    <article class="post type-post <?= $is_clickable ?>">
        <div class="outer uk-card">
            <div class="featured-image uk-card-media-right uk-cover-container chess">
                <div class="image pr__image__cover pr__ratio__square" data-src="<?php the_post_thumbnail_url('pixe-grid-image');?>" data-uk-img></div>
                <a <?= $content_link ?> class="link"></a>
            </div>
            <div class="inner uk-card-body chess">
                <div class="top">
                    <span class="category"><?php the_category(', '); ?></span>
                    <<?php echo esc_attr( $heading ); ?> class="blog-entry-title entry-title">
                        <a <?= $content_link ?> title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
                    </<?php echo esc_attr( $heading ); ?>><!-- .blog-entry-title -->
                    <p><?php echo pixe_words_limit(get_the_excerpt(), $excerpt_lenghth); ?></p>
                </div>
                <div class="bottom">
                    <ul class="meta">
                        <li class="meta-date"><?php echo get_the_date(); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </article>
</div>