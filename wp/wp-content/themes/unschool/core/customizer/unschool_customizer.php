<?php 
add_action( 'customize_register', 'unschool_customize_register_custom_controls', 9 );
function unschool_customize_register_custom_controls( $wp_customize ) {
    get_template_part( 'core/proupgrade/unschool','sectionpro');
}
function unschool_customize_controls_js() {
    $theme = wp_get_theme();
    wp_enqueue_script( 'unschool-customizer-section-pro-jquery', get_template_directory_uri() . '/core/proupgrade/unschool_customize-controls.js', array( 'customize-controls' ), $theme->get( 'Version' ), true );
    wp_enqueue_style( 'unschool-customizer-section-pro', get_template_directory_uri() . '/core/proupgrade/unschool_customize-controls.css', $theme->get( 'Version' ) );
}
add_action( 'customize_controls_enqueue_scripts', 'unschool_customize_controls_js' );
?>
<?php
function unschool_enqueue_comments_reply() {
if( get_option( 'thread_comments' ) ) {
wp_enqueue_script( 'comment-reply' );
}
}
add_action( 'comment_form_before', 'unschool_enqueue_comments_reply' );
?>
<?php 
if ( ! function_exists( 'unschool_sanitize_page' ) ) :
    function unschool_sanitize_page( $page_id, $setting ) {
        // Ensure $input is an absolute integer.
        $page_id = absint( $page_id );
        // If $page_id is an ID of a published page, return it; otherwise, return the default.
        return ( 'publish' === get_post_status( $page_id ) ? $page_id : $setting->default );
    }

endif;
function unschool_customize_register($wp_customize){

    // Register custom section types.
    $wp_customize->register_section_type( 'unschool_Customize_Section_Pro' );

    // Register sections.
    $wp_customize->add_section( new unschool_Customize_Section_Pro(
        $wp_customize,
        'theme_go_pro',
        array(
            'priority' => 1,
            'title'    => esc_html__( 'UnSchool', 'unschool' ),
            'pro_text' => esc_html__( 'Upgrade To Pro', 'unschool' ),
            'pro_url'  => 'https://themestulip.com/themes/education-wordpress-theme/',
        )
    ) );
    $wp_customize->add_section('unschool_header', array(
        'title'    => esc_html__('UnSchool Header Phone and Address', 'unschool'),
        'description' => '',
        'priority' => 30,
    ));
     $wp_customize->add_section('unschool_social', array(
        'title'    => esc_html__('UnSchool Social Link', 'unschool'),
        'description' => '',
        'priority' => 35,
    ));


    //  =============================
    //  = Text Input phone number                =
    //  =============================
    $wp_customize->add_setting('unschool_phone', array(
        'default'        => '',
        'sanitize_callback' => 'unschool_sanitize_phone_number'
    ));
 
    $wp_customize->add_control('unschool_phone', array(
        'label'      => esc_html__('Phone Number', 'unschool'),
        'section'    => 'unschool_header',
        'setting'   => 'unschool_phone',
        'type'    => 'text'
    ));
    
    //  =============================
    //  = Text Input Email                =
    //  =============================
    $wp_customize->add_setting('unschool_address', array(
        'default'        => '',
        'sanitize_callback' => 'sanitize_textarea_field'       
    ));
 
    $wp_customize->add_control('unschool_address', array(
        'label'      => esc_html__('Full Address', 'unschool'),
        'section'    => 'unschool_header',
        'setting'   => 'unschool_address',
        'type'    => 'textarea'
    ));

    //  =============================
    //  = Text Input facebook                =
    //  =============================
    $wp_customize->add_setting('unschool_fb', array(
        'default'        => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
 
    $wp_customize->add_control('unschool_fb', array(
        'label'      => esc_html__('Facebook', 'unschool'),
        'section'    => 'unschool_social',
        'setting'   => 'unschool_fb',
    ));
    //  =============================
    //  = Text Input Twitter                =
    //  =============================
    $wp_customize->add_setting('unschool_twitter', array(
        'default'        => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
 
    $wp_customize->add_control('unschool_twitter', array(
        'label'      => esc_html__('Twitter', 'unschool'),
        'section'    => 'unschool_social',
        'setting'   => 'unschool_twitter',
    ));
    //  =============================
    //  = Text Input googleplus                =
    //  =============================
    $wp_customize->add_setting('unschool_glplus', array(
        'default'        => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
 
    $wp_customize->add_control('unschool_glplus', array(
        'label'      => esc_html__('Google Plus', 'unschool'),
        'section'    => 'unschool_social',
        'setting'   => 'unschool_glplus',
    ));
    //  =============================
    //  = Text Input linkedin                =
    //  =============================
    $wp_customize->add_setting('unschool_in', array(
        'default'        => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
 
    $wp_customize->add_control('unschool_in', array(
        'label'      => esc_html__('Linkedin', 'unschool'),
        'section'    => 'unschool_social',
        'setting'   => 'unschool_in',
    ));

    //  =============================
    //  = slider section              =
    //  =============================
    $wp_customize->add_section('business_multi_lite_banner', array(
        'title'    => esc_html__('UnSchool Home Banner Text', 'unschool'),
        'description' => esc_html__('add home banner text here.','unschool'),
        'priority' => 36,
    ));
   
// Banner heading Text
    $wp_customize->add_setting('banner_heading',array(
            'default'   => null,
            'sanitize_callback' => 'sanitize_text_field'    
    ));
    
    $wp_customize->add_control('banner_heading',array( 
            'type'  => 'text',
            'label' => esc_html__('Add Banner heading here','unschool'),
            'section'   => 'business_multi_lite_banner',
            'setting'   => 'banner_heading'
    )); // Banner heading Text

    // Banner heading Text
    $wp_customize->add_setting('banner_sub_heading',array(
            'default'   => null,
            'sanitize_callback' => 'sanitize_text_field'    
    ));
    
    $wp_customize->add_control('banner_sub_heading',array( 
            'type'  => 'text',
            'label' => esc_html__('Add Banner sub heading here','unschool'),
            'section'   => 'business_multi_lite_banner',
            'setting'   => 'banner_sub_heading'
    )); // Banner heading Text

  //  =============================
    //  = Footer              =
    //  =============================

    $wp_customize->add_section('unschool_footer', array(
        'title'    => esc_html__('UnSchool Footer', 'unschool'),
        'description' => '',
        'priority' => 37,
    ));

	// Footer design and developed
	 $wp_customize->add_setting('unschool_design', array(
        'default'        => '',
		'sanitize_callback' => 'sanitize_textarea_field'
    ));
 
    $wp_customize->add_control('unschool_design', array(
        'label'      => esc_html__('Design and developed', 'unschool'),
        'section'    => 'unschool_footer',
        'setting'   => 'unschool_design',
		'type'	   =>'textarea'
    ));
	// Footer copyright
	 $wp_customize->add_setting('unschool_copyright', array(
        'default'        => '',
		'sanitize_callback' => 'sanitize_textarea_field'       
    ));
 
    $wp_customize->add_control('unschool_copyright', array(
        'label'      => esc_html__('Copyright', 'unschool'),
        'section'    => 'unschool_footer',
        'setting'   => 'unschool_copyright',
		'type'	   =>'textarea'
    ));	
}
add_action('customize_register', 'unschool_customize_register');
?>