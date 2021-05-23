<?php
/**
 * Dynamic styles
 *
 * @package Color Blog Dark
 * @since 1.0.0
 *
 */

add_action( 'wp_enqueue_scripts', 'color_blog_dark_dynamic_styles' );

if ( ! function_exists( 'color_blog_dark_dynamic_styles' ) ) :

    function color_blog_dark_dynamic_styles() {

        $color_blog_dark_primary_color = get_theme_mod( 'color_blog_dark_primary_color', '#dd3333' );
        $get_categories = get_categories( array( 'hide_empty' => 1 ) );

        $output_css = '';
    
        foreach ( $get_categories as $category ) {

            $cat_color = get_theme_mod( 'color_blog_dark_category_color_'.$category->slug, '#3b2d1b' );
            $cat_hover_color = color_blog_dark_hover_color( $cat_color, '-50' );
            $cat_id = $category->term_id;
            
            if ( !empty( $cat_color ) ) {
                $output_css .= ".category-button.cbd-cat-". esc_attr( $cat_id ) ." a { background: ". esc_attr( $cat_color ) ."}\n";
                $output_css .= ".category-button.cbd-cat-". esc_attr( $cat_id ) ." a:hover { background: ". esc_attr( $cat_hover_color ) ."}\n";
                $output_css .= "#site-navigation ul li.cbd-cat-". esc_attr( $cat_id ) ." .menu-item-description { background: ". esc_attr( $cat_color ) ."}\n";
               $output_css .= "#site-navigation ul li.cbd-cat-". esc_attr( $cat_id ) ." .menu-item-description:after { border-top-color: ". esc_attr( $cat_color ) ."}\n";
            }
        }
        
        $output_css .= "a,a:hover,a:focus,a:active,.entry-cat .cat-links a:hover,.entry-cat a:hover,.entry-footer a:hover,.comment-author .fn .url:hover,.commentmetadata .comment-edit-link, #cancel-comment-reply-link, #cancel-comment-reply-link:before, .logged-in-as a,.widget a:hover, .widget a:hover::before, .widget li:hover::before,.mt-social-icon-wrap li a:hover,.mt-social-icon-wrap li a:focus,#site-navigation ul li:hover>a,#site-navigation ul li.current-menu-item>a,#site-navigation ul li.current_page_ancestor>a,#site-navigation ul li.current-menu-ancestor>a,#site-navigation ul li.current_page_item>a,#site-navigation ul li.current-menu-parent>a,#site-navigation ul li.focus>a,.banner-sub-title,.entry-title a:hover,.cat-links a:hover,.entry-footer .mt-readmore-btn:hover,.btn-wrapper a:hover,.mt-readmore-btn:hover,.navigation.pagination .nav-links .page-numbers.current, .navigation.pagination .nav-links a.page-numbers:hover,#footer-menu li a:hover,.color_blog_dark_latest_posts .mt-post-title a:hover,#mt-scrollup:hover,.menu-toggle:hover, #top-navigation ul li a:hover,.mt-search-icon:hover, .entry-meta a:hover, .front-slider-block .banner-title a:hover, .post-info-wrap .entry-meta a:hover, .single .mt-single-related-posts .entry-title a:hover, .breadcrumbs .trail-items li a:hover, .wrap-label i,.has-thumbnail .post-info-wrap .entry-title a:hover,.front-slider-block .post-info-wrap .entry-title a:hover,#top-footer a:hover{ color: ". esc_attr( $color_blog_dark_primary_color ) ."}\n";
        $output_css .= ".widget_search .search-submit,.widget_search .search-submit:hover,.navigation.pagination .nav-links .page-numbers.current, .navigation.pagination .nav-links a.page-numbers:hover, .error-404.not-found, .color_blog_dark_social_media a:hover, .custom-header{ border-color: ". esc_attr( $color_blog_dark_primary_color ) ."}\n";
        $output_css .= ".front-slider-block .lSAction > a:hover, .top-featured-post-wrap .post-thumbnail .post-number, .post-cats-list a, #site-navigation .menu-item-description, article .post-thumbnail::before, #secondary .widget .widget-title::before, .mt-related-post-title::before, #colophon .widget .widget-title::before, .features-post-title::before, .mt-menu-search .mt-form-wrap .search-form .search-submit,.mt-live-link a { background: ". esc_attr( $color_blog_dark_primary_color ) ."}\n";
        $output_css .= ".edit-link .post-edit-link,.reply .comment-reply-link,.widget_search .search-submit, .mt-menu-search .mt-form-wrap .search-form .search-submit:hover, article.sticky::before{ background: ". esc_attr( $color_blog_dark_primary_color ) ."}\n";

        $output_css .= ".mt-menu-search .mt-form-wrap .search-form .search-field:focus{ outline-color: ". esc_attr( $color_blog_dark_primary_color ) ."}\n";

        $slider_bg_image = get_theme_mod( 'color_blog_dark_slider_bg_image' );

        if ( !empty( $slider_bg_image ) ) {
            $output_css .= ".front-slider-wrapper{background: url(". esc_url( $slider_bg_image ) .") no-repeat fixed center center/cover}\n";
        }

        $refine_output_css = color_blog_dark_css_strip_whitespace( $output_css );
        wp_add_inline_style( 'color-blog-dark-style', $refine_output_css );
    }
endif;