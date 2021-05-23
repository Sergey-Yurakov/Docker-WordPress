<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Color Blog Dark
 * @since 1.0.0
 */

get_header();
?>
<div class="mt-page-content-wrapper">
	<div itemscope id="primary" class="content-area">
		<main id="main" class="site-main">
		<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', 'single' );

				the_post_navigation();

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			endwhile; // End of the loop.

			$related_posts_option = get_theme_mod( 'color_blog_dark_enable_related_posts', true );
			if ( true === $related_posts_option && 'post' === get_post_type() ) {
				get_template_part( 'template-parts/related/related', 'posts' );
			}
		?>
		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div><!-- .mt-page-content-wrapper -->
<?php
get_footer();