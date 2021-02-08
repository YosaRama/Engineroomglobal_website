<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package gentium
 */

?>
	</div>
    
    <?php if(!is_404() && !is_page_template('page-thank-you.php') && !is_front_page()) : ?>
    <!-- site-footer -->
    <?php get_template_part( 'components/footer/footer' ); ?>
    <?php get_template_part( 'components/footer/contact' ); ?>
    <?php endif; ?>
    
    <?php if(!is_404() && !is_page_template('page-thank-you.php')) : ?>
    <?php get_template_part( 'components/widget/call-button' ); ?>
    <?php endif; ?>

</div>
<?php wp_footer(); ?>
</body>
</html>
