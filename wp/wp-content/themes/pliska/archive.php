<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pliska
 */

get_header();
?>
<!--Site wrapper-->
<div class="wrapper">
	<main id="primary" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				
				// Display post excerpt content.
					get_template_part( 'template-parts/content-excerpt', get_post_type() );

			endwhile;
			do_action('pliska_pagination_hook');
		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</main><!-- #main -->
	<?php if(!pliska_is_post_archives_fullwidth()) : get_sidebar(); endif; ?>
</div>

<?php get_footer();