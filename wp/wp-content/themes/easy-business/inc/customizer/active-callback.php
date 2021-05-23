<?php
/**
 * Active callback functions.
 *
 * @package Easy Business
 */

function easy_business_featured_slider_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_featured_slider_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function easy_business_featured_slider_page( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[featured_slider_content_type]' )->value();
    return ( easy_business_featured_slider_active( $control ) && ( 'featured_slider_page' == $content_type ) );
}

function easy_business_featured_slider_post( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[featured_slider_content_type]' )->value();
    return ( easy_business_featured_slider_active( $control ) && ( 'featured_slider_post' == $content_type ) );
}

function easy_business_featured_slider_category( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[featured_slider_content_type]' )->value();
    return ( easy_business_featured_slider_active( $control ) && ( 'featured_slider_category' == $content_type ) );
}

function easy_business_our_services_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_our_services_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function easy_business_our_services_page( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[our_services_content_type]' )->value();
    return ( easy_business_our_services_active( $control ) && ( 'our_services_page' == $content_type ) );
}

function easy_business_our_services_post( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[our_services_content_type]' )->value();
    return ( easy_business_our_services_active( $control ) && ( 'our_services_post' == $content_type ) );
}

function easy_business_our_services_category( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[our_services_content_type]' )->value();
    return ( easy_business_our_services_active( $control ) && ( 'our_services_category' == $content_type ) );
}

function easy_business_call_to_action_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_call_to_action_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function easy_business_our_gallery_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_our_gallery_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function easy_business_our_gallery_page( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[our_gallery_content_type]' )->value();
    return ( easy_business_our_gallery_active( $control ) && ( 'our_gallery_page' == $content_type ) );
}

function easy_business_our_gallery_post( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[our_gallery_content_type]' )->value();
    return ( easy_business_our_gallery_active( $control ) && ( 'our_gallery_post' == $content_type ) );
}

function easy_business_our_gallery_category( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[our_gallery_content_type]' )->value();
    return ( easy_business_our_gallery_active( $control ) && ( 'our_gallery_category' == $content_type ) );
}

function easy_business_our_testimonial_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_our_testimonial_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function easy_business_our_testimonial_page( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[our_testimonial_content_type]' )->value();
    return ( easy_business_our_testimonial_active( $control ) && ( 'our_testimonial_page' == $content_type ) );
}

function easy_business_our_testimonial_post( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[our_testimonial_content_type]' )->value();
    return ( easy_business_our_testimonial_active( $control ) && ( 'our_testimonial_post' == $content_type ) );
}

function easy_business_our_testimonial_category( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[our_testimonial_content_type]' )->value();
    return ( easy_business_our_testimonial_active( $control ) && ( 'our_testimonial_category' == $content_type ) );
}

function easy_business_blog_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_blog_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}