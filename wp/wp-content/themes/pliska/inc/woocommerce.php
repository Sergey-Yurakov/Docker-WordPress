<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package pliska
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function pliska_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 300,
			'single_image_width'    => 300,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'pliska_woocommerce_setup' );

/**
 * Register Woocommerce sidebar areas for better customizations.
 */
function pliska_wc_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Woocommerce Sidebar', 'pliska' ),
			'id'            => 'sidebar-2-1',
			'description'   => __( 'Add widgets here to appear on your shop pages.', 'pliska' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}

add_action( 'widgets_init', 'pliska_wc_widgets_init', 11 );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function pliska_woocommerce_scripts() {
	wp_enqueue_style( 'pliska-woocommerce-style', get_template_directory_uri() . '/assets/css/woocommerce.css', array(), PLISKA_VERSION );
	/* RTL css */
	wp_style_add_data('pliska-woocommerce-style', 'rtl', 'replace');
	$font_path   = esc_url( WC()->plugin_url() ) . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'pliska-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'pliska_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
//add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function pliska_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'pliska_woocommerce_active_body_class' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function pliska_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'pliska_woocommerce_related_products_args' );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'pliska_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function pliska_woocommerce_wrapper_before() {
		?>
		<!--Site wrapper-->
		<div class="wrapper">
			<main id="primary" class="site-main">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'pliska_woocommerce_wrapper_before' );

if ( ! function_exists( 'pliska_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function pliska_woocommerce_wrapper_after() {
		?>
			</main><!-- #main -->
		<?php get_sidebar(); ?>
		</div><!-- #Site wrapper-->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'pliska_woocommerce_wrapper_after' );


if ( ! function_exists( 'pliska_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function pliska_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		pliska_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'pliska_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'pliska_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function pliska_woocommerce_cart_link() {
		
	global $woocommerce; 
	?>
    <a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('Cart View', 'pliska'); ?>">
	<span class="cart-contents-count">
	<i class="cart-icon"></i>
	&nbsp;<?php 
	
	$cart_contents_count =$woocommerce->cart->cart_contents_count;

	if($cart_contents_count>0){ ?>
		<span class="cart-counter">
			<?php echo esc_html ($cart_contents_count); ?>
		</span> <?php
	}

	?></span>
    </a> 
    <?php
	}
}

/**
 * Sample implementation of the WooCommerce Mini Cart Link.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
 */

if ( ! function_exists( 'pliska_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function pliska_woocommerce_header_cart() {
		?>
			<li class="site-header-cart">
				<?php pliska_woocommerce_cart_link(); ?>
			</li>
		<?php
	}
}

/* Add container on woocommerce shop page */

/*
 * Add a container to the thumbnail
 */

function pliska_woocommerce_before_thumbnail() {
    echo "<div class='woocommerce-thumbnail-container'>";
}

function pliska_woocommerce_after_thumbnail() {
    echo "</div><!--.woocommerce-thumbnail-container-->";
}

add_action('woocommerce_before_shop_loop_item_title', 'pliska_woocommerce_before_thumbnail', 5);
add_action('woocommerce_before_shop_loop_item_title', 'pliska_woocommerce_after_thumbnail', 20);

/*
 * Move the Add to Cart button inside the thumbnail,
 * and add a div for the Add to card and View cart buttons
 */

function pliska_woocommerce_before_buttons() {
    echo "<div class='woocommerce-buttons-container'>";
}

function pliska_woocommerce_after_buttons() {
    echo "</div><!--.woocommerce-buttons-container-->";
}

remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 16);
add_action('woocommerce_before_shop_loop_item_title', 'pliska_woocommerce_before_buttons', 15);
add_action('woocommerce_before_shop_loop_item_title', 'pliska_woocommerce_after_buttons', 17);
