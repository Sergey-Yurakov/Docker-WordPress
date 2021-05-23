<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Color Blog Dark
 * @since 1.0.0
 */

?>
	    </div> <!-- mt-container -->
	</div><!-- #content -->

    <?php
        /**
         * color_blog_dark before footer
         * 
         * @since 1.0.0
         */
        do_action( 'color_blog_dark_before_footer' );

        /**
         * color_blog_dark footer
         * 
         * @hooked - color_blog_dark_footer_start - 5
         * @hooked - color_blog_dark_footer_sidebar - 10
         * @hooked - color_blog_dark_bottom_footer - 15
         * @hooked - color_blog_dark_footer_end - 20
         *
         * @since 1.0.0
         */
        do_action( 'color_blog_dark_footer' );


		/**
		 * color_blog_dark_scroll_top hook
		 *
		 * @hooked - color_blog_dark_scroll_top_content - 10
		 *
		 * @since 1.0.0
		 */
		do_action( 'color_blog_dark_scroll_top' );
	?>
	
</div><!-- #page -->

<?php
	/**
     * color_blog_dark_after_page hook
     *
     * @since 1.0.0
     */
    do_action( 'color_blog_dark_after_page' );

    wp_footer();
?>
</body>
</html>
