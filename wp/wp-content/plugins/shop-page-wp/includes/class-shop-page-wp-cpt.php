<?php

/**
 * Class Shop_Page_WP_CPT
 */
class Shop_Page_WP_CPT
{
    /**
     * Static Function create_post_type
     */
    public static function create_post_type()
    {
        register_post_type('shop-page-wp',

            array(
                'menu_position' => 4,
                'exclude_from_search' => true,
                'labels' => array(
                    'name' => esc_html__('Shop Page WP'),
                    'singular_name' => esc_html__('Shop Page WP'),
                    'add_new' => esc_html__('Add New Product'),
                    'add_new_item' => esc_html__('Add New Product'),
                    'edit_item' => esc_html__('Edit Product'),
                    'new_item' => esc_html__('New Product'),
                    'all_items' => esc_html__('All Products'),
                    'view_item' => esc_html__('View Product'),
                    'search_items' => esc_html__('Search Products'),
                    'not_found' => esc_html__('No Products found'),
                    'not_found_in_trash' => esc_html__('No Product found in Trash'),
                    'parent_item_colon' => '',
                    'menu_name' => 'Shop Page WP',
                ),
                'public' => true,
                'publicly_queryable' => false,
                'menu_icon' => 'dashicons-cart',
                '_builtin' => false,
                'rewrite' => array('slug' => 'shop-page'),
                'has_archive' => true,
                'supports' => array('title', 'thumbnail'),
                'taxonomies' => array('category'),
            )
        );
    }

    public static function add_id_column()
    {
        add_filter('manage_shop-page-wp_posts_columns', 'add_id_column');
        function add_id_column($columns)
        {
            $new_array = array();
            $count = 0;
            foreach ($columns as $key => $item) {
                if ($count == 2) {
                    $new_array['id'] = __('Product ID', 'shop-page-wp');
                    $new_array[$key] = $item;
                } else {
                    $new_array[$key] = $item;
                }
                $count++;
            }
            return $new_array;
        }
    }

    public static function add_id_value()
    {
        add_action('manage_shop-page-wp_posts_custom_column', 'get_product_id', 10, 2);

        function get_product_id($column, $post_id)
        {
            echo $post_id;
        }
    }
}
