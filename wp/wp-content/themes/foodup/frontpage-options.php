<?php

/**
 *
 * @package Foodup
 */
function foodup_customize_register($wp_customize) {

$newsup_default = foodup_get_default_theme_options();

/* Option list of all post */  
    $options_posts = array();
    $options_posts_obj = get_posts('posts_per_page=-1');
    $options_posts[''] = __( 'Choose Post','foodup' );
    foreach ( $options_posts_obj as $posts ) {
        $options_posts[$posts->ID] = $posts->post_title;
    }

//section title
$wp_customize->add_setting('one_post_section',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control(
    new newsup_Section_Title(
        $wp_customize,
        'one_post_section',
        array(
            'label'             => esc_html__( 'Latest Post', 'foodup' ),
            'section'           => 'frontpage_main_banner_section_settings',
            'priority'          => 40,
            'active_callback' => 'newsup_main_banner_section_status'
        )
    )
);



 //Select Post One
  $wp_customize->add_setting('foodup_post_one',array(
                'capability'=>'edit_theme_options',
                'sanitize_callback' => 'newsup_sanitize_select',
            ));
            
   $wp_customize->add_control('foodup_post_one',array(
                'label' => __('Select Post','foodup'),
                'section'=>'frontpage_main_banner_section_settings',
                'type'=>'select',
                'priority'          => 50,
                'choices'=>$options_posts,
            ));




//section title
$wp_customize->add_setting('two_post_section',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control(
    new newsup_Section_Title(
        $wp_customize,
        'two_post_section',
        array(
            'label'             => esc_html__( 'Trending Section', 'foodup' ),
            'section'           => 'frontpage_main_banner_section_settings',
            'priority'          => 100,
            'active_callback' => 'newsup_main_banner_section_status'
        )
    )
);




// Setting - drop down category for slider.
$wp_customize->add_setting('select_trending_post_category',
    array(
        'default' => $newsup_default['select_trending_post_category'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'absint',
    )
);


$wp_customize->add_control(new Newsup_Dropdown_Taxonomies_Control($wp_customize, 'select_trending_post_category',
    array(
        'label' => esc_html__('Category', 'foodup'),
        'description' => esc_html__('Select Tranding 2 Post category', 'foodup'),
        'section' => 'frontpage_main_banner_section_settings',
        'type' => 'dropdown-taxonomies',
        'taxonomy' => 'category',
        'priority' => 110,
        'active_callback' => 'newsup_main_banner_section_status'
    )));


// Featured Section
$wp_customize->add_section('foodup_featured_post_settings',
    array(
        'title' => esc_html__('Featured Post', 'foodup'),
        'priority' => 60,
        'capability' => 'edit_theme_options',
        'panel' => 'frontpage_option_panel',
    )
);


//Featured Post One
$wp_customize->add_setting('featured_post_one',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);


$wp_customize->add_control(
    new newsup_Section_Title(
        $wp_customize,
        'featured_post_one',
        array(
            'label'             => esc_html__( 'Featured Post', 'foodup' ),
            'section'           => 'foodup_featured_post_settings',
            'priority'          => 100,
            'active_callback' => 'newsup_main_banner_section_status'
        )
    )
);



$wp_customize->add_setting('enable_featured_section',
    array(
        'default' => $newsup_default['enable_featured_section'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'newsup_sanitize_checkbox',
    )
);

$wp_customize->add_control('enable_featured_section',
    array(
        'label' => esc_html__('Enable Featured Post Section', 'foodup'),
        'section' => 'foodup_featured_post_settings',
        'type' => 'checkbox',
        'priority' => 10,

    )
);


$wp_customize->add_setting('fatured_post_image_one',
    array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    )
);

$wp_customize->add_control(
    new WP_Customize_Image_Control($wp_customize, 'fatured_post_image_one',
        array(
            'label' => esc_html__('Image', 'foodup'),
            'section' => 'foodup_featured_post_settings',
            'priority'          => 110,
        )
    )
);


$wp_customize->add_setting('featured_post_one_btn_txt',
    array(
        'default' => $newsup_default['featured_post_one_btn_txt'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control('featured_post_one_btn_txt',
    array(
        'label' => esc_html__('Button Text', 'foodup'),
        'section' => 'foodup_featured_post_settings',
        'type' => 'url',
        'priority' => 120,
    )
);


$wp_customize->add_setting('featured_post_one_url',
    array(
        'default' => $newsup_default['featured_post_one_url'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    )
);
$wp_customize->add_control('featured_post_one_url',
    array(
        'label' => esc_html__('Button Link', 'foodup'),
        'section' => 'foodup_featured_post_settings',
        'type' => 'url',
        'priority' => 130,
    )
);

$wp_customize->add_setting('featured_post_one_url_new_tab',
    array(
        'default' => true,
        'sanitize_callback' => 'newsup_sanitize_checkbox',
    )
    );
    $wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'featured_post_one_url_new_tab', 
        array(
            'label' => esc_html__('Open link in a new tab', 'foodup'),
            'type' => 'toggle',
            'section' => 'foodup_featured_post_settings',
            'priority' => 140,
        )
    ));



     //Featured Post One
$wp_customize->add_setting('featured_post_two',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control(
    new newsup_Section_Title(
        $wp_customize,
        'featured_post_two',
        array(
            'label'             => esc_html__( 'Featured Post', 'foodup' ),
            'section'           => 'foodup_featured_post_settings',
            'priority'          => 150,
            'active_callback' => 'newsup_main_banner_section_status'
        )
    )
);


$wp_customize->add_setting('fatured_post_image_two',
    array(
        'default' => $newsup_default['fatured_post_image_two'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    )
);

$wp_customize->add_control(
    new WP_Customize_Image_Control($wp_customize, 'fatured_post_image_two',
        array(
            'label' => esc_html__('Image', 'foodup'),
            'section' => 'foodup_featured_post_settings',
            'flex_width' => true,
            'flex_height' => true,
            'priority'          => 160,
        )
    )
);


$wp_customize->add_setting('featured_post_two_btn_txt',
    array(
        'default' => $newsup_default['featured_post_two_btn_txt'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control('featured_post_two_btn_txt',
    array(
        'label' => esc_html__('Button Text', 'foodup'),
        'section' => 'foodup_featured_post_settings',
        'type' => 'url',
        'priority' => 170,
    )
);


$wp_customize->add_setting('featured_post_two_url',
    array(
        'default' => $newsup_default['featured_post_two_url'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    )
);
$wp_customize->add_control('featured_post_two_url',
    array(
        'label' => esc_html__('Button Link', 'foodup'),
        'section' => 'foodup_featured_post_settings',
        'type' => 'url',
        'priority' => 180,
    )
);

$wp_customize->add_setting('featured_post_two_url_new_tab',
    array(
        'default' => true,
        'sanitize_callback' => 'newsup_sanitize_checkbox',
    )
    );
    $wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'featured_post_two_url_new_tab', 
        array(
            'label' => esc_html__('Open link in a new tab', 'foodup'),
            'type' => 'toggle',
            'section' => 'foodup_featured_post_settings',
            'priority' => 190,
        )
    ));


    //Featured Post One
$wp_customize->add_setting('featured_post_three',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control(
    new newsup_Section_Title(
        $wp_customize,
        'featured_post_three',
        array(
            'label'             => esc_html__( 'Featured Post', 'foodup' ),
            'section'           => 'foodup_featured_post_settings',
            'priority'          => 200,
            'active_callback' => 'newsup_main_banner_section_status'
        )
    )
);


$wp_customize->add_setting('fatured_post_image_three',
    array(
        'default' => $newsup_default['fatured_post_image_three'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    )
);

$wp_customize->add_control(
    new WP_Customize_Image_Control($wp_customize, 'fatured_post_image_three',
        array(
            'label' => esc_html__('Image', 'foodup'),
            'section' => 'foodup_featured_post_settings',
            'flex_width' => true,
            'flex_height' => true,
            'priority'          => 210,
        )
    )
);


$wp_customize->add_setting('featured_post_three_btn_txt',
    array(
        'default' => $newsup_default['featured_post_three_btn_txt'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control('featured_post_three_btn_txt',
    array(
        'label' => esc_html__('Button Text', 'foodup'),
        'section' => 'foodup_featured_post_settings',
        'type' => 'url',
        'priority' => 220,
    )
);


$wp_customize->add_setting('featured_post_three_url',
    array(
        'default' => $newsup_default['featured_post_three_url'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    )
);
$wp_customize->add_control('featured_post_three_url',
    array(
        'label' => esc_html__('Button Link', 'foodup'),
        'section' => 'foodup_featured_post_settings',
        'type' => 'url',
        'priority' => 230,
    )
);

$wp_customize->add_setting('featured_post_three_url_new_tab',
    array(
        'default' => true,
        'sanitize_callback' => 'newsup_sanitize_checkbox',
    )
    );
    $wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'featured_post_three_url_new_tab', 
        array(
            'label' => esc_html__('Open link in a new tab', 'foodup'),
            'type' => 'toggle',
            'section' => 'foodup_featured_post_settings',
            'priority' => 240,
        )
    ));  

}
add_action('customize_register', 'foodup_customize_register');