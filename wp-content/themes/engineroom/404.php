<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package gentium
 */

get_header(); ?>

    <div class="page-404-content" style="background-image: url('/wp-content/uploads/2020/04/vlad-hilitanu-POecJARFtAc-unsplash-scaled.jpg');">
        <div class="uk-container">
            <div class="uk-flex uk-flex-center uk-flex-middle full-height">
                <div class="uk-1-1">
                    <div class="error-404 not-found">
                        <header class="page-header">
                            <h1 class="page-title"><?php esc_html_e( '404', 'gentium' ); ?></h1>
                            <span><?php esc_html_e( 'Page Not Found', 'gentium' ); ?></span>
                        </header>

                        <div class="page-content">
                            <p><?php esc_html_e( 'It looks like nothing was found at this location. try another link or click the button below.', 'gentium' ); ?></p>
                            <div class="btn-back">
                                <a href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html_e('BACK TO HOME','gentium');?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>

<?php
get_footer();
