<?php
/**
 * Default theme options.
 *
 * @package Easy Business
 */

if ( ! function_exists( 'easy_business_get_default_theme_options' ) ) :

	/**
	 * Get default theme options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Default theme options.
	 */
function easy_business_get_default_theme_options() {

	$defaults = array();

    // Homepage Options
	$defaults['enable_frontpage_content'] 		= false;

	// Featured Slider Section	
	$defaults['enable_featured_slider_section']		= false;
	$defaults['number_of_featured_slider_items']	= 3;
	$defaults['featured_slider_content_type']		= 'featured_slider_page';

	// Our Services Section	
	$defaults['enable_our_services_section']		= false;
	$defaults['our_services_section_title']			= esc_html__( 'What We Do', 'easy-business' );
	$defaults['number_of_our_services_items']		= 3;
	$defaults['our_services_content_type']			= 'our_services_page';

	// Call to action Section	
	$defaults['enable_call_to_action_section']	   	= false;
	$defaults['background_call_to_action_section']	= esc_url(get_template_directory_uri()) .'/assets/images/default-header.jpg';
	$defaults['call_to_action_title']	   	 		= esc_html__( 'We Provide Marketing Services', 'easy-business' );
	$defaults['call_to_action_button_label']	   	= esc_html__( 'Contact Us', 'easy-business' );
	$defaults['call_to_action_button_url']	   	 	= '#';

	// Our Gallery Section	
	$defaults['enable_our_gallery_section']			= false;
	$defaults['our_gallery_section_title']			= esc_html__( 'Creative Works', 'easy-business' );
	$defaults['number_of_our_gallery_items']		= 6;
	$defaults['our_gallery_content_type']			= 'our_gallery_page';

	// Our Testimonial Section	
	$defaults['enable_our_testimonial_section']		= false;
	$defaults['our_testimonial_section_title']		= esc_html__( 'What Our Clients Say', 'easy-business' );
	$defaults['background_our_testimonial_section']	= get_template_directory_uri() .'/assets/images/default-header.jpg';
	$defaults['number_of_our_testimonial_items']	= 2;
	$defaults['our_testimonial_content_type']		= 'our_testimonial_page';

	// Latest Posts Section
	$defaults['enable_blog_section']		= false;
	$defaults['blog_section_title']			= esc_html__( 'Latest Posts', 'easy-business' );
	$defaults['blog_category']	   			= 0; 
	$defaults['blog_number']				= 3;

	//General Section
	$defaults['readmore_text']					= esc_html__('Read More','easy-business');
	$defaults['your_latest_posts_title']		= esc_html__('Blog','easy-business');
	$defaults['excerpt_length']					= 15;
	$defaults['layout_options_blog']			= 'no-sidebar';
	$defaults['layout_options_archive']			= 'no-sidebar';
	$defaults['layout_options_page']			= 'no-sidebar';	
	$defaults['layout_options_single']			= 'right-sidebar';	

	//Footer section 		
	$defaults['copyright_text']					= esc_html__( 'Copyright &copy; All rights reserved.', 'easy-business' );

	// Pass through filter.
	$defaults = apply_filters( 'easy_business_filter_default_theme_options', $defaults );
	return $defaults;
}

endif;

/**
*  Get theme options
*/
if ( ! function_exists( 'easy_business_get_option' ) ) :

	/**
	 * Get theme option
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Option key.
	 * @return mixed Option value.
	 */
	function easy_business_get_option( $key ) {

		$default_options = easy_business_get_default_theme_options();
		if ( empty( $key ) ) {
			return;
		}

		$theme_options = (array)get_theme_mod( 'theme_options' );
		$theme_options = wp_parse_args( $theme_options, $default_options );

		$value = null;

		if ( isset( $theme_options[ $key ] ) ) {
			$value = $theme_options[ $key ];
		}

		return $value;

	}

endif;