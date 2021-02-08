<?php // Template Name: Thank You Page ?>
<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
get_header(); ?>

    <div class="page-404-content" style="background-image: url('/wp-content/uploads/2020/04/vlad-hilitanu-POecJARFtAc-unsplash-scaled.jpg');">
        <div class="uk-container">
            <div class="uk-flex uk-flex-center uk-flex-middle full-height">
                <div class="uk-1-1">
                    <div class="error-404 not-found">
                        <header class="page-header">
                            <h1 class="page-title">THANK YOU</h1>
                        </header>
                        <div class="page-content">
                            <p>Thanks for reaching out! One of our team members will get back to you within 24 hours.</p>
                            <div class="btn-back">
                                <a href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html_e('BACK TO HOME','gentium');?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setInterval(function(){ window.location.replace('/'); }, 5000);
        }, false);
    </script>

<?php
get_footer();
