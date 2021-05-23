<?php
/**
 * Featured Slider options.
 *
 * @package Easy Business
 */

$default = easy_business_get_default_theme_options();

// Featured Featured Slider Section
$wp_customize->add_section( 'section_featured_slider',
	array(
	'title'      => __( 'Featured Slider', 'easy-business' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'home_page_panel',
	)
);

// Enable Featured Slider Section
$wp_customize->add_setting('theme_options[enable_featured_slider_section]', 
	array(
	'default' 			=> $default['enable_featured_slider_section'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'easy_business_sanitize_checkbox'
	)
);

$wp_customize->add_control('theme_options[enable_featured_slider_section]', 
	array(		
	'label' 	=> __('Enable Featured Slider Section', 'easy-business'),
	'section' 	=> 'section_featured_slider',
	'settings'  => 'theme_options[enable_featured_slider_section]',
	'type' 		=> 'checkbox',	
	)
);

// Number of items
$wp_customize->add_setting('theme_options[number_of_featured_slider_items]', 
	array(
	'default' 			=> $default['number_of_featured_slider_items'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'easy_business_sanitize_number_range'
	)
);

$wp_customize->add_control('theme_options[number_of_featured_slider_items]', 
	array(
	'label'       => __('Number Of Slide Items', 'easy-business'),
	'description' => __('Save & Refresh the customizer to see its effect. Maximum is 10.', 'easy-business'),
	'section'     => 'section_featured_slider',   
	'settings'    => 'theme_options[number_of_featured_slider_items]',		
	'type'        => 'number',
	'active_callback' => 'easy_business_featured_slider_active',
	'input_attrs' => array(
			'min'	=> 1,
			'max'	=> 10,
			'step'	=> 1,
		),
	)
);

$wp_customize->add_setting('theme_options[featured_slider_content_type]', 
	array(
	'default' 			=> $default['featured_slider_content_type'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'easy_business_sanitize_select'
	)
);

$wp_customize->add_control('theme_options[featured_slider_content_type]', 
	array(
	'label'       => __('Content Type', 'easy-business'),
	'section'     => 'section_featured_slider',   
	'settings'    => 'theme_options[featured_slider_content_type]',		
	'type'        => 'select',
	'active_callback' => 'easy_business_featured_slider_active',
	'choices'	  => array(
			'featured_slider_page'	  => __('Page','easy-business'),
			'featured_slider_post'	  => __('Post','easy-business'),
		),
	)
);

$number_of_featured_slider_items = easy_business_get_option( 'number_of_featured_slider_items' );

for( $i=1; $i<=$number_of_featured_slider_items; $i++ ) {

	// Page
	$wp_customize->add_setting('theme_options[featured_slider_page_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'easy_business_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[featured_slider_page_'.$i.']', 
		array(
		'label'       => sprintf( __('Select Page #%1$s', 'easy-business'), $i),
		'section'     => 'section_featured_slider',   
		'settings'    => 'theme_options[featured_slider_page_'.$i.']',		
		'type'        => 'dropdown-pages',
		'active_callback' => 'easy_business_featured_slider_page',
		)
	);

	// Posts
	$wp_customize->add_setting('theme_options[featured_slider_post_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'easy_business_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[featured_slider_post_'.$i.']', 
		array(
		'label'       => sprintf( __('Select Post #%1$s', 'easy-business'), $i),
		'section'     => 'section_featured_slider',   
		'settings'    => 'theme_options[featured_slider_post_'.$i.']',		
		'type'        => 'select',
		'choices'	  => easy_business_dropdown_posts(),
		'active_callback' => 'easy_business_featured_slider_post',
		)
	);
}