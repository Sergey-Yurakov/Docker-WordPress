<?php

/**
 * Class Shop_Page_WP_Instructions
 */
class Shop_Page_WP_Pro
{

    public static function activate_admin()
    {
        add_action('admin_menu', array('Shop_Page_WP_Pro', 'activate_submenu_page'));
    }

    public static function activate_submenu_page()
    {

        add_submenu_page(
            'edit.php?post_type=shop-page-wp', // string $parent_slug
            'Pro Features', // string $page_title,
            'Pro Features', // string $menu_title,
            'manage_options', // string $capability
            'shop-page-wp-pro', // string $menu_slug
            array('Shop_Page_WP_Pro', 'output_admin_page')
        );
    }

    public static function output_admin_page()
    {?>
		<div class="wrap">
			<style>
				.shortcode-guide h2 {
					margin-top: 30px;
                    font-size: 24px;
                    margin-bottom: 13px;
				}
				.shortcode-guide .shortcode {
					font-size: 1.6em;
					line-height: 50px;
					color: #222;
				}
				.shortcode-guide .explanation {
					color: #777;
					font-size: 1.1em;
					margin-bottom: 10px;
				}
                .support-links {
                    margin-top: 20px;
                    font-size: 16px;
                }
                .support-links a {
                    font-size: 16px;
                }
			</style>
			<h1><?php esc_html_e(Shop_Page_WP_Name . ' Instructions', 'shop-page-wp');?></h1>

            <div class="support-links">
                <a href="https://shoppagewp.com/documentation/" target="_blank">Documentation</a> | <a href="https://shoppagewp.com/faq/" target="_blank">FAQ</a> | <a href="https://wordpress.org/support/plugin/shop-page-wp" target="_blank">Support</a>
            </div>

			<div class="shortcode-guide">

				<h2><?php esc_html_e('Gutenberg Usage', 'shop-page-wp');?></h2>

				<?php $gutenberg_settings_line_1 = esc_html__('Insert a Shop Page WP product grid in the Gutenberg editor by clicking on the "+" to Add block. Either search for "Shop Page" or scroll to the widgets block category and select the Shop Page WP block.', 'shop-page-wp');?>

				<?php $gutenberg_settings_line_2 = esc_html__('The settings for number of columns, categories to display and maximum number of products to display are optional. If left blank, all products will display in the grid.', 'shop-page-wp');?>

				<?php $gutenberg_settings_line_3 = esc_html__('To display categories separately on the page; add multiple blocks and insert a heading with the desired text above each.', 'shop-page-wp');?>

				<div class="explanation"><?php echo $gutenberg_settings_line_1; ?></div>

				<div class="explanation"><?php echo $gutenberg_settings_line_2; ?></div>

				<div class="explanation"><?php echo $gutenberg_settings_line_3; ?></div>

				<h2><?php esc_html_e('Shortcode Usage', 'shop-page-wp');?></h2>

				<div class="shortcode">[shop-page-wp]</div>

				<div class="explanation"><?php esc_html_e('Default shortcode. This will output a grid with every product you\'ve added.', 'shop-page-wp');?></div>

				<div class="shortcode">[shop-page-wp category='Electronics']</div>

				<div class="explanation"><?php esc_html_e('Show only products from one category. You may use either the category slug or the category name.', 'shop-page-wp');?></div>

				<div class="shortcode">[shop-page-wp category='Electronics,Games,New Products']</div>

        				<div class="explanation"><?php esc_html_e('Default shortcode. This will output a grid with every product you\'ve added.', 'shop-page-wp');?></div>

				<div class="shortcode">[shop-page-wp id='17']</div>

				<div class="explanation"><?php esc_html_e('Show only the product with ID equal to 17.', 'shop-page-wp');?></div>

				<div class="shortcode">[shop-page-wp id='17,18,19']</div>

				<div class="explanation"><?php esc_html_e('Show specific products by ID (separated by a comma).', 'shop-page-wp');?></div>

				<div class="shortcode">[shop-page-wp grid='3']</div>

				<div class="explanation"><?php esc_html_e('Specify grid size (will override default settings). Options are 1, 2, 3 or 4.', 'shop-page-wp');?></div>

				<div class="shortcode">[shop-page-wp max_number='2']</div>

				<div class="explanation"><?php esc_html_e('Specify max number of products to show. Options are any integer', 'shop-page-wp');?></div>

				<h2><?php esc_html_e('Changing Image Sizes', 'shop-page-wp');?></h2>

				<?php $image_settings_string = esc_html__('This plugin sets a custom image size of 300 x 300 pixels. After installing this plugin (or after changing the image size in settings) you must', 'shop-page-wp') . ' <a href="https://wordpress.org/plugins/regenerate-thumbnails/" target="_blank">' . esc_html__('regenerate thumbnails', 'shop-page-wp') . '</a> ' . esc_html__('to create appropriately sized thumbnails for each of your product images. This will not be necessary for new images you upload while the plugin is installed and active.', 'shop-page-wp');?>

				<div class="explanation"><?php echo $image_settings_string; ?></div>

				<h2><?php esc_html_e('Use in Widgets', 'shop-page-wp');?></h2>

				<?php $widget_settings_string = esc_html__('To add products to a widget area just drag the Shop Page WP widget into a Widget Area. You can then set the number of columns and categories (separated by a comma) or else specify which products should appear with one or more product IDs (separated by a comma), and optionally add a title for the widget section.', 'shop-page-wp');?>

				<div class="explanation"><?php echo $widget_settings_string; ?></div>

			</div>
		</div>
	<?php }
}
