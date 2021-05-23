<?php
get_header(); ?>

<div class="container" id="contentdiv">
     <div class="row">
        
        <div class="col-md-8 site-main">
             <div class="pagelayout_area">
                <section class="site-maincontentarea">            
                        <?php while ( have_posts() ) : the_post(); ?>
                            <?php get_template_part('template/content/template', 'contentsingle');?>
                            <?php the_post_navigation(); ?>
                            <?php if ( comments_open() || get_comments_number() ) :
                comments_template();
                endif;?>
                        <?php endwhile; // end of the loop. ?>                  
                 </section>  
            </div><!--pagelayout_area-->
         </div><!--col-md-8 site-main-->
         <div class="col-md-4" id="sidebar">            
                <?php get_sidebar();?>
         </div>  <!--sidebar -->
             
                <div class="clear"></div>
            </div><!-- row -->
</div><!-- container -->	
<?php get_footer(); ?>