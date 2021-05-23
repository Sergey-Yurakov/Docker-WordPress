<?php

/**
 * Class Shop_Page_WP_Widget
 */
class Shop_Page_WP_Widget extends WP_Widget
{

    /**
     * Register widget
     */
    public function __construct()
    {
        parent::__construct(
            'shop_page_wp',
            esc_html__('Shop Page WP', 'shop-page-wp'),
            array('description' => esc_html__('Output Shop Page WP responsive product grid.', 'shop-page-wp'))
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {

        echo $args['before_widget'];

        if (!empty($instance['title'])) {

            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        $grid_content = Shop_Page_WP_Grid::return_grid($instance);

        echo $grid_content;

        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance)
    {

        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('', 'shop-page-wp');

        $columns = !empty($instance['grid']) ? $instance['grid'] : 1;

        $categories = !empty($instance['category']) ? $instance['category'] : esc_html__('', 'shop-page-wp');

        $max_number = !empty($instance['max_number']) ? $instance['max_number'] : esc_html__('', 'shop-page-wp');

        $id = !empty($instance['id']) ? $instance['id'] : esc_html__('', 'shop-page-wp');
        ?>
		<p>
			<label
				for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'shop-page-wp');?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
			       name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
			       value="<?php echo esc_attr($title); ?>">
		</p>
		<p>
			<label
				for="<?php echo esc_attr($this->get_field_id('grid')); ?>"><?php esc_attr_e('Columns:', 'shop-page-wp');?></label>
			<select class="widefat"
			        id="<?php echo esc_attr($this->get_field_id('grid')); ?>"
			        name="<?php echo esc_attr($this->get_field_name('grid')); ?>">
				<option
					value="1" <?php selected($columns, '1');?>><?php _e('1 Column', 'shop-page-wp');?>
				</option>
				<option
					value="2" <?php selected($columns, '2');?>><?php _e('2 Column', 'shop-page-wp');?>
				</option>
				<option
					value="3" <?php selected($columns, '3');?>><?php _e('3 Column', 'shop-page-wp');?>
				</option>
				<option
					value="4" <?php selected($columns, '4');?>><?php _e('4 Column', 'shop-page-wp');?>
				</option>
			</select>
		</p>
		<p>
			<label
				for="<?php echo esc_attr($this->get_field_id('category')); ?>"><?php esc_attr_e('Categories (separate with comma) - Leave Blank to Display All', 'shop-page-wp');?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('category')); ?>"
			       name="<?php echo esc_attr($this->get_field_name('category')); ?>" type="text"
			       value="<?php echo esc_attr($categories); ?>">
		</p>
		<p>
			<label
				for="<?php echo esc_attr($this->get_field_id('max_number')); ?>"><?php esc_attr_e('Max Number of Products', 'shop-page-wp');?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('max_number')); ?>"
			       name="<?php echo esc_attr($this->get_field_name('max_number')); ?>" type="number"
			       value="<?php echo esc_attr($max_number); ?>">
		</p>
    <p>
			<label
				for="<?php echo esc_attr($this->get_field_id('id')); ?>"><?php esc_attr_e('Products by ID (separate with comma) - overrides Categories and Max Number', 'shop-page-wp');?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('id')); ?>"
			       name="<?php echo esc_attr($this->get_field_name('id')); ?>" type="text"
			       value="<?php echo esc_attr($id); ?>">
		</p>
		<?php
}

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['grid'] = (!empty($new_instance['grid'])) ? strip_tags($new_instance['grid']) : 1;
        $instance['category'] = (!empty($new_instance['category'])) ? strip_tags($new_instance['category']) : '';
        $instance['max_number'] = (!empty($new_instance['max_number'])) ? strip_tags($new_instance['max_number']) : '';
        $instance['id'] = (!empty($new_instance['id'])) ? strip_tags($new_instance['id']) : '';

        return $instance;
    }
}
