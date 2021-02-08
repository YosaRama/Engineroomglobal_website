<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Gentium
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php
			the_content();

			// Split Pages Pagination
			wp_link_pages(array(
				'before'        => '<div class="pixe-split-pages">',
				'after'         => '</div>',
				'link_before'   => '<span>',
				'link_after'    => '</span>'
			));
		?>
	</div>
</article><!-- #post-## -->
