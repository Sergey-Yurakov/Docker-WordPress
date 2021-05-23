<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package pliska
 */

do_action( 'pliska_back_to_top_hook');
do_action('pliska_full_screen_search_hook');
?>

<footer id="colophon" class="site-footer" role="complementary" <?php pliska_schema_microdata( 'footer' );?> aria-label="<?php esc_attr_e( 'Footer', 'pliska' ); ?>">
<?php do_action('pliska_social_icons_hook');
		//Add content to the footer
		if ( is_active_sidebar( 'sidebar-2' ) || is_active_sidebar( 'sidebar-3' ) ) : ?>
		<div class="wrapper widget-area" <?php pliska_schema_microdata( 'sidebar' );?> aria-label="<?php esc_attr_e( 'Footer Widget Area', 'pliska' ); ?>">
			<?php
				if ( is_active_sidebar( 'sidebar-2' ) ) { ?>
			<div class="widget-column footer-widget-1">
				<?php dynamic_sidebar( 'sidebar-2' ); ?>
			</div>
			<?php }
				if ( is_active_sidebar( 'sidebar-3' ) ) { ?>
			<div class="widget-column footer-widget-2">
				<?php dynamic_sidebar( 'sidebar-3' ); ?>
			</div>
			<?php } ?>
		</div><!-- .widget-area -->
		<?php endif; ?>
		<div class="site-info">
		<?php do_action('pliska_theme_footer_custom_credits_hook');
		do_action('pliska_theme_footer_credits_hook'); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>