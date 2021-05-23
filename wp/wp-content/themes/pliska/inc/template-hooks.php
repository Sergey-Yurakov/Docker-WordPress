<?php 

//Primary Menu hook
add_action( 'pliska_primary_menu_hook', 'pliska_primary_menu' );

// Header image hook
add_action( 'pliska_header_image_hook', 'pliska_header_title', 100 );

// Header meta data before title hooks in single.php
add_action( 'pliska_header_before_title_meta_hook', 'pliska_posted_in', 10 );

// Header meta data after title hooks in single.php
add_action( 'pliska_header_after_title_meta_hook', 'pliska_posted_on', 20 );
add_action( 'pliska_header_after_title_meta_hook', 'pliska_updated_on', 30 );
add_action( 'pliska_header_after_title_meta_hook', 'pliska_blog_read_time', 40 );
add_action( 'pliska_header_after_title_meta_hook', 'pliska_posted_by', 60 );

//Meta data after post content in single.php
add_action( 'pliska_entry_footer_meta_hook', 'pliska_entry_footer', 10 );

// Before title hook on post archives
add_action('pliska_header_before_post_archives_hook', 'pliska_posted_on', 10);
add_action('pliska_header_before_post_archives_hook', 'pliska_updated_on', 20);
//After title hook on post archives
add_action('pliska_header_after_post_archives_hook', 'pliska_posted_by', 20);
add_action('pliska_header_after_post_archives_hook', 'pliska_blog_read_time', 30);
add_action('pliska_header_after_post_archives_hook', 'pliska_edit_link', 40);
//Entry Footer hook on post archives
add_action('pliska_entry_footer_post_archives_hook', 'pliska_entry_footer', 10);
if (function_exists('pliska_ajax_post_likes')) {
    add_action('pliska_entry_footer_post_archives_hook', 'pliska_ajax_post_likes', 20);
}

// Call to acton
add_action( 'pliska_call_to_action_hook', 'pliska_call_to_action');
// Meta arrow in the Header
add_action( 'pliska_meta_arrow_hook', 'pliska_meta_arrow', 10);
add_action( 'pliska_meta_arrow_hook', 'pliska_breadcrumbs', 20);

// Back to top
add_action( 'pliska_back_to_top_hook', 'pliska_back_to_top');

//Full-width header search
add_action('pliska_full_screen_search_hook', 'pliska_full_screen_search');

// Pagination
add_action( 'pliska_pagination_hook', 'pliska_numeric_posts_nav' );

//Social Icons
add_action( 'pliska_social_icons_hook', 'pliska_social_icons' );

// Footer credits
add_action ('pliska_theme_footer_credits_hook','pliska_footer_default_theme_credits');
add_action('pliska_theme_footer_custom_credits_hook', 'pliska_footer_custom_theme_credits');

// Dark Mode mobile hook
add_action ('pliska_dark_mode_mobile_hook','pliska_dark_mode_button_markup');