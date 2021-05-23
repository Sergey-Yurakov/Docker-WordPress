<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package pliska
 */

get_header();
?>
<!--Site wrapper-->
<div id="wrapper" class="wrapper">
	<main id="primary" class="site-main" role="main">
		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

			pliska_auhor_box_markup(); //display author box

			pliska_the_post_navigation();

			pliska_display_related_posts(); // display related posts

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->
	<?php if(!pliska_is_post_fullwidth()) : get_sidebar(); endif; ?>
</div>

<?php get_footer();
