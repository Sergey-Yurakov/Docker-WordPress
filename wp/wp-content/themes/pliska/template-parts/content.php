<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pliska
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content" <?php pliska_schema_microdata( 'entry-content' ); ?> >
		<?php //display post rating system
		if (function_exists('pliska_ajax_post_likes')) {
			pliska_ajax_post_likes();
		}
		 // display social share buttons
		if (function_exists('pliska_social_posts_share')) {
			pliska_social_posts_share();
		}
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'pliska' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'pliska' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php pliska_entry_footer();
		//display post rating system
		if (function_exists('pliska_ajax_post_likes')) {
			pliska_ajax_post_likes();
		}
		pliska_social_posts_share(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->