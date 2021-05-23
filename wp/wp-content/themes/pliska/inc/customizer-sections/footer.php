<?php

function pliska_register_footer_customizer( $wp_customize ) {

	$wp_customize->add_section(
		'custom_footer',
		array(
			'title'       => __( 'Footer Options', 'pliska' ),
			'description' => __( 'Change footer styles and remove theme credits - go Pro version.', 'pliska' ),
		)
	);
	/*
	 * Allow users to add their own footer credits.
	 */
	$wp_customize->add_setting(
		'footer_text_block',
		array(
			'default'           => '',
			'sanitize_callback' => 'pliska_sanitize_html',
			'description'       => __( 'Add copyright info', 'pliska' ),
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'footer_text_block',
		array(
			'label'   => __( 'Copyright Notice', 'pliska' ),
			'section' => 'custom_footer',
			'type'    => 'text',
		)
	);

}

add_action( 'customize_register', 'pliska_register_footer_customizer', 999 );