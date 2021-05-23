<?php
/**
 * Default theme options.
 *
 * @package Foodup
 */

if (!function_exists('foodup_get_default_theme_options')):

/**
 * Get default theme options
 *
 * @since 1.0.0
 *
 * @return array Default theme options.
 */
function foodup_get_default_theme_options() {

    $defaults = array();
    $defaults['enable_featured_section'] = 1;

    $defaults['fatured_post_image_one'] ="";
    $defaults['featured_post_one_btn_txt'] ="";
    $defaults['featured_post_one_url'] ="";
    $defaults['featured_post_one_url_new_tab']="";

    $defaults['fatured_post_image_two']="";
    $defaults['featured_post_two_btn_txt']="";
    $defaults['featured_post_two_url']="";
    $defaults['featured_post_two_url_new_tab']="";

    $defaults['fatured_post_image_three']="";
    $defaults['featured_post_three_btn_txt']="";
    $defaults['featured_post_three_url']="";
    $defaults['featured_post_three_url_new_tab']="";


    $defaults['select_trending_post_category'] = 0;
    $defaults['foodup_number_of_trending_post'] = 2;

	return $defaults;

}
endif;