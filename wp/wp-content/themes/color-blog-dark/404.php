<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Pag
 *
 * @package Color Blog Dark
 * @since 1.0.0
 */

get_header();
$color_blog_dark_pnf_latest_posts = get_theme_mod( 'color_blog_dark_enable_pnf_latest_posts', true );
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<section class="error-404 not-found">
				<div class="error-num"><?php esc_html_e( '404', 'color-blog-dark' ); ?><span><?php esc_html_e( 'error', 'color-blog-dark' );?></span></div>
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'color-blog-dark' ); ?></h1>
				</header><!-- .page-header -->
				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location.', 'color-blog-dark' ); ?></p>
			</section><!-- .error-404 -->

			<?php if ( true ===  $color_blog_dark_pnf_latest_posts ) { ?>
			<div class="page-extra-content mt-404-latest-posts-wrapper">
				<?php
					$color_blog_dark_pnf_latest_post_count = get_theme_mod( 'color_blog_dark_pnf_latest_post_count', 3 );
					$color_blog_dark_pnf_args = array(
						'post_type' 			=> 'post',
						'posts_per_page' 		=> absint( $color_blog_dark_pnf_latest_post_count ),
						'ignore_sticky_posts' 	=> 1,
					);
					$color_blog_dark_pnf_query = new WP_Query( $color_blog_dark_pnf_args );
					if ( $color_blog_dark_pnf_query->have_posts() ) {
						echo '<div class="mt-pnf-latest-posts-wrapper mt-related-posts-wrapper">';
						$color_blog_dark_404_latest_title = get_theme_mod( 'color_blog_dark_pnf_latest_title', __( 'You May Like' ,'color-blog-dark' ) );
						echo '<h2 class="section-title mt-related-post-title">'. esc_html( $color_blog_dark_404_latest_title ) .'</h2>';
						while ( $color_blog_dark_pnf_query->have_posts() ) {
							$color_blog_dark_pnf_query->the_post();

							/*
							 * Include the Post-Type-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
							 */
							get_template_part( 'template-parts/content', 'related' );
							
						}
						echo '</div><!-- .mt-pnf-latest-posts-wrapper -->';
					}
					wp_reset_postdata();
				?>
			</div><!-- .page-extra-content -->

		<?php } ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();