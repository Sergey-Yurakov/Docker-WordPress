<?php 
/**
 * Template part for displaying Our Testimonial Section
 *
 *@package Easy Business
 */
    $our_testimonial_section_title           = easy_business_get_option( 'our_testimonial_section_title' );
    $our_testimonial_content_type            = easy_business_get_option( 'our_testimonial_content_type' );
    $number_of_our_testimonial_items         = easy_business_get_option( 'number_of_our_testimonial_items' );

    if( $our_testimonial_content_type == 'our_testimonial_page' ) :
        for( $i=1; $i<=$number_of_our_testimonial_items; $i++ ) :
            $our_testimonial_posts[] = easy_business_get_option( 'our_testimonial_page_'.$i );
        endfor;  
    elseif( $our_testimonial_content_type == 'our_testimonial_post' ) :
        for( $i=1; $i<=$number_of_our_testimonial_items; $i++ ) :
            $our_testimonial_posts[] = easy_business_get_option( 'our_testimonial_post_'.$i );
        endfor;
    endif;
    ?>

    <?php if( !empty($our_testimonial_section_title) ):?>
        <div class="section-header">
            <h2 class="section-title"><?php echo esc_html($our_testimonial_section_title);?></h2>
        </div><!-- .section-header -->
    <?php endif;?>

    <?php if( $our_testimonial_content_type == 'our_testimonial_page' ) : ?>
        <div class="testimonial-slider" data-slick='{"slidesToShow": 1, "slidesToScroll": 1, "infinite": true, "speed": 1000, "dots": true, "arrows":false, "autoplay": false, "draggable": true, "fade": false }'>
            <?php $args = array (
                'post_type'     => 'page',
                'posts_per_page' => absint( $number_of_our_testimonial_items ),
                'post__in'      => $our_testimonial_posts,
                'orderby'       =>'post__in',
            );        
            $loop = new WP_Query($args);                        
            if ( $loop->have_posts() ) :
            $i=-1;
                while ($loop->have_posts()) : $loop->the_post(); $i++; ?>            
                
                <article>
                    <div class="testimonial-item">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="featured-image" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
                                <a href="<?php the_permalink();?>" class="post-thumbnail-link"></a>
                            </div><!-- .featured-image -->
                        <?php endif; ?>

                        <div class="entry-container">
                            <div class="entry-content">
                                <?php
                                    $excerpt = easy_business_the_excerpt( 30 );
                                    echo wp_kses_post( wpautop( $excerpt ) );
                                ?>
                            </div><!-- .entry-content -->

                            <header class="entry-header">
                                <h2 class="entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                            </header>
                        </div><!-- .entry-container -->
                    </div><!-- .testimonial-item -->
                </article>

                <?php endwhile; ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div><!-- .section-content -->
    
    <?php else: ?>
        <div class="testimonial-slider" data-slick='{"slidesToShow": 1, "slidesToScroll": 1, "infinite": true, "speed": 1000, "dots": true, "arrows":false, "autoplay": false, "draggable": true, "fade": false }'>
            <?php $args = array (
                'post_type'     => 'post',
                'posts_per_page' => absint( $number_of_our_testimonial_items ),
                'post__in'      => $our_testimonial_posts,
                'orderby'       =>'post__in',
                'ignore_sticky_posts' => true,
            );        
            $loop = new WP_Query($args);                        
            if ( $loop->have_posts() ) :
            $i=-1;
                while ($loop->have_posts()) : $loop->the_post(); $i++; ?>            
                
                <article>
                    <div class="testimonial-item">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="featured-image" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
                                <a href="<?php the_permalink();?>" class="post-thumbnail-link"></a>
                            </div><!-- .featured-image -->
                        <?php endif; ?>

                        <div class="entry-container">
                            <div class="entry-content">
                                <?php
                                    $excerpt = easy_business_the_excerpt( 30 );
                                    echo wp_kses_post( wpautop( $excerpt ) );
                                ?>
                            </div><!-- .entry-content -->

                            <header class="entry-header">
                                <h2 class="entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                            </header>
                        </div><!-- .entry-container -->
                    </div><!-- .testimonial-item -->
                </article>

                <?php endwhile; ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div><!-- .section-content -->
    <?php endif;