<?php
/**
 * Call to action options.
 *
 * @package Easy Business
 */

$default = easy_business_get_default_theme_options();

// Call to action section
$wp_customize->add_section( 'section_call_to_action',
	array(
		'title'      => __( 'Call To Action', 'easy-business' ),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
		'panel'      => 'home_page_panel',
		)
);
// Enable Call to action Section
$wp_customize->add_setting('theme_options[enable_call_to_action_section]', 
	array(
	'default' 			=> $default['enable_call_to_action_section'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'easy_business_sanitize_checkbox'
	)
);

$wp_customize->add_control('theme_options[enable_call_to_action_section]', 
	array(		
	'label' 	=> __('Enable Call to action section', 'easy-business'),
	'section' 	=> 'section_call_to_action',
	'settings'  => 'theme_options[enable_call_to_action_section]',
	'type' 		=> 'checkbox',	
	)
);

// Call to action Background Image
$wp_customize->add_setting('theme_options[background_call_to_action_section]', 
	array(
	'type'              => 'theme_mod',
	'default' 			=> $default['background_call_to_action_section'],
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'easy_business_sanitize_image'
	)
);

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,
	'theme_options[background_call_to_action_section]', 
	array(
	'label'       		=> __('Background Image', 'easy-business'),
	'section'     		=> 'section_call_to_action',   
	'settings'    		=> 'theme_options[background_call_to_action_section]',		
	'active_callback' 	=> 'easy_business_call_to_action_active',
	'type'        		=> 'image',
	)
	)
);

// Call to action title
$wp_customize->add_setting('theme_options[call_to_action_title]', 
	array(
	'default' 			=> $default['call_to_action_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[call_to_action_title]', 
	array(
	'label'       		=> __('Title', 'easy-business'),
	'section'     		=> 'section_call_to_action',   
	'settings'    		=> 'theme_options[call_to_action_title]',
	'active_callback' 	=> 'easy_business_call_to_action_active',		
	'type'        		=> 'text'
	)
);

// Call to action Button Text
$wp_customize->add_setting('theme_options[call_to_action_button_label]', 
	array(
	'default' 			=> $default['call_to_action_button_label'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[call_to_action_button_label]', 
	array(
	'label'       		=> __('Button Label', 'easy-business'),
	'section'     		=> 'section_call_to_action',   
	'settings'    		=> 'theme_options[call_to_action_button_label]',	
	'active_callback' 	=> 'easy_business_call_to_action_active',	
	'type'        		=> 'text'
	)
);

// Call to action Button Url
$wp_customize->add_setting('theme_options[call_to_action_button_url]', 
	array(
	'default' 			=> $default['call_to_action_button_url'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'esc_url_raw'
	)
);

$wp_customize->add_control('theme_options[call_to_action_button_url]', 
	array(
	'label'       		=> __('Button Url', 'easy-business'),
	'section'     		=> 'section_call_to_action',   
	'settings'    		=> 'theme_options[call_to_action_button_url]',	
	'active_callback' 	=> 'easy_business_call_to_action_active',	
	'type'        		=> 'url'
	)
);