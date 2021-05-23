<?php

/**
 * Class Shop_Page_WP_Image_Sizes
 */
class Shop_Page_WP_Image_Sizes {

	public static function create_image_sizes() {
		add_action( 'after_setup_theme', array( 'Shop_Page_WP_Image_Sizes', 'shop_page_wp_custom_image_size' ) );
	}

	public static function shop_page_wp_custom_image_size() {

		$image_width      = get_option( 'shop-page-wp-image-width' );
		$image_height     = get_option( 'shop-page-wp-image-height' );
		$image_crop_array = get_option( 'shop-page-wp-image-crop' );
		$image_crop       = $image_crop_array['crop_options'];

		if ( ! $image_width ) {
			$image_width = 300;
		}
		if ( ! $image_height ) {
			$image_height = 300;
		}
		if ( $image_crop == 'no-crop' ) {
			$crop_var = false;
		} else {
			$crop_var = true;
		}

		add_image_size( 'shop-page-wp-product', $image_width, $image_height, $crop_var );
	}

}
