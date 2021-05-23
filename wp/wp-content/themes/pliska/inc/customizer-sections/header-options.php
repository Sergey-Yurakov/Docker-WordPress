<?php

/*
 * Allow users to change or remove the call to action on the Homepage
 * and customize the header image
 */

function pliska_customize_register_banner_and_header( $wp_customize ) {
	/*
	 * HEADER IMAGE OPTIONS
	 *
	 */

	$wp_customize->add_panel(
		'pliska_header_options',
		array(
			'title'       => __( 'Header Options', 'pliska' ),
			'description' => esc_html__( 'Customize the header image to taste with the options below. Change width, height and position of the image. Choose to add or remove the parallax effect on the image. Customize the call to action button on the header of the Homepage. Please note: for these options to work, make sure that a header image is specified in the "Header Image" section.', 'pliska' ),
			'priority'    => 160,
		)
	);

	$wp_customize->add_section(
		'header_menu',
		array(
			'title'       => esc_html__( 'Header Menu Options', 'pliska' ),
			'description' => esc_html__( 'Customize the top menu bar. Show it only on top of the page (static position), show it all the time (fixed) or show it when you scroll up (sticky). The default positon is sticky.', 'pliska' ),
			'panel'       => 'pliska_header_options',
		)
	);
	$wp_customize->add_section(
		'header_image_options',
		array(
			'title'       => esc_html__( 'Header Image Options', 'pliska' ),
			'description' => esc_html__( 'Customize the header image to taste with the options below. Change width, height and position of the image. Choose to add or remove the parallax effect on the image. Customize the call to action button on the header of the Homepage. Please note: for these options to work, make sure that a header image is specified in the "Header Image" section.', 'pliska' ),
			'panel'       => 'pliska_header_options',
		)
	);

	$wp_customize->add_section(
		'call_to_action',
		array(
			'title'       => esc_html__( 'Call to Action Buttons', 'pliska' ),
			'description' => esc_html__( 'Customize the header image to taste with the options below. Change width, height and position of the image. Choose to add or remove the parallax effect on the image. Customize the call to action button on the header of the Homepage. Please note: for these options to work, make sure that a header image is specified in the "Header Image" section.', 'pliska' ),
			'panel'       => 'pliska_header_options',
		)
	);

	$wp_customize->add_section(
		'header_animations',
		array(
			'title'       => esc_html__( 'Header Animations', 'pliska' ),
			'description' => esc_html__( 'Animate the page title text on page load.', 'pliska' ),
			'panel'       => 'pliska_header_options',
		)
	);

	// Header Menu Position

	$wp_customize->add_setting(
		'header-menu-position',
		array(
			'default'           => 'sticky',
			'sanitize_callback' => 'pliska_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'header-menu-position',
		array(
			'label'       => esc_html__( 'Header Menu Position', 'pliska' ),
			'section'     => 'header_menu',
			'description' => esc_html__( ' Position the menu to stick to the top of the screen when scrolling down or keep it above the fold.', 'pliska' ),
			'type'        => 'select',
			'choices'     => array(
				'fixed'  => esc_html( 'fixed' ),
				'sticky' => esc_html( 'sticky' ),
				'static' => esc_html( 'static' ),
			),
		)
	);

	// Header Image on All Pages
	$wp_customize->add_setting(
		'show-header-image-homepage',
		array(
			'default'           => 1,
			'sanitize_callback' => 'pliska_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'show-header-image-homepage',
		array(
			'label'       => esc_html__( 'Show the site header image as a fallback image when there is no featured image on single posts and pages.', 'pliska' ),
			'section'     => 'header_image_options',
			'description' => esc_html__( 'Display the global header image from the Header Image section on all posts and pages that do not have a specified featured image. Unchecking this option will keep the global header image on the homepage, the blog page and posts archives only. Useful when you want to develop your site with a page builder or Gutenberg blocks.', 'pliska' ),
			'type'        => 'checkbox',
		)
	);

	// Header Image on All Pages
	$wp_customize->add_setting(
		'show-header-image-post-archives',
		array(
			'default'           => 1,
			'sanitize_callback' => 'pliska_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'show-header-image-post-archives',
		array(
			'label'       => esc_html__( 'Show the site header image on post archives', 'pliska' ),
			'section'     => 'header_image_options',
			'description' => esc_html__( 'Display the global header image on post archives.', 'pliska' ),
			'type'        => 'checkbox',
		)
	);

	//Control woocommerce  featured image on single product page
	if ( class_exists( 'WooCommerce' ) ) {
		$wp_customize->add_setting(
			'show-product-image-as-header-image',
			array(
				'default'           => 1,
				'sanitize_callback' => 'pliska_sanitize_checkbox',
			)
		);
	
		$wp_customize->add_control(
			'show-product-image-as-header-image',
			array(
				'label'       => esc_html__( 'Show the product image as a header image on WooCommerce single product page.', 'pliska' ),
				'section'     => 'header_image_options',
				'type'        => 'checkbox'
			)
		);
	}

	// Header background size
	$wp_customize->add_setting(
		'header_background_size',
		array(
			'default'           => 'cover',
			'sanitize_callback' => 'pliska_sanitize_select',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'header_background_size',
		array(
			'label'       => esc_html__( 'Header Background Size', 'pliska' ),
			'section'     => 'header_image_options',
			'description' => esc_html__( 'Resize the header image to adjust to the width of the whole screen or choose to keep its initial width.', 'pliska' ),
			'type'        => 'select',
			'choices'     => array(
				'initial' => esc_html( 'initial' ),
				'cover'   => esc_html( 'cover' ),
			),
		)
	);

	// Header Image Position
	$wp_customize->add_setting(
		'header_background_position',
		array(
			'default'           => 'center',
			'sanitize_callback' => 'pliska_sanitize_select',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'header_background_position',
		array(
			'label'       => esc_html__( 'Header Background Position', 'pliska' ),
			'section'     => 'header_image_options',
			'description' => esc_html__( 'Choose how you want to position the header image.', 'pliska' ),
			'type'        => 'select',
			'choices'     => array(
				'top'    => esc_html( 'top' ),
				'center' => esc_html( 'center' ),
				'bottom' => esc_html( 'bottom' ),
			),
		)
	);

	// Header Height

	$wp_customize->add_setting(
		'header_image_height',
		array(
			'default'           => '100vh',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'header_image_height',
		array(
			'label'       => esc_html__( 'Header Image Height', 'pliska' ),
			'section'     => 'header_image_options',
			'type'        => 'text',
			'description' => esc_html__( 'Change the height of the header image. Recommended size is between 60-100vh (default is 100vh). Note: this setting is only for large desktop screens in order to avoid text overlapping.', 'pliska' ),
		)
	);

	// Header Parallax Effect
	$wp_customize->add_setting(
		'header_background_attachment',
		array(
			'default'           => 1,
			'sanitize_callback' => 'pliska_sanitize_checkbox',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'header_background_attachment',
		array(
			'label'       => esc_html__( 'Header Image Parallax', 'pliska' ),
			'section'     => 'header_image_options',
			'description' => esc_html__( 'Add beautiful parallax effect on the header image. Try it by scrolling down the page.', 'pliska' ),
			'type'        => 'checkbox',
		)
	);

	// Header Gradient

	$wp_customize->add_setting(
		'gradient_direction',
		array(
			'default'           => 'left',
			'sanitize_callback' => 'pliska_sanitize_select',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'gradient_direction',
			array(
				'label'   => esc_html__( 'Gradient Direction', 'pliska' ),
				'section' => 'header_image_options',
				'type'    => 'select',
				'choices' => array(
					'left'   => esc_html__( 'Left', 'pliska' ),
					'right'  => esc_html__( 'Right', 'pliska' ),
					'top'    => esc_html__( 'Top', 'pliska' ),
					'bottom' => esc_html__( 'Bottom', 'pliska' ),
				),
			)
		)
	);

	// Gradient Opacity

	function pliska_customize_gradient_range() {
		return apply_filters(
			'pliska_customize_gradient_range',
			array(
				'min'  => 0,
				'max'  => 9,
				'step' => 1,
			)
		);
	}

	$wp_customize->add_setting(
		'header_gradient_density',
		array(
			'default'           => '4',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'header_gradient_density',
		array(
			'label'       => __( 'Header Image Gradient Density', 'pliska' ),
			'description' => __( 'Control the gradient density. From 0 to 10. Default is 4. Set it to 0 to remove the entire gradient.', 'pliska' ),
			'section'     => 'header_image_options',
			'type'        => 'range',
			'input_attrs' => pliska_customize_gradient_range(),
		)
	);

	// Header Overlay Opacity

	function pliska_customize_opacity_range() {
		return apply_filters(
			'pliska_customize_opacity_range',
			array(
				'min'  => 0,
				'max'  => 9,
				'step' => 1,
			)
		);
	}

	$wp_customize->add_setting(
		'cover_template_overlay_opacity',
		array(
			'default'           => '1',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'cover_template_overlay_opacity',
		array(
			'label'       => __( 'Overlay Opacity Density', 'pliska' ),
			'description' => __( 'Make sure that the contrast is high enough so that the text is readable. To change the on-scroll opacity animation overlay, go to "Header Animations" tab', 'pliska' ),
			'section'     => 'header_image_options',
			'type'        => 'range',
			'input_attrs' => pliska_customize_opacity_range(),
		)
	);

	/*
	 * CALL TO ACTION
	 */

	// Banner label
	$wp_customize->add_setting(
		'banner_label_one',
		array(
			'default'           => esc_html__( 'Get Started', 'pliska' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'banner_label_one',
		array(
			'label'       => esc_html__( 'Banner Text', 'pliska' ),
			'section'     => 'call_to_action',
			'description' => esc_html__( 'Change the default text of the button.', 'pliska' ),
			'type'        => 'text',
		)
	);

	// Banner Link
	$wp_customize->add_setting(
		'banner_link_one',
		array(
			'default'           => '#',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'banner_link_one',
		array(
			'label'       => esc_html__( 'Banner Link', 'pliska' ),
			'section'     => 'call_to_action',
			'description' => esc_html__( 'Add link to the button. You can link it to the About page or the Contact page or to a specific section from the Homepage.', 'pliska' ),
			'type'        => 'url',
		)
	);

	// Banner label
	$wp_customize->add_setting(
		'banner_label_two',
		array(
			'default'           => esc_html__( 'Contact Us', 'pliska' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'banner_label_two',
		array(
			'label'       => esc_html__( 'Banner Text 2', 'pliska' ),
			'section'     => 'call_to_action',
			'description' => esc_html__( 'Change the default text of the button.', 'pliska' ),
			'type'        => 'text',
		)
	);
	// Banner Link
	$wp_customize->add_setting(
		'banner_link_two',
		array(
			'default'           => '#',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'banner_link_two',
		array(
			'label'       => esc_html__( 'Banner Link 2', 'pliska' ),
			'section'     => 'call_to_action',
			'description' => esc_html__( 'Add link to the button. You can link it to the About page or the Contact page or to a specific section from the Homepage.', 'pliska' ),
			'type'        => 'url',
		)
	);
	// Meta arrow
	$wp_customize->add_setting(
		'show_meta_arrow',
		array(
			'default'           => 1,
			'sanitize_callback' => 'pliska_sanitize_checkbox',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'show_meta_arrow',
		array(
			'label'       => esc_html__( 'Show Header Arrow', 'pliska' ),
			'description' => esc_html__( 'Show an arrow that links to the main content.', 'pliska' ),
			'section'     => 'header_image_options',
			'type'        => 'checkbox',
		)
	);

	// Overlay Animation
	$wp_customize->add_setting(
		'header_text_animation_enable_homepage_only',
		array(
			'default'           => 0,
			'sanitize_callback' => 'pliska_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'header_text_animation_enable_homepage_only',
		array(
			'label'       => esc_html__( 'Enable Header Text Animation on HomePage only', 'pliska' ),
			'section'     => 'header_animations',
			'description' => esc_html__( 'By default, the header text animation is displayed throughout the whole website. Check this option if you want to display the page title animation only on the homepage.', 'pliska' ),
			'type'        => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'header_text_animation',
		array(
			'default'           => 'bounce',
			'sanitize_callback' => 'pliska_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'header_text_animation',
		array(
			'label'       => esc_html__( 'Header Text Animation', 'pliska' ),
			'section'     => 'header_animations',
			'description' => esc_html__( ' Choose how to animate the page title on page load.', 'pliska' ),
			'type'        => 'select',
			'choices'     => array(
				'bounce'    => esc_html( 'Zoom in and Bounce' ),
				'slide_left_right' => esc_html( 'Slide in Left and Right' ),
				'typewrite' => esc_html( 'Typewrite' ),
				'none'      => esc_html( 'None' ),
			),
		)
	);

	// Overlay Animation
	$wp_customize->add_setting(
		'header_scroll_animation',
		array(
			'default'           => 1,
			'sanitize_callback' => 'pliska_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'header_scroll_animation',
		array(
			'label'       => esc_html__( 'Header Image Overlay Opacity Animation', 'pliska' ),
			'section'     => 'header_animations',
			'description' => esc_html__( 'Enable overlay animation on page scroll. The header image gets darker, while scrolling down the page.', 'pliska' ),
			'type'        => 'checkbox',
		)
	);
}

add_action( 'customize_register', 'pliska_customize_register_banner_and_header', 20 );

function pliska_customize_header_menu_options() {

	// get menu colors
	$top_menu_text_color = get_theme_mod( 'nav_top_menu_text_color', '#666' );
	$top_menu_bgr_color  = get_theme_mod( 'nav_top_menu_bgr_color', '#fff' );

	// static vs sticky header
	$header_menu_position = get_theme_mod( 'header-menu-position', 'sticky' );

	if ( $header_menu_position == 'static' ) { // static header ?>

	<style>
	
	.main-navigation-container {
		background-color: #fff;
		position: relative;
		z-index: 9;
	}
	
	.menu-toggle .burger,
	.menu-toggle .burger:before,
	.menu-toggle .burger:after {
		border-bottom: 2px solid #333;
	}

	@media (min-width: 40em) { 
	.site-menu a {
		color: <?php echo esc_attr( $top_menu_text_color ); // WPCS: XSS ok. ?>;
		}
	.site-menu ul ul a {
		color: #fff;
		}
	}
	</style>
	
		<?php

	} else { // sticky header
		?>
	<style>

	.main-navigation-container {
		background: transparent;
		position: fixed;
		z-index: 9;
		transition: background-color .15s ease-out;
	}

	.main-navigation-container.fixed-header {
		background-color: #fff;
	}

	.menu-toggle .burger,
	.menu-toggle .burger:before,
	.menu-toggle .burger:after {
		border-bottom: 2px solid #f7f7f7;
	}

	.fixed-header .menu-toggle .burger,
	.fixed-header .burger:before,
	.fixed-header .burger:after {
		border-bottom: 2px solid #333;
	}

	.main-navigation-container .site-title a, .main-navigation-container p.site-description {
		color: #fff;
	}
	.fixed-header .site-title a, .fixed-header p.site-description {
		color: #<?php echo esc_attr( get_header_textcolor() ); ?>;
	}
	.no-header-image .site-title a, .no-header-image p.site-description {
		color: #<?php echo esc_attr( get_header_textcolor() ); ?>;
	}

	.fixed-header {
		top: 0;
	}

	@media (min-width: 40em) {
		.fixed-header {
			top: auto;
		}
		.site-menu a {
			color: #fff;
		}
	}
	</style> 
	<script>
	</script>
		<?php
	}
}

add_action( 'wp_head', 'pliska_customize_header_menu_options' );

// Customize header animations

function pliska_customize_header_animations() {

	$animation                     = get_theme_mod( 'header_text_animation', 'bounce' );
	$is_display_animation_homepage = get_theme_mod( 'header_text_animation_enable_homepage_only', 0 );
	// five letters per second typewrite animation
	$typewrite_duration            = pliska_get_page_title_length() / 5;
	$cursor_duration               = ceil( pliska_get_page_title_length() /4 );
	$typewrite_letters_number      = pliska_get_page_title_length();
	$secondary_accent_color        = get_theme_mod( 'secondary_accent_color', '#fbc02d' );
	if ( $animation == 'none' ) {
		return;
	}

	if ( $is_display_animation_homepage ) {
		if (!is_front_page() && !( is_front_page() && is_home() ) ) return;
	}

	if ( $animation == 'slide_left_right' ) {
		?>
		<style>
		#header-page-title .entry-title {
			animation-name: moveInleft;
			animation-duration: 3s;
		}

		#header-page-title .description {
			animation-name: moveInRight;
			animation-duration: 3s;
		}
		</style>

		<?php

	} elseif ( $animation == 'bounce' ) {
		?>
		<style>
		#header-page-title h1 span {
			display: inline-block;
			animation: bounce 1s ease-in-out;
		}
		#header-page-title-inside {
			animation: 1s pliska_zoom_in_header ease-in-out forwards 0s;
			z-index: 10;
			opacity: 0;
			position: relative;
		}
		</style>

		<?php
	} elseif ( $animation == 'typewrite' ) {
		if(is_search( )) return;
		?>
		<style>
			@media only screen and (min-width:40em){
				#header-page-title h1 {
					font-family: monospace;
					display: inline-block;
					overflow: hidden;
					letter-spacing: 2px;
					animation: typing <?php echo esc_attr( $typewrite_duration ); ?>s steps(<?php echo esc_attr( $typewrite_letters_number ); ?>, end), blink .8s step-end <?php echo esc_attr( $cursor_duration ); ?> forwards;
					white-space: nowrap;
					font-weight: 700;
					box-sizing: border-box;
					<?php if( is_rtl() ) : ?>
						border-left: 4px solid <?php echo esc_attr( $secondary_accent_color ); ?>;
					<?php else : ?>
						border-right: 4px solid <?php echo esc_attr( $secondary_accent_color ); ?>;
					<?php endif; ?>
				}
			}
			@keyframes typing {
				from { 
					width: 0% 
				}
				to { 
					width: 100%
				}
			}
			@keyframes blink {
				from, to { 
					border-color: transparent 
				}
				50% { 
					border-color: <?php echo esc_attr( $secondary_accent_color ); ?>; 
				}
			}
		</style>

		<?php
	}

}

add_action( 'wp_head', 'pliska_customize_header_animations' );
