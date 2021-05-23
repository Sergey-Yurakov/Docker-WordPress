<?php

function pliska_has_header_image() {

	if ( ! has_header_image() ) {
		if ( ! has_post_thumbnail() || is_home() ) {
			return false;
		}
		if ( class_exists( 'Woocommerce' ) ) {
			if ( is_shop() || is_product_category() || is_product_tag() ) {
				return false;
			}
		}
	}

	if ( is_archive() || is_search() || is_author() ) {
		if ( get_theme_mod( 'show-header-image-post-archives', 1 ) ) {
			return true;
		} else {
			return false;
		}
	}

	if ( class_exists( 'Woocommerce' ) ) {
		if ( ! get_theme_mod( 'show-product-image-as-header-image', 1 ) && is_product() ) {
			return false;
		} elseif ( get_theme_mod( 'show-product-image-as-header-image', 1 ) && is_product() ) {
			return true;
		}
	}

	if ( is_front_page() || ( has_header_image() && is_home() ) || ( has_header_image() && get_theme_mod( 'show-header-image-homepage', 1 && get_theme_mod( 'show-header-image-post-archives', 1 ) ) ) ) {
		return true;
	}

	if ( ! has_post_thumbnail() && ! get_theme_mod( 'show-header-image-homepage', 1 ) ) {
		return false;
	}

	return true;
}

function pliska_is_fixed_header() {
	return get_theme_mod( 'header-menu-position', 'fixed' ) == 'fixed';
}

function pliska_is_sticky_header() {
	return get_theme_mod( 'header-menu-position', 'sticky' ) == 'sticky';
}

function pliska_is_paralax() {
	return 1 == get_theme_mod( 'header_background_attachment', 1 );
}

function pliska_is_overlay() {
	return get_theme_mod( 'cover_template_overlay_opacity', 1 );
}

/* Check to show or hide breadcrumbs */
function pliska_show_breadcrumbs() {
	return is_single() ? get_theme_mod( 'show_breadcrumbs', 1 ) : get_theme_mod( 'show_page_breadcrumbs', 1 );
}

function pliska_default_mode() {
	return get_theme_mod( 'default_dark_mode', 0 ) ? 'dark' : 'light';
}

// hex to rgba converter

/**
 * Convert given hex values to rgb or rgba values. Useful to convert values stored in the theme customizer.
 *
 * @param string $hex Get the hex value from the customizer api.
 * @param int    $alpha Add Opacity
 * @link https://stackoverflow.com/questions/15202079/convert-hex-color-to-rgb-values-in-php
 * @since 0.0.1
 */

function pliska_hex_to_rgba( $hex, $alpha = false ) {
	$hex      = str_replace( '#', '', $hex );
	$length   = strlen( $hex );
	$rgb['r'] = hexdec( $length == 6 ? substr( $hex, 0, 2 ) : ( $length == 3 ? str_repeat( substr( $hex, 0, 1 ), 2 ) : 0 ) );
	$rgb['g'] = hexdec( $length == 6 ? substr( $hex, 2, 2 ) : ( $length == 3 ? str_repeat( substr( $hex, 1, 1 ), 2 ) : 0 ) );
	$rgb['b'] = hexdec( $length == 6 ? substr( $hex, 4, 2 ) : ( $length == 3 ? str_repeat( substr( $hex, 2, 1 ), 2 ) : 0 ) );
	if ( $alpha ) {
		$rgb['a'] = $alpha;
	}
	return implode( array_keys( $rgb ) ) . '(' . implode( ', ', $rgb ) . ')';
}

 /**
  * Get lighter/darker color when given a hex value.
  *
  * @param string $hex Get the hex value from the customizer api.
  * @param int    $steps Steps should be between -255 and 255. Negative = darker, positive = lighter.
  * @link https://wordpress.org/themes/scaffold
  * @license GPL-2.0-or-later
  * @since 0.0.1
  */

function pliska_brightness( $hex, $steps ) {

	$steps = max( -255, min( 255, $steps ) );

	// Normalize into a six character long hex string.
	$hex = str_replace( '#', '', $hex );
	if ( strlen( $hex ) === 3 ) {
		$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
	}

	// Split into three parts: R, G and B.
	$color_parts = str_split( $hex, 2 );
	$return      = '#';

	foreach ( $color_parts as $color ) {
		$color   = hexdec( $color ); // Convert to decimal.
		$color   = max( 0, min( 255, $color + $steps ) ); // Adjust color.
		$return .= str_pad( dechex( $color ), 2, '0', STR_PAD_LEFT ); // Make two char hex code.
	}

	return sanitize_hex_color( $return );
}

/**
 * Load async changes to theme customizer by preloading removed DOM elements with class hide
 *
 * This function adds class hide to an element that is removed from DOM by default but is kept in the Customizer theme preview
 *
 * This allow for much smoother user experience and async page load instead of reloading the page
 *
 * @since 0.0.0
 */
function pliska_add_customizer_class( $class ) {
	return esc_attr( ! $class && is_customize_preview() ? ' hide' : '' );
}

/**
 * Determine if post content should be full-width layout
 */

function pliska_is_page_fullwidth() {
	return get_theme_mod( 'page_layout', 'two' ) == 'two' && 'page' == get_post_type() ? true : false;
}

function pliska_is_post_fullwidth() {
	return get_theme_mod( 'post_layout', 'one' ) == 'two' && 'post' == get_post_type() && ! pliska_is_blog() ? true : false;
}

function pliska_is_post_archives_fullwidth() {
	return get_theme_mod( 'post_archives_layout', 'one' ) == 'two' && pliska_is_blog() ? true : false;
}

function pliska_is_shop_fullwidth_layout() {
	if ( ! class_exists( 'Woocommerce' ) ) {
		return;
	}
	return get_theme_mod( 'shop_page_layout', 'one' ) == 'two' && is_shop() ? true : false;
}

function pliska_is_single_product_fullwidth_layout() {
	if ( ! class_exists( 'Woocommerce' ) ) {
		return;
	}
	return get_theme_mod( 'single_product_page_layout', 'one' ) == 'two' && is_product() ? true : false;
}
