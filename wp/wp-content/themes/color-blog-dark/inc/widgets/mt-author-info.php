<?php
/**
 * MT: Author Info
 *
 * Widget show the author information
 *
 * @package Color Blog Dark
 * @since 1.0.0
 */

class color_blog_dark_Author_Info extends WP_widget {

	/**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_ops = array( 
            'classname'         => 'color_blog_dark_author_info',
            'description'       => __( 'Select the user to display the author info.', 'color-blog-dark' ),
            'customize_selective_refresh'   => true,
        );
        parent::__construct( 'color_blog_dark_author_info', __( 'MT: Author Info', 'color-blog-dark' ), $widget_ops );
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

            'user_name' => array(
                'color_blog_dark_widgets_name'         => 'user_name',
                'color_blog_dark_widgets_title'        => __( 'User Name', 'color-blog-dark' ),
                'color_blog_dark_widgets_field_type'   => 'text'
            ),

            'user_id' => array(
                'color_blog_dark_widgets_name'         => 'user_id',
                'color_blog_dark_widgets_title'        => __( 'Select Author', 'color-blog-dark' ),
                'color_blog_dark_widgets_default'      => '',
                'color_blog_dark_widgets_field_type'   => 'user_dropdown'
            ),

            'user_thumb' => array(
                'color_blog_dark_widgets_name'         => 'user_thumb',
                'color_blog_dark_widgets_title'        => __( 'Author Image', 'color-blog-dark' ),
                'color_blog_dark_widgets_field_type'   => 'upload'
            ),

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

        $color_blog_dark_widget_title    = empty( $instance['widget_title'] ) ? '' : $instance['widget_title'];
        $color_blog_dark_user_name       = empty( $instance['user_name'] ) ? '' : $instance['user_name'];
        $color_blog_dark_user_id         = empty( $instance['user_id'] ) ? '' : $instance['user_id'];
        $color_blog_dark_user_image      = empty( $instance['user_thumb'] ) ? '' : $instance['user_thumb'];

        echo $before_widget;
    ?>
            <div class="mt-author-info-wrapper">
                <?php
                    if ( ! empty( $color_blog_dark_widget_title ) ) {
                        echo $before_title . esc_html( $color_blog_dark_widget_title ) . $after_title;
                    }
                ?>
                <div class="author-bio-wrap">
                    <div class="author-avatar">
                        <?php
                            if ( ! empty( $color_blog_dark_user_image ) ) {
                                echo '<img src="'. esc_url( $color_blog_dark_user_image ) .'" />';
                            } else {
                                echo get_avatar( $color_blog_dark_user_id, '132' );
                            }
                        ?>
                    </div>
                    <h3 class="author-name">
                        <?php 
                            if ( empty( $color_blog_dark_user_name ) ) {
                                echo wp_kses_post( get_the_author_meta( 'nickname', $color_blog_dark_user_id ) );
                            } else {
                                echo esc_html( $color_blog_dark_user_name );
                            }
                        ?>
                    </h3>
                    <div class="author-description"><?php echo wp_kses_post( wpautop( get_the_author_meta( 'description', $color_blog_dark_user_id ) ) ); ?></div>
                    <div class="author-social">
                        <?php color_blog_dark_social_media_content(); ?>
                    </div><!-- .author-social -->
                </div><!-- .author-bio-wrap -->
            </div><!-- .mt-author-info-wrapper -->
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