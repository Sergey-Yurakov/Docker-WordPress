<?php
/**
 * Color Blog Dark manage the Customizer panels
 *
 * @package Color Blog Dark
 * @since 1.0.0
 */
add_action( 'customize_register', 'color_blog_dark_customize_panels_register' );

/**
 * Add panels in the theme customizer
 * 
 */
function color_blog_dark_customize_panels_register( $wp_customize ) {
	/**
	 * General Settings Panel
	 */
	$wp_customize->add_panel( 'color_blog_dark_general_panel',
		array(
			'priority'          => 10,
			'capability'        => 'edit_theme_options',
			'theme_supports'    => '',
			'title'             => __( 'General Settings', 'color-blog-dark' ),
		)
	);

	/**
	 * Header Settings Panel
	 */
	$wp_customize->add_panel( 'color_blog_dark_header_panel',
		array(
			'priority'          => 15,
			'capability'        => 'edit_theme_options',
			'theme_supports'    => '',
			'title'             => __( 'Header Settings', 'color-blog-dark' ),
		)
	);

	/**
	 * Front Settings Panel
	 */
	$wp_customize->add_panel( 'color_blog_dark_front_section_panel',
		array(
			'priority'          => 20,
			'capability'        => 'edit_theme_options',
			'theme_supports'    => '',
			'title'             => __( 'Front Sections', 'color-blog-dark' ),
		)
	);

	/**
	 * Design Settings Panel
	 */
	$wp_customize->add_panel( 'color_blog_dark_design_panel',
		array(
			'priority'          => 35,
			'capability'        => 'edit_theme_options',
			'theme_supports'    => '',
			'title'             => __( 'Design Settings', 'color-blog-dark' ),
		)
	);
	
	/**
	 * Additional Features Panel
	 */
	$wp_customize->add_panel( 'color_blog_dark_additional_panel',
		array(
			'priority'          => 40,
			'capability'        => 'edit_theme_options',
			'theme_supports'    => '',
			'title'             => __( 'Additional Features', 'color-blog-dark' ),
		)
	);

	/**
	 * Footer Settings Panel
	 */
	$wp_customize->add_panel( 'color_blog_dark_footer_panel',
		array(
			'priority'          => 45,
			'capability'        => 'edit_theme_options',
			'theme_supports'    => '',
			'title'             => __( 'Footer Settings', 'color-blog-dark' ),
		)
	);
}