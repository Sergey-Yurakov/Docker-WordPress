<?php

require plugin_dir_path(__FILE__) . 'class-shop-page-wp-grid.php';

/**
 * Class Shop_Page_WP_Shortcode
 */
class Shop_Page_WP_Shortcode
{

    /**
     * Link grid to 'add_shortcode' function
     */
    public static function activate_shortcode()
    {

        add_shortcode('shop-page-wp', array('Shop_Page_WP_Shortcode', 'shortcode_attributes'));
    }

    public static function shortcode_attributes($atts)
    {
        $attributes = shortcode_atts(array(
            'category' => '',
            'grid' => '',
            'max_number' => '',
            'id' => '',
        ), $atts);

        $grid_content = Shop_Page_WP_Grid::return_grid($attributes);

        return $grid_content;
    }
}
