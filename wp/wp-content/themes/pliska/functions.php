<?php

/**
 * Pliska functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @package pliska
 */

if ( ! defined( 'PLISKA_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'PLISKA_VERSION', '0.1.9' );
}
if ( ! function_exists( 'pliska_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function pliska_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on pliska, use a find and replace
		 * to change 'pliska' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'pliska', get_template_directory() . '/languages' );
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );
		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'pliska' ),
			)
		);
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);
		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'pliska_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);
		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
		/**
		 * Add support for page excerpts.
		 *
		 * @link https://developer.wordpress.org/reference/functions/add_post_type_support/
		 */
		add_post_type_support( 'page', 'excerpt' );
		// Add support for Block Styles.
		// add_theme_support( 'wp-block-styles' );
		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );
		// Editor Color Palette
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => __( 'Green', 'pliska' ),
					'slug'  => 'green',
					'color' => get_theme_mod( 'primary_accent_color', '#0b8276' ),
				),
				array(
					'name'  => __( 'Yellow', 'pliska' ),
					'slug'  => 'yellow',
					'color' => get_theme_mod( 'secondary_accent_color', '#fbc02d' ),
				),
			)
		);
	}
}
add_action( 'after_setup_theme', 'pliska_setup' );
/* Primary Menu Custom Markup */
function pliska_primary_menu() {
	wp_nav_menu(
		array(
			'container'      => '',
			'menu_id'        => 'primary-menu',
			'menu_class'     => '',
			'theme_location' => 'menu-1',
			'show_toggles'   => true,
			'items_wrap'     => '<div class="slide-menu slide-section"><ul id="%s" class="%s">%s</ul></div>',
			'fallback_cb'    => 'pliska_pages_menu',
		)
	);
}

/* WP Pages Custom Markup */
function pliska_pages_menu() {
	wp_page_menu(
		array(
			'menu_class'   => 'slide-menu slide-section',
			'before'       => '<ul id="primary-menu">',
			'after'        => '</ul>',
			'show_toggles' => true,
		)
	);
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function pliska_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'pliska_content_width', 900 );
}

add_action( 'after_setup_theme', 'pliska_content_width', 0 );
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function pliska_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'pliska' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'pliska' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Footer 1', 'pliska' ),
			'id'            => 'sidebar-2',
			'description'   => __( 'Add widgets here to appear in your footer. It is recommended that you add one widget here and two more widgets in Footer 2.', 'pliska' ),
			'before_widget' => '<section id="%1$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="heading">',
			'after_title'   => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Footer 2', 'pliska' ),
			'id'            => 'sidebar-3',
			'description'   => __( 'Add widgets here to appear in your footer. It is recommended that you add two widgets here.', 'pliska' ),
			'before_widget' => '<section id="%1$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}

add_action( 'widgets_init', 'pliska_widgets_init' );
/**
 * Enqueue scripts and styles.
 */
function pliska_scripts() {
	wp_enqueue_style(
		'pliska-style',
		get_template_directory_uri() . '/assets/css/app.css',
		array(),
		PLISKA_VERSION
	);
	wp_style_add_data( 'pliska-style', 'rtl', 'replace' );
	wp_enqueue_script(
		'pliska-navigation',
		get_template_directory_uri() . '/assets/js/navigation.js',
		array(),
		PLISKA_VERSION,
		true
	);
	wp_enqueue_script(
		'pliska-dark-mode',
		get_template_directory_uri() . '/assets/js/dark-mode.min.js',
		array(),
		PLISKA_VERSION,
		true
	);
	$js_default_theme_mode = array( pliska_default_mode() );
	wp_localize_script( 'pliska-dark-mode', 'pliska_theme_mode_object', $js_default_theme_mode );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	// Theme options script that takes values from the theme customizer.
	wp_enqueue_script(
		'pliska-options',
		esc_url( get_template_directory_uri() . '/assets/js/theme-options.min.js' ),
		array(),
		PLISKA_VERSION
	);
	$js_customizer_options = array(
		'overlay'              => esc_attr( get_theme_mod( 'cover_template_overlay_opacity', '1' ) ),
		'animation'            => esc_attr( get_theme_mod( 'header_scroll_animation', 1 ) ),
		'fixed_header'         => pliska_is_fixed_header(),
		'sticky_header'        => pliska_is_sticky_header(),
		'has_header_image'     => pliska_has_header_image(),
		'site_title_animation' => get_theme_mod( 'header_text_animation', 'bounce' ),
		'myAjax'               => array(
			'ajaxurl'   => admin_url( 'admin-ajax.php' ),
			'has_voted' => ( function_exists( 'pliska_has_voted' ) ? pliska_has_voted() : false ),
		),
	);
	wp_localize_script( 'pliska-options', 'pliska_customizer_object', $js_customizer_options );
}

add_action( 'wp_enqueue_scripts', 'pliska_scripts' );
// Add scripts and styles for backend
function pliska_scripts_admin( $hook ) {
	// Styles
	wp_enqueue_style(
		'pliska-style-admin',
		get_template_directory_uri() . '/admin/css/admin.css',
		'',
		PLISKA_VERSION,
		'all'
	);
}

add_action( 'admin_enqueue_scripts', 'pliska_scripts_admin' );
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';
/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';
/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';
/**
 * Custom theme hooks
 */
require get_template_directory() . '/inc/template-hooks.php';
/**
 * Theme Header
 */
require get_template_directory() . '/inc/template-header.php';
/**
 * Custom svg icons
 */
require get_template_directory() . '/assets/svg/svg-icons.php';
/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}
/* Custom block patterns */
require get_template_directory() . '/inc/block-patterns.php';

/* Include Theme Options Page for Admin */
if ( is_admin() ) {
	require_once 'admin/theme-intro.php';

	if ( current_user_can( 'manage_options' ) ) {
		require_once get_template_directory() . '/admin/notices.php';
		require_once get_template_directory() . '/admin/welcome-notice.php';
	}
}