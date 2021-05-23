<?php
/**
 * Color Blog Dark manage the Customizer options of footer settings panel.
 *
 * @package Color Blog Dark
 * @since 1.0.0
 */

add_action( 'customize_register', 'color_blog_dark_customize_footer_panels_sections_register' );
/**
 * Add Additional panels in the theme customizer
 * 
 */
function color_blog_dark_customize_footer_panels_sections_register( $wp_customize ) {
	/*-------------------------------------------------------  Footer Widget Area Section  --------------------------------------------------------------------------*/
	/**
	 * Footer Widget Area
	 */
	$wp_customize->add_section( 'color_blog_dark_section_footer_widget_area',
		array(
			'title'    			=> esc_html__( 'Footer Widget Area', 'color-blog-dark' ),
			'panel'          	=> 'color_blog_dark_footer_panel',
			'capability'     	=> 'edit_theme_options',
			'priority'       	=> 5,
			'theme_supports' 	=> '',
		)
	);

	/**
	 * Toggle field for Enable/Disable footer widget area.
	 */
	$wp_customize->add_setting( 'color_blog_dark_enable_footer_widget_area',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => true,
			'sanitize_callback' => 'color_blog_dark_sanitize_checkbox'
		)
	);

	$wp_customize->add_control( new Color_Blog_Dark_Control_Toggle(
		$wp_customize, 'color_blog_dark_enable_footer_widget_area',
			array(
				'label'    		=> esc_html__( 'Enable Footer Widget Area', 'color-blog-dark' ),
				'section'       => 'color_blog_dark_section_footer_widget_area',
				'settings'      => 'color_blog_dark_enable_footer_widget_area',
				'priority'      => 5,
			)
		)
	);

	/** 
	 * Radio Image field for Widget Area layout
	*/
	$wp_customize->add_setting( 'color_blog_dark_widget_area_layout',
		array(
			'default'           => 'column-three',
			'sanitize_callback' => 'sanitize_key',
		)
	);
	$wp_customize->add_control( new Color_Blog_Dark_Control_Radio_Image(
		$wp_customize, 'color_blog_dark_widget_area_layout',
			array(
				'label'    			=> esc_html__( 'Widget Area Layout', 'color-blog-dark' ),
				'description'   	=> __( 'Choose widget layout from available layouts', 'color-blog-dark' ),
				'section'       	=> 'color_blog_dark_section_footer_widget_area',
				'settings'      	=> 'color_blog_dark_widget_area_layout',
				'priority'      	=> 15,
				'active_callback'	=> 'color_blog_dark_enable_footer_widget_area_active_callback',
				'choices'  			=> array(
					'column-four'		=> get_template_directory_uri() . '/assets/images/footer-4.png',
					'column-three' 	 	=> get_template_directory_uri() . '/assets/images/footer-3.png',
					'column-two'     	=> get_template_directory_uri() . '/assets/images/footer-2.png',
					'column-one'  	 	=> get_template_directory_uri() . '/assets/images/footer-1.png'
				),
			)
		)
	);

	/*-------------------------------------------------------  Bottom Footer Section  --------------------------------------------------------------------------*/
	/**
	 * Bottom footer
	 */
	$wp_customize->add_section( 'color_blog_dark_section_bottom_footer',
		array(
			'title'    			=> esc_html__( 'Bottom Footer', 'color-blog-dark' ),
			'panel'          	=> 'color_blog_dark_footer_panel',
			'capability'     	=> 'edit_theme_options',
			'priority'       	=> 10,
			'theme_supports' 	=> '',
		)
	);

	/**
	 * Toggle field for Enable/Disable footer menu.
	 */
	$wp_customize->add_setting( 'color_blog_dark_enable_footer_menu',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => true,
			'sanitize_callback' => 'color_blog_dark_sanitize_checkbox'
		)
	);

	$wp_customize->add_control( new Color_Blog_Dark_Control_Toggle(
		$wp_customize, 'color_blog_dark_enable_footer_menu',
			array(
				'label'    		=> esc_html__( 'Enable Footer Menu', 'color-blog-dark' ),
				'section'       => 'color_blog_dark_section_bottom_footer',
				'settings'      => 'color_blog_dark_enable_footer_menu',
				'priority'      => 5,
			)
		)
	);


	/**
	 * Text filed for copyright
	 */
	$wp_customize->add_setting( 'color_blog_dark_footer_copyright',
		array(
			'capability'        => 'edit_theme_options',
			'default'  			=> esc_html__( 'Color Blog Dark', 'color-blog-dark' ),
			'sanitize_callback' => 'sanitize_text_field'
		)
	);

	$wp_customize->add_control( 'color_blog_dark_footer_copyright', 
		array(
			'type'				=> 'text',
			'label'    			=> esc_html__( 'Copyright Text', 'color-blog-dark' ),
			'section'       	=> 'color_blog_dark_section_bottom_footer',
			'priority'      	=> 25,
			'active_callback'	=> 'color_blog_dark_enable_footer_menu_active_callback',
		)
	);
}