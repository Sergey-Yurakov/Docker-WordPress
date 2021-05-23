<?php

function pliska_customize_fonts( $wp_customize ) {
	$wp_customize->add_section(
		'font_section',
		array(
			'title'       => __( 'Fonts', 'pliska' ),
			'description' => __( 'Choose between 1000+ google fonts - go pro version.', 'pliska' ),
		)
	);
	$wp_customize->add_setting(
		'headings_fontfamily',
		array(
			'default'           => 'Rubik',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'headings_fontfamily',
		array(
			'label'       => __( 'Headings Font Family', 'pliska' ),
			'section'     => 'font_section',
			'type'        => 'select',
			'choices'     => pliska_font_family(),
			'description' => esc_html__( 'Choose font for the headlines.', 'pliska' ),
		)
	);
	$wp_customize->add_setting(
		'body_fontfamily',
		array(
			'default'           => 'IBM Plex Sans',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'body_fontfamily',
		array(
			'label'       => __( 'Body Font Family', 'pliska' ),
			'section'     => 'font_section',
			'type'        => 'select',
			'choices'     => pliska_font_family(),
			'description' => esc_html__( 'Choose font for the text.', 'pliska' ),
		)
	);
	/* Regulate body size */
	$wp_customize->add_setting(
		'body_font_size',
		array(
			'default'           => '16',
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'body_font_size',
		array(
			'label'       => __( 'Body Font Size', 'pliska' ),
			'section'     => 'font_section',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 8,
				'max'  => 30,
				'step' => 1,
			),
			'description' => esc_html__( 'Change the size of the text. Enter a number in pixels between 8 and 30. Default is 16.', 'pliska' ),
		)
	);
}

add_action( 'customize_register', 'pliska_customize_fonts', 40 );
/**
 * Display custom font CSS.
 */
function pliska_business_fonts_css_container() {    ?>
<style type="text/css">
h1,
h2,
h3,
h4,
h5,
h6 {
	font-family: <?php echo esc_attr( get_theme_mod( 'headings_fontfamily', 'Rubik' ) ); ?> ;
}

body {
	font-family: <?php echo esc_attr( get_theme_mod( 'body_fontfamily', 'IBM Plex Sans' ) );?>;
    font-size: <?php echo esc_attr( get_theme_mod( 'body_font_size', '16' ) ); ?>px;
}

		
</style>
	<?php
}

add_action( 'wp_head', 'pliska_business_fonts_css_container' );
