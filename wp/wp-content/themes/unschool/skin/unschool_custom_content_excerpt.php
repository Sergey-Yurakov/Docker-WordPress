<?php   
/**
 * @package unschool
 */
 ?>
 <?php
function unschool_get_excerpt($postid,$post_count_size){
$excerpt = get_post_field('post_content', $postid);;
$excerpt = preg_replace(" ([.*?])",'',$excerpt);
$excerpt = strip_shortcodes($excerpt);
$excerpt = strip_tags($excerpt);
$excerpt = substr($excerpt, 0, $post_count_size);
$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
return $excerpt;
}
?>