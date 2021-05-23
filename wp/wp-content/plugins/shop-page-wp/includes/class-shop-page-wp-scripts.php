<?php

/**
 * Class Shop_Page_WP_Scripts
 */
class Shop_Page_WP_Scripts
{
    public static function hook_grid_styles()
    {

        add_action('wp_enqueue_scripts', array('Shop_Page_WP_Scripts', 'enqueue_grid_styles'));
    }

    public static function enqueue_grid_styles()
    {
        $plugin_dir = plugin_dir_url(__FILE__);
        wp_register_style(
            'shop-page-wp-grid',
            $plugin_dir . '../assets/css/shop-page-wp-grid.css',
            '',
            Shop_Page_WP_Version
        );
        wp_enqueue_style('shop-page-wp-grid');
    }

    public static function hook_base_styles()
    {

        add_action('wp_enqueue_scripts', array('Shop_Page_WP_Scripts', 'enqueue_base_styles'));
    }

    public static function enqueue_base_styles()
    {
        $plugin_dir = plugin_dir_url(__FILE__);
        wp_register_style(
            'shop-page-wp-base-styles',
            $plugin_dir . '../assets/css/shop-page-wp-base-styles.css',
            '',
            Shop_Page_WP_Version
        );
        wp_enqueue_style('shop-page-wp-base-styles');
    }

    public static function hook_admin_styles()
    {

        add_action('admin_enqueue_scripts', array('Shop_Page_WP_Scripts', 'enqueue_admin_styles'));
    }

    public static function enqueue_admin_styles()
    {
        $plugin_dir = plugin_dir_url(__FILE__);
        wp_register_style(
            'shop-page-wp-admin-styles',
            $plugin_dir . '../assets/css/shop-page-wp-admin-styles.css',
            '',
            Shop_Page_WP_Version
        );
        wp_register_script(
            'shop-page-wp-admin-scripts',
            $plugin_dir . '../assets/js/shop-page-wp-admin.js',
            array('jquery'),
            Shop_Page_WP_Version,
            true
        );
        wp_enqueue_style('shop-page-wp-admin-styles');
        wp_enqueue_script('shop-page-wp-admin-scripts');
    }

}
