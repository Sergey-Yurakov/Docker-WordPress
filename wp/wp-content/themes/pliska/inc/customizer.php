<?php

/**
 * Theme Customizer
 *
 * @package pliska
 * @since 0.0.1
 */
/**
 * Custom Sanitization Functions
 *
 * @link https://developer.wordpress.org/themes/theme-security/data-sanitization-escaping/
 */
/* Helper Functions */
require get_template_directory() . '/inc/customizer-helper.php';
/* Call Custom Sanitization Functions */
require get_template_directory() . '/inc/sanitization-functions.php';

// Customizer sections
require get_template_directory() . '/inc/customizer-sections/go-pro.php';
require get_template_directory() . '/inc/customizer-sections/colors.php';
require get_template_directory() . '/inc/customizer-sections/header-options.php';
require get_template_directory() . '/inc/customizer-sections/blog.php';
require get_template_directory() . '/inc/customizer-sections/fonts.php';
require get_template_directory() . '/inc/customizer-sections/layout.php';
require get_template_directory() . '/inc/customizer-sections/dark-mode.php';
require get_template_directory() . '/inc/customizer-sections/social-icons.php';
require get_template_directory() . '/inc/customizer-sections/footer.php';
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function pliska_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}
	$wp_customize->selective_refresh->add_partial(
		'blogname',
		array(
			'selector'        => '.site-title a',
			'render_callback' => 'pliska_customize_partial_blogname',
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'blogdescription',
		array(
			'selector'        => '.site-description',
			'render_callback' => 'pliska_customize_partial_blogdescription',
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'banner_label_one',
		array(
			'selector'         => '.left-btn',
			'fallback_refresh' => false,
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'banner_link_one',
		array(
			'selector'         => '.left-btn',
			'fallback_refresh' => false,
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'banner_label_two',
		array(
			'selector'         => '.right-btn',
			'fallback_refresh' => false,
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'banner_link_two',
		array(
			'selector'         => '.right-btn',
			'fallback_refresh' => false,
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'show_meta_arrow',
		array(
			'selector'         => '.meta-arrow',
			'render_callback'  => '__return_false',
			'fallback_refresh' => false,
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'show_post_categories',
		array(
			'selector'         => '.cat-links',
			'render_callback'  => '__return_false',
			'fallback_refresh' => false,
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'show_post_date',
		array(
			'selector'         => '.posted-on',
			'render_callback'  => '__return_false',
			'fallback_refresh' => false,
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'show_modified_date',
		array(
			'selector'         => '.updated-on',
			'render_callback'  => '__return_false',
			'fallback_refresh' => false,
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'show_time_to_read',
		array(
			'selector'         => '.time-read-links',
			'render_callback'  => '__return_false',
			'fallback_refresh' => false,
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'show_post_author',
		array(
			'selector'         => '.byline',
			'render_callback'  => '__return_false',
			'fallback_refresh' => false,
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'show_post_tags',
		array(
			'selector'         => '.tags-links',
			'render_callback'  => '__return_false',
			'fallback_refresh' => false,
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'show_post_comments',
		array(
			'selector'         => '.comments-link',
			'render_callback'  => '__return_false',
			'fallback_refresh' => false,
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'show_post_likes',
		array(
			'selector'         => '.user_like',
			'render_callback'  => '__return_false',
			'fallback_refresh' => false,
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'show_post_share_btns',
		array(
			'selector'         => '.post-share-wrap',
			'render_callback'  => '__return_false',
			'fallback_refresh' => false,
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'show_author_box',
		array(
			'selector'         => '.about-author',
			'render_callback'  => '__return_false',
			'fallback_refresh' => false,
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'show_related_posts',
		array(
			'selector'         => '.related-posts-wrapper',
			'render_callback'  => '__return_false',
			'fallback_refresh' => false,
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'show_breadcrumbs',
		array(
			'selector'            => '.breadcrumbs',
			'container_inclusive' => true,
			'fallback_refresh'    => false,
			'render_callback'     => '__return_false',
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'show_page_breadcrumbs',
		array(
			'selector'            => '.breadcrumbs',
			'fallback_refresh'    => false,
			'container_inclusive' => true,
			'render_callback'     => '__return_false',
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'enable_dark_mode',
		array(
			'selector'         => '.dark-mode-menu-item',
			'render_callback'  => '__return_false',
			'fallback_refresh' => false,
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'phone_control',
		array(
			'selector'            => '.phone',
			'container_inclusive' => true,
			'render_callback'     => 'pliska_phone_partial',
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'facebook_url',
		array(
			'selector'            => '.facebook',
			'container_inclusive' => true,
			'render_callback'     => 'pliska_facebook_partial',
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'instagram_url',
		array(
			'selector'            => '.instagram',
			'container_inclusive' => true,
			'render_callback'     => 'pliska_instagram_partial',
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'twitter_url',
		array(
			'selector'            => '.twitter',
			'container_inclusive' => true,
			'render_callback'     => 'pliska_twitter_partial',
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'youtube_url',
		array(
			'selector'            => '.youtube',
			'container_inclusive' => true,
			'render_callback'     => 'pliska_youtube_partial',
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'linkedin_url',
		array(
			'selector'            => '.linkedin',
			'container_inclusive' => true,
			'render_callback'     => 'pliska_linkedin_partial',
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'mail_control',
		array(
			'selector'            => '.email',
			'container_inclusive' => true,
			'render_callback'     => 'pliska_mail_partial',
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'footer_text_block',
		array(
			'selector'        => '.site-info',
			'render_callback' => 'pliska_custom_footer_credits_partial',
		)
	);
}

add_action( 'customize_register', 'pliska_customize_register' );
/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function pliska_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function pliska_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 *
 * Render Header buttons for the selective refresh partial
 */
function pliska_customize_partial_banner_label_one() {
	$banner_label = get_theme_mod( 'banner_label_one', __( 'Get Started', 'pliska' ) );
	$banner_link  = get_theme_mod( 'banner_link_one', '#' );

	if ( $banner_label && $banner_link ) {
		?>
		<a href="
		<?php
		echo esc_url( $banner_link );
		?>
		" class="left-btn"><button class="btn">
		<?php
		echo esc_html( $banner_label );
		?>
		</button></a>
		<?php
	}

}

function pliska_customize_partial_banner_label_two() {
	$banner_label_two = get_theme_mod( 'banner_label_two', __( 'Contact Us', 'pliska' ) );
	$banner_link_two  = get_theme_mod( 'banner_link_two', '#' );

	if ( $banner_label_two && $banner_link_two ) {
		?>
		<a href="
		<?php
		echo esc_url( $banner_link_two );
		?>
		" class="right-btn"><button class="btn">
		<?php
		echo esc_html( $banner_label_two );
		?>
		</button></a>
		<?php
	}

}

/**
 * Social icons selective refresh partials
 */
function pliska_phone_partial() {
	$phone = get_theme_mod( 'phone_control', '' );
	pliska_phone( $phone );
}

function pliska_facebook_partial() {
	$url = get_theme_mod( 'facebook_url', '#' );
	pliska_facebook( $url );
}

function pliska_instagram_partial() {
	$url = get_theme_mod( 'instagram_url', '#' );
	pliska_instagram( $url );
}

function pliska_twitter_partial() {
	 $url = get_theme_mod( 'twitter_url', '#' );
	pliska_twitter( $url );
}

function pliska_linkedin_partial() {
	$url = get_theme_mod( 'linkedin_url', '#' );
	pliska_twitter( $url );
}

function pliska_youtube_partial() {
	 $url = get_theme_mod( 'linkedin_url', '#' );
	pliska_twitter( $url );
}

function pliska_mail_partial() {
	$mail = get_theme_mod( 'mail_control', '#' );
	pliska_email( $mail );
}

/* Footer Credits selective refresh partial */
function pliska_custom_footer_credits_partial() {
	do_action( 'pliska_theme_footer_custom_credits_hook' );
	do_action( 'pliska_theme_footer_credits_hook' );
}

/**
 * Binds JS handlers and CSS code to make Theme Customizer preview reload changes asynchronously.
 */
function pliska_customize_preview_js() {
	wp_enqueue_script(
		'pliska-customizer',
		get_template_directory_uri() . '/assets/js/customizer.min.js',
		array( 'customize-preview' ),
		PLISKA_VERSION,
		true
	);
	wp_enqueue_style(
		'pliska-customizer',
		get_template_directory_uri() . '/assets/css/customizer.css',
		array( 'customize-preview' ),
		PLISKA_VERSION
	);
}

add_action( 'customize_preview_init', 'pliska_customize_preview_js' );