<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package pliska
 */

 /**
  * Print edit button for logged-in editors
  */
if ( ! function_exists( 'pliska_edit_link' ) ) :

	function pliska_edit_link() {

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'pliska' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);

	}
endif;

/**
 * Prints the post author.
 */

if ( ! function_exists( 'pliska_posted_by' ) ) :
	function pliska_posted_by() {
		if ( 'post' !== get_post_type() ) {
			return;
		}
		global $post;
		$show_post_author = get_theme_mod( 'show_post_author', 1 );
		$author_id        = $post->post_author;
		$customizer_class = ! $show_post_author && is_customize_preview() ? ' hide' : '';

		if ( $show_post_author || is_customize_preview() ) {
			echo sprintf(
				'<span class="screen-reader-text">Post author</span>' .
				'<div class="author byline' . esc_attr( $customizer_class ) . '">' .
				'<span class="author vcard"' . pliska_schema_microdata( 'author', 0 ) . '>' .
					'<a class="url fn n" rel="author" href="%1$s" title="%2$s"' . pliska_schema_microdata( 'author-url', 0 ) . '>
						<span class="author-avatar" >' . get_avatar( $author_id ) . '</span>
						<em' . pliska_schema_microdata( 'author-name', 0 ) . '>%3$s</em></a>' .
				'</span></div>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID', $author_id ) ) ),
				sprintf( esc_attr__( 'View all posts by %s', 'pliska' ), wp_kses( get_the_author_meta( 'display_name', $author_id ), array() ) ),
				wp_kses( get_the_author_meta( 'display_name', $author_id ), array() )
			);
		}
	}
endif;

/**
 * Print the post categories.
 */
/* translators: used between list items, there is a space after the comma */
if ( ! function_exists( 'pliska_posted_in' ) ) :
	function pliska_posted_in() {
		if ( 'post' !== get_post_type() ) {
			return;
		}
		$display_category_list = get_theme_mod( 'show_post_categories', 1 );

		if ( $display_category_list || is_customize_preview() ) {
			$category_list = get_the_category_list( esc_html( ' ' ) );
			?>
			<?php if ( $category_list ) : ?>
				<span class="screen-reader-text"><?php esc_html_e( 'Post Categories', 'pliska' ); ?></span>
				<span class="cat-links <?php echo esc_attr( ! $display_category_list && is_customize_preview() ? 'hide' : 'show' ); ?>">
					<?php printf( /* category list */esc_html( '%1$s' ), $category_list ); // xss ok. ?>
				</span>
				<?php
			endif;
		}
	}
endif;

/**
 * Prints the post-date/time.
 */

if ( ! function_exists( 'pliska_posted_on' ) ) :
	function pliska_posted_on() {
		if ( 'post' !== get_post_type() ) {
			return;
		}
		// check user settings in theme customizer
		$show_post_published_date = get_theme_mod( 'show_post_date', 1 );
		if ( $show_post_published_date || is_customize_preview() ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
			$time_string = sprintf(
				$time_string,
				esc_attr( get_the_date( DATE_W3C ) ),
				esc_html( get_the_date() )
			);
			$posted_on   = sprintf(
				esc_html( '%s', 'post date' ),
				'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
			);
			echo '<span class="screen-reader-text">' . __( 'Post date', 'pliska' ) . '</span><span class="posted-on' , pliska_add_customizer_class( $show_post_published_date ) , '">' , $posted_on , '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

	}
endif;

/**
 * Display last modified date.
 */

if ( ! function_exists( 'pliska_updated_on' ) ) :
	function pliska_updated_on() {
		if ( 'post' !== get_post_type() ) {
			return;
		}
		// check user settings in theme customizer
		$show_modified_date = get_theme_mod( 'show_modified_date', 1 );
		if ( $show_modified_date || is_customize_preview() ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
			$time_string = sprintf(
				$time_string,
				esc_attr( get_the_modified_date( DATE_W3C ) ),
				esc_html( get_the_modified_date() )
			);
			$updated_on  = sprintf(
				esc_html_x( 'Updated %s', 'post date', 'pliska' ),
				'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
			);
			echo '<span class="screen-reader-text">' . __( 'Post last updated date', 'pliska' ) . '</span><span class="updated-on' ,  pliska_add_customizer_class( $show_modified_date ) , '">' , $updated_on , '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

	}
endif;

/**
 * Print post reading time
 */

function pliska_blog_read_time() {

	if ( 'post' !== get_post_type() ) {
		return;
	}

	$show_time_to_read = get_theme_mod( 'show_time_to_read', 1 );

	if ( $show_time_to_read || is_customize_preview() ) {
		global $post;
		$words_per_minute = 225;
		$words_per_second = $words_per_minute / 60;

		// Count the words in the content.
		$word_count = str_word_count( strip_tags( $post->post_content ) );

		// [UNUSED] How many minutes?
		$minutes = floor( $word_count / $words_per_minute );

		// [UNUSED] How many seconds (remainder)?
		$seconds_remainder = floor( $word_count % $words_per_minute / $words_per_second );

		// How many seconds (total)?
		$seconds_total = floor( $word_count / $words_per_second );

		printf( '<span class="screen-reader-text">' . __( 'Post read time', 'pliska' ) . '</span><span class="time-read-links' . pliska_add_customizer_class( $show_time_to_read ) . '">' . wp_kses( pliska_get_svg( 'clock' ), pliska_get_kses_extended_ruleset() ) . '<span class="time-read">' . wp_kses_post( pliska_blog_convert_read_time( $seconds_total ) . '</span> </span>' ) );
	}

}

function pliska_blog_convert_read_time( $seconds ) {

	$string = '';

	$days    = intval( intval( $seconds ) / ( 3600 * 24 ) );
	$hours   = ( intval( $seconds ) / 3600 ) % 24;
	$minutes = ( intval( $seconds ) / 60 ) % 60;
	$seconds = ( intval( $seconds ) ) % 60;

	if ( $days > 0 ) {
		$string .= "$days " . esc_html__( 'days read', 'pliska' );
		return $string;
	}
	if ( $hours > 0 ) {
		$string .= "$hours " . esc_html__( 'hrs read', 'pliska' );
		return $string;
	}
	if ( $minutes > 0 ) {
		$string .= "$minutes " . esc_html__( 'min read', 'pliska' );
		return $string;
	}
	if ( $seconds > 0 ) {
		$string .= "$seconds " . esc_html__( 'sec read', 'pliska' );
		return $string;
	}

	return $string;
}

if ( ! function_exists( 'pliska_comments' ) ) :

	function pliska_comments() {
		$display_comments = get_theme_mod( 'show_post_comments', 1 );

		if ( $display_comments || is_customize_preview() ) {

			if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {

				$no_of_comments = get_comments_number( get_the_ID() );

				echo '<span class="comments-link' . pliska_add_customizer_class( $display_comments ) . '">' . wp_kses( pliska_get_svg( 'comment' ), pliska_get_kses_extended_ruleset() ) . '<a href="' . esc_url( get_comments_link() ) . '">';
				echo absint( $no_of_comments );
				echo '</a></span>';

			}
		}

	}

endif;

if ( ! function_exists( 'pliska_tags' ) ) :

	function pliska_tags() {
		$display_tag_list = get_theme_mod( 'show_post_tags', 1 );
		// Hide tags for pages.
		if ( 'page' !== get_post_type() ) {
			if ( $display_tag_list || is_customize_preview() ) {
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', esc_html( ',&nbsp;' ) );
				if ( $tags_list ) {
					/* translators: 1: list of tags. */
					printf( '<span class="screen-reader-text">' . __( 'Post tags', 'pliska' ) . '</span><span class="tags-links' . pliska_add_customizer_class( $display_tag_list ) . '">' . wp_kses( pliska_get_svg( 'tag' ), pliska_get_kses_extended_ruleset() ) . esc_html( '%s' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
			}
		}
	}

endif;

/**
 * Prints post tags and comments.
 */
if ( ! function_exists( 'pliska_entry_footer' ) ) :
	function pliska_entry_footer() {
		pliska_tags();
		pliska_comments();
	}

endif;

if ( ! function_exists( 'pliska_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function pliska_post_thumbnail( $size = '' ) {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}
		?>
		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<figure>
				<?php
					the_post_thumbnail(
						$size,
						array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
				?>
			</figure>
		</a> 
		<?php
	}
endif;

function pliska_footer_default_theme_credits() {
	esc_html_e( 'Designed by', 'pliska' );
	?>
		<a href="<?php echo esc_url( __( 'https://nasiothemes.com/', 'pliska' ) ); ?>" class="imprint">
			<?php esc_html_e( 'Nasio Themes', 'pliska' ); ?>
		</a>
		<span class="sep"> || </span>
		<?php
		/* translators: %s: CMS name, i.e. WordPress. */
		esc_html_e( 'Powered by', 'pliska' );
		?>
		<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'pliska' ) ); ?>" class="imprint">
			<?php esc_html_e( 'WordPress', 'pliska' ); ?>
		</a>
	<?php
}

function pliska_footer_custom_theme_credits() {
	if ( get_theme_mod( 'footer_text_block' ) ) :
		echo esc_html( get_theme_mod( 'footer_text_block' ) ) , ' || ';
	endif;
}

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;

/**
 * Adds a Sub Nav Toggle Button to the Mobile Menu.
 *
 * @param stdClass $args  An object of wp_nav_menu() arguments.
 * @param WP_Post  $item  Menu item data object.
 * @param int      $depth Depth of menu item. Used for padding.
 * @return stdClass An object of wp_nav_menu() arguments.
 */
function pliska_add_sub_toggles_to_main_menu( $args, $item, $depth ) {
	// Add sub menu toggles to the Expanded Menu with toggles.
	if ( isset( $args->show_toggles ) ) {

		$args->after = '';

		// Add a toggle to items with children.
		if ( in_array( 'menu-item-has-children', $item->classes, true ) || in_array( 'page_item_has_children', $item->classes, true ) ) {

			// Add the sub menu toggle.
			$args->after .= '<button class="menu-toggle sub-menu-toggle" aria-expanded="false">' . '<i class="arrow-down"></i>' . '<span class="screen-reader-text">' . __( 'Show sub menu', 'pliska' ) . '</span></button>';

		}
	}

	return $args;

}

add_filter( 'nav_menu_item_args', 'pliska_add_sub_toggles_to_main_menu', 10, 3 );

/* Add search list item to top menu bar */

function pliska_add_search_box() {
	?>
	
	<li class="search-item">
		<?php get_search_form(); ?>
		<a href="#search-open">
			<span class="screen-reader-text"><?php esc_html_e( 'Search', 'pliska' ); ?></span>
			<i class="search-icon">
				<?php echo wp_kses( pliska_get_svg( 'search' ), pliska_get_kses_extended_ruleset() ); ?>
			</i>
		</a>
	</li>
	<?php

}

function pliska_add_top_menu_items( $items, $args ) {
	ob_start();
	if ( class_exists( 'WooCommerce' ) ) {
		pliska_woocommerce_header_cart();
	}
	pliska_add_search_box(); ?>
	<li class="dark-mode-menu-item">
		<?php pliska_dark_mode_button_markup();?>
	</li>
	<?php $items .= ob_get_clean();
	return $items;
}

add_filter( 'wp_nav_menu_items', 'pliska_add_top_menu_items', 10, 2 );
add_filter( 'wp_list_pages', 'pliska_add_top_menu_items', 10, 2 );

/**
 *  Social icons markup in theme footer
 */
function pliska_phone( $phone ) {
	if ( $phone ) :
		?>
		<li class="social-icon phone">
			<a href="#">
			<?php echo wp_kses( pliska_get_svg( 'phone' ), pliska_get_kses_extended_ruleset() ); ?>
			 <span><?php echo esc_html( $phone ); ?></span>
			</a>
		</li>
		 <?php
	 endif;
}

function pliska_facebook( $facebook_url ) {
	if ( $facebook_url ) :
		?>
	   <li class="social-icon facebook">
		   <a href="<?php echo esc_url( $facebook_url ); ?>" aria-label="<?php _e('Facebook', 'pliska')?>">
				<?php echo wp_kses( pliska_get_svg( 'facebook' ), pliska_get_kses_extended_ruleset() ); ?>
		   </a>
	   </li> 
		<?php
	endif;
}

function pliska_instagram( $instagram ) {
	if ( $instagram ) :
		?>
	   <li class="social-icon instagram">
		   <a href="<?php echo esc_url( $instagram ); ?>" aria-label="<?php _e('Instagram', 'pliska')?>">
				<?php echo wp_kses( pliska_get_svg( 'instagram' ), pliska_get_kses_extended_ruleset() ); ?>
		   </a>
	   </li> 
		<?php
	endif;

}

function pliska_twitter( $twitter ) {
	if ( $twitter ) :
		?>
	   <li class="social-icon twitter">
		   <a href="<?php echo esc_url( $twitter ); ?>" aria-label="<?php _e('Twitter', 'pliska')?>">
				<?php echo wp_kses( pliska_get_svg( 'twitter' ), pliska_get_kses_extended_ruleset() ); ?>
		   </a>
	   </li>
		<?php
	   endif;
}

function pliska_youtube( $youtube ) {
	if ( $youtube ) :
		?>
	   <li class="social-icon youtube">
		   <a href="<?php echo esc_url( $youtube ); ?>" aria-label="<?php _e('Youtube', 'pliska')?>">
				<?php echo wp_kses( pliska_get_svg( 'youtube' ), pliska_get_kses_extended_ruleset() ); ?>
		   </a>
	   </li>
		<?php
	endif;
}

function pliska_linkedin( $linkedin ) {
	if ( $linkedin ) :
		?>
	   <li class="social-icon linkedin">
		   <a href="<?php echo esc_url( $linkedin ); ?>" aria-label="<?php _e('Linkedin', 'pliska')?>">
				   <i><?php echo wp_kses( pliska_get_svg( 'linkedin' ), pliska_get_kses_extended_ruleset() ); ?></i>
		   </a>
	   </li>
		<?php
	endif;
}

function pliska_email( $mail ) {
	if ( $mail ) :
		?>
	   <li class="social-icon email">
		   <a href="mailto:<?php echo esc_html( $mail ); ?>" aria-label="<?php _e('Email', 'pliska')?>">
				<?php echo wp_kses( pliska_get_svg( 'mail' ), pliska_get_kses_extended_ruleset() ); ?>
		   </a>
	   </li>
		<?php
	endif;

}

/**
 * Custom comment markup for this theme
 *
 * @since 0.0.1
 * @package Pliska
 */

function pliska_comment( $comment, $args, $depth ) {
	switch ( $comment->comment_type ) :
		case 'pingback':
		case 'trackback':
			?>
				<li class="post pingback">
				<p><?php _e( 'Pingback: ', 'pliska' ); ?><?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'pliska' ), ' ' ); ?></p>
			<?php
			break;
		case '':
		default:
			?>
				<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>"<?php pliska_schema_microdata( 'comment' ); ?>>
	
					<article class="comment-body">
	
						<div class="comment-meta">
							<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
							<time datetime="<?php comment_time( 'c' ); ?>" <?php pliska_schema_microdata( 'time' ); ?>>

								<span class="comment-date">
								<?php
									/* translators: 1: date, 2: time */
								printf( '%1$s ' . __( 'at', 'pliska' ) . ' %2$s', get_comment_date(), get_comment_time() );
								?>
								</span>
								<span class="comment-timediff">
									<?php printf( _x( '%1$s ago', '%s = human-readable time difference', 'pliska' ), esc_html( human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ) ); ?>
								</span>

							</time>
							</a>
							<?php edit_comment_link( __( '(Edit)', 'pliska' ), ' ' ); ?>
						</div><!-- .comment-meta -->
	
						<div class="comment-content">
							<?php if ( $comment->comment_approved == '0' ) : ?>
								<span class="comment-await"><em><?php _e( 'Your comment is awaiting moderation.', 'pliska' ); ?></em></span>
							<?php endif; ?>
							<div class="comment-avatar">
								<figure>
									<?php echo get_avatar( $comment, 64, '', '', array( 'extra_attr' => pliska_schema_microdata( 'image', 0 ) ) ); ?>
								</figure>
								</div>
							<div class="comment-text" <?php pliska_schema_microdata( 'text' ); ?>>
								<div class="comment-author" <?php pliska_schema_microdata( 'comment-author' ); ?>>
									<?php printf( '%s ', sprintf( '<h3 class="author-name fn"' . pliska_schema_microdata( 'author-name', 0 ) . '>%s</h3>', get_comment_author_link() ) ); ?>
								</div> <!-- .comment-author -->
								<?php comment_text(); ?>
							</div><!-- .comment-body -->
						</div>
	
						<div class="reply">
							<?php
							comment_reply_link(
								array_merge(
									$args,
									array(
										'reply_text' => '<i class="icon-reply-comments"></i> ' . __( 'Reply', 'pliska' ),
										'depth'      => $depth,
										'max_depth'  => $args['max_depth'],
									)
								)
							);
							?>
						</div><!-- .reply -->
	
					</article>
			<?php
			break;
		endswitch;

		// </li><!-- #comment-##  -->  closed by wp_comments_list()
}
