<?php   
/**
 * @package unschool
 */
 ?>
 <?php function unschool_style_js()
 {
 	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/skin/bootstrap/css/bootstrap.css');
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() .'/css/font-awesome.css');
	wp_enqueue_style( 'unschool-basic-style', get_stylesheet_uri() );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/skin/bootstrap/js/bootstrap.js', array('jquery'));	
	wp_enqueue_script( 'unschool-toggle-jquery', get_template_directory_uri() . '/js/unschool-toggle.js', array('jquery'));	
 }
 add_action( 'wp_enqueue_scripts', 'unschool_style_js' );
?>