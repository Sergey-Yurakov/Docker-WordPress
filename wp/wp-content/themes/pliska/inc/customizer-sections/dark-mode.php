<?php 
/**
 * Night Mode
 * @since version 0.0.1
 * 
 */

function pliska_night_mode_customizer( $wp_customize ) {
	$wp_customize->add_section(
		'night_mode',
		array(
			'title'       => esc_html( __( 'Night Mode', 'pliska' ) ),
			'description' => esc_html(
				__( 'Customize the dark theme mode. For additional customizations, you can use the "dark-mode" body class and add the code to the Additional Css tab.', 'pliska' )
			),
		)
	);

	// Enable Dark Mode
	$wp_customize->add_setting(
		'enable_dark_mode',
		array(
			'default'           => 1,
			'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
		)
	);

	$wp_customize->add_control(
		'enable_dark_mode',
		array(
			'label'       => esc_html__( 'Enable Dark Mode', 'pliska' ),
			'section'     => 'night_mode',
			'description' => esc_html__( 'Enable site visitors to switch to dark or light theme mode in the header menu.', 'pliska' ),
			'type'        => 'checkbox',
		)
	);

    // Default mode dark

    $wp_customize->add_setting(
		'default_dark_mode',
		array(
			'default'           => 0,
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'default_dark_mode',
		array(
			'label'       => esc_html__( 'Make the dark mode default', 'pliska' ),
			'section'     => 'night_mode',
			'description' => esc_html__( 'Make the dark mode the default theme mode. Please note: the site visitors will still be able to switch modes, if you have enabled the above option.', 'pliska' ),
			'type'        => 'checkbox',
		)
	);

	// Change Dark Mode Colors

	$wp_customize->add_setting(
		'dark_mode_background_color',
		array(
			'default'           => '#262626',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'dark_mode_background_color',
			array(
				'label'   => __( 'Background', 'pliska' ),
				'section' => 'night_mode',
			)
		)
	);
}

add_action( 'customize_register', 'pliska_night_mode_customizer' );

function pliska_customize_night_mode_css() {

	$isDarkMode = get_theme_mod( 'enable_dark_mode', 1 ) == 1 ? 'block' : 'none';

	?>

<style type="text/css">
.dark-mode-widget {
    display: <?php echo esc_attr($isDarkMode); ?>
}
<?php if($isDarkMode=='block' || pliska_default_mode() =='dark') : ?>
.dark-mode{
	background-color: <?php echo esc_attr( get_theme_mod( 'dark_mode_background_color', '#262626' ) ); ?>;
}
.dark-mode .main-navigation-container.fixed-header {
	background-color: <?php echo esc_attr( get_theme_mod( 'dark_mode_background_color', '#262626' ) ); ?>;
}
.dark-mode .comment-form, .dark-mode .comment-body, .dark-mode .comment-form textarea {
	background-color: <?php echo esc_attr( get_theme_mod( 'dark_mode_background_color', '#262626' ) ); ?> !important;
}
<?php endif; ?>
</style>

<script>

<?php if (pliska_default_mode() =='dark') : //clean up localstorage ?>
	localStorage.removeItem('pliskaNightMode', 'true');
<?php else : ?>
    localStorage.removeItem('pliskaLightMode');
<?php endif; ?>
</script> 

<?php
}

add_action( 'wp_head', 'pliska_customize_night_mode_css' );