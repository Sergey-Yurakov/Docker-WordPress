<?php
/**
 * draftly functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package draftly
 */


if ( ! function_exists( 'draftly_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */

	function draftly_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on draftly, use a find and replace
		 * to change 'draftly' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'draftly', get_template_directory() . '/languages' );

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
		set_post_thumbnail_size( 300 );

		add_image_size( 'draftly-grid', 350 , 230, true );
		add_image_size( 'draftly-slider', 850 );
		add_image_size( 'draftly-small', 300 , 180, true );


		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1'	=> esc_html__( 'Primary', 'draftly' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'draftly_custom_background_args', array(
			'default-color' => '#fff',
			'default-image' => '',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'draftly_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function draftly_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'draftly_content_width', 640 );
}
add_action( 'after_setup_theme', 'draftly_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function draftly_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'draftly' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'draftly' ),
		'before_widget' => '<section id="%1$s" class="fbox swidgets-wrap widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="sidebar-headline-wrapper"><h4 class="widget-title">',
		'after_title'   => '</h4></div>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget (1)', 'draftly' ),
		'id'            => 'footerwidget-1',
		'description'   => esc_html__( 'Add widgets here.', 'draftly' ),
		'before_widget' => '<section id="%1$s" class="fbox widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="swidget"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget (2)', 'draftly' ),
		'id'            => 'footerwidget-2',
		'description'   => esc_html__( 'Add widgets here.', 'draftly' ),
		'before_widget' => '<section id="%1$s" class="fbox widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="swidget"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget (3)', 'draftly' ),
		'id'            => 'footerwidget-3',
		'description'   => esc_html__( 'Add widgets here.', 'draftly' ),
		'before_widget' => '<section id="%1$s" class="fbox widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="swidget"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );
	
}




add_action( 'widgets_init', 'draftly_widgets_init' );


/**
 * Enqueue scripts and styles.
 */
function draftly_scripts() {
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css' );
	wp_enqueue_style( 'draftly-style', get_stylesheet_uri() );
	wp_enqueue_script( 'draftly-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20170823', true );
	wp_enqueue_script( 'draftly-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20170823', true );	
	wp_enqueue_script( 'draftly-flexslider-jquery', get_template_directory_uri() . '/js/jquery.flexslider.js', array('jquery'), '20150423', true );
	wp_enqueue_script( 'draftly-script', get_template_directory_uri() . '/js/script.js', array(), '20160720', true );
	wp_enqueue_script( 'draftly-accessibility', get_template_directory_uri() . '/js/accessibility.js', array(), '20160720', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'draftly_scripts' );

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
 * Google fonts, credits can be found in readme.
 */

function draftly_google_fonts() {

	wp_enqueue_style( 'draftly-google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,700', false ); 
}

add_action( 'wp_enqueue_scripts', 'draftly_google_fonts' );


/**
 * Dots after excerpt
 */

function draftly_excerpt_more( $more ) {
	if ( is_admin() ) return $more;
	return '...';
}
add_filter('excerpt_more', 'draftly_excerpt_more');



/**
 * Blog Pagination 
 */
if ( !function_exists( 'draftly_numeric_posts_nav' ) ) {
	
	function draftly_numeric_posts_nav() {
		
		$prev_arrow = is_rtl() ? 'Previous' : 'Next';
		$next_arrow = is_rtl() ? 'Next' : 'Previous';
		
		global $wp_query;
		$total = $wp_query->max_num_pages;
		$big = 999999999; // need an unlikely integer
		if( $total > 1 )  {
			if( !$current_page = get_query_var('paged') )
				$current_page = 1;
			if( get_option('permalink_structure') ) {
				$format = 'page/%#%/';
			} else {
				$format = '&paged=%#%';
			}
			echo wp_kses_post(paginate_links(array(
				'base'			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'		=> $format,
				'current'		=> max( 1, get_query_var('paged') ),
				'total' 		=> $total,
				'mid_size'		=> 3,
				'type' 			=> 'list',
				'prev_text'		=> 'Previous',
				'next_text'		=> 'Next',
			) ));
		}
	}
	
}




/**
 * Copyright and License for Upsell button by Justin Tadlock - 2016 © Justin Tadlock. customizer button https://github.com/justintadlock/trt-customizer-pro
 */
require_once( trailingslashit( get_template_directory() ) . 'justinadlock-customizer-button/class-customize.php' );




/**
 * Compare page CSS
 */

function draftly_comparepage_css($hook) {
	if ( 'appearance_page_draftly-info' != $hook ) {
		return;
	}
	wp_enqueue_style( 'draftly-custom-style', get_template_directory_uri() . '/css/compare.css' );
}
add_action( 'admin_enqueue_scripts', 'draftly_comparepage_css' );

/**
 * Compare page content
 */

add_action('admin_menu', 'draftly_themepage');
function draftly_themepage() {
	if ( current_user_can( 'edit_theme_options' ) ) {
		$theme_info = add_theme_page( __('Draftly Info','draftly'), __('Draftly Info','draftly'), 'manage_options', 'draftly-info.php', 'draftly_info_page' );
	}
}

function draftly_info_page() {
	$user = wp_get_current_user();
	?>
	<div class="wrap about-wrap draftly-add-css">
		<div>
			<div class="about-the-theme-intro">
				<h1>
					<?php echo __('Meet Draftly!','draftly'); ?>
				</h1>
				<p class="about-the-theme-tagline"><?php echo __('The last WordPress themes you will need. Finally.
				','draftly'); ?></p>
			</div>
			<div class="feature-section three-col">
				<div class="col">
					<div class="widgets-holder-wrap">
						<h3><?php echo __("Contact Support", "draftly"); ?></h3>
						<p><?php echo __("Getting started with a new theme can be difficult, if you have issues with Draftly then throw us an email.", "draftly"); ?></p>
						<p><a target="blank" href="https://superbthemes.com/help-contact/" class="button button-primary">
							<?php echo __("Contact Support", "draftly"); ?>
						</a></p>
					</div>
				</div>
				<div class="col">
					<div class="widgets-holder-wrap">
						<h3><?php echo __("View Demo", "draftly"); ?></h3>
						<p><?php echo __("Try the theme in action. We've built a complete website using Draftly; click the button below to preview it!", "draftly"); ?></p>
						<p><a target="blank" href="https://superbthemes.com/demo/draftly/" class="button button-primary">
							<?php echo __("View Demo", "draftly"); ?>
						</a></p>
					</div>
				</div>
				<div class="col">
					<div class="widgets-holder-wrap">
						<h3><?php echo __("Unlock All Features", "draftly"); ?></h3>
						<p><?php echo __("If you enjoy Draftly and want to take your website to the next step, then check out our premium edition here.", "draftly"); ?></p>
						<p><a target="blank" href="https://superbthemes.com/draftly/" class="button button-primary">
							<?php echo __("Get Premium", "draftly"); ?>
						</a></p>
					</div>
				</div>
			</div>
		</div>
		
		<div class="theme-comparison">
			<h2><?php echo __("Let's compare the versions","draftly"); ?></h2>


			<table class="theme-comparison-table" cellspacing=0>
				<thead>
					<tr>
						<th><strong></strong></th>
						<th><strong><?php echo __("Free Version", "draftly"); ?></strong></th>
						<th><strong><?php echo __("Premium Version", "draftly"); ?></strong></th>
					</tr>
				</thead>

				<tbody>
					<tr>
						<td><?php echo __("Header Background Color", "draftly"); ?></td>
						<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "draftly"); ?>" /></span></td>
						<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "draftly"); ?>" /></span></td>
					</tr>
					<tr>
						<td><?php echo __("Custom Navigation Logo Or Text", "draftly"); ?></td>
						<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "draftly"); ?>" /></span></td>
						<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "draftly"); ?>" /></span></td>
					</tr>
					<tr>
						<td><?php echo __("Hide Logo Text", "draftly"); ?></td>
						<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "draftly"); ?>" /></span></td>
						<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "draftly"); ?>" /></span></td>
					</tr>

					<tr>
						<td><?php echo __("Premium Support", "draftly"); ?></td>
						<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "draftly"); ?>" /></span></td>
						<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "draftly"); ?>" /></span></td>
					</tr>
					<tr>
						<td><?php echo __("Recent Posts Widget", "draftly"); ?></td>
						<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "draftly"); ?>" /></span></td>
						<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "draftly"); ?>" /></span></td>
					</tr>
					<tr>
						<td><?php echo __("Easy Google Fonts", "draftly"); ?></td>
						<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "draftly"); ?>" /></span></td>
						<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "draftly"); ?>" /></span></td>
					</tr>
					<tr>
						<td><?php echo __("Pagespeed Plugin", "draftly"); ?></td>
						<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "draftly"); ?>" /></span></td>
						<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "draftly"); ?>" /></span></td>
					</tr>

					<tr>
						<td><?php echo __("Only Show Header Image On Front Page", "draftly"); ?></td>
						<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "draftly"); ?>" /></span></td>
						<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "draftly"); ?>" /></span></td>
					</tr>
					<tr>
						<td><?php echo __("Show Header Everywhere", "draftly"); ?></td>
						<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "draftly"); ?>" /></span></td>
						<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "draftly"); ?>" /></span></td>
					</tr>
					<tr>
						<td><?php echo __("Custom Text On Header Image", "draftly"); ?></td>
						<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "draftly"); ?>" /></span></td>
						<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "draftly"); ?>" /></span></td>
					</tr>

					<tr>
						<td><?php echo __("Hide Sidebar (Full Width Mode)", "draftly"); ?></td>
						<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "draftly"); ?>" /></span></td>
						<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "draftly"); ?>" /></span></td>
					</tr>
					<tr>
						<td><?php echo __("Replace Copyright Text", "draftly"); ?></td>
						<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "draftly"); ?>" /></span></td>
						<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "draftly"); ?>" /></span></td>
					</tr>
					<tr>
						<td><?php echo __("Hide Header Text", "draftly"); ?></td>
						<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "draftly"); ?>" /></span></td>
						<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "draftly"); ?>" /></span></td>
					</tr>
					<tr>
						<td><?php echo __("Customize Navigation Color", "draftly"); ?></td>
						<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "draftly"); ?>" /></span></td>
						<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "draftly"); ?>" /></span></td>
					</tr>
					<tr>
						<td><?php echo __("Customize Post/Page Color", "draftly"); ?></td>
						<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "draftly"); ?>" /></span></td>
						<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "draftly"); ?>" /></span></td>
					</tr>
					<tr>
						<td><?php echo __("Customize Blog Feed Color", "draftly"); ?></td>
						<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "draftly"); ?>" /></span></td>
						<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "draftly"); ?>" /></span></td>
					</tr>
					<tr>
						<td><?php echo __("Customize Footer Color", "draftly"); ?></td>
						<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "draftly"); ?>" /></span></td>
						<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "draftly"); ?>" /></span></td>
					</tr>
					<tr>
						<td><?php echo __("Header Background Image", "draftly"); ?></td>
						<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "draftly"); ?>" /></span></td>
						<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "draftly"); ?>" /></span></td>
					</tr>
					<tr>
						<td><?php echo __("Customize Background Color", "draftly"); ?></td>
						<td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "draftly"); ?>" /></span></td>
						<td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "draftly"); ?>" /></span></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="draftly-button-container">
<div>
			<h3>Are you ready to go pro? </h3>
			</div>
			<div>
			<a target="blank" href="https://superbthemes.com/draftly/" class="button button-primary">
				<?php echo __("Get Draftly Premium", "draftly"); ?>
			</a>
			<a target="blank" href="https://superbthemes.com/demo/draftly/" class="button button-primary">
				<?php echo __("View Demo", "draftly"); ?>
			</a></div>
		</div>

	</div>
	<?php
}



/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function draftly_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- js/skip-link-focus-fix.js`.
	?>
	<script>
		/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'draftly_skip_link_focus_fix' );
