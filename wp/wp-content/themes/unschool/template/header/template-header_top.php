<a class="skip-link screen-reader-text" href="#contentdiv">
<?php esc_html_e( 'Skip to content', 'unschool' ); ?></a>
<div id="maintopdiv">
    <div class="header-top">
        <div class="container" >
            <div class="row">  
                <div class="col-md-8  col-sm-12 col-lg-8 headercommon header-left">            
                    <ul> 
                        <li>
                            <?php $unschool_phone = get_theme_mod('unschool_phone'); ?>
                            <?php if (get_theme_mod('unschool_phone')) { ?>
                                <i class="fa fa-phone"></i>&nbsp;&nbsp;<?php echo esc_html($unschool_phone); ?>
                            <?php } ?>
                        </li>
                        <li class="lastemail">
                            <?php $unschool_address = get_theme_mod('unschool_address'); ?>
                            <?php if (get_theme_mod('unschool_address')) { ?>
                                <i class="fa fa-map-marker"></i>&nbsp;&nbsp;<?php echo esc_html($unschool_address); ?>
                            <?php } ?>                             
                        </li>
                    </ul>
                    <div class="clear"></div>
                </div> <!--col-sm-3--> 
                
                <div class="col-md-4 col-lg-4 col-sm-12 social-icons headercommon">
                    <ul>
                        <?php if (get_theme_mod('unschool_fb')) { ?>
                            <li><a title="<?php esc_attr_e('Facebook', 'unschool'); ?>" class="fa fa-facebook" target="_blank" href="<?php echo esc_url(get_theme_mod('unschool_fb')); ?>"></a> </li>
                        <?php } ?>
                        <?php if (get_theme_mod('unschool_twitter')) { ?>
                            <li><a title="<?php esc_attr_e('twitter', 'unschool'); ?>" class="fa fa-twitter" target="_blank" href="<?php echo esc_url(get_theme_mod('unschool_twitter')); ?>"></a></li>
                        <?php } ?>
                        <?php if (get_theme_mod('unschool_glplus')) { ?>
                            <li><a title="<?php esc_attr_e('googleplus', 'unschool'); ?>" class="fa fa-google-plus" target="_blank" href="<?php echo esc_url(get_theme_mod('unschool_glplus')); ?>"></a></li>
                        <?php } ?>
                        <?php if (get_theme_mod('unschool_in')) { ?>
                            <li><a title="<?php esc_attr_e('linkedin', 'unschool'); ?>" class="fa fa-linkedin" target="_blank" href="<?php echo esc_url(get_theme_mod('unschool_in')); ?>"></a></li>
                        <?php } ?>
                    </ul>
                    <div class="clear"></div>
                </div><!--col-md-34 col-lg-4 header_right-->
                <div class="clearfix"></div>
            </div><!--row-->
        </div><!--container-->
    </div><!--main-navigations-->


<div class="header-bottom">
    <div class="container" >
            <div class="row">  
    <div class="col-md-3  col-lg-3 col-sm-12 header_middle  leftlogo">

                    <?php if (display_header_text() == true) { ?>
                        <div class="logotxt">
                            <h1><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a></h1>
                            <p><?php bloginfo('description'); ?></p>
                        </div>
                    <?php } ?>


                </div><!--col-md-4 header_middle-->
<div class="col-md-9  col-lg-9 col-sm-12   ">
    <section id="main_navigation">
        
                <div class="main-navigation-inner rightmenu">
                    <div class="toggle">
                        <a class="togglemenu" href="#"><?php esc_html_e('Menu', 'unschool'); ?></a>
                    </div><!-- toggle --> 
                    <div class="sitenav">
                        <div class="nav">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary'                            
                        ));
                        ?>
                        </div>
                    </div><!-- site-nav -->
                </div><!--<div class=""main-navigation-inner">-->
            
    </section><!--main_navigation-->
</div>
</div><!--row-->
</div><!--container-->
<div class="clearfix"></div>
</div><!--header-bottom-->


    
</div><!--maintopdiv-->