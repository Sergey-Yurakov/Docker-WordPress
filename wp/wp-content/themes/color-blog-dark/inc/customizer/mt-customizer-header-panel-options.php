<?php
/**
 * Color Blog Dark manage the Customizer options of header panel.
 *
 * @package Color Blog Dark
 * @since 1.0.0
 */

add_action( 'customize_register', 'color_blog_dark_customize_header_panels_sections_register' );
/**
 * Add panels in the theme customizer
 * 
 */
function color_blog_dark_customize_header_panels_sections_register( $wp_customize ) {

	/*------------------------------------------ Top Header Section ----------------------------------------*/
	/**
	 * Top Header Section
	 */
	$wp_customize->add_section( 'color_blog_dark_section_top_header',
		array(
			'priority'       => 10,
			'panel'          => 'color_blog_dark_header_panel',
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => __( 'Top Header Settings', 'color-blog-dark' )
		)
	);

	/**
	 * Toggle field for Enable/Disable Top Header section
	 * 
	 */
	$wp_customize->add_setting( 'color_blog_dark_enable_top_header',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => true,
			'sanitize_callback' => 'color_blog_dark_sanitize_checkbox'
		)
	);

	$wp_customize->add_control( new Color_Blog_Dark_Control_Toggle(
		$wp_customize, 'color_blog_dark_enable_top_header',
			array(
				'label'         => __( 'Enable Top Header', 'color-blog-dark' ),
				'description' 	=> esc_html__( 'Show/Hide top header section.', 'color-blog-dark' ),
				'section'       => 'color_blog_dark_section_top_header',
				'settings'      => 'color_blog_dark_enable_top_header',
				'priority'      => 10,
			)
		)
	);

	/**
	 * Toggle field for Enable/Disable trending section.
	 * 
	 */
	$wp_customize->add_setting( 'color_blog_dark_enable_trending',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => false,
			'sanitize_callback' => 'color_blog_dark_sanitize_checkbox'
		)
	);

	$wp_customize->add_control( new Color_Blog_Dark_Control_Toggle(
		$wp_customize, 'color_blog_dark_enable_trending',
			array(
				'label'    			=> esc_html__( 'Enable Trending Section', 'color-blog-dark' ),
				'description' 		=> esc_html__( 'Trending section shows the popular tags.', 'color-blog-dark' ),
				'section'       	=> 'color_blog_dark_section_top_header',
				'settings'      	=> 'color_blog_dark_enable_trending',
				'priority'      	=> 10,
				'active_callback' 	=> 'color_blog_dark_enable_top_header_active_callback',
			)
		)
	);

	/**
	 * checkox for before icon in tags.
	 *
	 */
	$wp_customize->add_setting( 'color_blog_dark_enable_trending_tag_before_icon',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => true,
			'sanitize_callback' => 'color_blog_dark_sanitize_checkbox'
		)
	);

	$wp_customize->add_control( 'color_blog_dark_enable_trending_tag_before_icon',
		array(
			'type'				=> 'checkbox',
			'label'       		=> esc_html__( 'Add Icon Before Tag', 'color-blog-dark' ),
			'description' 		=> esc_html__( 'Show/Hide Hash Icon before tag.', 'color-blog-dark' ),
			'section'       	=> 'color_blog_dark_section_top_header',
			'priority'      	=> 20,
			'active_callback' 	=> 'color_blog_dark_enable_top_header_trending_active_callback',
		)
	);
	
	/**
	 * Text field for trending label.
	 * 
	 */
	$wp_customize->add_setting( 'color_blog_dark_trending_label',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => esc_html__( 'Trending Now', 'color-blog-dark' ),
			'sanitize_callback' => 'sanitize_text_field'
		)
	);

	$wp_customize->add_control( 'color_blog_dark_trending_label',
		array(
			'type'				=> 'text',
			'label'    			=> esc_html__( 'Trending Label', 'color-blog-dark' ),
			'section'       	=> 'color_blog_dark_section_top_header',
			'priority'      	=> 25,
			'active_callback' 	=> 'color_blog_dark_enable_top_header_trending_active_callback',
		)
	);

	/**
	 * Select field of trending tags orderby.
	 * 
	 */
	$wp_customize->add_setting( 'color_blog_dark_trending_tags_orderby',
		array(
			'capability' 		=> 'edit_theme_options',
			'default' 			=> '',
			'sanitize_callback' => 'color_blog_dark_sanitize_select',
		)
	);
	  
	$wp_customize->add_control( 'color_blog_dark_trending_tags_orderby',
		array(
			'type'     			=> 'select',
			'label'    			=> esc_html__( 'Tags Orderby', 'color-blog-dark' ),
			'section'  			=> 'color_blog_dark_section_top_header',
			'default'  			=> '',
			'priority' 			=> 30,
			'choices'  			=> array(
				''	  		=> esc_html__( 'Default', 'color-blog-dark' ),
				'count' 	=> esc_html__( 'Count', 'color-blog-dark' ),
			),
			'active_callback'	=> 'color_blog_dark_enable_top_header_trending_active_callback',
		)
	);

	/**
	 * Number field of trending tags count.
	 * 
	 */
	$wp_customize->add_setting( 'color_blog_dark_trending_tags_count',
		array(
			'capability' 		=> 'edit_theme_options',
			'default' 			=> '5',
			'sanitize_callback'	=> 'absint',
		)
	);
	  
	$wp_customize->add_control( 'color_blog_dark_trending_tags_count',
		array(
			'type'     			=> 'number',
			'label'    			=> esc_html__( 'Tags Count', 'color-blog-dark' ),
			'section'  			=> 'color_blog_dark_section_top_header',
			'priority' 			=> 35,
			'active_callback' 	=> 'color_blog_dark_enable_top_header_trending_active_callback',
		)
	);

	/**
	 * Toggle field for Enable/Disable live now button.
	 * 
	 */
	$wp_customize->add_setting( 'color_blog_dark_enable_live_now',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => false,
			'sanitize_callback' => 'color_blog_dark_sanitize_checkbox'
		)
	);

	$wp_customize->add_control( new Color_Blog_Dark_Control_Toggle(
		$wp_customize, 'color_blog_dark_enable_live_now',
			array(
				'label'    			=> esc_html__( 'Enable Live Now Button', 'color-blog-dark' ),
				'section'       	=> 'color_blog_dark_section_top_header',
				'settings'      	=> 'color_blog_dark_enable_live_now',
				'priority'      	=> 40,
				'active_callback' 	=> 'color_blog_dark_enable_top_header_active_callback',
			)
		)
	);

	/**
	 * Text field for live now button label.
	 * 
	 */
	$wp_customize->add_setting( 'color_blog_dark_live_now_label',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => esc_html__( 'Live Now', 'color-blog-dark' ),
			'sanitize_callback' => 'sanitize_text_field'
		)
	);

	$wp_customize->add_control( 'color_blog_dark_live_now_label',
		array(
			'type'				=> 'text',
			'label'    			=> esc_html__( 'Button Label', 'color-blog-dark' ),
			'section'       	=> 'color_blog_dark_section_top_header',
			'settings'			=> 'color_blog_dark_live_now_label',
			'priority'      	=> 45,
			'active_callback' 	=> 'color_blog_dark_enable_top_header_live_now_active_callback',
		)
	);

	/**
	 * Text field for live now button link.
	 * 
	 */
	$wp_customize->add_setting( 'color_blog_dark_live_now_link',
		array(
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw'
		)
	);

	$wp_customize->add_control( 'color_blog_dark_live_now_link',
		array(
			'type'				=> 'text',
			'label'    			=> esc_html__( 'Button Link', 'color-blog-dark' ),
			'section'       	=> 'color_blog_dark_section_top_header',
			'settings'			=> 'color_blog_dark_live_now_link',
			'priority'      	=> 50,
			'active_callback' 	=> 'color_blog_dark_enable_top_header_live_now_active_callback',
			'input_attrs'		=> array(
				'placeholder' => "https://www.youtube.com/channel/UCnGp3UHMB4DH8W_KmSmrCEw"
			)
		)
	);

	/*------------------------------------------ Header: Extra Options ----------------------------------------*/
	/**
	 * Header Extra Options
	 */
	$wp_customize->add_section( 'color_blog_dark_section_header_extra',
		array(
			'priority'       => 30,
			'panel'          => 'color_blog_dark_header_panel',
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => __( 'Extra Options', 'color-blog-dark' )
		)
	);

	/**
	 * Toggle field for Enable/Disable sticky menu.
	 * 
	 */
	$wp_customize->add_setting( 'color_blog_dark_enable_sticky_menu',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => true,
			'sanitize_callback' => 'color_blog_dark_sanitize_checkbox'
		)
	);

	$wp_customize->add_control( new Color_Blog_Dark_Control_Toggle(
		$wp_customize, 'color_blog_dark_enable_sticky_menu',
			array(
				'label'    		=> esc_html__( 'Enable Sticky Menu', 'color-blog-dark' ),
				'section'       => 'color_blog_dark_section_header_extra',
				'settings'      => 'color_blog_dark_enable_sticky_menu',
				'priority'      => 5,
			)
		)
	);

	/**
	 * Toggle field for Enable/Disable social icons.
	 * 
	 */
	$wp_customize->add_setting( 'color_blog_dark_enable_header_social_icons',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => false,
			'sanitize_callback' => 'color_blog_dark_sanitize_checkbox'
		)
	);

	$wp_customize->add_control( new Color_Blog_Dark_Control_Toggle(
		$wp_customize, 'color_blog_dark_enable_header_social_icons',
			array(
				'label'    		=> esc_html__( 'Enable Social Icons', 'color-blog-dark' ),
				'section'       => 'color_blog_dark_section_header_extra',
				'settings'      => 'color_blog_dark_enable_header_social_icons',
				'priority'      => 10,
			)
		)
	);

	/**
	 * Toggle field for Enable/Disable search icon. 
	 * 
	 */
	$wp_customize->add_setting( 'color_blog_dark_enable_search_icon',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => true,
			'sanitize_callback' => 'color_blog_dark_sanitize_checkbox'
		)
	);

	$wp_customize->add_control( new Color_Blog_Dark_Control_Toggle(
		$wp_customize, 'color_blog_dark_enable_search_icon',
			array(
				'label'    		=> esc_html__( 'Enable Search Icon', 'color-blog-dark' ),
				'section'       => 'color_blog_dark_section_header_extra',
				'settings'      => 'color_blog_dark_enable_search_icon',
				'priority'      => 15,
			)
		)
	);
}