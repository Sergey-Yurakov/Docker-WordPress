<?php
/**
 * Template part for displaying related post
 *
 * @package Color Blog Dark
 * @since 1.0.0
 */

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

	<footer class="entry-footer">
		<?php color_blog_dark_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->