<?php   
/**
 * @package unschool
 */
 ?>
 <?php
 if ( ! function_exists( 'unschool_setup' ) ) :
function unschool_setup() {   
	add_theme_support( 'automatic-feed-links' );
	add_theme_support('woocommerce');
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-header' );
	add_theme_support( 'title-tag' );
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'unschool' ),
		'footer' => esc_html__( 'Footer Menu', 'unschool' ),
	) );
	add_theme_support( 'custom-background', array(
		'default-color' => 'ffffff'
	) );	

	$defaults = array(
			'default-image'          => get_template_directory_uri() .'/images/slider1.jpg',
			'default-text-color' => '05305a',
			'width'                  => 1400,
			'height'                 => 500,
			'uploads'                => true,
			'wp-head-callback'   => 'unschool_header_style',			
		);
	add_theme_support( 'custom-header', $defaults );
	if ( ! isset( $content_width ) ) $content_width = 900;
} 
endif; // unschool_setup
add_action( 'after_setup_theme', 'unschool_setup' );
?>
<?php
function unschool_header_style() {
	$unschool_header_text_color = get_header_textcolor();
	if ( get_theme_support( 'custom-header', 'default-text-color' ) === $unschool_header_text_color ) {
		return;
	}
	echo '<style id="unschool-custom-header-styles" type="text/css">';
	if ( 'blank' !== $unschool_header_text_color ) 
	{
		echo '.logotxt, .logotxt a
			 {
				color: #'.esc_attr( $unschool_header_text_color ).'
			}';
	}	
	echo '</style>';	
}