<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Color Blog Dark
 * @since 1.0.0
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

<body <?php body_class(); ?>>

<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		/**
		 * Hook: wp_body_open
		 *
		 * @since 1.1.0
		 */
		do_action( 'wp_body_open' );
	}

	/**
	 * color_blog_dark before page hook 
	 * 
	 * @since 1.0.0
	 */
	do_action( 'color_blog_dark_before_page' );
?>

<div id="page" class="site">
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip To Content', 'color-blog-dark' ) ?></a>
	<?php
		/**
		 * color_blog_dark before header
		 * 
		 * @since 1.0.0
		 */
		do_action( 'color_blog_dark_before_header' );

		$color_blog_dark_enable_top_header = get_theme_mod( 'color_blog_dark_enable_top_header', true );
		if ( true ===  $color_blog_dark_enable_top_header ) {
			/**
			 * hook - color_blog_dark_top_header
			 * 
			 * @hooked - color_blog_dark_top_header_start - 5
			 * @hooked - color_blog_dark_trending_section - 10 
			 * @hooked - color_blog_dark_top_header_nav - 20
			 * @hooked - color_blog_dark_top_header_end - 50
			 */
			do_action( 'color_blog_dark_top_header' );				
		}

		/**
		 * color_blog_dark main header
		 * 
		 * @hooked - color_blog_dark_main_header_start - 5
		 * @hooked - color_blog_dark_site_branding - 10
		 * @hooked - color_blog_dark_menu_wrapper_start - 15
		 * @hooked - color_blog_dark_header_main_menu - 20
		 * @hooked - color_blog_dark_menu_icon_wrapper_start - 25
		 * @hooked - color_blog_dark_menu_social_icons - 30
		 * @hooked - color_blog_dark_menu_search_icon - 35
		 * @hooked - color_blog_dark_menu_icon_wrapper_end - 40
		 * @hooked - color_blog_dark_menu_wrapper_end - 45
		 * @hooked - color_blog_dark_main_header_end - 50
		 * 
		 * @since 1.0.0
		 */
		do_action( 'color_blog_dark_main_header' );

		if ( is_front_page() ) {
			/**
			 * hook - front_slider_section
			 * displays front top section before archive blogs.
			 */
			do_action( 'color_blog_dark_front_slider_section' );
		}

		if ( ! is_front_page() ) {
            /**
    		 * color_blog_dark_innerpage_header hook
    		 *
    		 * @hooked - color_blog_dark_innerpage_header_start - 5
    		 * @hooked - color_blog_dark_innerpage_header_title - 10
    		 * @hooked - color_blog_dark_breadcrumb_content - 15
    		 * @hooked - color_blog_dark_innerpage_header_end - 20
    		 *
    		 * @since 1.0.0
    		 */
    		do_action( 'color_blog_dark_innerpage_header' );
        }
	?>

	<div id="content" class="site-content">
		<div class="mt-container">
