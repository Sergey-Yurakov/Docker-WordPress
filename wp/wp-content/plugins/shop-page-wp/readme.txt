=== Shop Page WP ===
Contributors: leonmagee, justinmw
Donate link: https://shoppagewp.com/donate
Tags: shop, affiliate, store, amazon, amazon affiliates, amazon associates
Requires at least: 3.0.1
Tested up to: 5.5
Stable tag: 1.2.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


Create an affiliate shop page on your website. Simple to setup and add products to start making money from affiliate links on your blog.

== Description ==

Shop Page WP is the affiliate shop page plugin for your WordPress website that everyone can easily setup and use. It’s super easy to create a shop page and start adding products immediately. No technical or special skills required. Output a beautiful grid of products and place it on a shop page, or insert specific products to a blog post.

Have you ever wanted to add a shop page to your website but didn’t want to build it manually or use a plugin that is overkill for what you are trying to do? Shop Page WP is the simple solution for creating an affiliate shop page on your blog.


= Features =

* Create a simple shop page on your website with a grid of products.
* Simple fields: Just add the product title, optional description, affiliate link, upload a product image as the featured image and specify a category.
* The plugin will automatically resize and or crop your product images to a specified size.
* Choose between a 1, 2, 3 or 4 column product grid.
* Customize the ‘Buy Now’ button text for individual products.
* Categorize Products.
* Add affiliate products to your page, post or sidebar by category or product ID.
* Add affiliate products to your page or sidebar by category
* Use any affiliate link (Amazon, ShareASale, RewardStyle, Ebay, CJ, etc.).
* Product links open in a new tab and are set as rel=nofollow.
* Customize the product image size in the plugin settings.
* Gutenberg block for adding a product grid to pages and posts with the ability to specify categories, columns, and maximum number of products to display or even specific products.
* Simple shortcodes available for adding the affiliate product shop to any page or post on your website.
* Custom shortcodes for adding specific categories or products to a shop page section.
* Option to remove CSS styling if you wish to style it yourself.
* Responsive and mobile friendly.

= Insert Products with Gutenberg =

From the Gutenberg editor; click Add Block then either search for Shop Page WP or scroll to the Widgets category and click "Shop Page WP."

= Insert Products by Shortcode =

Default Shortcode

`[shop-page-wp]`

Specify Product Category

`[shop-page-wp category='food']`

Specify Multiple Categories (separated by comma)

`[shop-page-wp category='food,electronics']`

Specify Product ID (will override categories)

`[shop-page-wp id='17']`

Specify Multiple IDs (separated by comma)

`[shop-page-wp id='17,18']`

Specify Grid Size (will override default settings)

`[shop-page-wp grid='3']`

= Changing Image Sizes =

This plugin sets a custom image size of 300 x 300 pixels. After installing this plugin (or after changing the image size in settings) you must regenerate thumbnails to create appropriately sized thumbnails for each of your product images. This will not be necessary for new images you upload while the plugin is installed and active.

*** if you are using already uploaded images, you will need to regenerate thumbnails

This plugin is in active development. Feel free to contact us with any feature requests or ideas.

<a href="https://shoppagewp.com/documentation/">View More Documentation</a>


== Installation ==

Automatic installation

Automatic installation is the quickest and least technical way to get Shop Page WP installed.
Go to your Wordpress admin area and select Plugins -> Add new from the menu.
Search for "Shop Page WP”.
Click “Install Now”.
Click “Activate”.

Manual installation

Manually installing the Shop Page WP plugin requires that you download the zip file from the Wordpress

Unzip the plugin archive on your computer.
Upload shop-page-wp directory to the /wp-content/plugins/ directory via FTP.
Activate the plugin through the 'Plugins' menu in WordPress
Go to Shop Page WP in your Wordpress dashboard to begin adding products.

== Frequently Asked Questions ==

= Where can I find setup instructions and documentation? =
You can view all the documentation on the plugin’s website, at <a href="https://shoppagewp.com/documentation/">shoppagewp.com/documentation</a>.
= What kind of affiliate links can I use? =
You can use any link you wish, it doesn’t even have to be an affiliate link.
= Where can I get support? =
You can submit questions on the <a href="https://wordpress.org/support/plugin/shop-page-wp">plugin’s support page</a> on Wordpress.org, or you can read more documentation on <a href="https://shoppagewp.com/documentation">shoppagewp.com</a>.
= Will Shop Page WP slow my site down? =
Shop Page WP is lightweight will not slow your site down like WooCommerce or other heavy plugins.
= How do I add product images? =
Product images are added as the “featured image” within the product post. How you source your images is up to you.
= Are product links No Follow? =
Yes. All product links are set to rel=nofollow.
= Where can I find the product ID for inserting specific products? =
From the Wordpress Admin, navigate to Shop Page WP > All products. The product post ID is displayed as a column and can be copied and pasted into the shortcode or Gutenberg block.

== Screenshots ==

1. Product Grid - 4 Columns

2. Product Grid - 3 Columns

3. Admin Settings

4. Gutenberg Block in page editor


== Changelog ==

= 1.2.4 =

* Updated admin styles.
* Tested with latest version of WordPress.

= 1.2.2 =

* Added ability to output products by ID (or multiple IDs).
* Added ability to list categories (or IDs) separated by comma (pipe symbol will still work).

= 1.2.0 =

* Gutenberg functionality and Shop Page WP Gutenberg block added.

= 1.1.0 =

* Grid class names changed: full-width -> spwp-full-width, one-half -> spwp-one-half, one-third -> spwp-one-third, one-fourth -> spwp-one-fourth
* The previous class names were too generic and they conflicted with some themes. If you are applying styles by using the old class names please update to these new class names.

= 1.0.9 =

* New Feature: New shortcode attribute to specify a 'max number' of products to display
* New Feature: Option to open shop page links in the same tab instead of a new tab
* New Feature: Plugin will now output alt text for images (if alt text is set for image in the media library)
* Fixed bug for Internet Explorer 11 where product grid was overlapping
* Fixed bug with underline of link text on certain themes
* Fixed bug with featured image upload not displaying for certain themes
Shop Page WP Products are now be excluded from WordPress Search

= 1.0.8 =

* Update to how stylesheets are enqueued

= 1.0.7 =

* The entire product card now is clickable (image, text and button)
* New optional field for product description
* Customize the button text for individual products
* Product links are now "rel=nofollow"
* Fixed bug that was causing a button style issue when alignment was applied to the shop page shortcode.
* Misc style updates

= 1.0.2 =
Settings and Documentation Update

= 1.0.1 =
Initial Release

== Upgrade Notice ==

= 1.2.4 =

* Updated admin styles.
* Tested with latest version of WordPress.

= 1.2.2 =

* Added ability to output products by ID (or multiple IDs).
* Added ability to list categories (or IDs) separated by comma (pipe symbol will still work).

= 1.2.0 =

* Gutenberg functionality and Shop Page WP Gutenberg block added.

= 1.1.0 =

* Grid class names changed: full-width -> spwp-full-width, one-half -> spwp-one-half, one-third -> spwp-one-third, one-fourth -> spwp-one-fourth
* The previous class names were too generic and they conflicted with some themes. If you are applying styles by using the old class names please update to these new class names.

= 1.0.9 =

* New Feature: New shortcode attribute to specify a 'max number' of products to display
* New Feature: Option to open shop page links in the same tab instead of a new tab
* New Feature: Plugin will now output alt text for images (if alt text is set for image in the media library)
* Fixed bug for IE 11 where product grid was overlapping
* Fixed bug with underline of link text on certain themes
* Fixed bug with featured image upload not displaying for certain themes
Shop Page WP Products are now be excluded from WordPress Search

= 1.0.8 =

* Update to how stylesheets are enqueued

= 1.0.7 =

* The entire product card now is clickable (image, text and button)
* New optional field for product description
* Customize the button text for individual products
* Product links are now "rel=nofollow"
* Fixed bug that was causing a button style issue when alignment was applied to the shop page shortcode.
* Misc style updates

= 1.0.2 =
Settings and Documentation Update
