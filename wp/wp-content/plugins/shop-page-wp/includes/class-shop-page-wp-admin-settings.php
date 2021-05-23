<?php

/**
 * Class Shop_Page_WP_Admin_Settings
 */
class Shop_Page_WP_Admin_Settings {

	public static function output_settings() {

		add_action( 'admin_init', array( 'Shop_Page_WP_Admin_Settings', 'display_options' ) );
	}

	public static function display_options() {

		add_settings_section(
			'shop-page-wp-options', // settings field handle
			'', // title
			array( 'Shop_Page_WP_Admin_Settings', 'Shop_Page_WP_regen_warning' ), // callback
			'shop-page-wp-section-regen' ); // section handle

		add_settings_section(
			'shop-page-wp-options', // settings field handle
			'', // title
			array( 'Shop_Page_WP_Admin_Settings', 'Shop_Page_WP_default_text' ), // callback
			'shop-page-wp-section' ); // section handle

		add_settings_section(
			'shop-page-wp-options', // settings field handle
			'', // title
			array( 'Shop_Page_WP_Admin_Settings', 'Shop_Page_WP_image_text' ), // callback
			'shop-page-wp-section-image' ); // section handle

		add_settings_field(
			'shop-page-wp-button-text', // field ID
			esc_html__( 'Button Text (max 14 characters)', 'shop-page-wp' ), // field Title
			array( 'Shop_Page_WP_Admin_Settings', 'shop_button_text_form' ), // callback
			'shop-page-wp-section', // section handle
			'shop-page-wp-options' // settings handle
		);

		add_settings_field(
			'shop-page-wp-show-choose-styles', // field ID
			esc_html__( 'Choose Default Styles', 'shop-page-wp' ), // field Title
			array( 'Shop_Page_WP_Admin_Settings', 'default_styles_form' ), // callback
			'shop-page-wp-section', // setting section handle
			'shop-page-wp-options' // settings handle
		);

		add_settings_field(
			'shop-page-wp-show-default-columns', // field ID
			esc_html__( 'Default Number of Columns', 'shop-page-wp' ), // field Title
			array( 'Shop_Page_WP_Admin_Settings', 'column_select_form' ), // callback
			'shop-page-wp-section', // setting section handle
			'shop-page-wp-options' // settings handle
		);

		add_settings_field(
			'shop-page-wp-link-target', // field ID
			esc_html__( 'Open Link in New Tab?', 'shop-page-wp' ), // field Title
			array( 'Shop_Page_WP_Admin_Settings', 'target_radio_form' ), // callback
			'shop-page-wp-section', // setting section handle
			'shop-page-wp-options' // settings handle
		);

		add_settings_field(
			'shop-page-wp-image-width', // field ID
			esc_html__( 'Image Width', 'shop-page-wp' ), // field Title
			array( 'Shop_Page_WP_Admin_Settings', 'image_width_form' ), // callback
			'shop-page-wp-section-image', // section handle
			'shop-page-wp-options' // settings handle
		);

		add_settings_field(
			'shop-page-wp-image-height', // field ID
			esc_html__( 'Image Height', 'shop-page-wp' ), // field Title
			array( 'Shop_Page_WP_Admin_Settings', 'image_height_form' ), // callback
			'shop-page-wp-section-image', // section handle
			'shop-page-wp-options' // settings handle
		);

		add_settings_field(
			'shop-page-wp-image-crop', // field ID
			esc_html__( 'Image Crop', 'shop-page-wp' ), // field Title
			array( 'Shop_Page_WP_Admin_Settings', 'image_crop_form' ), // callback
			'shop-page-wp-section-image', // section handle
			'shop-page-wp-options' // settings handle
		);

		register_setting( 'shop-page-wp-options', 'shop-page-wp-button-text' );
		register_setting( 'shop-page-wp-options', 'shop-page-wp-show-choose-styles' );
		register_setting( 'shop-page-wp-options', 'shop-page-wp-show-default-columns' );
		register_setting( 'shop-page-wp-options', 'shop-page-wp-link-target' );

		register_setting( 'shop-page-wp-options', 'shop-page-wp-image-width', array(
			'Shop_Page_WP_Admin_Settings',
			'shop_page_wp_iw_validate'
		) );
		register_setting( 'shop-page-wp-options', 'shop-page-wp-image-height', array(
			'Shop_Page_WP_Admin_Settings',
			'shop_page_wp_ih_validate'
		) );
		register_setting( 'shop-page-wp-options', 'shop-page-wp-image-crop', array(
			'Shop_Page_WP_Admin_Settings',
			'shop_page_wp_ic_validate'
		) );
	}

	public static function Shop_Page_WP_regen_warning() { ?>
		<div class="notice notice-warning is-dismissible">
			<p><?php esc_html_e( 'You must', 'shop-page-wp' ); ?> <a
					href="https://wordpress.org/plugins/regenerate-thumbnails/"
					target="_blank"><?php esc_html_e( 'regenerate thumbnails', 'shop-page-wp' ); ?></a> <?php esc_html_e( 'for the updated image size to take effect.', 'shop-page-wp' ); ?>
			</p>
		</div>
	<?php }

	public static function Shop_Page_WP_default_text() { ?>
		<h2><?php esc_html_e( 'Default Settings', 'shop-page-wp' ); ?></h2>
	<?php }

	public static function Shop_Page_WP_image_text() { ?>
		<h2><?php esc_html_e( 'Custom Image Size Settings (Optional)', 'shop-page-wp' ); ?></h2>
		<div
			class="explanation"><?php esc_html_e( 'Set max image width and height in pixels (Default is 300px x 300px with crop)', 'shop-page-wp' ); ?>
			<br/><?php esc_html_e( 'After changing image size you must', 'shop-page-wp' ); ?> <a
				href="https://wordpress.org/plugins/regenerate-thumbnails/"
				target="_blank"><?php esc_html_e( 'regenerate thumbnails', 'shop-page-wp' ); ?></a>.
		</div>
	<?php }

	public static function shop_button_text_form() { ?>
		<input type="text" name="shop-page-wp-button-text" maxlength="14"
		       id="shop-page-wp-button-text"
		       value="<?php echo get_option( 'shop-page-wp-button-text' ); ?>"/>
	<?php }

	public static function default_styles_form() {
		$options = get_option( 'shop-page-wp-show-choose-styles' );
		?>
		<select id='style_options' name='shop-page-wp-show-choose-styles[style_options]'>
			<option
				value="default" <?php selected( $options['style_options'], 'default' ); ?>><?php esc_html_e( 'Default Styles' ); ?>
			</option>
			<option
				value="grid-only" <?php selected( $options['style_options'], 'grid-only' ); ?>><?php esc_html_e( 'Grid Spacing Only', 'shop-page-wp' ); ?>
			</option>
			<option
				value="no-styles" <?php selected( $options['style_options'], 'no-styles' ); ?>><?php esc_html_e( 'No Styles', 'shop-page-wp' ); ?>
			</option>
			</option>
		</select>
		<?php
	}

	public static function column_select_form() {
		$options = get_option( 'shop-page-wp-show-default-columns' );
		if ( ! $options ) {
			$options['column_options'] = 3;
		}
		?>
		<select id='column_options' name='shop-page-wp-show-default-columns[column_options]'>
			<option
				value="1" <?php selected( $options['column_options'], '1' ); ?>><?php esc_html_e( '1 Column', 'shop-page-wp' ); ?>
			</option>
			<option
				value="2" <?php selected( $options['column_options'], '2' ); ?>><?php esc_html_e( '2 Column', 'shop-page-wp' ); ?>
			</option>
			<option
				value="3" <?php selected( $options['column_options'], '3' ); ?>><?php esc_html_e( '3 Column', 'shop-page-wp' ); ?>
			</option>
			<option
				value="4" <?php selected( $options['column_options'], '4' ); ?>><?php esc_html_e( '4 Column', 'shop-page-wp' ); ?>
			</option>
		</select>
		<?php
	}


	public static function target_radio_form() {
		$link = get_option( 'shop-page-wp-link-target' );
		//update_option('shop-page-wp-link-target', false);
		if ( ! $link ) {
			update_option('shop-page-wp-link-target', 1);
		}
		//var_dump($link);
		?>
		<input type="radio" value="1" name="shop-page-wp-link-target" <?php checked(1, get_option('shop-page-wp-link-target', true)); ?> />
		<label class='radio-label'>YES</label>
		<input type="radio" value="2" name="shop-page-wp-link-target" <?php checked(2, get_option('shop-page-wp-link-target', true)); ?> />
		<label class='radio-label'>NO</label>

	<?php 
	}

	public static function image_width_form() { ?>
		<input type="number" name="shop-page-wp-image-width"
		       id="shop-page-wp-image-width"
		       value="<?php echo get_option( 'shop-page-wp-image-width' ); ?>"/>
	<?php }

	public static function image_height_form() { ?>
		<input type="number" name="shop-page-wp-image-height"
		       id="shop-page-wp-image-height"
		       value="<?php echo get_option( 'shop-page-wp-image-height' ); ?>"/>
	<?php }

	public static function image_crop_form() {
		$options = get_option( 'shop-page-wp-image-crop' );
		?>
		<select id='crop_options' name='shop-page-wp-image-crop[crop_options]'>
			<option
				value="crop" <?php selected( $options['crop_options'], 'crop' ); ?>><?php esc_html_e( 'Crop Image', 'shop-page-wp' ); ?>
			</option>
			<option
				value="no-crop" <?php selected( $options['crop_options'], 'no-crop' ); ?>><?php esc_html_e( 'Don\'t Crop Image', 'shop-page-wp' ); ?>
			</option>
		</select>
		<?php
	}

	public static function shop_page_wp_iw_validate( $current_input ) {
		$image_width = get_option( 'shop-page-wp-image-width' );
		update_option( 'shop-page-wp-iw-field-change', 'no-change' );
		if ( $image_width != $current_input ) {
			update_option( 'shop-page-wp-iw-field-change', 'has-changed' );
		}

		return $current_input;
	}

	public static function shop_page_wp_ih_validate( $current_input ) {
		$image_height = get_option( 'shop-page-wp-image-height' );
		update_option( 'shop-page-wp-ih-field-change', 'no-change' );
		if ( $image_height != $current_input ) {
			update_option( 'shop-page-wp-ih-field-change', 'has-changed' );
		}

		return $current_input;
	}

	public static function shop_page_wp_ic_validate( $current_input ) {
		$image_crop_array = get_option( 'shop-page-wp-image-crop' );
		$image_crop       = $image_crop_array['crop_options'];
		update_option( 'shop-page-wp-ic-field-change', 'no-change' );
		if ( $image_crop != $current_input['crop_options'] ) {
			update_option( 'shop-page-wp-ic-field-change', 'has-changed' );
		}

		return $current_input;
	}
}