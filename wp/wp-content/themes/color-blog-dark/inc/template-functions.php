<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Color Blog Dark
 * @since 1.0.0
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function color_blog_dark_body_classes( $classes ) {
	global $post;

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	$color_blog_dark_site_layout = get_theme_mod( 'color_blog_dark_site_layout', 'site-layout--wide' );
	$classes[] = esc_attr( $color_blog_dark_site_layout );

	/**
	 * Add classes about style and sidebar layout for archive, post and page
	 */
	if ( is_archive() || is_home() || is_search()) {
		$archive_sidebar_layout = get_theme_mod( 'color_blog_dark_archive_sidebar_layout', 'no-sidebar' );
		$archive_style          = get_theme_mod( 'color_blog_dark_archive_style', 'mt-archive--masonry-style' );
		$classes[] = esc_attr( $archive_sidebar_layout );
		$classes[] = esc_attr( $archive_style );
	} elseif ( is_single() ) {
		$single_post_sidebar_layout = get_post_meta( $post->ID, 'color_blog_dark_post_sidebar_layout', true );
		if ( 'layout--default-sidebar' !== $single_post_sidebar_layout && !empty( $single_post_sidebar_layout ) ) {
			$classes[] = esc_attr( $single_post_sidebar_layout );
		} else {
			$posts_sidebar_layout = get_theme_mod( 'color_blog_dark_posts_sidebar_layout', 'right-sidebar' );
			$classes[] = esc_attr( $posts_sidebar_layout );
		}
	} elseif ( is_page() ) {
		$single_page_sidebar_layout = get_post_meta( $post->ID, 'color_blog_dark_post_sidebar_layout', true );
		if ( 'layout--default-sidebar' !== $single_page_sidebar_layout && !empty( $single_page_sidebar_layout ) ) {
			$classes[] = esc_attr( $single_page_sidebar_layout );
		} else {
			$pages_sidebar_layout = get_theme_mod( 'color_blog_dark_pages_sidebar_layout', 'right-sidebar' );
			$classes[] = esc_attr( $pages_sidebar_layout );
		}
	}
	return $classes;
}
add_filter( 'body_class', 'color_blog_dark_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function color_blog_dark_pingback_header() {

	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}

}
add_action( 'wp_head', 'color_blog_dark_pingback_header' );
/*-----------------------------------------------------------------------------------------------------------------------*/
if ( ! function_exists( 'color_blog_dark_fonts_url' ) ) :

	/**
	 * Register Google fonts for Color Blog Dark.
	 *
	 * @return string Google fonts URL for the theme.
	 * @since 1.0.0
	 */
    function color_blog_dark_fonts_url() {
        $fonts_url = '';
        $font_families = array();

        /*
         * Translators: If there are characters in your language that are not supported
         * byJosefin Sans  translate this to 'off'. Do not translate into your own language.
         */
        if ( 'off' !== _x( 'on', 'Josefin Sans font: on or off', 'color-blog-dark' ) ) {
            $font_families[] = 'Josefin Sans:400,700';
        }

        /*
         * Translators: If there are characters in your language that are not supported
         * by Poppins, translate this to 'off'. Do not translate into your own language.
         */
        if ( 'off' !== _x( 'on', 'Poppins font: on or off', 'color-blog-dark' ) ) {
            $font_families[] = 'Poppins:300,400,400i,500,700';
        }   

        if ( $font_families ) {
            $query_args = array(
                'family' => urlencode( implode( '|', $font_families ) ),
                'subset' => urlencode( 'latin,latin-ext' ),
            );
            $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
        }
        return $fonts_url;
    }

endif;

/*-----------------------------------------------------------------------------------------------------------------------*/
/**
 * Enqueue scripts and styles for only admin
 *
 * @since 1.0.0
 */
add_action( 'admin_enqueue_scripts', 'color_blog_dark_admin_scripts' );

function color_blog_dark_admin_scripts( $hook ) {
    global $color_blog_dark_theme_version;

    if ( 'widgets.php' != $hook && 'customize.php' != $hook && 'edit.php' != $hook && 'post.php' != $hook && 'post-new.php' != $hook ) {
        return;
    }

    wp_enqueue_script( 'jquery-ui-button' );
    wp_enqueue_script( 'color-blog-dark--admin-script', get_template_directory_uri() .'/assets/js/mt-admin-scripts.js', array( 'jquery' ), esc_attr( $color_blog_dark_theme_version ), true );
    wp_enqueue_style( 'color-blog-dark--admin-style', get_template_directory_uri() . '/assets/css/mt-admin-styles.css', array(), esc_attr( $color_blog_dark_theme_version ) );
}
/*----------------------------------------------------------------------------------------------------------------------------------------*/
/**
 * Enqueue scripts and styles.
 */
function color_blog_dark_scripts() {
	global $color_blog_dark_theme_version;

	wp_enqueue_style( 'color-blog-dark-fonts', color_blog_dark_fonts_url(), array(), null );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/library/font-awesome/css/font-awesome.min.css', array(), '4.7.0' );
	wp_enqueue_style( 'lightslider-style', get_template_directory_uri() .'/assets/library/lightslider/css/lightslider.min.css', array(), '' );
	wp_enqueue_style( 'animate', get_template_directory_uri(). '/assets/library/animate/animate.min.css', array(), '3.5.1' );
	wp_enqueue_style( 'preloader', get_template_directory_uri() .'/assets/css/mt-preloader.css', array(), esc_attr( $color_blog_dark_theme_version ) );
	wp_enqueue_style( 'color-blog-dark-style', get_stylesheet_uri(), array(), esc_attr( $color_blog_dark_theme_version) );
	wp_enqueue_style( 'color-blog-dark-responsive-style', get_template_directory_uri(). '/assets/css/mt-responsive.css', array(), esc_attr( $color_blog_dark_theme_version ) );

	wp_enqueue_script( 'color-blog-dark-combine-scripts', get_template_directory_uri() .'/assets/js/mt-combine-scripts.js', array('jquery'), esc_attr( $color_blog_dark_theme_version ), true );
	wp_enqueue_script( 'color-blog-dark-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), esc_attr( $color_blog_dark_theme_version ), true );
	wp_enqueue_script( 'color-blog-dark-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), esc_attr( $color_blog_dark_theme_version ), true );
	wp_enqueue_script( 'color-blog-dark-custom-scripts', get_template_directory_uri() .'/assets/js/mt-custom-scripts.js', array('jquery'), esc_attr( $color_blog_dark_theme_version ), true );

	$color_blog_dark_enable_sticky_menu = get_theme_mod( 'color_blog_dark_enable_sticky_menu', true );
	if ( true === $color_blog_dark_enable_sticky_menu ) {
		$sticky_value = 'on';
	} else {
		$sticky_value = 'off';
	}

	$color_blog_dark_enable_wow_animation = get_theme_mod( 'color_blog_dark_enable_wow_animation', true );
	if ( true === $color_blog_dark_enable_wow_animation ) {
		$wow_value = 'on';
	} else {
		$wow_value = 'off';
	}

	wp_localize_script( 'color-blog-dark-custom-scripts', 'color_blog_darkObject', array(
        'menu_sticky' => $sticky_value,
        'wow_effect'     => $wow_value
    ) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'color_blog_dark_scripts' );

/*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/
if ( ! function_exists( 'color_blog_dark_preloader' ) ) :

    /**
     * preloader function
     * 
     * @since 1.0.0
     */
    function color_blog_dark_preloader() {
        $color_blog_dark_enable_preloader = get_theme_mod( 'color_blog_dark_enable_preloader', true );
        if ( false === $color_blog_dark_enable_preloader ){
            return;
        }
?>
        <div id="preloader-background">
            <div class="preloader-wrapper">
                <div class="sk-spinner sk-spinner-pulse"></div>
            </div><!-- .preloader-wrapper -->
        </div><!-- #preloader-background -->
<?php
    }

endif;
add_action( 'color_blog_dark_before_page', 'color_blog_dark_preloader', 5 );

if ( ! function_exists( 'color_blog_dark_font_awesome_social_icon_array' ) ) :

    /**
     * Define font awesome social media icons
     *
     * @return array();
     * @since 1.0.0
     */
    function color_blog_dark_font_awesome_social_icon_array() {
        return array(
            "fa fa-facebook-square","fa fa-facebook-f","fa fa-facebook","fa fa-facebook-official","fa fa-twitter-square","fa fa-twitter","fa fa-yahoo","fa fa-google","fa fa-google-wallet","fa fa-google-plus-circle","fa fa-google-plus-official","fa fa-instagram","fa fa-linkedin-square","fa fa-linkedin","fa fa-pinterest-p","fa fa-pinterest","fa fa-pinterest-square","fa fa-google-plus-square","fa fa-google-plus","fa fa-youtube-square","fa fa-youtube","fa fa-youtube-play","fa fa-vimeo","fa fa-vimeo-square",
        );
    }

endif;

/*----------------------------------------------------------------------------------------------------------------------------------------*/
if ( ! function_exists( 'color_blog_dark_social_media_content' ) ) :

	/**
	 * function to display the social icons
	 */
	function color_blog_dark_social_media_content() {
		$defaults_icons = json_encode( array(
				array(
					'social_icon' => 'fa fa-twitter',
					'social_url'  => '#',
				),
				array(
					'social_icon' => 'fa fa-pinterest',
					'social_url'  => '#',
				)
			)
		);
		$color_blog_dark_social_icons = get_theme_mod( 'color_blog_dark_social_icons', $defaults_icons );
		$social_icons = json_decode( $color_blog_dark_social_icons );

		if ( ! empty( $social_icons ) ) {
?>
			<ul class="mt-social-icon-wrap">
				<?php
					foreach ( $social_icons as $social_icon ) {
						if ( ! empty( $social_icon->social_url ) ) {
				?>
							<li class="mt-social-icon">
								<a href="<?php echo esc_url( $social_icon->social_url ); ?>" target="_blank">
									<i class="<?php echo esc_attr( $social_icon->social_icon ); ?>"></i>
								</a>
							</li>
				<?php
						}
					}
				?>
			</ul>
<?php 
		}
	}

endif;
/*-----------------------------------------------------------------------------------------------------------------------*/

if ( ! function_exists( 'color_blog_dark_hover_color' ) ) :

    /**
     * Generate darker color
     * Source: http://stackoverflow.com/questions/3512311/how-to-generate-lighter-darker-color-with-php
     *
     * @since 1.0.0
     */
    function color_blog_dark_hover_color( $hex, $steps ) {
        // Steps should be between -255 and 255. Negative = darker, positive = lighter
        $steps = max( -255, min( 255, $steps ) );

        // Normalize into a six character long hex string
        $hex = str_replace( '#', '', $hex );
        if ( strlen( $hex ) == 3) {
            $hex = str_repeat( substr( $hex,0,1 ), 2 ).str_repeat( substr( $hex, 1, 1 ), 2 ).str_repeat( substr( $hex,2,1 ), 2 );
        }

        // Split into three parts: R, G and B
        $color_parts = str_split( $hex, 2 );
        $return = '#';

        foreach ( $color_parts as $color ) {
            $color   = hexdec( $color ); // Convert to decimal
            $color   = max( 0, min( 255, $color + $steps ) ); // Adjust color
            $return .= str_pad( dechex( $color ), 2, '0', STR_PAD_LEFT ); // Make two char hex code
        }
        return $return;
    }

endif;

/*----------------------------------------------------------------------------------------------------------------------------------------*/
if ( ! function_exists( 'color_blog_dark_select_categories_list' ) ) :

	/**
	 * function to return category lists
	 *
	 * @return $color_blog_dark_categories_list in array
	 */
	function color_blog_dark_select_categories_list() {
		$color_blog_dark_get_categories = get_categories( array( 'hide_empty' => 0 ) );
		$color_blog_dark_categories_list[''] = __( 'Select Category', 'color-blog-dark' );
        foreach ( $color_blog_dark_get_categories as $category ) {
    	    $color_blog_dark_categories_list[esc_attr( $category->slug )] = esc_html( $category->cat_name );
        }
        return $color_blog_dark_categories_list;
	}

endif;
/*----------------------------------------------------------------------------------------------------------------------------------------*/
if ( ! function_exists( 'color_blog_dark_is_sidebar_layout' ) ) :

	/**
	 * Checks if the current page matches the given layout
	 *
	 * @return string $layout layout of current page.
	 */
	function color_blog_dark_is_sidebar_layout() {
		global $post;
		$layout = '';
		if ( is_archive() || is_home() ) {
			$layout = get_theme_mod( 'color_blog_dark_archive_sidebar_layout', 'no-sidebar' );
		} elseif ( is_single() ) {
			$single_post_layout = get_post_meta( $post->ID, 'color_blog_dark_post_sidebar_layout', true );
			if ( 'layout--default-sidebar' !== $single_post_layout ) {
				$layout = $single_post_layout;
			} else {
				$layout = get_theme_mod( 'color_blog_dark_posts_sidebar_layout', 'right-sidebar' );
			}
		} elseif ( is_page() ) {
			$single_page_layout = get_post_meta( $post->ID, 'color_blog_dark_post_sidebar_layout', true );
			if ( 'layout--default-sidebar' !== $single_page_layout ) {
				$layout = $single_page_layout;
			} else {
				$layout = get_theme_mod( 'color_blog_dark_pages_sidebar_layout', 'right-sidebar' );
			}
		}
		return $layout;
	}

endif;
/*----------------------------------------------------------------------------------------------------------------------------------------*/
if ( ! function_exists( 'color_blog_dark_inner_header_bg_image' ) ) :

    /**
     * Background image for inner page header
     *
     * @since 1.0.0
     */
    function color_blog_dark_inner_header_bg_image( $input ) {

        $image_attr = array();

        if ( empty( $image_attr ) ) {

            // Fetch from Custom Header Image.
            $image = get_header_image();
            if ( ! empty( $image ) ) {
                $image_attr['url']    = $image;
                $image_attr['width']  = get_custom_header()->width;
                $image_attr['height'] = get_custom_header()->height;
            }
        }

        if ( ! empty( $image_attr ) ) {
            $input .= 'background-image:url(' . esc_url( $image_attr['url'] ) . ');';
            $input .= 'background-size:cover;';
        }

      return $input;
    }

endif;
add_filter( 'color_blog_dark_inner_header_style_attribute', 'color_blog_dark_inner_header_bg_image' );
/*-----------------------------------------------------------------------------------------------------------------------*/
if ( ! function_exists( 'color_blog_dark_css_strip_whitespace' ) ) :

	/**
	 * Get minified css and removed space
	 *
	 * @since 1.0.0
	 */

    function color_blog_dark_css_strip_whitespace( $css ){
        $replace = array(
            "#/\*.*?\*/#s" => "",  // Strip C style comments.
            "#\s\s+#"      => " ", // Strip excess whitespace.
        );
        $search = array_keys( $replace );
        $css = preg_replace( $search, $replace, $css );

        $replace = array(
            ": "  => ":",
            "; "  => ";",
            " {"  => "{",
            " }"  => "}",
            ", "  => ",",
            "{ "  => "{",
            ";}"  => "}", // Strip optional semicolons.
            ",\n" => ",", // Don't wrap multiple selectors.
            "\n}" => "}", // Don't wrap closing braces.
            "} "  => "}\n", // Put each rule on it's own line.
        );
        $search = array_keys( $replace );
        $css = str_replace( $search, $replace, $css );

        return trim( $css );
    }

endif;

/*-----------------------------------------------------------------------------------------------------------------------*/

/**
 * Archive title prefix
 *
 */
$archive_title_prefix_option = get_theme_mod( 'color_blog_dark_enable_archive_title_prefix', true );

if ( false === $archive_title_prefix_option ) {
    add_filter( 'get_the_archive_title', 'color_blog_dark_archive_title_prefix' );
}

if ( ! function_exists( 'color_blog_dark_archive_title_prefix' ) ) :
    
    function color_blog_dark_archive_title_prefix( $title ) {
        return preg_replace( '/^\w+: /', '', $title );
    }

endif;