<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to generate_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package gentium
 */

if ( post_password_required() ) {
	return;
}
?>


<section id="comments" class="post-comments">

	<?php if ( have_comments() ) { ?>
		<h3 class="title-block">
			<?php
			$comments_number = get_comments_number();
			if ( 1 === $comments_number ) {
				esc_html_e( 'One comment', 'gentium' );
			} else {
				printf( esc_html( _n( '%s comment', '%s comments', $comments_number, 'gentium' ) ), intval( number_format_i18n( $comments_number ) ) );
			}
			?>
		</h3>

		<ol class="comment-list">
			<?php
			wp_list_comments(array(
				'avatar_size'	=> 60,
				'max_depth'		=> 5,
				'style'			=> 'ol',
				'callback'		=> 'pixe_comments',
				'type'			=> 'all'
			));
			?>
		</ol><!-- .comment-list -->

		<?php the_comments_navigation(); ?>

	<?php } // End if(). ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) {
		?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'gentium' ); ?></p>
		<?php } ?>

		<?php
			$custom_comment_field = '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>';  //label removed for cleaner layout
			$aria_req = '';
			$cmnt_fields =  array(

				'author' =>
				'<p class="comment-form-author"><input id="author" placeholder="'. esc_attr__('Name', 'gentium') .'" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .'" size="30"' . $aria_req . ' /></p>',

				'email' =>
				'<p class="comment-form-email"><input id="email" placeholder="'. esc_attr__('Email', 'gentium') .'" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .'" size="30"' . $aria_req . ' /></p>',

				'url' =>
				'<p class="comment-form-url"><input id="url" placeholder="'. esc_attr__('Website', 'gentium') .'" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .'" size="30" /></p>',
			);
			
			comment_form(array(
				'comment_field'			=> $custom_comment_field,
				'comment_notes_after'	=> '',
				'logged_in_as' 			=> '',
				'comment_notes_before' 	=> '',
				'title_reply'			=> esc_attr__('Leave a Reply', 'gentium'),
				'cancel_reply_link'		=> esc_attr__('Cancel Reply', 'gentium'),
				'label_submit'			=> esc_attr__('Post Comment', 'gentium'),
				'fields' => $cmnt_fields,
			));
		?>

</section><!-- .comments-area -->
