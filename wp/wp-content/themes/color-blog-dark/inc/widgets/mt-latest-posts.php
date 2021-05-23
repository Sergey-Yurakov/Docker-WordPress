<?php
/**
 * MT: Latest Posts
 *
 * Widget show the latest post with thumbnail.
 *
 * @package Color Blog Dark
 * @since 1.0.0
 */

class color_blog_dark_Latest_Posts extends WP_widget {

	/**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_ops = array( 
            'classname'         => 'color_blog_dark_latest_posts',
            'description'       => __( 'A widget to display the latest posts with thumbnail.', 'color-blog-dark' ),
            'customize_selective_refresh'   => true,
        );
        parent::__construct( 'color_blog_dark_latest_posts', __( 'MT: Latest Posts', 'color-blog-dark' ), $widget_ops );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        
        $fields = array(

            'widget_title' => array(
                'color_blog_dark_widgets_name'         => 'widget_title',
                'color_blog_dark_widgets_title'        => __( 'Widget title', 'color-blog-dark' ),
                'color_blog_dark_widgets_field_type'   => 'text'
            ),

            'widget_post_order' => array(
                'color_blog_dark_widgets_name'         => 'widget_post_order',
                'color_blog_dark_widgets_title'        => __( 'Post Order', 'color-blog-dark' ),
                'color_blog_dark_widgets_default'      => 'default',
                'color_blog_dark_widgets_field_type'   => 'select',
                'color_blog_dark_widgets_field_options' => array(
                    'default'   => __( 'Default Order', 'color-blog-dark' ),
                    'random'    => __( 'Random Order', 'color-blog-dark' ),
                )
            ),

            'widget_post_count' => array(
                'color_blog_dark_widgets_name'         => 'widget_post_count',
                'color_blog_dark_widgets_title'        => __( 'Post Count', 'color-blog-dark' ),
                'color_blog_dark_widgets_default'      => '5',
                'color_blog_dark_widgets_field_type'   => 'number'
            )

        );
        return $fields;
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );

        if ( empty( $instance ) ) {
            return ;
        }

        $color_blog_dark_widget_title = empty( $instance['widget_title'] ) ? '' : $instance['widget_title'];
        $color_blog_dark_post_order   = empty( $instance['widget_post_order'] ) ? 'default' : $instance['widget_post_order'];
        $color_blog_dark_post_count   = empty( $instance['widget_post_count'] ) ? '5' : $instance['widget_post_count'];

        echo $before_widget;
    ?>
            <div class="mt-latest-posts-wrapper">
                <?php
                    if ( !empty( $color_blog_dark_widget_title ) ) {
                        echo $before_title . esc_html( $color_blog_dark_widget_title ) . $after_title;
                    }
                ?>
                <div class="mt-posts-content-wrapper">
                    <?php
                        $color_blog_dark_posts_args = array(
                            'posts_per_page'        => absint( $color_blog_dark_post_count ),
                            'ignore_sticky_posts'   => 1,
                        );
                        if ( 'random' === $color_blog_dark_post_order ) {
                            $color_blog_dark_posts_args['orderby'] = 'rand';
                        }
                        $color_blog_dark_posts_query = new WP_Query( $color_blog_dark_posts_args );
                        if ( $color_blog_dark_posts_query->have_posts() ) {
                            while ( $color_blog_dark_posts_query->have_posts() ) {
                                $color_blog_dark_posts_query->the_post();
                    ?>
                                <div class="mt-single-post-wrap">
                                    <?php if ( has_post_thumbnail() ) { ?>
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                            <figure><div class="mt-post-thumb"><?php the_post_thumbnail( 'thumbnail' ); ?></div></figure>
                                        </a>
                                    <?php } ?>
                                    <div class="mt-post-content">
                                        <h5 class="mt-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                        <div class="entry-cat">
                                            <?php
                                                color_blog_dark_posted_on();
                                                color_blog_dark_posted_by();  
                                            ?>
                                        </div>
                                        <?php color_blog_dark_widget_entry_footer(); ?>
                                    </div>
                                </div><!-- .mt-single-post-wrap -->
                    <?php
                            }
                        }
                    ?>
                </div><!-- .mt-posts-content-wrapper -->
            </div><!-- .mt-latest-posts-wrapper -->
    <?php
        echo $after_widget;
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param   array   $new_instance   Values just sent to be saved.
     * @param   array   $old_instance   Previously saved values from database.
     *
     * @uses    color_blog_dark_widgets_updated_field_value()     defined in mt-widget-fields.php
     *
     * @return  array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ( $widget_fields as $widget_field ) {

            extract( $widget_field );

            // Use helper function to get updated field values
            $instance[$color_blog_dark_widgets_name] = color_blog_dark_widgets_updated_field_value( $widget_field, $new_instance[$color_blog_dark_widgets_name] );
        }

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param   array $instance Previously saved values from database.
     *
     * @uses    color_blog_dark_widgets_show_widget_field()       defined in mt-widget-fields.php
     */
    public function form( $instance ) {
        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ( $widget_fields as $widget_field ) {

            // Make array elements available as variables
            extract( $widget_field );
            $color_blog_dark_widgets_field_value = !empty( $instance[$color_blog_dark_widgets_name] ) ? wp_kses_post( $instance[$color_blog_dark_widgets_name] ) : '';
            color_blog_dark_widgets_show_widget_field( $this, $widget_field, $color_blog_dark_widgets_field_value );
        }
    }
}