<?php

/**
 * Sample implementation of the Custom Header feature
 *
 * @link       https://developer.wordpress.org/themes/functionality/custom-headers/
 * @package Pliska
 *
 * @copyright  Copyright (c) 2020, Nasio Themes
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses pliska_header_style()
 */

register_default_headers(
	array(
		'default-image' => array(
			'url'           => get_template_directory_uri() . '/assets/img/mountain-lake.jpg',
			'thumbnail_url' => get_template_directory_uri() . '/assets/img/mountain-lake.jpg',
			'description'   => __( 'Default Header Image', 'pliska' ),
		),
	)
);

/* Create the header image object */
function pliska_custom_header_setup() {
	add_theme_support(
		'custom-header',
		apply_filters(
			'pliska_custom_header_args',
			array(
				'default-text-color' => '333',
				'default-image'      => get_template_directory_uri() . '/assets/img/mountain-lake.jpg',
				'flex-width'         => true,
				'flex-height'        => true,
				'width'              => 2200,
				'wp-head-callback'   => 'pliska_header_image_css',
			)
		)
	);
}
add_action( 'after_setup_theme', 'pliska_custom_header_setup' );

/**
 * 
 * Apply the styles for the header image. This is where the magic happens.
 * Get the settings from the theme customizer. Construct the header image url (featured post or global site header)
 * Subtract admin bar height. Subtract menu height from img height when static header is selected
 * 
 */
function pliska_header_image_css() {

	$header_text_color = get_header_textcolor(); ?>
	
	<style type="text/css">
	.site-title a, .site-description {
		color: #<?php echo esc_attr( $header_text_color ); ?>;
	}
	</style>

	<?php if ( !pliska_has_header_image() ) return;
	
	/* Create the header image object */
	$height                               = get_theme_mod( 'header_image_height', '100vh' );
	$repeat                               = get_theme_mod( 'header_background_repeat', 'no-repeat' );
	$size                                 = get_theme_mod( 'header_background_size', 'cover' );
	$position                             = get_theme_mod( 'header_background_position', 'center' );
	$overlay                              = get_theme_mod( 'cover_template_overlay_opacity', '1' );
	$attachment                           = get_theme_mod( 'header_background_attachment', 1 ) ? 'fixed' : 'scroll';
	$gradient_first_color                 = get_theme_mod( 'pliska_gradient_color_one', '#1997d2' );
	$gradient_second_color                = get_theme_mod( 'pliska_gradient_color_two', '#000' );
	$gradient_density                     = get_theme_mod( 'header_gradient_density', '4' );
	$gradient_direction                   = get_theme_mod( 'gradient_direction', 'left' );
	$show_header_image_on_posts_and_pages = get_theme_mod( 'show-header-image-homepage', 1 );

	// by default show header image as a fallback image when there is no featured image displayed
	$header_img_url = has_post_thumbnail( get_the_ID() ) ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : get_header_image();

	// Do not show the header image as a fallback image if there is no setting in the theme customizer
	if ( ! $show_header_image_on_posts_and_pages ) {
		$header_img_url = get_the_post_thumbnail_url( get_the_ID() );
	}

	// Conditionals to display header images on homepage and archive pages
	if ( is_front_page() || is_home()) {
		$header_img_url = get_header_image();
	}

	if ( is_archive() || is_search() || is_author()) {
		$header_img_url = get_header_image();
	}
	if ( class_exists( 'WooCommerce' ) ) {
		if ( is_product_category() ) {
			$header_img_url = get_header_image();
		}
		if ( is_shop() ) {
			$header_img_url = get_header_image();
		}
	}
	?>
	
<style>
	.header-image-wrapper {
		height: <?php echo is_user_logged_in() && ! is_customize_preview() ? 'calc(100vh - 32px)' : '100vh'; ?>;
		background-image: url(<?php echo esc_attr( $header_img_url ); ?>);
		background-repeat: <?php echo esc_attr( $repeat ); ?>;
		background-size: <?php echo esc_attr( $size ); ?>;
		background-position: <?php echo esc_attr( $position ); ?>;
		position: relative;
		padding-bottom: 2em;
	}
	
	<?php if ( $gradient_density ) : ?>
		.header-image-wrapper::before {
			background: linear-gradient(to <?php echo esc_attr( $gradient_direction ); ?>, <?php echo esc_attr( pliska_hex_to_rgba( $gradient_first_color, $gradient_density / 10 ) ); ?>, <?php echo esc_attr( pliska_hex_to_rgba( $gradient_second_color, $gradient_density / 10 ) ); ?>);
			width: 100%;
			height: 100%;
			top: 0px;
			left: 0px;
			position: absolute;
			display: inline-block;
			content: "";
		} 
	<?php endif;

	if ( $overlay && pliska_is_overlay() ) :
	?>
	.img-overlay {
		background-color: rgba(0, 0, 0, .<?php echo esc_attr( $overlay ); ?>);
	} 
	<?php endif; ?>

	@media (max-width: 40em) {
		.admin-bar .header-image-wrapper {
			height: calc(100vh - 96px);
		}
		.header-image-wrapper {
			height: calc(100vh - 48px);
		}
	}
	
	@media (min-width: 40em){
		.header-image-wrapper {
			background-attachment: <?php echo esc_attr( $attachment ); ?>;
		}
	}

	<?php if ( $height !== '100vh' ) : //allow dynamic header image height from theme customizer ?>
	@media (min-width: 100em) {
		.admin-bar .header-image-wrapper, .header-image-wrapper {
			height: <?php echo esc_attr( $height ); ?>;
		}
	}
	<?php if (is_customize_preview( ) ): ?>
		@media (min-width: 80em) {
		.admin-bar .header-image-wrapper, .header-image-wrapper {
			height: <?php echo esc_attr( $height ); ?>;
		}
	}
	<?php endif;
	endif; ?>

</style>
<script>
	//static header fix
	window.addEventListener('DOMContentLoaded', function(){
		if(document.body.className.indexOf('static-header') > -1) {
			var adminBar = document.getElementById('wpadminbar').offsetHeight || 0;
			var menuHeight = document.getElementById("main-navigation").parentElement.offsetHeight + adminBar;
			var headerImgWrapper = document.getElementsByClassName('header-image-wrapper')[0];
			var headerImgHeight = '<?php echo esc_attr($height);?>';
			var dynamicImgHeight = 'calc(' + headerImgHeight + ' - ' + menuHeight + 'px)';
			headerImgWrapper.style.height = dynamicImgHeight;
		}
	})
</script>

 <?php
}