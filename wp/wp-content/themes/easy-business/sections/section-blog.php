<?php 
/**
 * Template part for displaying Blog Section
 *
 *@package Easy Business
 */
?>
<?php 
    $blog_section_title    = easy_business_get_option( 'blog_section_title' );
	$blog_category 		   = easy_business_get_option( 'blog_category' );
	$blog_number		   = easy_business_get_option( 'blog_number' );
?> 
    <?php if( !empty($blog_section_title) ):?>
        <div class="section-header">
            <h2 class="section-title"><?php echo esc_html($blog_section_title);?></h2>
        </div><!-- .section-header -->
    <?php endif;?>

  	<div class="section-content col-3 clear">
	  	<?php
			$blog_args = array(
				'posts_per_page' =>absint( $blog_number ),				
				'post_type' => 'post',
	            'post_status' => 'publish',
	            'paged' => 1,
				);

				if ( absint( $blog_category ) > 0 ) {
					$blog_args['cat'] = absint( $blog_category );
				}
			
			$loop = new WP_Query( $blog_args );
			
			if ( $loop->have_posts() ) : 
			$i=-1; $j=0;	
				while ( $loop->have_posts() ) : $loop->the_post(); $i++; $j++; ?>    

			    <article class="<?php echo has_post_thumbnail() ? 'has-post-thumbnail' : 'no-post-thumbnail'; ?>">
			    	<div class="post-item">
				      	<?php if(has_post_thumbnail()):?>
					        <div class="featured-image" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
                                <a href="<?php the_permalink();?>" class="post-thumbnail-link"></a>
                            </div><!-- .featured-image -->
				    	<?php endif; ?>

				    	<div class="entry-container">
				    		<div class="entry-meta">
                                <?php easy_business_posted_on(); ?>
                            </div><!-- .entry-meta -->
					        
					        <header class="entry-header">
								<h2 class="entry-title">
									<a href="<?php the_permalink();?>"><?php the_title();?></a>
								</h2>
					        </header>

					        <div class="entry-content">
			 				    <?php
									$excerpt = easy_business_the_excerpt( 15 );
									echo wp_kses_post( wpautop( $excerpt ) );
								?>
					        </div><!-- .entry-content -->

					        <?php $readmore_text = easy_business_get_option( 'readmore_text' );?>
                            <?php if (!empty($readmore_text) ) :?>
                                <div class="read-more">
                                    <a href="<?php the_permalink();?>"><?php echo esc_html($readmore_text);?></a>
                                </div><!-- .read-more -->
                            <?php endif; ?>
				        </div><!-- .entry-container -->
				    </div><!-- .post-item -->
			    </article>
		    	<?php endwhile;?>
	    	<?php endif; ?>
		<?php wp_reset_postdata(); ?>
  	</div><!-- .section-content -->