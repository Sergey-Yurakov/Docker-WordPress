<?php
/**
 * Color Blog Dark manage the Customizer options of general panel.
 *
 * @package Color Blog Dark
 * @since 1.0.0
 */

add_action( 'customize_register', 'color_blog_dark_customize_general_panels_sections_register' );
/**
 * Add panels in the theme customizer
 * 
 */
function color_blog_dark_customize_general_panels_sections_register( $wp_customize ) {
	/*------------------------------------------- Site Settings Section -----------------------------------------------*/
	/**
	 * Site Settings Section
	 */
	$wp_customize->add_section( 'color_blog_dark_section_site',
		array(
			'priority'       => 40,
			'panel'          => 'color_blog_dark_general_panel',
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => __( 'Site Settings', 'color-blog-dark' )

		)
	);

	/**
	 * Toggle field for Enable/Disable preloader.
	 *  
	 */ 
	$wp_customize->add_setting( 'color_blog_dark_enable_preloader',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => true,
			'sanitize_callback' => 'color_blog_dark_sanitize_checkbox'
		)
	);

	$wp_customize->add_control( new Color_Blog_Dark_Control_Toggle(
		$wp_customize, 'color_blog_dark_enable_preloader',
			array(
				'label'         => __( 'Enable Preloader', 'color-blog-dark' ),
				'section'       => 'color_blog_dark_section_site',
				'settings'      => 'color_blog_dark_enable_preloader',
				'priority'      => 5,
			)
		)
	);
		
	/**
	 * Toggle field for Enable/Disable wow animation. 
	 *  
	 */
	$wp_customize->add_setting( 'color_blog_dark_enable_wow_animation',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => true,
			'sanitize_callback' => 'color_blog_dark_sanitize_checkbox'
		)
	);

	$wp_customize->add_control( new Color_Blog_Dark_Control_Toggle(
		$wp_customize, 'color_blog_dark_enable_wow_animation',
			array(
				'label'         => __( 'Enable Wow Animation', 'color-blog-dark' ),
				'section'       => 'color_blog_dark_section_site',
				'settings'      => 'color_blog_dark_enable_wow_animation',
				'priority'      => 10,
			)
		)
	);

	/**
	 * Radio image field for Archive Sidebar
	 *
	 * @since 1.0.0
	 */
	$wp_customize->add_setting( 'color_blog_dark_site_layout',
		array(
			'default'           => 'site-layout--wide',
			'sanitize_callback' => 'sanitize_key',
		)
	);
	$wp_customize->add_control( new Color_Blog_Dark_Control_Radio_Image(
		$wp_customize, 'color_blog_dark_site_layout',
			array(
				'label'         => __( 'Site Layout', 'color-blog-dark' ),
				'description'   => __( 'Choose site layout from available layouts', 'color-blog-dark' ),
				'section'       => 'color_blog_dark_section_site',
				'settings'      => 'color_blog_dark_site_layout',
				'priority'      => 15,
				'choices'  		=> array(
					'site-layout--wide'   => get_template_directory_uri() . '/assets/images/full-width.png',
					'site-layout--boxed'  => get_template_directory_uri() . '/assets/images/boxed-layout.png'
				),
			)
		)
	);

	/*-------------------------------------------------- Default: Colors Section ----------------------------------------------------*/
	/**
	 * Color Picker field for Primary Color
	 */
	$wp_customize->add_setting( 'color_blog_dark_primary_color',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => '#dd3333',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize, 'color_blog_dark_primary_color',
			array(
				'label'      => __( 'Primary Color', 'color-blog-dark' ),
				'section'    => 'colors',
				'settings'   => 'color_blog_dark_primary_color',
				'priority'   => 5
			)
		)
	);
}