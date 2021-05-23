<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package draftly
 */

?>
<?php if ( has_post_thumbnail() ) : ?>
	<div>
		<?php the_post_thumbnail('draftly-slider'); ?>
	</div>
<?php endif; ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('posts-entry fbox'); ?>>

	<?php if ( is_single() ) : ?>
	<div class="blog-data-wrapper">
		<div class="post-data-text">
			<?php draftly_posted_on(); ?>
		</div>
	</div><!-- .entry-meta -->
<?php endif; ?>
<header class="entry-header">
	<?php
	if ( is_singular() ) :
		the_title( '<h1 class="entry-title">', '</h1>' );
	else :
		the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
	endif;

	if ( 'post' === get_post_type() ) : ?>

	<?php
	endif; ?>
</header><!-- .entry-header -->

<div class="entry-content">
	<?php the_content(); ?>

	<?php
	wp_link_pages( array(
		'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'draftly' ),
		'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
