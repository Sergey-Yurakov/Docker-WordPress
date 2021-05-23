<?php 
/**
 * Template part for displaying Our Gallery Section
 *
 *@package Easy Business
 */
    $our_gallery_section_title           = easy_business_get_option( 'our_gallery_section_title' );
    $our_gallery_content_type            = easy_business_get_option( 'our_gallery_content_type' );
    $number_of_our_gallery_items         = easy_business_get_option( 'number_of_our_gallery_items' );

    if( $our_gallery_content_type == 'our_gallery_page' ) :
        for( $i=1; $i<=$number_of_our_gallery_items; $i++ ) :
            $our_gallery_posts[] = easy_business_get_option( 'our_gallery_page_'.$i );
        endfor;  
    elseif( $our_gallery_content_type == 'our_gallery_post' ) :
        for( $i=1; $i<=$number_of_our_gallery_items; $i++ ) :
            $our_gallery_posts[] = easy_business_get_option( 'our_gallery_post_'.$i );
        endfor;
    endif;
    ?>

    <?php if( !empty($our_gallery_section_title) ):?>
        <div class="section-header">
            <h2 class="section-title"><?php echo esc_html($our_gallery_section_title);?></h2>
        </div><!-- .section-header -->
    <?php endif;?>

    <?php if( $our_gallery_content_type == 'our_gallery_page' ) : ?>
        <div class="section-content col-3 clear">
            <?php $args = array (
                'post_type'     => 'page',
                'posts_per_page' => absint( $number_of_our_gallery_items ),
                'post__in'      => $our_gallery_posts,
                'orderby'       =>'post__in',
            );        
            $loop = new WP_Query($args);                        
            if ( $loop->have_posts() ) :
            $i=-1;
                while ($loop->have_posts()) : $loop->the_post(); $i++; ?>            
                
                <article>
                    <div class="gallery-item-wrapper">
                        <div class="featured-image" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
                        </div><!-- .featured-image -->

                        <div class="entry-container">
                            <header class="entry-header">
                                <h2 class="entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                            </header>
                        </div><!-- .entry-container -->
                    </div><!-- .gallery-item-wrapper -->
                </article>

                <?php endwhile; ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div><!-- .section-content -->
    
    <?php else: ?>
        <div class="section-content col-3 clear">
            <?php $args = array (
                'post_type'     => 'post',
                'posts_per_page' => absint( $number_of_our_gallery_items ),
                'post__in'      => $our_gallery_posts,
                'orderby'       =>'post__in',
                'ignore_sticky_posts' => true,
            );        
            $loop = new WP_Query($args);                        
            if ( $loop->have_posts() ) :
            $i=-1;
                while ($loop->have_posts()) : $loop->the_post(); $i++; ?>                
                
                <article>
                    <div class="gallery-item-wrapper">
                        <div class="featured-image" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
                        </div><!-- .featured-image -->

                        <div class="entry-container">
                            <header class="entry-header">
                                <h2 class="entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                            </header>
                        </div><!-- .entry-container -->
                    </div><!-- .gallery-item-wrapper -->
                </article>

                <?php endwhile; ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div><!-- .section-content -->
    <?php endif;