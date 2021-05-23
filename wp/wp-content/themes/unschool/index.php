<?php
/**
 * @package unschool
 */
get_header();
?>
<div class="container" id="contentdiv">
    <div class="container-fluid page_content row">        
        <div class="site-main col-md-8">
            <div class="blog-post">
                <?php
                if (have_posts()) :

                    while (have_posts()) : the_post();
                        get_template_part('template/content/template', 'content');
                        ?> 
                        <?php
                    endwhile;
                    the_posts_pagination();
                endif;
                ?>
            </div><!-- blog-post -->
        </div><!--site-main -->
        <div class="col-md-4" id="sidebar">
            <?php get_sidebar(); ?>     
        </div><!--col-md-4-->
        <div class="clearfix"></div>
    </div><!-- site-aligner -->

</div><!-- content -->
<?php get_footer(); ?>