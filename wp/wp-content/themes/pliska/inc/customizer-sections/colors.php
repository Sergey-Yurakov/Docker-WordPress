<?php
// Gradient colors

function pliska_customize_colors( $wp_customize ) {

	$wp_customize->get_section( 'colors' )->description = esc_html__( 'Customze the colors of the light theme mode. To customize the dark theme mode, go to the Night Mode section.', 'pliska' );
	
	$wp_customize->add_setting(
		'pliska_gradient_color_one',
		array(
			'default'           => '#1997d2',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'pliska_gradient_color_one',
			array(
				'label'       => esc_html__( 'Header Image Gradient Color One', 'pliska' ),
				'section'     => 'colors',
				'description' => esc_html__( 'To change header image gradient direction, density or completely remove it, go to "Header Options" section.', 'pliska' ),
			)
		)
	);

	$wp_customize->add_setting(
		'pliska_gradient_color_two',
		array(
			'default'           => '#000',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'pliska_gradient_color_two',
			array(
				'label'   => esc_html__( 'Header Image Gradient Color Two', 'pliska' ),
				'section' => 'colors',
			)
		)
	);

	// Menu Text Color
	$wp_customize->add_setting(
		'nav_top_menu_text_color',
		array(
			'default'           => '#666',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'nav_top_menu_text_color',
			array(
				'label'       => esc_html__( 'Header Menu Text Color', 'pliska' ),
				'section'     => 'colors',
				'description' => esc_html__( 'The menu text color when you scroll down the page. To change the menu behavior (sticky, fixed or static menu), go to "Header Options" section.', 'pliska' ),
			)
		)
	);

	// Sub-menu Text Color
	$wp_customize->add_setting(
		'nav_text_color',
		array(
			'default'           => '#fff',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'nav_text_color',
			array(
				'label'   => esc_html__( 'Sub-menu Text Color', 'pliska' ),
				'section' => 'colors',
			)
		)
	);

	// Sub Menu Background
	$wp_customize->add_setting(
		'nav_color',
		array(
			'default'           => '#066664',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'nav_color',
			array(
				'label'   => __( 'Sub-menu Background Color', 'pliska' ),
				'section' => 'colors',
				'type'    => 'color',
			)
		)
	);

	// Mobile Menu Background

	$wp_customize->add_setting(
		'mobile_menu_background',
		array(
			'default'           => '#066664',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'mobile_menu_background',
			array(
				'label'   => __( 'Mobile Menu Background Color', 'pliska' ),
				'section' => 'colors',
				'type'    => 'color',
			)
		)
	);

	// Headings Text Color
	$wp_customize->add_setting(
		'headings_text_color',
		array(
			'default'           => '#404040',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'headings_text_color',
			array(
				'label'   => esc_html__( 'Headings Text Color', 'pliska' ),
				'section' => 'colors',
			)
		)
	);

	// Body Text Color
	$wp_customize->add_setting(
		'body_text_color',
		array(
			'default'           => '#404040',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'body_text_color',
			array(
				'label'   => esc_html__( 'Body Text Color', 'pliska' ),
				'section' => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'links_text_color',
		array(
			'default'           => '#128284',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'links_text_color',
			array(
				'label'   => esc_html__( 'Links Text Color', 'pliska' ),
				'section' => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'links_hover_color',
		array(
			'default'           => '#066664',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'links_hover_color',
			array(
				'label'   => esc_html__( 'Links Hover Color', 'pliska' ),
				'section' => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'primary_accent_color',
		array(
			'default'           => '#0b8276',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'primary_accent_color',
			array(
				'label'   => esc_html__( 'Primary Accent Color', 'pliska' ),
				'section' => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'secondary_accent_color',
		array(
			'default'           => '#fbc02d',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'secondary_accent_color',
			array(
				'label'   => esc_html__( 'Secondary Accent Color', 'pliska' ),
				'section' => 'colors',
			)
		)
	);

}

add_action( 'customize_register', 'pliska_customize_colors', 10 );

function pliska_customize_colors_css() {

	$top_menu_text_color = get_theme_mod( 'nav_top_menu_text_color', '#666' );
	$submenu_bgr_color   = get_theme_mod( 'nav_color', '#066664' );
	$submenu_text_color  = get_theme_mod( 'nav_text_color', '#fff' );
	$body_text_color     = get_theme_mod( 'body_text_color', '#404040' );
	$headings_text_color = get_theme_mod( 'headings_text_color', '#404040' );
	$links_text_color    = get_theme_mod( 'links_text_color', '#128284' );
	$links_hover_color   = get_theme_mod( 'links_hover_color', '#066664' );

	$mobile_bgr_menu = get_theme_mod( 'mobile_menu_background', '#066664' );

	$primary_accent_color   = get_theme_mod( 'primary_accent_color', '#0b8276' );
	$secondary_accent_color = get_theme_mod( 'secondary_accent_color', '#fbc02d' );

	?>
	
	<style>
	body {
		color: <?php echo esc_attr( $body_text_color ); ?>;
	}
	h1, h2, h3, h4, h5, h6, .entry-title a, .entry-title a:hover, .entry-title a:focus{
		color: <?php echo esc_attr( $headings_text_color ); ?>;
	}
	.hentry .feather-clock, .hentry .feather-comment {
		stroke: <?php echo esc_attr( $body_text_color ); ?>;
		opacity: .75;
	}
	.hentry .tag-icon {
		fill: <?php echo esc_attr( $body_text_color ); ?>;
		opacity: .65;
	}
	a {
		color: <?php echo esc_attr( $links_text_color ); ?>;
	}
	a:hover, a:active, a:focus {
		color: <?php echo esc_attr( $links_hover_color ); ?>;
	}
	button, input[type="button"], input[type="reset"], input[type="submit"] {
		background: <?php echo esc_attr( $primary_accent_color ); ?>;
	}
	.header-buttons .left-btn button {
		background: <?php echo esc_attr( $secondary_accent_color ); ?>;
		border-color: <?php echo esc_attr( $secondary_accent_color ); ?>;
	}
	.header-buttons .left-btn button:before {
		border: 2px solid <?php echo esc_attr( $secondary_accent_color ); ?>;
	}
	.cart-counter {
		background: <?php echo esc_attr( $secondary_accent_color ); ?>;
	}
	.top-meta .cat-links a:nth-of-type(3n+1) {
		background: <?php echo esc_attr( $secondary_accent_color ); ?>;
	}
	.top-meta .cat-links a:nth-of-type(3n+1):hover {
		background: <?php echo esc_attr( $primary_accent_color ); ?>;
	}
	.widget-area h2, .comments-title, .comment-reply-title, .related-posts-wrapper h2,
	.section-right-image h2, .section-left-image h2, .section-call-to-action h2, 
	.section-fullwidth-2 h2, .services-page h2, .about-page h2 {
		background-image: linear-gradient(to bottom, <?php echo esc_attr( pliska_hex_to_rgba( $secondary_accent_color, 0.4 ) ); ?> 0%, <?php echo esc_attr( pliska_hex_to_rgba( $secondary_accent_color, 0.8 ) ); ?> 100%)
	}
	.ionicon-youtube, .ionicon-pinterest, .ionicon-linkedin, .ionicon-instagram {
		fill: <?php echo esc_attr( $secondary_accent_color ); ?>
	}
	.feather-facebook, .feather-twitter, .feather-mail {
		stroke: <?php echo esc_attr( $secondary_accent_color ); ?>
	}
	#back-to-top {
		background: <?php echo esc_attr( pliska_brightness( $primary_accent_color, 75 ) ); // WPCS: XSS ok. ?>;
	}
	#back-to-top:hover {
		background: <?php echo esc_attr( pliska_brightness( $primary_accent_color, 25 ) ); // WPCS: XSS ok. ?>;
	}
	.text-wrapper .entry-title a {
		background-image: linear-gradient(to bottom, <?php echo esc_attr( $secondary_accent_color ); ?> 0%, <?php echo esc_attr( $secondary_accent_color ); ?> 100%)	
	}
	.navigation .page-numbers:hover,
	.navigation .page-numbers.current {
		background-color: <?php echo esc_attr( $secondary_accent_color ); ?>;
	}
	@media (max-width: 40em) {
		.slide-menu {
			background-color:  <?php echo esc_attr( $mobile_bgr_menu ); ?>;
		}
	}
	@media (min-width:40em){
		.search-form button {
			background: <?php echo esc_attr( pliska_brightness( $primary_accent_color, 75 ) ); // WPCS: XSS ok. ?>;
		}
		.fixed-header .site-menu a {
			color: <?php echo esc_attr( $top_menu_text_color ); ?>;
		}
		.no-header-image .site-menu a {
			color: <?php echo esc_attr( $top_menu_text_color ); ?>;
		}
		.no-header-image .ionicon-search {
			fill: <?php echo esc_attr( $top_menu_text_color ); ?>;
		}
		.static-header .search-item .search-icon svg,
		.sticky-header .search-item .search-icon svg {
			fill: <?php echo esc_attr( $top_menu_text_color ); ?>;
		}

		.site-menu ul ul a {
			background-color: <?php echo esc_attr( $submenu_bgr_color ); ?>;
			transition: .4s all;
		}
		.site-menu ul ul a:hover, .site-menu ul ul .focus a, .site-menu ul ul ul a {
			background-color: <?php echo esc_attr( pliska_brightness( $submenu_bgr_color, -25 ) ); // WPCS: XSS ok. ?>;

		}
		.site-menu ul ul ul .focus a, .site-menu ul ul ul a:hover {
			background-color: <?php echo esc_attr( pliska_brightness( $submenu_bgr_color, -37.5 ) ); // WPCS: XSS ok. ?>;

		}
		.site-menu .mega-menu ul a{
			background-color: <?php echo esc_attr( $submenu_bgr_color ); ?> !important;
		}
		.site-menu .mega-menu > ul > .focus > a, .site-menu .mega-menu ul ul .focus a, .site-menu .mega-menu ul a:hover {
			background-color: <?php echo esc_attr( pliska_brightness( $submenu_bgr_color, -25 ) ); // WPCS: XSS ok. ?> !important;
		}

		.site-menu ul ul a {
			color: <?php echo esc_attr( $submenu_text_color ); ?>;
		}

		.fixed-header .site-menu ul ul a {
			color: <?php echo esc_attr( $submenu_text_color ); ?>;
		}

		#secondary .tagcloud a:hover {
			background-color: <?php echo esc_attr( $secondary_accent_color ); ?>;
		}
	}

	.preloader-inside .bounce1{
		background-color: <?php echo esc_attr( $primary_accent_color ); ?>;
	}
	.preloader-inside .bounce2{
		background-color: <?php echo esc_attr( $secondary_accent_color ); ?>;
	}

	.has-green-color, .has-green-color:focus, .has-green-color:hover, .has-green-color:visited {
		color: <?php echo esc_attr( $primary_accent_color ); ?>
	}

	.has-yellow-color, .has-yellow-color:focus, .has-yellow-color:hover, .has-yellow-color:visited {
		color: <?php echo esc_attr( pliska_brightness( $secondary_accent_color, -90 ) ); ?>
	}
	hr.has-yellow-color {
		background-color: <?php echo esc_attr( $secondary_accent_color ); ?>
	}
	.has-green-color:before {
		border: 1px solid <?php echo esc_attr( $primary_accent_color ); ?>
	}
	.has-yellow-color:before{
		border: 1px solid <?php echo esc_attr( pliska_brightness( $secondary_accent_color, -90 ) ); ?>
	}
	.dark-mode a, .dark-mode a:hover, .dark-mode a:focus {
		color: <?php echo esc_attr( $secondary_accent_color ); ?>;
	}
	</style>
	
	<?php
}

add_action( 'wp_head', 'pliska_customize_colors_css' );