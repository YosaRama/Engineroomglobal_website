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
        
        <div class="portfolio-list">

          <div class="portfolio-list-selector">
            <button class="portfolio-list-selector-button" data-list="branding">Branding</button>
            <button class="portfolio-list-selector-button" data-list="website">Website</button>
          </div>

          <?php $index = 0; $container_slot = 0; ?>
          <div class="portfolio-list-items portfolio-list-items-all">
            <?php do{ ?>
              <?php if($container_slot % 4 == 0): ?><div class="portfolio-list-column"> <?php endif; ?>
              
              <?php
                $content_link = (get_field('clickable', $posts[$index]->ID) && get_field('clickable', $posts[$index]->ID) == 'yes') ? 'href="'.esc_url(get_permalink($posts[$index]->ID)).'"' : '';
                $is_clickable = ($content_link != '') ? '' : 'disable-click';
                list($r, $g, $b) = sscanf(get_field('overlay_color', $posts[$index]->ID), "#%02x%02x%02x");
              ?>

              <div class="portfolio-item portfolio-item-popup <?php echo (get_field('layout_size', $posts[$index]->ID))? get_field('layout_size', $posts[$index]->ID) : 'w2-h2'; ?>" data-index="<?php echo $index; ?>">
                <a>
                  <img class="portfolio-bg" alt="<?php echo get_the_title($posts[$index]->ID); ?>" src="<?php echo get_the_post_thumbnail_url($posts[$index]->ID, 'large'); ?>">
                  <div class="portfolio-overlay" style="background: rgba(<?php echo $r.','.$g.','.$b; ?>, 0.9);">
                    <?php if(get_field('portfolio_logo', $posts[$index]->ID)): ?>
                      <img class="portfolio-logo" alt="<?php echo get_the_title($posts[$index]->ID); ?>" src="<?php echo get_field('portfolio_logo', $posts[$index]->ID)['url']; ?>"></img>
                    <?php endif; ?>
                  </div>
                </a>
              </div>
            
              <?php 
                if(get_field('layout_size', $posts[$index]->ID) == 'w2-h2') $container_slot += 4;
                else if(get_field('layout_size', $posts[$index]->ID) == 'w2-h1') $container_slot += 2;
                else if(get_field('layout_size', $posts[$index]->ID) == 'w1-h2') $container_slot += 2;
                else if(get_field('layout_size', $posts[$index]->ID) == 'w1-h1') $container_slot += 1;
                else $container_slot += 4;
                if($container_slot >= 4) $container_slot = 0;
                $index++;
              ?>
              <?php if($container_slot % 4 == 0): ?></div> <?php endif; ?>

            <?php } while($index < count($posts)); ?>
          </div>

          <?php $index = 0; $index_actual = 0; $container_slot = 0; ?>
          <div class="portfolio-list-items portfolio-list-items-branding hide">
            <?php do{ ?>
              
              <?php if(get_field('portfolio_group', $posts[$index]->ID) != 'branding'): $index++; continue; endif;?>

              <?php if($container_slot % 4 == 0): ?><div class="portfolio-list-column"> <?php endif; ?>
              
              <?php
                $content_link = (get_field('clickable', $posts[$index]->ID) && get_field('clickable', $posts[$index]->ID) == 'yes') ? 'href="'.esc_url(get_permalink($posts[$index]->ID)).'"' : '';
                $is_clickable = ($content_link != '') ? '' : 'disable-click';
                list($r, $g, $b) = sscanf(get_field('overlay_color', $posts[$index]->ID), "#%02x%02x%02x");
              ?>

              <div class="portfolio-item portfolio-item-popup <?php echo (get_field('layout_size_alt', $posts[$index]->ID))? get_field('layout_size_alt', $posts[$index]->ID) : 'w2-h2'; ?>" data-index="<?php echo $index_actual; ?>">
                <a>
                  <img class="portfolio-bg" alt="<?php echo get_the_title($posts[$index]->ID); ?>" src="<?php echo get_the_post_thumbnail_url($posts[$index]->ID, 'large'); ?>">
                  <div class="portfolio-overlay" style="background: rgba(<?php echo $r.','.$g.','.$b; ?>, 0.9);">
                    <?php if(get_field('portfolio_logo', $posts[$index]->ID)): ?>
                      <img class="portfolio-logo" alt="<?php echo get_the_title($posts[$index]->ID); ?>" src="<?php echo get_field('portfolio_logo', $posts[$index]->ID)['url']; ?>"></img>
                    <?php endif; ?>
                  </div>
                </a>
              </div>
            
              <?php 
                if(get_field('layout_size_alt', $posts[$index]->ID) == 'w2-h2') $container_slot += 4;
                else if(get_field('layout_size_alt', $posts[$index]->ID) == 'w2-h1') $container_slot += 2;
                else if(get_field('layout_size_alt', $posts[$index]->ID) == 'w1-h2') $container_slot += 2;
                else if(get_field('layout_size_alt', $posts[$index]->ID) == 'w1-h1') $container_slot += 1;
                else $container_slot += 4;
                if($container_slot >= 4) $container_slot = 0;
                $index++; $index_actual++;
              ?>
              <?php if($container_slot % 4 == 0): ?></div> <?php endif; ?>

            <?php } while($index < count($posts)); ?>
          </div>

          <?php $index = 0; $index_actual = 0; $container_slot = 0; ?>
          <div class="portfolio-list-items portfolio-list-items-website hide">
            <?php do{ ?>

              <?php if(get_field('portfolio_group', $posts[$index]->ID) != 'website'): $index++; continue; endif;?>

              <?php if($container_slot % 4 == 0): ?><div class="portfolio-list-column"> <?php endif; ?>
              
              <?php
                $content_link = (get_field('clickable', $posts[$index]->ID) && get_field('clickable', $posts[$index]->ID) == 'yes') ? 'href="'.esc_url(get_permalink($posts[$index]->ID)).'"' : '';
                $is_clickable = ($content_link != '') ? '' : 'disable-click';
                list($r, $g, $b) = sscanf(get_field('overlay_color', $posts[$index]->ID), "#%02x%02x%02x");
              ?>

              <div class="portfolio-item portfolio-item-popup <?php echo (get_field('layout_size_alt', $posts[$index]->ID))? get_field('layout_size_alt', $posts[$index]->ID) : 'w2-h2'; ?>" data-index="<?php echo $index_actual; ?>">
                <a>
                  <img class="portfolio-bg" alt="<?php echo get_the_title($posts[$index]->ID); ?>" src="<?php echo get_the_post_thumbnail_url($posts[$index]->ID, 'large'); ?>">
                  <div class="portfolio-overlay" style="background: rgba(<?php echo $r.','.$g.','.$b; ?>, 0.9);">
                    <?php if(get_field('portfolio_logo', $posts[$index]->ID)): ?>
                      <img class="portfolio-logo" alt="<?php echo get_the_title($posts[$index]->ID); ?>" src="<?php echo get_field('portfolio_logo', $posts[$index]->ID)['url']; ?>"></img>
                    <?php endif; ?>
                  </div>
                </a>
              </div>
            
              <?php 
                if(get_field('layout_size_alt', $posts[$index]->ID) == 'w2-h2') $container_slot += 4;
                else if(get_field('layout_size_alt', $posts[$index]->ID) == 'w2-h1') $container_slot += 2;
                else if(get_field('layout_size_alt', $posts[$index]->ID) == 'w1-h2') $container_slot += 2;
                else if(get_field('layout_size_alt', $posts[$index]->ID) == 'w1-h1') $container_slot += 1;
                else $container_slot += 4;
                if($container_slot >= 4) $container_slot = 0;
                $index++; $index_actual++;
              ?>
              <?php if($container_slot % 4 == 0): ?></div> <?php endif; ?>

            <?php } while($index < count($posts)); ?>
          </div>

        </div>

        <div class="portfolio-gallery" data-index="0" data-count="<?php echo count($posts); ?>" data-list="all">
          <div class="portfolio-gallery-close fa fa-close"></div>
          <div class="portfolio-gallery-content">
            <img class="portfolio-gallery-image" src="">
            <div class="portfolio-gallery-label"></div>
          </div>
          <div class="portfolio-gallery-nav">
            <div class="portfolio-gallery-nav-button portfolio-gallery-nav-prev fa fa-angle-left"></div>
            <div class="portfolio-gallery-nav-button portfolio-gallery-nav-next fa fa-angle-right"></div>
          </div>
        </div>

      <?php endif; ?>
    </main>
	</div>

<?php
get_footer();