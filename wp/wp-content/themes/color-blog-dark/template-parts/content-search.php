<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Color Blog Dark
 * @since 1.0.0
 */
$post_content_type = apply_filters( 'color_blog_dark_archive_post_content_type', 'excerpt' );
if ( has_post_thumbnail() ) {
    $post_class = 'has-thumbnail wow fadeInUp';
} else {
    $post_class = 'no-thumbnail wow fadeInUp';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>>
	<?php
		echo '<div class="thumb-cat-wrap">';
			color_blog_dark_post_thumbnail();
			color_blog_dark_article_categories_list();
		echo '</div><!-- .thumb-cat-wrap -->';
		if ( 'post' === get_post_type() ) {
	?>
		<div class="entry-cat">
			<?php
				color_blog_dark_posted_on();
				color_blog_dark_posted_by();
			?>
		</div><!-- .entry-meta -->
	<?php } ?>

	<header class="entry-header">
		<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			if ( 'excerpt' === $post_content_type ) {
				the_excerpt();
			} elseif ( 'content' === $post_content_type ) {
				the_content( sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'color-blog-dark' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				) );
			}
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php color_blog_dark_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->