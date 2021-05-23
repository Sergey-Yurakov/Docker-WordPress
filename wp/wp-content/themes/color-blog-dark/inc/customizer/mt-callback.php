<?php
/**
 * Define callback functions for active_callback.
 * 
 * @package Color Blog Dark
 * @since 1.0.0
 */

if ( ! function_exists( 'color_blog_dark_enable_top_header_active_callback' ) ) :

    /**
	 * Check if top header option is enabled.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 *
	 * @return bool Whether the control is active to the current preview.
	 */
    function color_blog_dark_enable_top_header_active_callback( $control ) {
        if ( false !== $control->manager->get_setting( 'color_blog_dark_enable_top_header' )->value() ) {
            return true;
        } else {
            return false;
        }
    }
    
endif;

if ( ! function_exists( 'color_blog_dark_enable_top_header_trending_active_callback' ) ) :

    /**
	 * Check if top header option and trending section option is enabled.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 *
	 * @return bool Whether the control is active to the current preview.
	 */
    function color_blog_dark_enable_top_header_trending_active_callback( $control ) {
        if ( false !== $control->manager->get_setting( 'color_blog_dark_enable_top_header' )->value() && false !== $control->manager->get_setting( 'color_blog_dark_enable_trending' )->value() ) {
            return true;
        } else {
            return false;
        }
    }
    
endif;

if ( ! function_exists( 'color_blog_dark_enable_top_header_live_now_active_callback' ) ) :

    /**
     * Check if top header option and trending section option is enabled.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function color_blog_dark_enable_top_header_live_now_active_callback( $control ) {
        if ( false !== $control->manager->get_setting( 'color_blog_dark_enable_top_header' )->value() && false !== $control->manager->get_setting( 'color_blog_dark_enable_live_now' )->value() ) {
            return true;
        } else {
            return false;
        }
    }
    
endif;

if ( ! function_exists( 'color_blog_dark_section_slider_option_active_callback' ) ) :

    /**
	 * Check if slider option is enabled.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 *
	 * @return bool Whether the control is active to the current preview.
	 */
    function color_blog_dark_section_slider_option_active_callback( $control ) {
        if ( false !== $control->manager->get_setting( 'color_blog_dark_section_slider_option' )->value() ) {
            return true;
        } else {
            return false;
        }
    }
    
endif;

if ( ! function_exists( 'color_blog_dark_section_top_featured_posts_option_active_callback' ) ) :

    /**
	 * Check if top featured posts option is enabled.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 *
	 * @return bool Whether the control is active to the current preview.
	 */
    function color_blog_dark_section_top_featured_posts_option_active_callback( $control ) {
        if ( false !== $control->manager->get_setting( 'color_blog_dark_section_top_featured_posts_option' )->value() ) {
            return true;
        } else {
            return false;
        }
    }
    
endif;

if ( ! function_exists( 'color_blog_dark_enable_footer_widget_area_active_callback' ) ) :

    /**
	 * Check if foooter menu option is enabled.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 *
	 * @return bool Whether the control is active to the current preview.
	 */
    function color_blog_dark_enable_footer_widget_area_active_callback( $control ) {
        if ( false !== $control->manager->get_setting( 'color_blog_dark_enable_footer_widget_area' )->value() ) {
            return true;
        } else {
            return false;
        }
    }
    
endif;

if ( ! function_exists( 'color_blog_dark_enable_footer_menu_active_callback' ) ) :

    /**
	 * Check if foooter menu option is enabled.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 *
	 * @return bool Whether the control is active to the current preview.
	 */
    function color_blog_dark_enable_footer_menu_active_callback( $control ) {
        if ( false !== $control->manager->get_setting( 'color_blog_dark_enable_footer_menu' )->value() ) {
            return true;
        } else {
            return false;
        }
    }
    
endif;


if ( ! function_exists( 'color_blog_dark_enable_pnf_latest_posts_active_callback' ) ) :

    /**
	 * Check if pnf latest posts option is enabled.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 *
	 * @return bool Whether the control is active to the current preview.
	 */
    function color_blog_dark_enable_pnf_latest_posts_active_callback( $control ) {
        if ( false !== $control->manager->get_setting( 'color_blog_dark_enable_pnf_latest_posts' )->value() ) {
            return true;
        } else {
            return false;
        }
    }
    
endif;