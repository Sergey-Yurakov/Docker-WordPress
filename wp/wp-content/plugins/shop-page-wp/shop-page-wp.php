<?php
/*
Plugin Name: Shop Page WP
Plugin URI: https://shoppagewp.com
Description: Create a shop for affiliate products.
Author: Leon Magee, Justin McChesney-Wachs
Version: 1.2.4
Author URI: https://shoppagewp.com
Text Domain: shop-page-wp
Domain Path: /languages
 */

// Abort if file is called directly
if (!defined('WPINC')) {
    die;
}

define('Shop_Page_WP_Name', 'Shop Page WP');
define('Shop_Page_WP_Version', '1.2.4');

/**
 * Plugin Pro Options
 */
require plugin_dir_path(__FILE__) . 'includes/class-shop-page-wp-authenticate-license.php';
$validated = Shop_Page_WP_Authenticate_License::authenticate();
define('Shop_Page_WP_Advanced_Access', $validated);

/**
 * Plugin Admin Page
 */
require plugin_dir_path(__FILE__) . 'includes/class-shop-page-wp-admin.php';

Shop_Page_WP_Admin::activate_admin();

/**
 * Admin Settings
 */
require plugin_dir_path(__FILE__) . 'includes/class-shop-page-wp-admin-settings.php';

Shop_Page_WP_Admin_Settings::output_settings();

/**
 * Plugin Help / FAQ Page
 */
require plugin_dir_path(__FILE__) . 'includes/class-shop-page-wp-instructions.php';

Shop_Page_WP_Instructions::activate_admin();

/**
 * Plugin Pro Features
 */
// require plugin_dir_path(__FILE__) . 'includes/class-shop-page-wp-pro-features.php';

// Shop_Page_WP_Pro::activate_admin();

/**
 * Register Custom Meta Boxes
 */
require plugin_dir_path(__FILE__) . 'includes/class-shop-page-wp-meta-boxes.php';

Shop_Page_WP_Meta_Boxes::add_meta_boxes();

/**
 * Activate Shortcode
 */
require plugin_dir_path(__FILE__) . 'includes/class-shop-page-wp-shortcode.php';

Shop_Page_WP_Shortcode::activate_shortcode();

/**
 * Gutenberg
 */
if (function_exists('register_block_type')) {
    require plugin_dir_path(__FILE__) . 'includes/class-shop-page-wp-gutenberg.php';
    function shop_page_wp_gutenberg_init()
    {
        Shop_Page_WP_Gutenberg::gutenberg_init();
    }
    add_action('init', 'shop_page_wp_gutenberg_init');
}

/**
 * Enqueue Styles
 */
$default_styles_array = get_option('shop-page-wp-show-choose-styles');
$default_styles = $default_styles_array['style_options'];

require plugin_dir_path(__FILE__) . 'includes/class-shop-page-wp-scripts.php';

if ($default_styles) {
    if ('default' === $default_styles) {
        Shop_Page_WP_Scripts::hook_grid_styles();
        Shop_Page_WP_Scripts::hook_base_styles();
    } elseif ('grid-only' === $default_styles) {
        Shop_Page_WP_Scripts::hook_grid_styles();
    }
} else {
    Shop_Page_WP_Scripts::hook_grid_styles();
    Shop_Page_WP_Scripts::hook_base_styles();
}

// if admin?
Shop_Page_WP_Scripts::hook_admin_styles();

/**
 * Register Post Type
 */
require plugin_dir_path(__FILE__) . 'includes/class-shop-page-wp-cpt.php';

function shop_page_wp_register_post_types()
{
    Shop_Page_WP_CPT::create_post_type();
    Shop_Page_WP_CPT::add_id_column();
    Shop_Page_WP_CPT::add_id_value();
}

add_action('init', 'shop_page_wp_register_post_types');

/**
 * Set Image Sizes
 */
require plugin_dir_path(__FILE__) . 'includes/class-shop-page-wp-image-sizes.php';

Shop_Page_WP_Image_Sizes::create_image_sizes();

/**
 * Register Widget
 */
require plugin_dir_path(__FILE__) . 'includes/class-shop-page-wp-widget.php';

function register_shop_page_wp_widget()
{
    register_widget('Shop_Page_WP_Widget');
}
add_action('widgets_init', 'register_shop_page_wp_widget');

/**
 * Enable Thumbnails for CPT in theme
 */
function enable_post_thumbnails()
{
    add_theme_support('post-thumbnails', array('shop-page-wp'));
}
add_action('after_setup_theme', 'enable_post_thumbnails');
