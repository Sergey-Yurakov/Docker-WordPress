<?php
/**
 * Managed the custom functions and hooks for entire theme.
 *
 * @package Color Blog Dark
 * @since 1.0.0
 */
/*----------------------------------------------------------------------------------------------------------------------------------*/
if ( ! function_exists( 'color_blog_dark_main_header_start' ) ) :

	/**
	 * function to start header section
	 */
	function color_blog_dark_main_header_start() {
		echo '<header id="masthead" class="site-header">';
		echo '<div class="mt-logo-row-wrapper mt-clearfix">';
	}

endif;

if ( ! function_exists( 'color_blog_dark_site_branding' ) ) :

	/**
	 * function to display site branding
	 */
	function color_blog_dark_site_branding() {
?>
		<div class="logo-ads-wrap">
			<div class="mt-container">
				<div class="site-branding">
					<?php
						the_custom_logo();
						if ( is_front_page() || is_home() ) :
					?>
							<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
							<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
						endif;
						$color_blog_dark_description = get_bloginfo( 'description', 'display' );
						if ( $color_blog_dark_description || is_customize_preview() ) :
					?>
							<p class="site-description"><?php echo $color_blog_dark_description; /* WPCS: xss ok. */ ?></p>
					<?php endif; ?>
				</div><!-- .site-branding -->
				<div class="header-widget-wrapper">
					<?php 
						if ( is_active_sidebar( 'header-ads-section' ) ) {
							dynamic_sidebar( 'header-ads-section' );
						}
					?>
				</div>
			</div> <!-- mt-container -->
		</div><!-- .logo-ads-wrap -->
<?php
	}
	
endif;

if ( ! function_exists( 'color_blog_dark_menu_wrapper_start' ) ) :

	/**
	 * function to start menu wrapper
	 */
	function color_blog_dark_menu_wrapper_start() {
		echo '<div class="mt-social-menu-wrapper">';
		echo '<div class="mt-container">';
	}

endif;

if ( ! function_exists( 'color_blog_dark_header_main_menu' ) ) :

	/**
	 * function to display primary menu
	 */
	function color_blog_dark_header_main_menu() {
		$color_blog_dark_menu_toggle_text = apply_filters( 'color_blog_dark_menu_toggle_text', __( 'Menu', 'color-blog-dark' ) );
?>
		<div class="mt-header-menu-wrap">
			<div class="menu-toggle"><a href="javascript:void(0)"><i class="fa fa-navicon"></i><?php echo esc_html( $color_blog_dark_menu_toggle_text ); ?></a></div>
			<nav itemscope id="site-navigation" class="main-navigation">
				<?php
					wp_nav_menu( array(
						'theme_location' => 'primary_menu',
						'menu_id'        => 'primary-menu',
					) );
				?>
			</nav><!-- #site-navigation -->
		</div>
<?php
	}

endif;

if ( ! function_exists( 'color_blog_dark_menu_icon_wrapper_start' ) ) :

	/**
	 * function to start icon wrapper
	 */
	function color_blog_dark_menu_icon_wrapper_start() {
		echo '<div class="mt-social-search-wrapper">';
	}

endif;

if ( ! function_exists( 'color_blog_dark_menu_social_icons' ) ) :

	/**
	 * function to display social icons at menu section
	 */
	function color_blog_dark_menu_social_icons() {
		$color_blog_dark_enable_header_social_icons = get_theme_mod( 'color_blog_dark_enable_header_social_icons', false );
		if ( false === $color_blog_dark_enable_header_social_icons ) {
			return;
		}
		$color_blog_dark_menu_social_icons_label = apply_filters( 'color_blog_dark_menu_social_icons_label', __( 'Follow Us: ', 'color-blog-dark' ) );
?>
		<div class="mt-social-wrapper">
			<span class="mt-follow-title"><?php echo esc_html( $color_blog_dark_menu_social_icons_label ); ?></span>
			<?php color_blog_dark_social_media_content(); ?>
		</div>
<?php
	}

endif;

if ( ! function_exists( 'color_blog_dark_menu_search_icon' ) ) :

	/**
	 * function to display search icon at menu section
	 */
	function color_blog_dark_menu_search_icon() {
		$color_blog_dark_enable_search_icon = get_theme_mod( 'color_blog_dark_enable_search_icon', true );
		if ( false === $color_blog_dark_enable_search_icon ) {
			return;
		}
		$color_blog_dark_menu_search_icon_lable = apply_filters( 'color_blog_dark_menu_search_icon_lable', __( 'Search', 'color-blog-dark' ) );
?>
		<div class="mt-menu-search">
			<div class="mt-search-icon"><a href="javascript:void(0)"><?php echo esc_html( $color_blog_dark_menu_search_icon_lable ); ?><i class="fa fa-search"></i></a></div>
			<div class="mt-form-wrap">
				
				<?php get_search_form(); ?>

				<div class="mt-form-close"><a href="javascript:void(0)"><i class="fa fa-close"></i></a></div>
			</div><!-- .mt-form-wrap -->
		</div><!-- .mt-menu-search -->
<?php
	}

endif;

if ( ! function_exists( 'color_blog_dark_menu_icon_wrapper_end' ) ) :

	/**
	 * function to end icon wrapper
	 */
	function color_blog_dark_menu_icon_wrapper_end() {
		echo '</div><!-- .mt-social-search-wrapper -->';
	}

endif;

if ( ! function_exists( 'color_blog_dark_menu_wrapper_end' ) ) :

	/**
	 * function to end menu wrapper
	 */
	function color_blog_dark_menu_wrapper_end() {
		echo '</div><!--.mt-container -->';
		echo '</div><!--.mt-social-menu-wrapper -->';
	}

endif;

if ( ! function_exists( 'color_blog_dark_main_header_end' ) ) :

	/**
	 * function to end header section
	 */
	function color_blog_dark_main_header_end() {
		echo '</div><!--.mt-logo-row-wrapper -->';
		echo '</header><!-- #masthead -->';
	}

endif;

/**
 * manage functions at color_blog_dark_main_header hook
 */
add_action( 'color_blog_dark_main_header', 'color_blog_dark_main_header_start', 5 );
add_action( 'color_blog_dark_main_header', 'color_blog_dark_site_branding', 10 );
add_action( 'color_blog_dark_main_header', 'color_blog_dark_menu_wrapper_start', 15 );
add_action( 'color_blog_dark_main_header', 'color_blog_dark_header_main_menu', 20 );
add_action( 'color_blog_dark_main_header', 'color_blog_dark_menu_icon_wrapper_start', 25 );
add_action( 'color_blog_dark_main_header', 'color_blog_dark_menu_social_icons', 30 );
add_action( 'color_blog_dark_main_header', 'color_blog_dark_menu_search_icon', 35 );
add_action( 'color_blog_dark_main_header', 'color_blog_dark_menu_icon_wrapper_end', 40 );
add_action( 'color_blog_dark_main_header', 'color_blog_dark_menu_wrapper_end', 45 );
add_action( 'color_blog_dark_main_header', 'color_blog_dark_main_header_end', 50 );

/*----------------------------------------------------------------------------------------------------------------------------------*/
if ( ! function_exists( 'color_blog_dark_header_categories_lists_content' ) ) :

	/**
	 * function to display categories lists
	 */
	function color_blog_dark_header_categories_lists_content() {
		$get_categories = get_categories( array( 'orderby' => 'name', 'order' => 'ASC' ) );
?>
			<div class="mt-header-cat-list-wrapper">
				<ul class="sticky-header-sidebar-menu mt-slide-cat-lists">
					<?php
						$count = 1;
						$cat_list_items = apply_filters( 'color_blog_dark_menu_cat_list_items', 5 );
						foreach ( $get_categories as $category ) {
							$cat_link 	= get_category_link( $category->term_id );
							$cat_name  	= $category->name;
							$cat_count 	= $category->count;
							if ( $count <= $cat_list_items ) {
					?>
								<li class="cat-item">
									<a href="<?php echo esc_url( $cat_link ); ?>">
										<?php
											echo esc_html( $cat_name );
											echo '<span>'. esc_html( $cat_count ) .'</span>';
										?>
									</a>
								</li>
					<?php
							}
						}
					?>
				</ul><!-- .mt-slide-cat-lists -->
			</div><!-- .mt-header-cat-list-wrapper -->
<?php
	}

endif;
add_action( 'color_blog_dark_header_categories_lists', 'color_blog_dark_header_categories_lists_content', 10 );
/*----------------------------------------------------------------------------------------------------------------------------------*/
if ( ! function_exists( 'color_blog_dark_header_author_box_content' ) ) :

	/**
	 * function to display author info
	 */
	function color_blog_dark_header_author_box_content() {
		$color_blog_dark_user_id = apply_filters( 'color_blog_dark_header_user_id', 1 );
?>
		<div itemscope itemtype="http://schema.org/Person" class="sticky-header-sidebar-author author-bio-wrap">
            <div class="author-avatar"><?php echo get_avatar( $color_blog_dark_user_id, '150' ); ?></div>
            <h3 itemprop="name" class="author-name"><?php echo esc_html( get_the_author_meta( 'nicename', $color_blog_dark_user_id ) ); ?></h3>
            <div class="author-description"><?php echo wp_kses_post( wpautop( get_the_author_meta( 'description', $color_blog_dark_user_id ) ) ); ?></div>
            <div class="author-social">
                <?php color_blog_dark_social_media_content(); ?>
            </div><!-- .author-social -->
        </div><!-- .author-bio-wrap -->
<?php
	}

endif;
add_action( 'color_blog_dark_header_author_box', 'color_blog_dark_header_author_box_content', 10 );

/*----------------------------------------------------------------------------------------------------------------------------------*/
add_action( 'color_blog_dark_scroll_top', 'color_blog_dark_scroll_top_content', 10 );

if ( ! function_exists( 'color_blog_dark_scroll_top_content' ) ) :

	/**
	 * Function for scroll top
	 *
	 * @since 1.0.0
	 */
	function color_blog_dark_scroll_top_content() {
		$color_blog_dark_scroll_top_text = apply_filters( 'color_blog_dark_scroll_top_text', __( 'Back To Top', 'color-blog-dark' ) );
        echo '<div id="mt-scrollup" class="animated arrow-hide">'. esc_html( $color_blog_dark_scroll_top_text ) .'</div>';
	}

endif;

/*----------------------------------------------------------------------------------------------------------------------------------*/
if ( ! function_exists( 'color_blog_dark_innerpage_header_start' ) ) :

	/**
	 * function to manage starting div of section
	 */
	function color_blog_dark_innerpage_header_start() {
		$inner_header_attribute = '';
		$inner_header_attribute = apply_filters( 'color_blog_dark_inner_header_style_attribute', $inner_header_attribute );
		if ( !empty( $inner_header_attribute ) ) {
			$header_class = 'has-bg-img';
		} else {
			$header_class = 'no-bg-img';
		}
?>
		<div class="custom-header <?php echo esc_attr( $header_class ); ?>" <?php echo ( ! empty( $inner_header_attribute ) ) ? ' style="' . esc_attr( $inner_header_attribute ) . '" ' : ''; ?>>
            <div class="mt-container">
<?php
	}

endif;

if ( ! function_exists( 'color_blog_dark_innerpage_header_title' ) ) :

	/**
	 * function to display the page title
	 */
	function color_blog_dark_innerpage_header_title() {
		if ( is_single() || is_page() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} elseif ( is_archive() ) {
			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="taxonomy-description">', '</div>' );
		} elseif ( is_search() ) {
	?>
			<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'color-blog-dark' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
	<?php
		} elseif ( is_404() ) {
			echo '<h1 class="entry-title">'. esc_html( '404 Error', 'color-blog-dark' ) .'</h1>';
		} elseif ( is_home() ) {
			$page_for_posts_id = get_option( 'page_for_posts' );
			$page_title = get_the_title( $page_for_posts_id );
	?>
			<h1 class="entry-title"><?php echo esc_html( $page_title ); ?></h1>
	<?php
		}
	}

endif;

if ( ! function_exists( 'color_blog_dark_breadcrumb_content' ) ) :

	/**
	 * function to manage the breadcrumbs content
	 */
	function color_blog_dark_breadcrumb_content() {
		$color_blog_dark_breadcrumb_option = get_theme_mod( 'color_blog_dark_enable_breadcrumb_option', true );
		if ( false === $color_blog_dark_breadcrumb_option ) {
			return;
		}
?>
		<nav id="breadcrumb" class="mt-breadcrumb">
			<?php
			breadcrumb_trail( array(
				'container'   => 'div',
				'before'      => '<div class="mt-container">',
				'after'       => '</div>',
				'show_browse' => false,
			) );
			?>
		</nav>
<?php
	}

endif;

if ( ! function_exists( 'color_blog_dark_innerpage_header_end' ) ) :

	/**
	 * function to manage ending div of section
	 */
	function color_blog_dark_innerpage_header_end() {
?>
			</div><!-- .mt-container -->
		</div><!-- .custom-header -->
<?php
	}

endif;

/**
 * manage the function at color_blog_dark_innerpage_header hook
 */

add_action( 'color_blog_dark_innerpage_header', 'color_blog_dark_innerpage_header_start', 5 );
add_action( 'color_blog_dark_innerpage_header', 'color_blog_dark_innerpage_header_title', 10 );
add_action( 'color_blog_dark_innerpage_header', 'color_blog_dark_breadcrumb_content', 15 );
add_action( 'color_blog_dark_innerpage_header', 'color_blog_dark_innerpage_header_end', 20 );

/*----------------------------------------------------------------------------------------------------------------------------------*/
if ( ! function_exists( 'color_blog_dark_front_slider' ) ) :

	/**
	 * Function displaying front slider section
	 * 
	 */
	function color_blog_dark_front_slider() {
		$color_blog_dark_section_slider_option = get_theme_mod( 'color_blog_dark_section_slider_option', false );
		if ( false == $color_blog_dark_section_slider_option ) {
			return;
		}
		$color_blog_dark_section_top_featured_posts_option = get_theme_mod( 'color_blog_dark_section_top_featured_posts_option', true );
		if ( true === $color_blog_dark_section_top_featured_posts_option ) {
			$slider_class = 'has-featured-slider default-width--slider';
		} else {
			$slider_class = 'no-featured-slider full-width--slider';
		}
?>
			<div class="front-slider-wrapper <?php echo esc_attr( $slider_class ); ?>">
				<div class="mt-container">
					<div class="front-slider-block">
						<div class="front-slider cS-hidden">
						<?php
							$slider_cat_slug = get_theme_mod( 'color_blog_dark_section_slider_cat', '' );
							$slide_post_count = apply_filters( 'color_blog_dark_slider_post_count', 3 );
							$slider_args = array(
								'category_name'    	=> esc_attr( $slider_cat_slug ), 
								'meta_key'     		=> '_thumbnail_id',
								'posts_per_page' 	=> absint( $slide_post_count )
							);
							$slider_post_query = new WP_Query( $slider_args );
							if ( $slider_post_query->have_posts() ) :
								while ( $slider_post_query-> have_posts() ) : 
									$slider_post_query -> the_post();
									$post_id = get_the_ID();
									$image_url = get_the_post_thumbnail_url( $post_id, 'large' );
									if ( ! empty( $image_url ) ) {
										$slider_style = 'style="background:url('. esc_url( $image_url ) .') no-repeat scroll center center; background-size:cover"';
									} else {
										$slider_style = '';
									}
						?>
									<div class="slider-post-wrap" <?php echo $slider_style; ?>>
										<div class="post-thumbnail">
											<a href="<?php the_permalink(); ?>"></a>
										</div>
										<div class="post-info-wrap">
											<div class="post-cat"><?php color_blog_dark_article_categories_list(); ?></div>
											<div class="entry-meta"> 
												<?php 
													color_blog_dark_posted_on();
													color_blog_dark_posted_by();
												?> 
											</div>
											<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
										</div><!--.post-info-wrap -->
									</div><!-- .slider-post-wrap -->
							<?php
								endwhile;
							endif;
						?>
						</div><!-- .front-slider -->
					</div> <!-- .front-slider-block -->
			<?php
					if ( true == $color_blog_dark_section_top_featured_posts_option ) {
						$color_blog_dark_top_featured_posts_title = get_theme_mod( 'color_blog_dark_top_featured_posts_title', __( 'Featured News', 'color-blog-dark' ) );
						echo '<div class="top-featured-post-main-wrapper">';
							if ( ! empty( $color_blog_dark_top_featured_posts_title ) ) {
								echo '<div class="features-post-title">'.esc_html( $color_blog_dark_top_featured_posts_title ).'</div><!-- .features-post-title -->';
							}
								
								$color_blog_dark_top_featured_post_order = get_theme_mod( 'color_blog_dark_top_featured_post_order', 'default' );
								$featured_posts_per_page = apply_filters( 'color_blog_dark_featured_post_count', 5 );
								$top_featured_post_args = array( 
									'post_type' 		=> 'post',
									'posts_per_page' 	=> absint( $featured_posts_per_page ),
								);
								if ( 'random' == $color_blog_dark_top_featured_post_order ) {
									$top_featured_post_args['orderby'] = 'rand';
								}
								$top_featured_post_query = new WP_Query( $top_featured_post_args );
								if ( $top_featured_post_query -> have_posts() ) :
									echo '<div class="top-featured-post-wrap">';
										$featured_post_count = 1;
										while ( $top_featured_post_query -> have_posts() ) : $top_featured_post_query -> the_post();
							?>
											<div  id="post-<?php the_ID(); ?>" class="mt-single-post-wrap mt-clearfix">
												<div class="post-thumbnail">
													<span class="post-number"><?php echo absint( $featured_post_count ); ?></span>	
												    <figure style="background: no-repeat center top url(<?php echo get_the_post_thumbnail_url(); ?>); background-size: cover; height: 100px;">
													</figure>
												</div>
												<div class="mt-post-content">
													<div class="entry-meta">
														<?php 
															color_blog_dark_posted_on();
															color_blog_dark_posted_by();
														?>
													</div>	
													<header class="entry-header">
														<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
													</header><!-- .entry-header -->
												</div>
											</div><!-- #post-<?php the_ID(); ?> -->
							<?php
										$featured_post_count ++;
									endwhile;
								echo '</div><!-- .top-featured-post-wrap -->';
								endif;
						echo '</div><!-- .top-featured-post-main-wrapper -->';
					}
				?>
				</div>
			</div><!-- .front-slider-wrapper -->
<?php
	}

endif;	
add_action( 'color_blog_dark_front_slider_section', 'color_blog_dark_front_slider' );

/*----------------------------------------------------------------------------------------------------------------------------------*/
if ( ! function_exists( 'color_blog_dark_footer_start' ) ) :

	/**
	 * function to start footer wrapper
	 */
	function color_blog_dark_footer_start() {
		echo '<footer itemscope id="colophon" class="site-footer">';
	}

endif;

if ( ! function_exists( 'color_blog_dark_footer_sidebar' ) ) :

	/**
	 * function to display footer widget area
	 */
	function color_blog_dark_footer_sidebar() {
		$color_blog_dark_footer_widget_option = get_theme_mod( 'color_blog_dark_enable_footer_widget_area', true );
		if ( true === $color_blog_dark_footer_widget_option ) {
			get_sidebar( 'footer' );
		}
	}

endif;

if ( ! function_exists( 'color_blog_dark_bottom_footer' ) ) :

	/**
	 * function to display bottom footer section
	 */
	function color_blog_dark_bottom_footer() {
?>
		<div id="bottom-footer">
            <div class="mt-container">
        		<?php
        			$color_blog_dark_enable_footer_menu = get_theme_mod( 'color_blog_dark_enable_footer_menu', true );
        			if ( true === $color_blog_dark_enable_footer_menu ) {
        		?>
        				<nav id="footer-navigation" class="footer-navigation">
    						<?php
    							wp_nav_menu( array(
    								'theme_location' => 'footer_menu',
    								'menu_id'        => 'footer-menu',
    								'fallback_cb' 	 => false,
    								'depth'			 => 1
    							) );
    						?>
        				</nav><!-- #footer-navigation -->
        		<?php
        			}
        		?>

        		<div class="site-info">
        			<span class="mt-copyright-text">
        				<?php 
        					$color_blog_dark_footer_copyright = get_theme_mod( 'color_blog_dark_footer_copyright', __( 'Color Blog Dark', 'color-blog-dark' ) );
        					echo esc_html( $color_blog_dark_footer_copyright );
        				?>
        			</span>
        			<span class="sep"> | </span>
        				<?php
	        				/* translators: 1: Theme name, 2: Theme author. */
	        				printf( esc_html__( 'Theme: %1$s by %2$s.', 'color-blog-dark' ), 'Color Blog Dark', '<a  itemprop="url" href="https://mysterythemes.com">Mystery Themes</a>' );
        				?>
        		</div><!-- .site-info -->
            </div><!-- .mt-container -->
        </div><!-- #bottom-footer -->
<?php
	}

endif;

if ( ! function_exists( 'color_blog_dark_footer_end' ) ) :

	/**
	 * function to end footer wrapper
	 */
	function color_blog_dark_footer_end() {
		echo '</footer><!-- #colophon -->';
	}

endif;

/**
 * manage the function at color_blog_dark_footer hook
 */
add_action( 'color_blog_dark_footer', 'color_blog_dark_footer_start', 5 );
add_action( 'color_blog_dark_footer', 'color_blog_dark_footer_sidebar', 10 );
add_action( 'color_blog_dark_footer', 'color_blog_dark_bottom_footer', 15 );
add_action( 'color_blog_dark_footer', 'color_blog_dark_footer_end', 20 );