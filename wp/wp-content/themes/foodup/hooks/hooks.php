 <?php if(!function_exists('foodup_frontpage_trending_post_section')):

/**
*
* @since Foodup
*
*
*/
  function foodup_frontpage_trending_post_section()
    {

        if(is_front_page() || is_home())
        {
        $foodup_post_one = array(get_theme_mod('foodup_post_one'));
        

        $slider_query = new WP_Query( array( 'post__in' => $foodup_post_one, 'ignore_sticky_posts' => 1));
                if( $slider_query->have_posts() ){                
                    while( $slider_query->have_posts() ){
                    $slider_query->the_post();

        global $post;
        $foodup_url = newsup_get_freatured_image_url($post->ID);
        ?>
        <div class="col-md-3 no-padding">
                        <div class="mg-blog-post lg back-img" style="background-image: url('<?php echo esc_url($foodup_url); ?>');">
                                        <a class="link-div" href="<?php echo the_permalink(); ?>"> </a>
                        <article class="bottom">
                                <div class="mg-blog-category"> <?php newsup_post_categories(); ?> </div>
                                <h4 class="title"> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <?php newsup_post_meta(); ?>
                </article>
                        </div>     
                    </div>

        
       <?php } } 
        else
        {
            $slider_query = new WP_Query( array( 'ignore_sticky_posts' => 1, "posts_per_page" => 1));
            if( $slider_query->have_posts() ){                
                    while( $slider_query->have_posts() ){
                    $slider_query->the_post();

        global $post;
        $foodup_url = newsup_get_freatured_image_url($post->ID);
        ?>
        <div class="col-md-3 no-padding">
                        <div class="mg-blog-post lg back-img" style="background-image: url('<?php echo esc_url($foodup_url); ?>');">
                                        <a class="link-div" href="<?php echo the_permalink(); ?>"> </a>
                        <article class="bottom">
                                <div class="mg-blog-category"> <?php newsup_post_categories(); ?> </div>
                                <h4 class="title"> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <?php newsup_post_meta(); ?>
                </article>
                        </div>     
                    </div>

     <?php   } }
        }
    } }

endif;

add_action('foodup_action_front_page_trending_section', 'foodup_frontpage_trending_post_section', 30);

//Front Page Banner
if (!function_exists('foodup_front_page_banner_section')) :
    /**
     *
     * @since Foodup
     *
     */
    function foodup_front_page_banner_section()
    {
        if (is_front_page() || is_home()) {
        $newsup_enable_main_slider = newsup_get_option('show_main_news_section');
        $select_vertical_slider_news_category = newsup_get_option('select_vertical_slider_news_category');
        $vertical_slider_number_of_slides = newsup_get_option('vertical_slider_number_of_slides');
        $all_posts_vertical = newsup_get_posts($vertical_slider_number_of_slides, $select_vertical_slider_news_category);
        if ($newsup_enable_main_slider):  

            $main_banner_section_background_image = newsup_get_option('main_banner_section_background_image');
            $main_banner_section_background_image_url = wp_get_attachment_image_src($main_banner_section_background_image, 'full');
        if(!empty($main_banner_section_background_image)){ ?>
             <section class="mg-fea-area over" style="background-image:url('<?php echo esc_url($main_banner_section_background_image_url[0]); ?>');">
        <?php }else{ ?>
            <section class="mg-fea-area">
        <?php  } ?>
            <div class="overlay">
                <div class="container-fluid">
                    <div class="row px-15">
                        <?php do_action('foodup_action_front_page_trending_section');?>
                        <div class="col-md-6 col-sm-6 no-padding">
                            <div id="homemain"class="homemain owl-carousel"> 
                                <?php newsup_get_block('list', 'banner'); ?>
                            </div>
                        </div> 
                        <?php do_action('foodup_action_banner_tabbed_posts');?>
                    </div>
                </div>
            </div>
        </section>
        <div class="w-100 clearfix mr-bot30"></div>
        <!--==/ Home Slider ==-->
        <?php endif; ?>
        <!-- end slider-section -->
        <?php }
    }
endif;
add_action('foodup_action_front_page_main_section_1', 'foodup_front_page_banner_section', 40);



//Banner Tabed Section
if (!function_exists('foodup_banner_tabbed_posts')):
    /**
     *
     * @since Foodup 1.0.0
     *
     */
    function foodup_banner_tabbed_posts()
    {
            $trending_category = newsup_get_option('select_trending_post_category');
            $number_of_trending_posts = 2;
            $all_trending_posts = newsup_get_posts($number_of_trending_posts, $trending_category);
            global $post;
        ?>
        <div class="col-md-3 no-padding">
            <?php if ($all_trending_posts->have_posts()) :
                    while ($all_trending_posts->have_posts()) : $all_trending_posts->the_post();
                    $url = newsup_get_freatured_image_url($post->ID, 'full'); ?>
                    <div class="mg-blog-post lg md back-img" style="background-image: url('<?php echo esc_url($url); ?>');">
                                <a href="<?php the_permalink(); ?>" class="link-div"></a>
                        <article class="bottom">
                            <div class="mg-blog-category"> <?php newsup_post_categories(); ?> </div>
                            <h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        </article>
                    </div> 
            <?php endwhile; endif; wp_reset_postdata(); ?>
        </div>
        <?php

    }
endif;

add_action('foodup_action_banner_tabbed_posts', 'foodup_banner_tabbed_posts', 10);



if(!function_exists('foodup_frontpage_featured_post_section')):

/**
*
* @since Foodup
*
*
*/
  function foodup_frontpage_featured_post_section()
{ 

if (is_front_page() || is_home()) {

$enable_featured_section = get_theme_mod('enable_featured_section',1);
$fatured_post_image_one = get_theme_mod('fatured_post_image_one'); 
$fatured_post_image_one_atc = wp_get_attachment_image($fatured_post_image_one);
$featured_post_one_btn_txt = get_theme_mod('featured_post_one_btn_txt');
$featured_post_one_url = get_theme_mod('featured_post_one_url');
$featured_post_one_url_new_tab = get_theme_mod('featured_post_one_url_new_tab');

$fatured_post_image_two = get_theme_mod('fatured_post_image_two');
$fatured_post_image_two_atc = wp_get_attachment_image($fatured_post_image_two);
$featured_post_two_btn_txt = get_theme_mod('featured_post_two_btn_txt');
$featured_post_two_url = get_theme_mod('featured_post_two_url');
$featured_post_two_url_new_tab = get_theme_mod('featured_post_two_url_new_tab');

$fatured_post_image_three = get_theme_mod('fatured_post_image_three');
$fatured_post_image_three_atc = wp_get_attachment_image($fatured_post_image_three);
$featured_post_three_btn_txt = get_theme_mod('featured_post_three_btn_txt');
$featured_post_three_url = get_theme_mod('featured_post_three_url');
$featured_post_three_url_new_tab = get_theme_mod('featured_post_three_url_new_tab');

if($enable_featured_section == 1) { 
?>
<!--container-->
<div id="content" class="container-fluid home">
                <!--row-->
                <div class="row">

<div class="col-md-12 mr-bot30">
        <div class="row align-items-center">
            <div class="col-md-4">
                <div class="back-img promobox featured-post-one" style="background-image: url('<?php echo esc_url($fatured_post_image_one); ?>');">
                    <a <?php if($featured_post_one_url_new_tab) { ?> target="_blank" <?php } ?> href="<?php echo esc_url($fatured_post_image_one_atc); ?>" class="link-div"><span class="btn btn-theme" >
                    <?php echo esc_html($featured_post_one_btn_txt); ?></span></a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="back-img promobox featured-post-two" style="background-image: url('<?php echo esc_url($fatured_post_image_two); ?>');">
                    <a <?php if($featured_post_two_url_new_tab) { ?> target="_blank" <?php } ?> href="<?php echo esc_url($fatured_post_image_two_atc); ?>" class="link-div"><span class="btn btn-theme" >
                    <?php echo esc_html($featured_post_two_btn_txt); ?></span></a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="back-img promobox featured-post-three" style="background-image: url('<?php echo esc_url($fatured_post_image_three)?>');">
                    <a <?php if($featured_post_three_url_new_tab) { ?> target="_blank" <?php } ?> href="<?php echo esc_url($fatured_post_image_three_atc); ?>" class="link-div"><span class="btn btn-theme" >
                        <?php echo esc_html($featured_post_three_btn_txt); ?></span></a>
                </div>
            </div>
        </div>
</div>
</div>
</div>
<?php } } }
endif;
add_action('foodup_action_featured_posts', 'foodup_frontpage_featured_post_section', 20);