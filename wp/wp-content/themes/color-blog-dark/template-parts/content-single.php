<?php
/**
 * Template part for displaying single post
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Color Blog Dark
 * @since 1.0.0
 */

if ( has_post_thumbnail() ) {
    $post_class = 'has-thumbnail';
} else {
    $post_class = 'no-thumbnail';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>>
	<div class="post-thumbnail">
		<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'full' );
			}
		?>
		<div class="post-info-wrap">
			<div class="post-cat"><?php color_blog_dark_article_categories_list(); ?></div>
			<div class="entry-meta"> 
				<?php 
					color_blog_dark_posted_on();
					color_blog_dark_posted_by();
				?> 
			</div>
			<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
	    </div><!--.post-info-wrap -->
	</div><!-- .post-thumbnail -->

	<div class="entry-content">
		<?php
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
			wp_link_pages( array(
		        'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'color-blog-dark' ),
		        'after'  => '</div>',
		    ) );
		?>
	</div> <!-- .entry-content -->

	<footer class="entry-footer">
		<?php color_blog_dark_entry_footer(); ?>
	</footer><!-- .entry-footer -->
	<?php get_template_part( 'template-parts/author/post', 'author-box' ); ?>
</article><!-- #post-<?php the_ID(); ?> -->