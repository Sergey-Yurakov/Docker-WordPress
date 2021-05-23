<?php
/**
 * Theme functions and definitions
 *
 * @package Foodup
 */
if ( ! function_exists( 'foodup_enqueue_styles' ) ) :
	/**
	 * @since 0.1
	 */
	function foodup_enqueue_styles() {
		wp_enqueue_style( 'newsup-style-parent', get_template_directory_uri() . '/style.css' );
		wp_enqueue_style( 'foodup-style', get_stylesheet_directory_uri() . '/style.css', array( 'newsup-style-parent' ), '1.0' );
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css');
		wp_dequeue_style( 'newsup-default',get_template_directory_uri() .'/css/colors/default.css');
		wp_enqueue_style( 'foodup-default-css', get_stylesheet_directory_uri()."/css/colors/default.css" );
		if(is_rtl()){
		wp_enqueue_style( 'newsup_style_rtl', trailingslashit( get_template_directory_uri() ) . 'style-rtl.css' );
	    }
		
	}

endif;
add_action( 'wp_enqueue_scripts', 'foodup_enqueue_styles', 9999 );

function foodup_theme_setup() {

//Load text domain for translation-ready
load_theme_textdomain('foodup', get_stylesheet_directory() . '/languages');

require( get_stylesheet_directory() . '/hooks/hooks.php' );
require( get_stylesheet_directory() . '/customizer-default.php' );
require( get_stylesheet_directory() . '/frontpage-options.php' );
require( get_stylesheet_directory() . '/hooks/hook-header-section.php' );


// custom header Support
			$args = array(
			'default-image'		=>  get_stylesheet_directory_uri() .'/images/head-back.jpg',
			'width'			=> '1600',
			'height'		=> '600',
			'flex-height'		=> false,
			'flex-width'		=> false,
			'header-text'		=> true,
			'default-text-color'	=> 'fff'
		);
		add_theme_support( 'custom-header', $args );
} 
add_action( 'after_setup_theme', 'foodup_theme_setup' );

add_action( 'customize_register', 'foodup_customizer_rid_values', 1000 );
function foodup_customizer_rid_values($wp_customize) {

  $wp_customize->remove_control('tabbed_section_title');

  $wp_customize->remove_control('latest_tab_title');

  $wp_customize->remove_control('popular_tab_title');

  $wp_customize->remove_control('trending_tab_title');

  $wp_customize->remove_control('select_trending_tab_news_category');
}


/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function foodup_customize_selective_register($wp_customize) {


	$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	if (isset($wp_customize->selective_refresh)) {


		$wp_customize->selective_refresh->add_partial('featured_post_one_btn_txt', array(
				'selector'        => '.featured-post-one a',
				'render_callback' => '.foodup_customize_partial_featured_post_one_btn_txt',
		));

		$wp_customize->selective_refresh->add_partial('featured_post_two_btn_txt', array(
				'selector'        => '.featured-post-two a',
				'render_callback' => '.foodup_customize_partial_featured_post_two_btn_txt',
		));

		$wp_customize->selective_refresh->add_partial('featured_post_three_btn_txt', array(
				'selector'        => '.featured-post-three a',
				'render_callback' => '.foodup_customize_partial_featured_post_three_btn_txt',
		));
	

	}
}

add_action('customize_register', 'foodup_customize_selective_register');