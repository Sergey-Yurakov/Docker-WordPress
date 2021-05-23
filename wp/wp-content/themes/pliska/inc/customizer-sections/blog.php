<?php
/**
 * Register Blog Settings Section in the theme customizer.
 *
 * @package pliska
 * @since 1.0.0
 */
function pliska_register_blog_theme_customizer( $wp_customize ) {
	$wp_customize->add_section(
		'blog_options',
		array(
			'title'       => esc_html__( 'Post Settings', 'pliska' ),
			'description' => esc_html__( 'Choose what type of post information to show in the post archives or individual blog posts. The post meta information includes published date, author, category tags or comments. You can display or remove this information if you want. You can also enable or disable breadcrumbs. Breadcrumbs are shown on single posts/pages only and can improve user experience by making it easier for your readers to navigate on the website.', 'pliska' ),
		)
	);
	/* Show categories entry meta */
	$wp_customize->add_setting(
		'show_post_categories',
		array(
			'default'           => 1,
			'sanitize_callback' => 'pliska_sanitize_checkbox',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'show_post_categories',
		array(
			'label'       => esc_html__( 'Show post categories', 'pliska' ),
			'description' => esc_html__( 'Show the categories, associated to the post.', 'pliska' ),
			'section'     => 'blog_options',
			'type'        => 'checkbox',
		)
	);

	/* Show Published date entry meta */
	$wp_customize->add_setting(
		'show_post_date',
		array(
			'default'           => 1,
			'sanitize_callback' => 'pliska_sanitize_checkbox',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'show_post_date',
		array(
			'label'       => esc_html__( 'Show post date', 'pliska' ),
			'description' => esc_html__( 'Show the published date of the post.', 'pliska' ),
			'section'     => 'blog_options',
			'type'        => 'checkbox',
		)
	);

	/* Show Published date entry meta */
	$wp_customize->add_setting(
		'show_modified_date',
		array(
			'default'           => 1,
			'sanitize_callback' => 'pliska_sanitize_checkbox',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'show_modified_date',
		array(
			'label'       => esc_html__( 'Show modified date', 'pliska' ),
			'description' => esc_html__( 'Show the last updated date of the post.', 'pliska' ),
			'section'     => 'blog_options',
			'type'        => 'checkbox',
		)
	);

	// show_time_to_read

	   /* Show Published date entry meta */
	$wp_customize->add_setting(
		'show_time_to_read',
		array(
			'default'           => 1,
			'sanitize_callback' => 'pliska_sanitize_checkbox',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'show_time_to_read',
		array(
			'label'       => esc_html__( 'Show time to read', 'pliska' ),
			'description' => esc_html__( 'Show the time needed to read the post.', 'pliska' ),
			'section'     => 'blog_options',
			'type'        => 'checkbox',
		)
	);

	/* Show Published author entry meta */
	$wp_customize->add_setting(
		'show_post_author',
		array(
			'default'           => 1,
			'sanitize_callback' => 'pliska_sanitize_checkbox',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'show_post_author',
		array(
			'label'       => esc_html__( 'Show post author', 'pliska' ),
			'description' => esc_html__( 'Show the published date of the post.', 'pliska' ),
			'section'     => 'blog_options',
			'type'        => 'checkbox',
		)
	);
	/* Show tags entry meta */
	$wp_customize->add_setting(
		'show_post_tags',
		array(
			'default'           => 1,
			'sanitize_callback' => 'pliska_sanitize_checkbox',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'show_post_tags',
		array(
			'label'       => esc_html__( 'Show post tags', 'pliska' ),
			'description' => esc_html__( 'Show the tags, associated to the post.', 'pliska' ),
			'section'     => 'blog_options',
			'type'        => 'checkbox',
		)
	);
	/* Show Post Comments */
	$wp_customize->add_setting(
		'show_post_comments',
		array(
			'default'           => 1,
			'sanitize_callback' => 'pliska_sanitize_checkbox',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'show_post_comments',
		array(
			'label'       => esc_html__( 'Show Comments', 'pliska' ),
			'description' => esc_html__( 'Display the number of comments.', 'pliska' ),
			'section'     => 'blog_options',
			'type'        => 'checkbox',
		)
	);
	/* Show or hide breadcrumbs */
	$wp_customize->add_setting(
		'show_breadcrumbs',
		array(
			'default'           => 1,
			'sanitize_callback' => 'pliska_sanitize_checkbox',
			'transport'         => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'show_breadcrumbs',
		array(
			'label'       => esc_html__( 'Show breadcrumbs on posts', 'pliska' ),
			'description' => esc_html__( 'Show simple breadcrumps on single posts', 'pliska' ),
			'section'     => 'blog_options',
			'type'        => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'show_page_breadcrumbs',
		array(
			'default'           => 1,
			'sanitize_callback' => 'pliska_sanitize_checkbox',
			'transport'         => 'postMessage'
		)
	);
	$wp_customize->add_control(
		'show_page_breadcrumbs',
		array(
			'label'       => esc_html__( 'Show breadcrumbs on pages', 'pliska' ),
			'description' => esc_html__( 'Show simple breadcrumps on pages', 'pliska' ),
			'section'     => 'blog_options',
			'type'        => 'checkbox',
		)
	);

	//Post likes
	$wp_customize->add_setting(
		'show_post_likes',
		array(
			'default'           => 1,
			'sanitize_callback' => 'pliska_sanitize_checkbox',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'show_post_likes',
		array(
			'label'       => esc_html__( 'Show post likes', 'pliska' ),
			'description' => esc_html__( 'Show number of post likes for each post.', 'pliska' ),
			'section'     => 'blog_options',
			'type'        => 'checkbox',
		)
	);

	//Post share buttons
	$wp_customize->add_setting(
		'show_post_share_btns',
		array(
			'default'           => 1,
			'sanitize_callback' => 'pliska_sanitize_checkbox',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'show_post_share_btns',
		array(
			'label'       => esc_html__( 'Show post share butons', 'pliska' ),
			'description' => esc_html__( 'Show post share butons on single blog posts', 'pliska' ),
			'section'     => 'blog_options',
			'type'        => 'checkbox',
		)
	);

	//Show author box
	$wp_customize->add_setting(
		'show_author_box',
		array(
			'default'           => 1,
			'sanitize_callback' => 'pliska_sanitize_checkbox',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'show_author_box',
		array(
			'label'       => esc_html__( 'Show post author box', 'pliska' ),
			'description' => esc_html__( 'Display post author box after post content on single blog posts', 'pliska' ),
			'section'     => 'blog_options',
			'type'        => 'checkbox',
		)
	);

	//Related posts
	$wp_customize->add_setting(
		'show_related_posts',
		array(
			'default'           => 1,
			'sanitize_callback' => 'pliska_sanitize_checkbox',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'show_related_posts',
		array(
			'label'       => esc_html__( 'Show related posts', 'pliska' ),
			'description' => esc_html__( 'Display related posts after post content on single blog posts', 'pliska' ),
			'section'     => 'blog_options',
			'type'        => 'checkbox',
		)
	);

	//Related Posts default img url

    $wp_customize->add_setting('image_control_one', array(
        'default' => esc_url(get_template_directory_uri()) . '/assets/img/240X180.jpg',
        'section' => 'blog_options',
        'sanitize_callback' => 'pliska_sanitize_image',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_control_one', 
		array(
			'label' => __('Related post default image', 'pliska'),
			'section' => 'blog_options',
			'description' => esc_html__( 'A default thumbnail is displayed as a fallback image, when the related post does not have a featured image. If the post has a featured image, the featured image will be displayed instead. Recommended size: 300X225px', 'pliska' ),
			'type' => 'image',
		))
    );

}

add_action( 'customize_register', 'pliska_register_blog_theme_customizer' );