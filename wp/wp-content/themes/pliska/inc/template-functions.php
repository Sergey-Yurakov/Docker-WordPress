<?php

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @package pliska
 * @since 0.0.1
 */
/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function pliska_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) && ! class_exists( 'Woocommerce' ) || pliska_is_page_fullwidth() || pliska_is_post_fullwidth() || pliska_is_post_archives_fullwidth() || pliska_is_shop_fullwidth_layout() || pliska_is_single_product_fullwidth_layout() ) {
		$classes[] = 'no-sidebar';
	}

	if ( class_exists( 'Woocommerce' ) ) {
		if ( ! is_active_sidebar( 'sidebar-1' ) && ! is_woocommerce() ) {
			$classes[] = 'no-sidebar';
		}

		if ( is_woocommerce() && is_active_sidebar( 'sidebar-1' ) && ! is_active_sidebar( 'sidebar-2' ) ) {
			$classes[] = '';
		} elseif ( ( is_woocommerce() || is_shop() || is_cart() ) && ! is_active_sidebar( 'sidebar-1' ) && ! is_active_sidebar( 'sidebar-2' ) ) {
			$classes[] = 'no-sidebar';
		}
	}

	/**
	 * Add no-header-image class to singular pages in case there is no featured image
	 * and the site header image is disabled from the theme customizer
	 */
	if ( ! pliska_has_header_image() ) {
		$classes[] = 'no-header-image';
	}
	else {
		$classes[] = 'has-header-image';
	}
	// Adds a class of hfeed to non-singular pages.
	$header_menu_position = get_theme_mod( 'header-menu-position', 'sticky' );
	if ( $header_menu_position == 'static' ) {
		$classes[] = 'static-header';
	}
	// Make the dark mode default theme mode
	if ( pliska_default_mode() == 'dark' ) {
		$classes[] = 'dark-mode';
	}
	return $classes;
}

add_filter( 'body_class', 'pliska_body_classes' );
/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function pliska_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}

add_action( 'wp_head', 'pliska_pingback_header' );
/**
 * Check if it is a content type that lists blog posts, including the taxonomy archives (categories, tags, etc.).
 */
function pliska_is_blog() {
	 return ( is_archive() || is_author() || is_category() || is_home() || is_tag() ) && 'post' == get_post_type();
}

/**
 * Add option to add site logo from the customizer
 *
 * @since WordPress 4.5
 * provides shim for wp versions older than 4.5
 */
function pliska_the_logo() {
	if ( ! function_exists( 'the_custom_logo' ) ) {
		return;
	}
	the_custom_logo();
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Read More' link.
 *
 * @since pliska 0.0.1
 *
 * @param string $link Link to single post/page.
 * @return string 'Read More' link prepended with an ellipsis.
 */
function pliska_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}
	$link = sprintf(
		'<span class="link-more"><a href="%1$s" class="more-link">%2$s</a></span>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Read more <span class="screen-reader-text">"%1$s"</span>', 'pliska' ), esc_html( get_the_title( get_the_ID() ) ) )
	);
	return '<span class="dots"> &hellip; </span>' . $link;
}

add_filter( 'excerpt_more', 'pliska_excerpt_more' );

// Custom Excerpt Length to be used on post archives
function pliska_the_excerpt( $limit ) {
    $excerpt = explode( ' ', get_the_excerpt(), $limit );
    
    if ( count( $excerpt ) >= $limit ) {
        array_pop( $excerpt );
        $excerpt = implode( " ", $excerpt ) . '...';
    } else {
        $excerpt = implode( " ", $excerpt );
    }
    
    $excerpt = preg_replace( '`\\[[^\\]]*\\]`', '', $excerpt );
    echo esc_attr($excerpt);
}

/**
 * Add spinner
 */
function pliska_preloader() {
	if ( is_front_page() || is_home() || is_customize_preview() ) {
		?>
		<div class="preloader" aria-label="<?php _e('Loading', 'pliska')?>">
			<div class="preloader-inside">
				<div class="bounce1"></div>
				<div class="bounce2"></div>
			</div>
		</div>
		<?php
	}
}

add_action( 'wp_body_open', 'pliska_preloader' );
/**
 * Adds failsafe styling for preloader
 */
function pliska_header_failsafes() {
	?>
	<noscript><style>.preloader {display: none;}</style></noscript>
	<?php
}

add_action( 'wp_head', 'pliska_header_failsafes', 11 );
// IMPLEMENT SIMPLE PAGINATION IN POST ARCHIVES
function pliska_numeric_posts_nav() {
	return the_posts_pagination(
		array(
			'mid_size'  => 2,
			'prev_text' => '&#x00AB;',
			'next_text' => '&#x00BB;',
		)
	);
}

/* Post navigation in single.php */
function pliska_the_post_navigation() {
	 $pliska_prev_arrow = '&#60;';
	$pliska_next_arrow  = '&#62;';
	the_post_navigation(
		array(
			'prev_text'          => '<span class="nav-subtitle">' . $pliska_prev_arrow . '</span> <span class="nav-title">%title</span>',
			'next_text'          => '<span class="nav-title">%title </span>' . '<span class="nav-subtitle">' . $pliska_next_arrow . '</span>',
			'screen_reader_text' => __( 'Posts navigation', 'pliska' ),
		)
	);
}

/**
 * Adds Schema.org structured data (microdata) to the HTML markup
 * More details at http://schema.org
 * Testing tools at https://developers.google.com/structured-data/testing-tool/
 */
function pliska_schema_microdata( $location = '', $echo = 1 ) {
	 $output = '';
	switch ( $location ) {
		case 'body':
			$output = 'itemscope itemtype="http://schema.org/WebPage"';
			break;
		case 'header':
			$output = 'itemscope itemtype="http://schema.org/WPHeader"';
			break;
		case 'blog':
			$output = 'itemscope itemtype="http://schema.org/Blog"';
			break;
		case 'element':
			$output = 'itemscope itemtype="http://schema.org/WebPageElement"';
			break;
		case 'sidebar':
			$output = 'itemscope itemtype="http://schema.org/WPSideBar"';
			break;
		case 'footer':
			$output = 'itemscope itemtype="http://schema.org/WPFooter"';
			break;
		case 'mainEntityOfPage':
			$output = 'itemprop="mainEntityOfPage"';
			break;
		case 'breadcrumbs':
			$output = 'itemprop="breadcrumb"';
			break;
		case 'menu':
			$output = 'itemscope itemtype="http://schema.org/SiteNavigationElement"';
			break;
			/*
			 SITE HEADER */
		/* SITE HEADER */
		case 'site-title':
			$output = 'itemprop="headline"';
			break;
		case 'site-description':
			$output = 'itemprop="description"';
			break;
			/*
			 MAIN CONTENT - BLOG */
		/* MAIN CONTENT - BLOG */
		case 'blogpost':
			// archive/blog pages
			$output = 'itemscope itemtype="http://schema.org/BlogPosting" itemprop="blogPost"';
			break;
		case 'article':
			// single pages single.php, page.php, image.php
			$output = 'itemscope itemtype="http://schema.org/Article" itemprop="mainEntity"';
			break;
		case 'entry-title':
			$output = 'itemprop="headline"';
			break;
		case 'url':
			$output = 'itemprop="url"';
			break;
		case 'entry-summary':
			$output = 'itemprop="description"';
			break;
		case 'entry-content':
			$output = 'itemprop="articleBody"';
			break;
		case 'text':
			$output = 'itemprop="text"';
			break;
		case 'comment':
			$output = 'itemscope itemtype="http://schema.org/Comment"';
			break;
		case 'comment-author':
			$output = 'itemscope itemtype="http://schema.org/Person" itemprop="creator"';
			break;
			/*
			 POST META */
		/* POST META */
		case 'author':
			$output = 'itemscope itemtype="http://schema.org/Person" itemprop="author"';
			break;
		case 'author-url':
			$output = 'itemprop="url"';
			break;
		case 'author-name':
			$output = 'itemprop="name"';
			break;
		case 'author-description':
			$output = 'itemprop="description"';
			break;
		case 'time':
			$output = 'itemprop="datePublished"';
			break;
		case 'time-modified':
			$output = 'itemprop="dateModified"';
			break;
		case 'category':
			$output = '';
			break;
		case 'tags':
			$output = 'itemprop="keywords"';
			break;
		case 'comment-meta':
			$output = 'itemprop="discussionURL"';
			break;
		case 'image':
			$output = 'itemprop="image" itemscope itemtype="http://schema.org/ImageObject"';
			break;
	}
	// switch
	$output = ' ' . $output;

	if ( $echo ) {
		echo $output;
	} else {
		return $output;
	}

}

/**
 * Gravatar Alt Tags Fix
 *
 * @link https://wphelper.site/fix-missing-gravatar-alt-tag-value/
 */
function pliska_gravatar_alt( $text ) {
	 $alt = get_the_author_meta( 'display_name' );
	 
	$text = str_replace( 'alt=\'\'', 'alt=\'' . __('Avatar', 'pliska') . '&nbsp;' . esc_attr( $alt ) . '\' title=\'' . __('Gravatar', 'pliska') . '&nbsp;' . $alt . '\'', $text );
	return $text;
}

add_filter( 'get_avatar', 'pliska_gravatar_alt' );
/**
 * Properly escape svg output
 *
 * @link https://wordpress.stackexchange.com/questions/312625/escaping-svg-with-kses
 */
function pliska_get_kses_extended_ruleset() {
	$kses_defaults = wp_kses_allowed_html( 'post' );
	$svg_args      = array(
		'svg'      => array(
			'class'           => true,
			'aria-hidden'     => true,
			'aria-labelledby' => true,
			'role'            => true,
			'xmlns'           => true,
			'width'           => true,
			'height'          => true,
			'stroke'          => true,
			'stroke-width'    => true,
			'fill'            => true,
			'stroke-linecap'  => true,
			'stroke-linejoin' => true,
			'viewbox'         => true,
		),
		'circle'   => array(
			'cx' => true,
			'cy' => true,
			'r'  => true,
		),
		'line'     => array(
			'x1' => true,
			'y1' => true,
			'x2' => true,
			'y2' => true,
		),
		'polyline' => array(
			'points' => true,
		),
		'g'        => array(
			'fill' => true,
		),
		'title'    => array(
			'title' => true,
		),
		'path'     => array(
			'd'    => true,
			'fill' => true,
		),
	);
	return array_merge( $kses_defaults, $svg_args );
}

/**
 * Get Page title letters length
 * used to calculate site title typewriter animation
 */
function pliska_get_page_title_length() {
	$page_title_length = '';

	if ( is_front_page() && is_home() ) {
		// Default homepage
		$page_title_length = strlen( get_bloginfo( 'name' ) );
	} elseif ( is_front_page() ) {
		// Static homepage
		$page_title_length = strlen( get_the_title() );
	} elseif ( is_home() ) {
		// Blog page
		$page_title_length = strlen( get_the_title( get_option( 'page_for_posts', true ) ) );
	} else {

		if ( function_exists( 'is_shop' ) && is_shop() ) {
			// Woocommerce Shop Page
			$page_title_length = strlen( wp_kses( get_the_title( wc_get_page_id( 'shop' ) ), array() ) );
		} elseif ( is_archive() ) {
			// Post Archives
			$page_title_length = strlen( wp_kses( get_the_archive_title(), array() ) );
		} else {
			// Everything else
			$page_title_length = strlen( get_the_title() );
		}
	}

	return $page_title_length;
}

/**
 * Register Google Fonts
 *
 * @since 0.0.4
 */
function pliska_font_family() {
	 $google_fonts = array(
		 'Times New Roman' => 'Times New Roman, Sans Serif',
		 'Open Sans'       => 'Open Sans',
		 'Roboto'          => 'Roboto',
		 'Rubik'           => 'Rubik',
		 'Lato'            => 'Lato',
		 'Oswald'          => 'Oswald',
		 'Alegreya'        => 'Alegreya',
		 'Dosis'           => 'Dosis',
		 'Montserrat'      => 'Montserrat',
		 'Raleway'         => 'Raleway',
		 'PT Sans'         => 'PT Sans',
		 'Lora'            => 'Lora',
		 'Noto Sans'       => 'Noto Sans',
		 'IBM Plex Sans'   => 'IBM Plex Sans',
		 'Nunito Sans'     => 'Nunito Sans',
		 'Oxygen'          => 'Oxygen',
		 'Work Sans'       => 'Work Sans',
	 );

     return ( $google_fonts );
}

/* Register google fonts */
/**
 * Register custom fonts.
 * Combine headings and body custom fonts in one http request.
 *
 * @link https://wordpress.org/themes/new-york-business/
 */
function pliska_fonts_url() {
	$fonts_url = '';
	/*
	 * Translators: If there are characters in your language that are not
	 * supported by "Open Sans", sans-serif;, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$typography = _x( 'on', 'Open Sans font: on or off', 'pliska' );

	if ( 'off' !== $typography ) {
		$font_families   = array();
		$font_families[] = wp_strip_all_tags( get_theme_mod( 'headings_fontfamily', 'Rubik' ) ) . ':500,700,900';
		$font_families[] = wp_strip_all_tags( get_theme_mod( 'body_fontfamily', 'IBM Plex Sans' ) ) . ':300,400';
		$query_args      = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
			'pliska' => urlencode( 'swap' ),
		);
		$fonts_url       = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	}

	return esc_url( $fonts_url );
}

/**
 * Load Google Fonts. Add preload and preconnect for performance
 *
 * @since pliska .0.1
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
// Add resource hints to our Google fonts call.

if ( ! function_exists( 'pliska_resource_hints' ) ) {
	function pliska_resource_hints( $urls, $relation_type ) {
		if ( wp_style_is( 'pliska-fonts', 'queue' ) && 'preconnect' === $relation_type ) {

			if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '>=' ) ) {
				$urls[] = array(
					'href' => 'https://fonts.gstatic.com',
					'crossorigin',
				);
			} else {
				$urls[] = 'https://fonts.gstatic.com';
			}
		}
		return $urls;
	}

	add_filter(
		'wp_resource_hints',
		'pliska_resource_hints',
		10,
		2
	);
}

// load the fonts
function pliska_enqueue_fonts() {
	// Enter the URL of your Google Fonts generated from https://fonts.google.com/ here.
	$google_fonts_url = pliska_fonts_url();
	wp_enqueue_style(
		'pliska-fonts',
		$google_fonts_url,
		array(),
		PLISKA_VERSION
	);
}

add_action( 'wp_enqueue_scripts', 'pliska_enqueue_fonts' );
// load fonts asynchronously
function pliska_add_stylesheet_attributes_to_fonts( $html, $handle ) {
	if ( 'pliska-fonts' === $handle ) {
		return str_replace( "rel='stylesheet'", "rel='stylesheet' media=\"print\" onload=\"this.media='all'\"", $html );
	}
	return $html;
}

add_filter(
	'style_loader_tag',
	'pliska_add_stylesheet_attributes_to_fonts',
	10,
	2
);
function pliska_social_posts_share() {
	$social_share = get_theme_mod( 'show_post_share_btns', 1 );

	if ( $social_share || is_customize_preview() ) {
		global  $post;
		$pin_image = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
		?>
		<span class="post-share-wrap
		<?php
		echo pliska_add_customizer_class( $social_share );
		?>
		">
			<span class="post-share">
				<span class="screen-reader-text">
				<?php
				echo esc_html__( 'Share this post on: ', 'pliska' );
				?>
		</span>
				<a aria-label="<?php _e('facebook', 'pliska')?>" title="<?php _e('Share this post on Facebook', 'pliska')?>" target="_blank" href="
				<?php
				echo esc_url( 'https://www.facebook.com/sharer/sharer.php?u=' . get_the_permalink() );
				?>
		">
					<i class="share-icon">
						<?php
						echo wp_kses( pliska_get_svg( 'facebook' ), pliska_get_kses_extended_ruleset() );
						?>
					</i>
				</a>
				<a aria-label="<?php _e('twitter', 'pliska')?>" title="<?php _e('Share this post on Twitter', 'pliska')?>" href="
				<?php
				echo esc_url( 'http://twitter.com/intent/tweet?text=Currently reading ' . esc_html( get_the_title() ) . '&url=' . get_the_permalink() );
				?>
		" target="_blank" rel="noopener noreferrer">
					<i class="share-icon">
						<?php
						echo wp_kses( pliska_get_svg( 'twitter' ), pliska_get_kses_extended_ruleset() );
						?>
					</i>
				</a>
				<a aria-label="<?php _e('pinterest', 'pliska')?>" title="<?php _e('Share this post on Pinterest', 'pliska')?>" target="_blank" href="
				<?php
				echo esc_url( 'https://pinterest.com/pin/create/button/?url=' . get_the_permalink() . '&media=' . esc_url( $pin_image ) . '&description=' . esc_html( get_the_title() ) );
				?>
		">
					<i class="share-icon">
						<?php
						echo wp_kses( pliska_get_svg( 'pinterest' ), pliska_get_kses_extended_ruleset() );
						?>
					</i>
				</a>
				<a target="_blank" title="<?php _e('Share this post on Linkedin', 'pliska')?>" href="
				<?php
				echo esc_url( 'http://www.linkedin.com/shareArticle?mini=true&url=' . get_the_permalink() . '&title=' . esc_html( get_the_title() ) . '&source=' . get_bloginfo( 'name' ) );
				?>
		">
					<i class="share-icon">
						<?php
						echo wp_kses( pliska_get_svg( 'linkedin' ), pliska_get_kses_extended_ruleset() );
						?>
					</i>
				</a>
			</span>
		</span>
		<?php
	}

}

function pliska_auhor_box_markup() {
	$author_box = get_theme_mod( 'show_author_box', 1 );

	if ( $author_box || is_customize_preview() ) {
		?>
		<div class="about-author
		<?php
		echo pliska_add_customizer_class( $author_box );
		?>
		">
			<div class="about-author-image">
				<figure>
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 80 );?>
				</figure>
			</div>
			<div class="about-author-text">
				<h2>
					<?php echo esc_html( __( 'Author: ', 'pliska' ) ), esc_html( get_the_author_meta( 'display_name' ) );?>
				</h2>
				<?php echo wpautop( esc_html( get_the_author_meta( 'description' ) ) ); ?>
				<button class="read-more">
					<a href="<?php echo esc_html( get_author_posts_url( get_the_author_meta( 'ID' ) ) );?>">
						<?php _e( 'View all posts by', 'pliska' );?>
						<?php the_author();?>
					</a>
				</button>
			</div>
		</div>
		<?php
	}

}

/**
 * Related Posts
 * pll_current_language($value) - returns the current language on frontend (Polylang plugin).
 * $value - (optional) either name or locale or slug.
 * Defaults to slug.
 */
function pliska_display_related_posts() {
	$show_related_posts = get_theme_mod( 'show_related_posts', 1 );
	$default_related_post_image = get_theme_mod( 'image_control_one', esc_url(get_template_directory_uri()) . '/assets/img/240X180.jpg' );

	if ( $show_related_posts || is_customize_preview() ) {
		?>
		<?php $related = new WP_Query(
			array(
				'category__in'   => wp_get_post_categories( get_the_ID() ),
				'posts_per_page' => 3,
				'post__not_in'   => array( get_the_ID() ),
			)
		);

		if ( $related->have_posts() ) { ?>
		<div class="related-posts-wrapper
			<?php echo pliska_add_customizer_class( $show_related_posts );?>">        
			<h2><?php _e( 'Related Posts', 'pliska' );?></h2>
			<div class="related-posts">
				<?php
				while ( $related->have_posts() ) {
					$related->the_post();
					?>
				<div class="related-post">
					<?php

					if ( ! has_post_thumbnail() ) {
						echo '<a class="post-thumbnail" href="' . esc_url( get_the_permalink() ) . '" aria-hidden="true" tabindex="-1">' . '<figure><img alt="' . __( 'header image fallback', 'pliska' ) . '" src="' . esc_url($default_related_post_image) . '"/></figure></a>';
					} else {
						pliska_post_thumbnail( 'medium' );
					}

					?>
					<div class="related-posts-link">        
						<a rel="external" 
							href="<?php the_permalink();?>"><?php the_title();?>
						</a>        
					</div>
				</div>
					<?php
				}
				wp_reset_postdata();
				?>
			</div> 
		</div>
			<?php
		}
	}

}

/* Call To action buttons on Homepage */
function pliska_call_to_action() {
	$banner_label     = get_theme_mod( 'banner_label_one', __( 'Get Started', 'pliska' ) );
	$banner_link      = get_theme_mod( 'banner_link_one', '#' );
	$banner_label_two = get_theme_mod( 'banner_label_two', __( 'Contact Us', 'pliska' ) );
	$banner_link_two  = get_theme_mod( 'banner_link_two', '#' );
	?>

	<div class="header-buttons">
		<?php

		if ( $banner_label && $banner_link || is_customize_preview() ) {
			?>
			<a href="
			<?php
			echo esc_url( $banner_link );
			?>
		" class="left-btn
			<?php
			echo esc_attr( ( $banner_label && $banner_link ? '' : ' hide' ) );
			?>
		"><button class="btn">
			<?php
			echo esc_html( $banner_label );
			?>
		</button></a>
			<?php
		}

		if ( $banner_label_two && $banner_link_two || is_customize_preview() ) {
			?>
			<a href="
			<?php
			echo esc_url( $banner_link_two );
			?>
		" class="right-btn 
			<?php
			echo esc_attr( ( $banner_label_two && $banner_link_two ? '' : ' hide' ) );
			?>
		"><button class="btn">
			<?php
			echo esc_html( $banner_label_two );
			?>
		</button></a>
			<?php
		}

		?>
	</div>
	
	<?php
}

function pliska_meta_arrow() {
	$arrow = get_theme_mod( 'show_meta_arrow', 1 );

	if ( $arrow || is_customize_preview() ) {
		?>
		<div class="meta-arrow 
		<?php
		echo esc_attr( ( ! $arrow && is_customize_preview() ? 'hide' : '' ) );
		?>
		 ">
			<a href="#primary" aria-label="<?php _e('Skip to Content', 'pliska')?>"><span></span></a>
		</div>
		<?php
	}

}

/**
 * Add very simple breadcrumps to posts and pages
 *
 * @since v.0.0.1
 */
function pliska_breadcrumbs() {
	if ( is_front_page() || is_author() || is_home() || is_archive() || is_search() || is_404() ) {
		return;
	}
	if ( class_exists( 'WooCommerce' ) ) {
		if ( is_woocommerce() ) {
			return;
		}
	}

	if ( pliska_show_breadcrumbs() || is_customize_preview() ) {
		$customizer_class = ( ! pliska_show_breadcrumbs() && is_customize_preview() ? 'hide' : '' );
		?>

	<div class="breadcrumbs 
		<?php
		echo esc_attr( $customizer_class );
		?>
		" 
		<?php
		pliska_schema_microdata( 'breadcrumbs' );
		?>
		>
		<div>
			<a href="
		<?php
		echo esc_url( home_url() );
		?>
		">
				<span class="screen-reader-text">
			<?php
			_e( 'Home', 'pliska' );
			?>
		</span>
			<?php
			echo wp_kses( pliska_get_svg( 'home' ), pliska_get_kses_extended_ruleset() );
			?>
			</a>

			<?php

			if ( is_category() || is_single() ) {
				$categories = get_the_category();
				echo '&nbsp;&nbsp;&#62;&nbsp;&nbsp;';
				echo esc_html( $categories[0]->cat_name );
				if ( is_singular( 'post' ) ) {
					echo '&nbsp;&nbsp;', ( is_rtl() ? '&#60;' : '&#62;' ), '&nbsp;&nbsp;';
				}
				the_title();
			} elseif ( is_page() ) {
				echo '&nbsp;&nbsp;&#62;&nbsp;&nbsp;';
				echo the_title();
			}

			?>
		</div>
	</div>
			<?php
	}

}

/**
 * Back to top
 */
function pliska_back_to_top() {
	?>
	<a href="#" aria-label="<?php _e('Back to top', 'pliska')?>">
		<button id="back-to-top">
			<i class="arrow_carrot-2up">
				<?php
				echo wp_kses( pliska_get_svg( 'arrow-double-up' ), pliska_get_kses_extended_ruleset() );
				?>
			</i>
		</button>
	</a>
	<?php
}

/* Full Screen Search */
function pliska_full_screen_search() {
	?>
	<div id="search-open">
		<div class="search-box-wrap">
			<div class="header-search-form" role="search">
				<?php
				get_search_form();
				?>
			</div>
		</div>
		<a href="#search-close" class="close">
			<button class="close-btn" tabindex="-1" aria-label="<?php _e('close', 'pliska')?>">
			<?php
			echo wp_kses( pliska_get_svg( 'close' ), pliska_get_kses_extended_ruleset() );
			?>
	</button>
		</a>
	</div>
	<a href="#search-close" class="search-close"></a>
	<?php
}

// Print the social icons in theme footer
function pliska_social_icons() {
	$phone                    = get_theme_mod( 'phone_control', '' );
	$mail                     = get_theme_mod( 'mail_control', '' );
	$facebook_url             = get_theme_mod( 'facebook_url', '' );
	$instagram_url            = get_theme_mod( 'instagram_url', '' );
	$twitter_url              = get_theme_mod( 'twitter_url', '' );
	$youtube_url              = get_theme_mod( 'youtube_url', '' );
	$linkedin_url             = get_theme_mod( 'linkedin_url', '' );
	$social_icons_are_visible = ( $phone || $mail || $facebook_url || $twitter_url || $youtube_url || $linkedin_url ? true : false );
	if ( ! $social_icons_are_visible ) {
		return;
	}
	?>
	
	<ul class="social-icons">
	<?php
	pliska_phone( $phone );
	pliska_facebook( $facebook_url );
	pliska_instagram( $instagram_url );
	pliska_twitter( $twitter_url );
	pliska_youtube( $youtube_url );
	pliska_linkedin( $linkedin_url );
	pliska_email( $mail );
	?>

	</ul> <!--.social-icons--> 
	<?php
}

/**
 * Dark Mode Toggle Button Html markup
 * Inspired by Nathan Gath codepen
 * improved html markup to meet WCAG 2.0 guidelines
 *
 * @link https://codepen.io/nathangath/pen/qYeOJJ
 * @license MIT License
 **/
function pliska_dark_mode_button_markup() {
	?>
	<button aria-label="<?php _e('Click to toggle dark mode', 'pliska')?>" class="dark-mode-widget">
		<div class="theme-toggle"></div>
		<div><span></span></div>
	</button>
	<?php pliska_dark_mode_loader();
}

/**
 * Enable dark theme mode
 * Hook css and js right after the dark mode markup to avoid light flash of unstyled content.
 */
function pliska_dark_mode_loader() {
	?>
	<script>
	(function(){
		var switchers = document.getElementsByClassName('dark-mode-widget');
		for (var i = 0; i < switchers.length; i++) {
			var switcher = switchers[i];
			if (localStorage.getItem('pliskaNightMode')) {
				document.body.className +=' dark-mode';
				switcher.className += ' js-toggle--checked';
			}
			if (localStorage.getItem('pliskaLightMode')) {
				document.body.className = document.body.className.replace('dark-mode', '');
				switcher.className = switcher.className.replace('js-toggle--checked', '');
			}
			if(document.body.className.indexOf('dark-mode')> -1){
				switcher.className += ' js-toggle--checked';
			}
		}
	})();
	</script>
	<?php
}

/**
 * Facebook Open Graph Compatibility.
 *
 * @since 0.1.2
 * Display the featured post image as og:image on the single post page
 * @see   https://stackoverflow.com/questions/28735174/wordpress-ogimage-featured-image
 */
function pliska_fb_open_graph() {
	if ( is_single() && has_post_thumbnail() ) {
		echo '<meta property="og:image" content="' . esc_attr( get_the_post_thumbnail_url( get_the_ID() ) ) . '" />';
	}
}

add_action( 'wp_head', 'pliska_fb_open_graph' );