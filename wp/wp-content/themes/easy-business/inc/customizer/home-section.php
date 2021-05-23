<?php
/**
 * Home Page Options.
 *
 * @package Easy Business
 */

$default = easy_business_get_default_theme_options();

// Add Panel.
$wp_customize->add_panel( 'home_page_panel',
	array(
	'title'      => __( 'Front Page Sections', 'easy-business' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	)
);

/**
* Section Customizer Options.
*/
require get_template_directory() . '/inc/customizer/home-sections/featured-slider.php';
require get_template_directory() . '/inc/customizer/home-sections/our-services.php';
require get_template_directory() . '/inc/customizer/home-sections/call-to-action.php';
require get_template_directory() . '/inc/customizer/home-sections/our-gallery.php';
require get_template_directory() . '/inc/customizer/home-sections/our-testimonial.php';
require get_template_directory() . '/inc/customizer/home-sections/blog.php';

