<?php
/**
 * Our Gallery options.
 *
 * @package Easy Business
 */

$default = easy_business_get_default_theme_options();

// Our Gallery Section
$wp_customize->add_section( 'section_our_gallery',
	array(
	'title'      => __( 'Our Gallery', 'easy-business' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'home_page_panel',
	)
);

// Enable Our Gallery Section
$wp_customize->add_setting('theme_options[enable_our_gallery_section]', 
	array(
	'default' 			=> $default['enable_our_gallery_section'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'easy_business_sanitize_checkbox'
	)
);

$wp_customize->add_control('theme_options[enable_our_gallery_section]', 
	array(		
	'label' 	=> __('Enable Our Gallery Section', 'easy-business'),
	'section' 	=> 'section_our_gallery',
	'settings'  => 'theme_options[enable_our_gallery_section]',
	'type' 		=> 'checkbox',	
	)
);

// Section Title
$wp_customize->add_setting('theme_options[our_gallery_section_title]', 
	array(
	'default'           => $default['our_gallery_section_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[our_gallery_section_title]', 
	array(
	'label'       => __('Section Title', 'easy-business'),
	'section'     => 'section_our_gallery',   
	'settings'    => 'theme_options[our_gallery_section_title]',	
	'active_callback' => 'easy_business_our_gallery_active',		
	'type'        => 'text'
	)
);

// Number of items
$wp_customize->add_setting('theme_options[number_of_our_gallery_items]', 
	array(
	'default' 			=> $default['number_of_our_gallery_items'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'easy_business_sanitize_number_range'
	)
);

$wp_customize->add_control('theme_options[number_of_our_gallery_items]', 
	array(
	'label'       => __('Number Of Items', 'easy-business'),
	'description' => __('Save & Refresh the customizer to see its effect. Maximum is 10.', 'easy-business'),
	'section'     => 'section_our_gallery',   
	'settings'    => 'theme_options[number_of_our_gallery_items]',		
	'type'        => 'number',
	'active_callback' => 'easy_business_our_gallery_active',
	'input_attrs' => array(
			'min'	=> 1,
			'max'	=> 10,
			'step'	=> 1,
		),
	)
);

$wp_customize->add_setting('theme_options[our_gallery_content_type]', 
	array(
	'default' 			=> $default['our_gallery_content_type'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'easy_business_sanitize_select'
	)
);

$wp_customize->add_control('theme_options[our_gallery_content_type]', 
	array(
	'label'       => __('Content Type', 'easy-business'),
	'section'     => 'section_our_gallery',   
	'settings'    => 'theme_options[our_gallery_content_type]',		
	'type'        => 'select',
	'active_callback' => 'easy_business_our_gallery_active',
	'choices'	  => array(
			'our_gallery_page'	  => __('Page','easy-business'),
			'our_gallery_post'	  => __('Post','easy-business'),
		),
	)
);

$number_of_our_gallery_items = easy_business_get_option( 'number_of_our_gallery_items' );

for( $i=1; $i<=$number_of_our_gallery_items; $i++ ) {

	// Page
	$wp_customize->add_setting('theme_options[our_gallery_page_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'easy_business_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[our_gallery_page_'.$i.']', 
		array(
		'label'       => sprintf( __('Select Page #%1$s', 'easy-business'), $i),
		'section'     => 'section_our_gallery',   
		'settings'    => 'theme_options[our_gallery_page_'.$i.']',		
		'type'        => 'dropdown-pages',
		'active_callback' => 'easy_business_our_gallery_page',
		)
	);

	// Posts
	$wp_customize->add_setting('theme_options[our_gallery_post_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'easy_business_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[our_gallery_post_'.$i.']', 
		array(
		'label'       => sprintf( __('Select Post #%1$s', 'easy-business'), $i),
		'section'     => 'section_our_gallery',   
		'settings'    => 'theme_options[our_gallery_post_'.$i.']',		
		'type'        => 'select',
		'choices'	  => easy_business_dropdown_posts(),
		'active_callback' => 'easy_business_our_gallery_post',
		)
	);
}