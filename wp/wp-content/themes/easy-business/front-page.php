<?php
/**
 * The template for displaying home page.
 * @package Easy Business
 */

if ( 'posts' != get_option( 'show_on_front' ) ){ 
    get_header(); ?>
    <?php $enabled_sections = easy_business_get_sections();
    if( is_array( $enabled_sections ) ) {
        foreach( $enabled_sections as $section ) {

            if( $section['id'] == 'featured-slider' ) { ?>
                <?php $enable_featured_slider_section = easy_business_get_option( 'enable_featured_slider_section' );
                if(true ==$enable_featured_slider_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>">  
                        <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                    </section>
            <?php endif; ?>

            <?php } elseif( $section['id'] == 'our-services' ) { ?>
                <?php $enable_our_services_section = easy_business_get_option( 'enable_our_services_section' );
                if(true ==$enable_our_services_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="section-gap">  
                        <div class="wrapper">
                            <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                        </div>
                    </section>
            <?php endif; ?>

            <?php } elseif( $section['id'] == 'call-to-action' ) { ?>
                <?php $enable_call_to_action_section   = easy_business_get_option( 'enable_call_to_action_section' );
                $background_call_to_action_section     = easy_business_get_option( 'background_call_to_action_section' );
                if( true ==$enable_call_to_action_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="section-gap" style="background-image: url('<?php echo esc_url( $background_call_to_action_section );?>');">
                        <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                    </section>
            <?php endif; ?>

            <?php } elseif( $section['id'] == 'our-gallery' ) { ?>
                <?php $enable_our_gallery_section = easy_business_get_option( 'enable_our_gallery_section' );
                if(true ==$enable_our_gallery_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="section-gap">  
                        <div class="wrapper">
                            <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                        </div>
                    </section>
            <?php endif; ?>

            <?php } elseif( $section['id'] == 'our-testimonial' ) { ?>
                <?php $enable_our_testimonial_section   = easy_business_get_option( 'enable_our_testimonial_section' );
                $background_our_testimonial_section         = easy_business_get_option( 'background_our_testimonial_section' );
                if(true ==$enable_our_testimonial_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="section-gap" style="background-image: url('<?php echo esc_url( $background_our_testimonial_section );?>');">  
                        <div class="overlay"></div>
                        <div class="wrapper">
                            <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                        </div>
                    </section>
            <?php endif; ?>
            
            <?php } elseif( ( $section['id'] == 'blog' ) ) { ?>
                <?php $enable_blog_section = easy_business_get_option( 'enable_blog_section' );
                if(true ==$enable_blog_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="blog-posts-wrapper section-gap">
                        <div class="wrapper">
                            <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                        </div>
                    </section>
            <?php endif;

            }
        }
    }
    if( true == easy_business_get_option('enable_frontpage_content') ) { ?>
        <div id="content-wrapper" class="wrapper">
            <div class="section-gap clear">
            <?php include( get_page_template() ); ?>
            </div><!-- .section-gap -->
        </div><!-- #content-wrapper -->
    <?php }
    get_footer();
} 
elseif ('posts' == get_option( 'show_on_front' ) ) {
    include( get_home_template() );
} 