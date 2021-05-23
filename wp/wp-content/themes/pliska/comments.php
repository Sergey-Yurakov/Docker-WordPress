<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pliska
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h2 class="comments-title">
			<?php
			$pliska_comment_count = get_comments_number();
			if ( '1' === $pliska_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One Comment', 'pliska' )
				);
			} else {
				printf( 
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s Comment', '%1$s Comments', $pliska_comment_count, 'comments title', 'pliska' ) ),
					number_format_i18n( $pliska_comment_count ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
			}
			?>
		</h2><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'short_ping' => true,
					'avatar_size' => 100,
					'callback' => 'pliska_comment',
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'pliska' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

	comment_form(array(
        'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
        'title_reply_after' => '</h2>',
        'title_reply' => __('Leave a Comment', 'pliska'),
        'class_submit' => 'btn-comment',
        'label_submit' => __('Post Comment', 'pliska'),
        'comment_field' => '<p class="comment-form-comment">' .
        '<label for="comment">' . __('Message', 'pliska') . '</label>' .
        '<textarea id="comment" name="comment" class="form-control" cols="45" rows="8" aria-required="true"></textarea>' .
        '</p>',
    ));
	?>

</div><!-- #comments -->
