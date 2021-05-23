<?php
function pliska_register_layout_theme_customizer( $wp_customize ){

    $wp_customize->add_section('layout_options', array(
        'title' => esc_html__('Page Layout', 'pliska') ,
        'description' => esc_html__('Decide where to position the sidebar for specific site content. You can use the sidebar to display widgets. You can choose between left sidebar, right sidebar (default) and full width layout. To add or remove widgets, go to "Widgets" section.', 'pliska')
    ));

    /* Single Page Layout */
    $wp_customize->add_setting('page_layout', array(
        'default' => 'two',
        'sanitize_callback' => 'pliska_sanitize_select',
    ));
    $wp_customize->add_control('page_layout', array(
        'label' => esc_html__('Single Page', 'pliska') ,
        'section' => 'layout_options',
        'type' => 'select',
        'choices' => array(
            'one' => esc_html__('Right Sidebar', 'pliska') ,
            'two' => esc_html__('Full-width', 'pliska') ,
            'three' => esc_html__('Left Sidebar', 'pliska') ,
        ) ,
        'description' => esc_html__("Choose the default layout of the site's pages, including the static home page.", 'pliska')
    ));
    /* Single Post Layout */
    $wp_customize->add_setting('post_layout', array(
        'default' => 'one',
        'sanitize_callback' => 'pliska_sanitize_select',
    ));
    $wp_customize->add_control('post_layout', array(
        'label' => esc_html__('Single Blog Post', 'pliska') ,
        'section' => 'layout_options',
        'type' => 'select',
        'choices' => array(
            'one' => esc_html__('Right Sidebar', 'pliska') ,
            'two' => esc_html__('Full-width', 'pliska') ,
            'three' => esc_html__('Left Sidebar', 'pliska') ,
        ) ,
        'description' => esc_html__("Change the layout of the individual blog posts.", 'pliska')
    ));
    /* Post Archives */
    $wp_customize->add_setting('post_archives_layout', array(
        'default' => 'one',
        'sanitize_callback' => 'pliska_sanitize_select',
    ));
    $wp_customize->add_control('post_archives_layout', array(
        'label' => esc_html__('Post Archives', 'pliska') ,
        'section' => 'layout_options',
        'type' => 'select',
        'choices' => array(
            'one' => esc_html__('Right Sidebar', 'pliska') ,
            'two' => esc_html__('Full-width', 'pliska') ,
            'three' => esc_html__('Left Sidebar', 'pliska') ,
        ) ,
        'description' => esc_html__("Change the layout of all the pages that list blog posts, including the taxonomy archives (categories, tags, etc.).", 'pliska')
    ));

    /* Shop Page Layout */
    if( class_exists('Woocommerce') ) :
        $wp_customize->add_setting('shop_page_layout', array(
            'default' => 'one',
            'sanitize_callback' => 'pliska_sanitize_select',
        ));
        $wp_customize->add_control('shop_page_layout', array(
            'label' => esc_html__('Shop Page', 'pliska') ,
            'section' => 'layout_options',
            'type' => 'select',
            'choices' => array(
                'one' => esc_html__('Right Sidebar', 'pliska') ,
                'two' => esc_html__('Full-width', 'pliska') ,
                'three' => esc_html__('Left Sidebar', 'pliska') ,
            ) ,
            'description' => esc_html__('Change the default layout of the page that lists products.', 'pliska')
        ));
        /* Single Product Page Layout */
        $wp_customize->add_setting('single_product_page_layout', array(
            'default' => 'one',
            'sanitize_callback' => 'pliska_sanitize_select',
        ));
        $wp_customize->add_control('single_product_page_layout', array(
            'label' => esc_html__('Single Product Page', 'pliska') ,
            'section' => 'layout_options',
            'type' => 'select',
            'choices' => array(
                'one' => esc_html__('Right Sidebar', 'pliska') ,
                'two' => esc_html__('Full-width', 'pliska') ,
                'three' => esc_html__('Left Sidebar', 'pliska') ,
            ),
            'description' => esc_html__('Change the default layout of the single product page', 'pliska')
        ));
    endif;

}

add_action( 'customize_register', 'pliska_register_layout_theme_customizer' );


function pliska_sidebar_css() {

    $sidebar_layout = get_theme_mod('default_sidebar_layout', 'one');
    $page_layout = get_theme_mod('page_layout', 'two');
    $post_layout = get_theme_mod('post_layout', 'one');
    $post_archives_layout = get_theme_mod('post_archives_layout', 'one');
    $shop_page_layout = get_theme_mod('shop_page_layout', 'one');
    $single_product_page_layout = get_theme_mod('single_product_page_layout', 'one');

    // Standard page layout
    if ($page_layout == 'three'): ?>

    <style type="text/css">
        .page .wrapper {
            flex-direction: row-reverse;
        }

    </style>
    
    <?php endif;
    
     //Single post layout
     if ($post_layout == 'three'): ?>

     <style type="text/css">
         .single .wrapper {
             flex-direction: row-reverse;
         }
     </style>
         
    <?php endif;
    
    /**
     * Post Archives layout
     */
     if ($post_archives_layout == 'three'): ?>

    <style type="text/css">
        .archive .wrapper, .home.blog .wrapper, .blog .wrapper, .search .wrapper, .error404 .wrapper {
            flex-direction: row-reverse;
        }
    </style>
        
    <?php endif;

    /**
     * Woocommerce shop layout
     */

    if( !class_exists('Woocommerce') ) return;

    if ($shop_page_layout == 'three'): ?>

    <style type="text/css">
        .woocommerce-page .wrapper {
            flex-direction: row-reverse;
        }
        .woocommerce-page #secondary {
            display: block;
        }
        @media (min-width: 40em){
            .woocommerce-page .site-main {
                max-width: 70%;
            }
        }
        
    </style>
        
    <?php elseif ($shop_page_layout == "two"): ?>
        
        <style type="text/css">
        .woocommerce-page #secondary {
            display: none;
        }
        
        .woocommerce-page .site-main {
            max-width: 100%;
            width: 100%;
        }
        </style>

    <?php else : ?>

    <style type="text/css">
        .woocommerce-page #secondary {
            display: block;
        }

        .woocommerce-page .wrapper {
            flex-direction: row;
        }
        @media (min-width: 40em){
            .woocommerce-page .site-main {
                max-width: 70%;
            } 
        }

    </style>
    <?php endif;

    /**
     * Woocommerce single product page layout
     */
    if ($single_product_page_layout == 'three'): ?>
    
    <style type="text/css">
        .woocommerce.single-product .wrapper {
            flex-direction: row-reverse;
        }

        .woocommerce.single-product #secondary {
                display: block;
        }
        @media (min-width: 40em){
            .woocommerce.single-product.single .site-main {
                max-width: 70%;
            }
        }

    </style>

    <?php elseif ($single_product_page_layout == "two"): ?>

    <style type="text/css">
        .woocommerce.single-product.single #secondary {
            display: none;
        }

        .woocommerce.single-product.single .site-main {
            max-width: 100%;
            width: 100%;
        }
    </style>

    <?php else : ?>

    <style type="text/css">

        .woocommerce.single-product.single #secondary {
            display: block;
        }

        .woocommerce.single-product.single .wrapper {
            flex-direction: row;
        }
        @media (min-width: 40em){
            .woocommerce.single-product.single .site-main {
                max-width: 70%;
            }
        }
        
    </style>
    
    <?php endif;

}

add_action('wp_head', 'pliska_sidebar_css');