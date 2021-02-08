<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package gentium
 */

get_header();

$heading = get_theme_mod('single_heading_tag', 'h1');
?>

<div id="primary" class="pixe-single-full cs-single-post">
    <main id="main" class="uk-width-1-1" role="main">
        <?php while (have_posts()) : the_post(); ?>
        <?php $post_banner = (wp_get_attachment_image_url(get_post_thumbnail_id(), 'full')) ? wp_get_attachment_image_url(get_post_thumbnail_id(), 'full') : '/wp-content/uploads/2020/03/er-bi-gc-small.jpg'; ?>
        <header class="pixe-single-post-header-full uk-background-cover case-study-bg" data-src="<?= $post_banner; ?>"
            data-uk-img data-uk-parallax="bgy: -200">
            <div class="single-post-heade-container uk-container cs-header-post">
                <div class="single-post-heade-content uk-margin-auto uk-width-xxlarge cs-header-box">
                    <div class="category"><?php the_category(', '); ?></div>
                    <div>
                        <h2 class="service-offered-title"><?= strtoupper(get_field('services_offered')) ?></h2>
                    </div>
                    <?php if (get_field('banner_title') && get_field('banner_title') != ''): ?>
                    <h1 class="entry-title uk-h1 cs-post-title"><?=get_field('banner_title')?></h1>
                    <?php endif; ?>
                </div>
            </div>
        </header>
        <div class="single-post-content uk-container cs-single-content">
            <article>
                <div class="outer uk-grid-large uk-flex" data-uk-grid>
                    <div class="entry-content-inner uk-width-expand cs-content-container">
                        <div class="entry-body clrfix">
                            <?php the_content(); ?>
                            <?php
                                // Split Pages Pagination
                                wp_link_pages(array(
                                    'before'        => '<div class="pixe-split-pages">',
                                    'after'         => '</div>',
                                    'link_before'   => '<span>',
                                    'link_after'    => '</span>'
                                )); ?>
                        </div>
                        <?php
                            // Comments
                            if (comments_open() || get_comments_number()) {
                                if (!post_password_required()) { ?>
                        <div class="post-comment-warp uk-flex">
                            <div class="uk-width-1-1">
                                <?php
                                            // If comments are open or we have at least one comment, load up the comment template.
                                            comments_template(); ?>
                            </div>
                        </div>
                        <?php }
                            } ?>
                    </div>
                    <div class="entry-sidebar uk-width-1-5@m uk-flex-first@m uk-first-column cs-sidebar">
                        <div class="post-enty-meta cs-sidebar-list">
                            <ul class="content uk-list uk-list-divider">
                                <?php if (get_field('services_offered') != "") : ?>
                                <li class="service-offered">
                                    <strong><?php esc_html_e('Services Offered:', 'gentium'); ?></strong>
                                    <span><?php echo get_field('services_offered') ?></span>
                                </li>
                                <?php endif; ?>
                                <?php if (get_field('project_duration') != "") : ?>
                                <li class="project-duration">
                                    <strong><?php esc_html_e('Project Duration:', 'gentium'); ?></strong>
                                    <span><?php echo get_field('project_duration'); ?></span>
                                </li>
                                <?php endif; ?>
                                <?php if (get_field('completed_by') != "") : ?>
                                <li class="completed-by">
                                    <strong><?php esc_html_e('Completed By:', 'gentium'); ?></strong>
                                    <span><?php echo get_field('completed_by'); ?></span>
                                </li>
                                <?php endif; ?>
                                <?php if (has_tag()) { ?>
                                <li class="tags">
                                    <strong><?php esc_html_e('Tags:', 'gentium'); ?></strong>
                                    <span><?php the_tags('', ', ', ''); ?></span>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <?php if (function_exists('pixe_post_share')) { ?>
                        <div class="post-share-container cs-social-icon">
                            <?php pixe_post_share(); ?>
                        </div>
                        <?php } ?>
                    </div>
                </div><!-- .entry-content -->
            </article><!-- #post-## -->
        </div>
        <?php endwhile; // End of the loop.
        ?>
    </main>
</div>
<?php
get_footer();