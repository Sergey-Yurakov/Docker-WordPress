<?php
/**
 * Register Social Menu Section in the theme customizer.
 *
 * @package pliska
 */

function pliska_register_social_icons_theme_customizer( $wp_customize ) {

	$wp_customize->add_section(
		'social_icons_section',
		array(
			'title'       => __( 'Social Icons', 'pliska' ),
			'description' => __( "Add social icons in the site footer. Navigate to your user's profile, copy the url and paste it in the corresponding field.", 'pliska' ),
		)
	);

	$wp_customize->add_setting(
		'phone_control',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage'
		)
	);

	$wp_customize->add_control(
		'phone_control',
		array(
			'label'       => __( 'Phone number', 'pliska' ),
			'section'     => 'social_icons_section',
			'type'        => 'url',
			'description' => esc_html__( 'Add your phone number', 'pliska' ),
		)
	);

	$wp_customize->add_setting(
		'facebook_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'postMessage'
		)
	);

	$wp_customize->add_control(
		'facebook_url',
		array(
			'label'       => __( 'Facebook Url', 'pliska' ),
			'section'     => 'social_icons_section',
			'type'        => 'url',
			'description' => esc_html__( 'Add link to your facebook account.', 'pliska' ),
		)
	);

	$wp_customize->add_setting(
		'instagram_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'postMessage'
		)
	);

	$wp_customize->add_control(
		'instagram_url',
		array(
			'label'       => __( 'Instagram Url', 'pliska' ),
			'section'     => 'social_icons_section',
			'type'        => 'url',
			'description' => esc_html__( 'Add link to your instagram account.', 'pliska' ),
		)
	);

	$wp_customize->add_setting(
		'twitter_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'postMessage'
		)
	);

	$wp_customize->add_control(
		'twitter_url',
		array(
			'label'       => __( 'Twitter Url', 'pliska' ),
			'section'     => 'social_icons_section',
			'type'        => 'url',
			'description' => esc_html__( 'Add link to your twitter account.', 'pliska' ),
		)
	);

	$wp_customize->add_setting(
		'youtube_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'postMessage'
		)
	);

	$wp_customize->add_control(
		'youtube_url',
		array(
			'label'       => __( 'Youtube Url', 'pliska' ),
			'section'     => 'social_icons_section',
			'type'        => 'url',
			'description' => esc_html__( 'Add link to your youtube account.', 'pliska' ),
		)
	);

	$wp_customize->add_setting(
		'linkedin_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'postMessage'
		)
	);

	$wp_customize->add_control(
		'linkedin_url',
		array(
			'label'       => __( 'Linkedin Url', 'pliska' ),
			'section'     => 'social_icons_section',
			'type'        => 'url',
			'description' => esc_html__( 'Add link to your linkedin account.', 'pliska' ),
		)
	);

	$wp_customize->add_setting(
		'mail_control',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage'
		)
	);

	$wp_customize->add_control(
		'mail_control',
		array(
			'label'       => __( 'Email address', 'pliska' ),
			'section'     => 'social_icons_section',
			'type'        => 'url',
			'description' => esc_html__( 'Add your mail address', 'pliska' ),
		)
	);

}

add_action( 'customize_register', 'pliska_register_social_icons_theme_customizer' );