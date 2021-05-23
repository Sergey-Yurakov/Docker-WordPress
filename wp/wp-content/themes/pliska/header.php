<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package pliska
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body 
<?php
body_class();
pliska_schema_microdata( 'body' );
?>
>
	<?php do_action( 'wp_body_open' ); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'pliska' ); ?></a>

<header id="masthead" class="site-header" role="banner" <?php pliska_schema_microdata( 'header' ); ?>>
	<div class="main-navigation-container">
		<div class="site-branding">
			<?php
				pliska_the_logo();
			if ( display_header_text() == true ) :
				?>
				<div class="site-title">
					 <a href="<?php echo esc_url( home_url( '/' ) ); ?>" <?php pliska_schema_microdata( 'site-title' ); ?> rel="home" ><?php bloginfo( 'name' ); ?></a>
					<?php
					$pliska_description = get_bloginfo( 'description', 'display' );
					if ( $pliska_description || is_customize_preview() ) :
						?>
						<p class="site-description" <?php pliska_schema_microdata( 'site-description' ); ?>> <?php echo $pliska_description; ?></p>
					<?php endif; ?> 
				</div> 
			<?php endif; ?>
		</div><!-- .site-branding -->
		<!--main nav -->
		<nav id="main-navigation" class="main-navigation site-menu" role="navigation" tabindex="-1" <?php pliska_schema_microdata( 'menu' ); ?>>
			<?php do_action( 'pliska_dark_mode_mobile_hook' ); ?>
			<button class="menu-toggle" data-toggle="collapse" aria-controls="top-menu" aria-expanded="false" aria-label="<?php _e('Toggle Navigation', 'pliska')?>">
				<span class="menu-toggle-icon">
					<input class="burger-check" id="burger-check" type="checkbox"><label for="burger-check" class="burger"></label>
				</span>
			</button>
			<?php do_action( 'pliska_primary_menu_hook' ); ?>
		</nav>
		<!-- .main nav -->
	</div>
	<?php if ( pliska_has_header_image() ) : ?>
	<div class="header-image-wrapper">
		<?php do_action( 'pliska_header_image_hook' ); ?>
	</div>
		<?php if ( pliska_is_overlay() ) : ?>
	<div class="img-overlay"></div>
		<?php
		endif;
	endif;
	?>
</header>
