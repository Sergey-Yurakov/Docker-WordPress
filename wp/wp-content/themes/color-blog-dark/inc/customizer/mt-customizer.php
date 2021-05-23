<?php
/**
 * Color Blog Dark Theme Customizer
 *
 * @package Color Blog Dark
 * @since 1.0.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function color_blog_dark_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->get_section( 'title_tagline' )->panel        = 'color_blog_dark_general_panel';
    $wp_customize->get_section( 'title_tagline' )->priority     = '5';
    $wp_customize->get_section( 'colors' )->panel               = 'color_blog_dark_general_panel';
    $wp_customize->get_section( 'colors' )->priority            = '10';
    $wp_customize->get_section( 'background_image' )->panel     = 'color_blog_dark_general_panel';
    $wp_customize->get_section( 'background_image' )->priority  = '15';
    $wp_customize->get_section( 'static_front_page' )->panel    = 'color_blog_dark_general_panel';
    $wp_customize->get_section( 'static_front_page' )->priority = '20';

    $wp_customize->get_section( 'header_image' )->panel        = 'color_blog_dark_header_panel';
    $wp_customize->get_section( 'header_image' )->priority     = '5';
    $wp_customize->get_section( 'header_image' )->description  = __( 'Header Image for only Innerpages', 'color-blog-dark' );

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'color_blog_dark_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'color_blog_dark_customize_partial_blogdescription',
		) );
	}

	/**
	 * Load customizer custom classes.
	 */
	$wp_customize->register_control_type( 'color_blog_dark_Control_Toggle' );
	$wp_customize->register_control_type( 'color_blog_dark_Control_Radio_Image' );

    /**
     * Register custom section types.
     *
     * @since 1.0.3
     */
    $wp_customize->register_section_type( 'color_blog_dark_Section_Upsell' );

    /**
     * Register theme upsell sections.
     *
     * @since 1.0.3
     */
    $wp_customize->add_section( new Color_Blog_Dark_Section_Upsell(
        $wp_customize,
            'theme_upsell',
            array(
                'title'     => esc_html__( 'Color Blog Pro', 'color-blog-dark' ),
                'pro_text'  => esc_html__( 'Buy Now', 'color-blog-dark' ),
                'pro_url'   => 'https://mysterythemes.com/wp-themes/color-blog-pro/',
                'priority'  => 1,
            )
        )
    );
}
add_action( 'customize_register', 'color_blog_dark_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function color_blog_dark_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function color_blog_dark_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function color_blog_dark_customize_preview_js() {
	wp_enqueue_script( 'color-blog-dark-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'color_blog_dark_customize_preview_js' );

/*----------------------------------------------------------------------------------------------------------------------------------------*/
/**
 * Enqueue required scripts/styles for customizer panel
 *
 * @since 1.0.0
 */
function color_blog_dark_customize_backend_scripts() {
	global $color_blog_dark_theme_version;

	wp_enqueue_style( 'color-blog-dark--admin-customizer-style', get_template_directory_uri() . '/assets/css/mt-customizer-styles.css', array(), esc_attr( esc_attr( $color_blog_dark_theme_version ) ) );
	wp_enqueue_style( 'jquery-ui', esc_url( get_template_directory_uri() . '/assets/css/jquery-ui.css' ) );
	wp_enqueue_style( 'font-awesome-customize', get_template_directory_uri() . '/assets/library/font-awesome/css/font-awesome.min.css', array(), '4.7.0' );
	
	wp_enqueue_script( 'color-blog-dark--admin-customizer-script', get_template_directory_uri() . '/assets/js/mt-customizer-controls.js', array( 'jquery', 'customize-controls' ), esc_attr( $color_blog_dark_theme_version ), true );
}
add_action( 'customize_controls_enqueue_scripts', 'color_blog_dark_customize_backend_scripts', 10 );

/**
 * Add Kirki required file for custom fields
 */
require get_template_directory() . '/inc/customizer/mt-customizer-custom-classes.php';
require get_template_directory() . '/inc/customizer/mt-customizer-panels.php';
require get_template_directory() . '/inc/customizer/mt-sanitize.php';
require get_template_directory() . '/inc/customizer/mt-callback.php';

require get_template_directory() . '/inc/customizer/mt-customizer-general-panel-options.php';
require get_template_directory() . '/inc/customizer/mt-customizer-header-panel-options.php';
require get_template_directory() . '/inc/customizer/mt-customizer-front-panel-options.php';
require get_template_directory() . '/inc/customizer/mt-customizer-additional-panel-options.php';
require get_template_directory() . '/inc/customizer/mt-customizer-design-panel-options.php';
require get_template_directory() . '/inc/customizer/mt-customizer-footer-panel-options.php';