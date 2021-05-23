<?php

/**
 * Class Shop_Page_WP_Admin
 */
class Shop_Page_WP_Admin {

	public static function activate_admin() {
		add_action( 'admin_menu', array( 'Shop_Page_WP_Admin', 'activate_submenu_page' ) );
	}

	public static function activate_submenu_page() {

		add_submenu_page(
			'edit.php?post_type=shop-page-wp', // string $parent_slug
			'Settings', // string $page_title,
			'Settings', // string $menu_title,
			'manage_options', // string $capability
			'shop-page-wp-settings', // string $menu_slug
			array( 'Shop_Page_WP_Admin', 'output_admin_page' )
		);
	}

	static function output_admin_page() { ?>
		<div class="wrap">
			<style>
				.shop-page-wp-settings input, .shop-page-wp-settings select {
					min-width: 210px;
				}

				.shop-page-wp-settings input[type="radio"] {
					min-width: auto;
				}

				.shop-page-wp-settings label.radio-label {
					margin-right: 15px;
				}

				.shop-page-wp-settings .form-table th {
					min-width: 230px;
				}

				.shop-page-wp-settings h2 {
					margin-top: 25px;
					margin-bottom: 0;
					font-size: 1.7em;
				}

				.shop-page-wp-settings .explanation {
					color: #777;
					font-size: 1.1em;
					margin-top: 15px;
				}
			</style>
			<h1><?php _e( Shop_Page_WP_Name . ' Settings', 'shop-page-wp' ); ?></h1>
			<form class="shop-page-wp-settings" method="post" action="options.php">
				<?php
				settings_fields( 'shop-page-wp-options' );

				/**
				 * Check if image size settings have changed and output warning dialogue
				 * if they have.
				 */
				if ( isset( $_GET['settings-updated'] ) ) {
					$image_width_changed  = get_option( 'shop-page-wp-iw-field-change' );
					$image_height_changed = get_option( 'shop-page-wp-ih-field-change' );
					$image_crop_changed   = get_option( 'shop-page-wp-ic-field-change' );
					if ( ( 'has-changed' == $image_width_changed ) || ( 'has-changed' == $image_height_changed ) || ( 'has-changed' == $image_crop_changed ) ) {
						do_settings_sections( 'shop-page-wp-section-regen' );
					}
				}

				do_settings_sections( 'shop-page-wp-section' );

				do_settings_sections( 'shop-page-wp-section-image' );

				submit_button();
				?>
			</form>
		</div>
	<?php }
}