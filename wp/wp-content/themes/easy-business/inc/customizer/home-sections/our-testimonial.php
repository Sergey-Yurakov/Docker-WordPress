<?php
/**
 * Our Testimonial options.
 *
 * @package Easy Business
 */

$default = easy_business_get_default_theme_options();

// Featured Our Testimonial Section
$wp_customize->add_section( 'section_our_testimonial',
	array(
	'title'      => __( 'Our Testimonial', 'easy-business' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'home_page_panel',
	)
);

// Enable Our Testimonial Section
$wp_customize->add_setting('theme_options[enable_our_testimonial_section]', 
	array(
	'default' 			=> $default['enable_our_testimonial_section'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'easy_business_sanitize_checkbox'
	)
);

$wp_customize->add_control('theme_options[enable_our_testimonial_section]', 
	array(		
	'label' 	=> __('Enable Our Testimonial Section', 'easy-business'),
	'section' 	=> 'section_our_testimonial',
	'settings'  => 'theme_options[enable_our_testimonial_section]',
	'type' 		=> 'checkbox',	
	)
);

// Section Title
$wp_customize->add_setting('theme_options[our_testimonial_section_title]', 
	array(
	'default'           => $default['our_testimonial_section_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[our_testimonial_section_title]', 
	array(
	'label'       => __('Section Title', 'easy-business'),
	'section'     => 'section_our_testimonial',   
	'settings'    => 'theme_options[our_testimonial_section_title]',	
	'active_callback' => 'easy_business_our_testimonial_active',		
	'type'        => 'text'
	)
);

// Background Image
$wp_customize->add_setting('theme_options[background_our_testimonial_section]', 
	array(
	'type'              => 'theme_mod',
	'default' 			=> $default['background_our_testimonial_section'],
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'easy_business_sanitize_image'
	)
);

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,
	'theme_options[background_our_testimonial_section]', 
	array(
	'label'       		=> __('Background Image', 'easy-business'),
	'section'     		=> 'section_our_testimonial',   
	'settings'    		=> 'theme_options[background_our_testimonial_section]',		
	'active_callback' 	=> 'easy_business_our_testimonial_active',
	'type'        		=> 'image',
	)
	)
);

// Number of items
$wp_customize->add_setting('theme_options[number_of_our_testimonial_items]', 
	array(
	'default' 			=> $default['number_of_our_testimonial_items'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'easy_business_sanitize_number_range'
	)
);

$wp_customize->add_control('theme_options[number_of_our_testimonial_items]', 
	array(
	'label'       => __('Number Of Items', 'easy-business'),
	'description' => __('Save & Refresh the customizer to see its effect. Maximum is 10.', 'easy-business'),
	'section'     => 'section_our_testimonial',   
	'settings'    => 'theme_options[number_of_our_testimonial_items]',		
	'type'        => 'number',
	'active_callback' => 'easy_business_our_testimonial_active',
	'input_attrs' => array(
			'min'	=> 1,
			'max'	=> 10,
			'step'	=> 1,
		),
	)
);

$wp_customize->add_setting('theme_options[our_testimonial_content_type]', 
	array(
	'default' 			=> $default['our_testimonial_content_type'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'easy_business_sanitize_select'
	)
);

$wp_customize->add_control('theme_options[our_testimonial_content_type]', 
	array(
	'label'       => __('Content Type', 'easy-business'),
	'section'     => 'section_our_testimonial',   
	'settings'    => 'theme_options[our_testimonial_content_type]',		
	'type'        => 'select',
	'active_callback' => 'easy_business_our_testimonial_active',
	'choices'	  => array(
			'our_testimonial_page'	  => __('Page','easy-business'),
			'our_testimonial_post'	  => __('Post','easy-business'),
		),
	)
);

$number_of_our_testimonial_items = easy_business_get_option( 'number_of_our_testimonial_items' );

for( $i=1; $i<=$number_of_our_testimonial_items; $i++ ) {

	// Page
	$wp_customize->add_setting('theme_options[our_testimonial_page_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'easy_business_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[our_testimonial_page_'.$i.']', 
		array(
		'label'       => sprintf( __('Select Page #%1$s', 'easy-business'), $i),
		'section'     => 'section_our_testimonial',   
		'settings'    => 'theme_options[our_testimonial_page_'.$i.']',		
		'type'        => 'dropdown-pages',
		'active_callback' => 'easy_business_our_testimonial_page',
		)
	);

	// Posts
	$wp_customize->add_setting('theme_options[our_testimonial_post_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'easy_business_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[our_testimonial_post_'.$i.']', 
		array(
		'label'       => sprintf( __('Select Post #%1$s', 'easy-business'), $i),
		'section'     => 'section_our_testimonial',   
		'settings'    => 'theme_options[our_testimonial_post_'.$i.']',		
		'type'        => 'select',
		'choices'	  => easy_business_dropdown_posts(),
		'active_callback' => 'easy_business_our_testimonial_post',
		)
	);
}