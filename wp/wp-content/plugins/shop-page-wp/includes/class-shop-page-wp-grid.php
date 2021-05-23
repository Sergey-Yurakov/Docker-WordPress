<?php

/**
 * Class Shop_Page_WP_Grid
 * query data and create grid
 */
class Shop_Page_WP_Grid
{

    /**
     * @param $content
     * @param $length
     * @param string $suffix
     *
     * @return string
     */

    public static function parseAmazonURL($url)
    {
        $matches1 = [];
        $matches2 = [];
        preg_match('/href="([^"]*)"/i', $url, $matches1);
        preg_match('/src="([^"]*)"/i', $url, $matches2);
        if (isset($matches1[1]) && isset($matches2[1])) {
            return [$matches1[1], $matches2[1]];
        }
        return false;
    }

    /**
     * @param $attributes
     * $attributes array can come from shortcode or widget settings
     *
     * @return string
     */
    public static function return_grid($attributes)
    {

        /**
         * Get saved settings data
         */
        if (!($button_text = get_option('shop-page-wp-button-text'))) {
            $button_text = esc_html__('Buy Now', 'shop-page-wp');
        }
        $columns_array = get_option('shop-page-wp-show-default-columns');
        if (!($number_of_columns = $columns_array['column_options'])) {
            $number_of_columns = 3;
        }

        /**
         * Get grid size from attributes
         */
        if (!$attributes['grid']) {
            if ($number_of_columns) {
                $attributes['grid'] = $number_of_columns;
            }
        }

        /**
         * @todo instead of doing math here, instead assign different class names
         * so media queries can be used. Switching to width instead of flex-basis for inline css
         * to make it work on IE 11?
         */
        if ($attributes['grid']) {
            if ($attributes['grid'] == 1) {
                //$grid_width = 100;
                $class_name = 'spwp-full-width';
            } elseif ($attributes['grid'] == 2) {
                //$grid_width = 50;
                $class_name = 'spwp-one-half';
            } elseif ($attributes['grid'] == 4) {
                //$grid_width = 25;
                $class_name = 'spwp-one-fourth';
            } else {
                //$grid_width = 33.3;
                $class_name = 'spwp-one-third';
            }
        } else {
            $class_name = 'spwp-one-third';
            //$grid_width = 33.3;
        }

        /**
         * Max Products to display
         */
        if (isset($attributes['max_number']) && ($attributes['max_number'] != '')) {
            $posts_per_page_max = intval($attributes['max_number']);
        } else {
            $posts_per_page_max = -1;
        }

        /**
         * Set $args for custom post type query
         */
        // default product array
        $args = array(
            'post_type' => 'shop-page-wp',
            'posts_per_page' => $posts_per_page_max,
        );
        // product ID or Category field is set
        if (isset($attributes['id']) && ($attributes['id'] != '')) {
            $id_array = array();
            $input_string = str_replace('|', ',', $attributes['id']);
            $id_explode = explode(',', $input_string);
            foreach ($id_explode as $id) {
                $id_array[] = $id;
            }
            $args = array(
                'post_type' => 'shop-page-wp',
                'post__in' => $id_array,
            );
        } elseif (isset($attributes['category']) && ($attributes['category'] != '')) {
            $cat_array = array();
            $input_string = str_replace('|', ',', $attributes['category']);
            $cat_explode = explode(',', $input_string);
            foreach ($cat_explode as $cat) {
                $cat_object = get_category_by_slug($cat);
                if ($cat_object) {
                    $cat_id = $cat_object->term_id;
                    $cat_array[] = $cat_id;
                } else {
                    // Add non-existant category to array if none exist
                    // This is done so no products show
                    $cat_array[] = 11111111111;
                }
            }
            $args = array(
                'post_type' => 'shop-page-wp',
                'category__in' => $cat_array,
                'posts_per_page' => $posts_per_page_max,
            );
        }

        /**
         * WordPress Query
         */
        $products = array();
        $shop_page_wp_query = new WP_Query($args);
        if ($shop_page_wp_query->have_posts()) {
            while ($shop_page_wp_query->have_posts()) {
                $shop_page_wp_query->the_post();
                $title = get_the_title();
                $prefix = '_Shop_Page_WP_';
                /**
                 * Check which type of product
                 */
                $type_field = $prefix . 'type';
                $type = get_post_meta(get_the_ID(), $type_field, true);

                if ($type == 2) {
                    /**
                     * Get Amazon Affiliate embed code
                     */
                    $amazon_field = $prefix . 'amazon-embed';
                    $amazon = get_post_meta(get_the_ID(), $amazon_field, true);
                    $matches = self::parseAmazonURL($amazon);

                    if ($matches) {
                        $link = $matches[0];
                        $image_url_final = 'https:' . $matches[1];
                    } else {
                        //die('no match - try skipping?');
                        continue;
                    }

                } else {
                    /**
                     * Get URL field (if no embed code)
                     */
                    $url_field = $prefix . 'url';
                    if (!($link = get_post_meta(get_the_ID(), $url_field, true))) {
                        $link = false;
                    }
                    /**
                     * Get Featured Image (if no embed code)
                     */
                    $image_id = get_post_thumbnail_id();
                    if (has_post_thumbnail()) {
                        $image_url = wp_get_attachment_image_src($image_id, 'shop-page-wp-product', true);
                        $image_url_final = $image_url[0];

                        $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);

                    } else {
                        $image_url_final = plugins_url('../assets/img/product-image-placeholder.png', __FILE__);
                    }

                }

                /**
                 * Get Description Field
                 */
                $description_field = $prefix . 'description';
                $description = get_post_meta(get_the_ID(), $description_field, true);

                /**
                 * Get Custom Button Text
                 */
                $button_custom = false;
                $button_text_field = $prefix . 'button-text';
                if ($button_text_new = get_post_meta(get_the_ID(), $button_text_field, true)) {
                    $button_custom = true;
                }
                $products[] = array(
                    'title' => $title,
                    'img_url' => $image_url_final,
                    'img_alt' => $alt_text,
                    'link' => $link,
                    'description' => $description,
                    'button_text' => $button_custom ? $button_text_new : $button_text,
                );
            }
        }
        wp_reset_postdata();

        ob_start();?>

        <script>
            function openUrlInNewTab(url) {
                var win = window.open(url, '_blank');
                win.focus();
            }
            function openUrlInSameTab(url) {
                var win = window.open(url, '_self');
                win.focus();
            }
        </script>
        <div class="shop-page-wp-grid">
			<?php foreach ($products as $product) {
            if (get_option('shop-page-wp-link-target') === "2") {

                /**
                 * @todo refactor this to be more dry
                 * @todo only use flex-basis if the grid is not just 1?
                 * @todo - this is not working for IE 11... flex-basis auto !important?
                 */
                ?>

					<div onclick="openUrlInSameTab('<?php echo $product['link']; ?>');" class="shop-page-wp-item <?php echo $class_name; ?>">

				<?php } else {?>

					<div onclick="openUrlInNewTab('<?php echo $product['link']; ?>');" class="shop-page-wp-item <?php echo $class_name; ?>">

				<?php }?>

                        <div class="shop-page-wp-image">
                            <img src="<?php echo $product['img_url']; ?>" alt="<?php echo $product['img_alt']; ?>"/>
                        </div>
                        <div class="shop-page-wp-title">
                            <h3><?php echo $product['title']; ?></h3>
                        </div>
						<?php if ($product['description']) {?>
                            <div class="shop-page-wp-description">
								<?php echo $product['description']; ?>
                            </div>
						<?php }?>
						<?php if ($product['link']) {?>
                            <div class="shop-page-wp-link">
								<a style="pointer-events: none;" class="buy-link" href="<?php echo $product['link']; ?>" rel="nofollow">
									<?php echo $product['button_text']; ?>
								</a>
                            </div>
						<?php } else {?>
                            <div class="shop-page-wp-link">
                                <a class="buy-link disabled">
	                                <?php echo $product['button_text']; ?>
                                </a>
                            </div>
						<?php }?>
                    </div>
			<?php }?>
        </div>
		<?php
$content = ob_get_clean();

        return $content;
    }
}
