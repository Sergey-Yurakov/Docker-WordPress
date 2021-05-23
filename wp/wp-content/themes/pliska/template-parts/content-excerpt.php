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
	<?php if ( has_post_thumbnail() ) : ?>
	<div class="img-wrapper">
		<div class="top-meta">
			<?php pliska_posted_in(); ?>
		</div><!-- .entry-meta -->
		<?php pliska_post_thumbnail( 'medium' ); ?>
	</div>
	<?php else : ?>
		<div class="top-meta no-image">
			<?php pliska_posted_in(); ?>
		</div><!-- .entry-meta --> 
	<?php endif; ?>
	<div class="text-wrapper <?php echo esc_attr( ! has_post_thumbnail() ? 'no-image' : '' ); ?>">
		<header class="entry-header">
			<?php if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php do_action( 'pliska_header_before_post_archives_hook' ); ?>
				</div>
				<?php
			endif;
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;
			?>
			<div class="entry-meta"> 
			<?php do_action( 'pliska_header_after_post_archives_hook' ); ?>
			</div>
		</header><!-- .entry-header -->

		<div class="entry-content" <?php pliska_schema_microdata( 'entry-content' ); ?> >
			
			<?php pliska_the_excerpt( 15 ); ?>
		
		</div><!-- .entry-content -->
		<?php if ( 'post' === get_post_type() ) : ?>
		<footer class="entry-footer">
			<?php do_action( 'pliska_entry_footer_post_archives_hook' ); ?>
		</footer><!-- .entry-footer -->
		<?php endif; ?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
