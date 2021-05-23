<?php
/**
 * Managed the custom functions and hooks for top header of theme.
 *
 * @package Color Blog Dark
 * @since 1.0.0
 */
/*----------------------------------------------------------------------------------------------------------------------------------*/
if ( ! function_exists( 'color_blog_dark_top_header_start' ) ) :

	/**
	 * function to start top header section
	 */
	function color_blog_dark_top_header_start() {
		echo '<div id="top-header" class="top-header-wrap mt-clearfix">';
		echo '<div class="mt-container">';
	}

endif;

if ( ! function_exists( 'color_blog_dark_top_header_end' ) ) :

	/**
	 * function to end top header section
	 */
	function color_blog_dark_top_header_end() {
		echo '</div><!-- mt-container -->';
		echo '</div><!-- #top-header -->';
	}

endif;

if ( ! function_exists( 'color_blog_dark_trending_section' ) ) :

    /**
     * function to display the trending tags sections
     *
     */
    function color_blog_dark_trending_section() {
		$color_blog_dark_enable_trending = get_theme_mod( 'color_blog_dark_enable_trending', false );
		if ( false === $color_blog_dark_enable_trending ){
			return;
		}
		$color_blog_dark_enable_trending_tag_before_icon = get_theme_mod( 'color_blog_dark_enable_trending_tag_before_icon', true );
		if ( $color_blog_dark_enable_trending_tag_before_icon === true ){
			$before_icon = 'tag-before-icon';
		}else{
			$before_icon = '';
		}
		$trending_label = get_theme_mod( 'color_blog_dark_trending_label', __( 'Trending Now', 'color-blog-dark' ) );
?>
        <div class="trending-wrapper <?php echo esc_html( $before_icon ); ?>">
                <span class="wrap-label"><i class="fa fa-bolt" aria-hidden="true"></i> <?php echo esc_html( $trending_label ); ?></span>
                <div class="tags-wrapper">
					<?php
						$color_blog_dark_trending_tags_orderby = get_theme_mod( 'color_blog_dark_trending_tags_orderby', '' );
							$color_blog_dark_trending_tags_count = get_theme_mod( 'color_blog_dark_trending_tags_count', '5' );
							$get_tags_lists = get_tags( array(
								'order' => 'DESC',
								'orderby'=> esc_attr( $color_blog_dark_trending_tags_orderby ),
								'number' => absint( $color_blog_dark_trending_tags_count ),
							));
							if ( !empty( $get_tags_lists ) ) {
								echo '<span class="head-tags-links">';
								foreach( $get_tags_lists as $tag ) {
									echo '<a href="'.esc_html( get_tag_link( $tag->term_id ) ).'" rel="tag">'. esc_html( $tag->name ) .'</a>';
								}
								echo '</span>';
							}
                    ?>
                </div><!-- .tags-wrapper -->
        </div><!-- .trending-wrapper -->
<?php
    }

endif;

if ( ! function_exists( 'color_blog_dark_top_header_nav' ) ) :

	/**
	 * function to display top nav menu.
	 */
	function color_blog_dark_top_header_nav() {

		$color_blog_dark_enable_live_now = get_theme_mod( 'color_blog_dark_enable_live_now', false );

		if ( true === $color_blog_dark_enable_live_now ) {
			$color_blog_dark_live_now_label = get_theme_mod( 'color_blog_dark_live_now_label', __( 'Live Now', 'color-blog-dark' ) );
			$color_blog_dark_live_now_link = get_theme_mod( 'color_blog_dark_live_now_link' );
	?>
			<div class="mt-live-link">
				<a href="<?php echo esc_url( $color_blog_dark_live_now_link ); ?>" target="_blank"> <i class="fa fa-play-circle-o" aria-hidden="true"></i><?php echo esc_html( $color_blog_dark_live_now_label ); ?></a>
			</div>
	<?php
		}
	?>
		<div class="top-header-nav">
			<nav itemscope id="top-navigation" class="main-navigation">
				<?php
					wp_nav_menu( array(
						'theme_location' => 'top_header_menu',
						'menu_id'        => 'top-header-menu',
						'fallback_cb'	 => false,
					) );
				?>
			</nav><!-- #site-navigation -->
		</div><!-- .top-header-nav -->
	<?php
	}

endif;
/*----------------------------------------------------------------------------------------------------------------------------------*/
add_action( 'color_blog_dark_top_header', 'color_blog_dark_top_header_start', 5 );
add_action( 'color_blog_dark_top_header', 'color_blog_dark_trending_section', 10 );
add_action( 'color_blog_dark_top_header', 'color_blog_dark_top_header_nav', 20 );
add_action( 'color_blog_dark_top_header', 'color_blog_dark_top_header_end', 50 );