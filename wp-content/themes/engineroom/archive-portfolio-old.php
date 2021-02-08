<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package gentium
 */

get_header();

// Get Post
$args = array(
  'post_type' => 'portfolio',
  'posts_per_page' => -1,
  'orderby' => 'publish_date',
  'order' => 'DESC'
);
$posts = get_posts($args);

?>


	<div id="primary" class="uk-container">
    <main id="main" class="uk-width-1-1" role="main">
      <?php if(count($posts) > 0) : ?>
        <div class="portfolio-list <?php echo (count($posts) % 2 == 1)? 'portfolio-last-item-full' : ''; ?>">
          <?php foreach($posts as $post): ?>
            <?php
              $content_link = (get_field('clickable') && get_field('clickable') == 'yes') ? 'href="'.esc_url(get_permalink($post->ID)).'"' : '';
              $is_clickable = ($content_link != '') ? '' : 'disable-click';
              list($r, $g, $b) = sscanf(get_field('overlay_color'), "#%02x%02x%02x");
            ?>
            <div class="portfolio-item">
              <a class="<?= $is_clickable ?>" <?php echo $content_link; ?>>
                <img class="portfolio-bg" alt="<?php echo get_the_title($post->ID); ?>" src="<?php echo get_the_post_thumbnail_url($post->ID, 'large'); ?>">
                <div class="portfolio-overlay" style="background: rgba(<?php echo $r.','.$g.','.$b; ?>, 0.9);">
                  <?php if(get_field('portfolio_logo', $post->ID)): ?>
                    <img class="portfolio-logo" alt="<?php echo get_the_title($post->ID); ?>" src="<?php echo get_field('portfolio_logo', $post->ID)['url']; ?>"></img>
                  <?php endif; ?>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </main>
	</div>

<?php
get_footer();