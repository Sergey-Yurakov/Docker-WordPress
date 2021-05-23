<?php
/**
 * Color Blog Dark include the Customizer custom classes of customizer fields.
 *
 * @package Color Blog Dark
 * @since 1.0.0
 */
add_action( 'customize_register', 'color_blog_dark_register_custom_controls' );

if ( ! function_exists( 'color_blog_dark_register_custom_controls' ) ) :
    /**
     * Register Custom Controls
     * 
     * @since 1.0.0
    */
    function color_blog_dark_register_custom_controls( $wp_customize ) {
        
        if ( ! class_exists( 'color_blog_dark_Control_Toggle' ) ) {
			/**
			 * Toggle control (modified checkbox)
			 */
			class Color_Blog_Dark_Control_Toggle extends WP_Customize_Control {
				
				/**
				 * The control type.
				 *
				 * @access public
				 * @var string
				 */
				public $type = 'mt-toggle';
				
				public $tooltip = '';
				
				public function to_json() {
					parent::to_json();
					
					if ( isset( $this->default ) ) {
						$this->json['default'] = $this->default;
					} else{
						$this->json['default'] = $this->setting->default;
					}
					
					$this->json['value']   = $this->value();
					$this->json['link']    = $this->get_link();
					$this->json['id']      = $this->id;
					$this->json['tooltip'] = $this->tooltip;
								
					$this->json['inputAttrs'] = '';
					foreach ( $this->input_attrs as $attr => $value ) {
						$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
					}
				}
				
				protected function content_template() {
					?>
					<# if ( data.tooltip ) { #>
						<a href="#" class="tooltip hint--left" data-hint="{{ data.tooltip }}"><span class='dashicons dashicons-info'></span></a>
					<# } #>
					<label for="toggle_{{ data.id }}">
						<span class="customize-control-title">
							{{{ data.label }}}
						</span>
						<# if ( data.description ) { #>
							<span class="description customize-control-description">{{{ data.description }}}</span>
						<# } #>
						<input {{{ data.inputAttrs }}} name="toggle_{{ data.id }}" id="toggle_{{ data.id }}" type="checkbox" value="{{ data.value }}" {{{ data.link }}}<# if ( '1' == data.value ) { #> checked<# } #> hidden />
						<span class="switch"></span>
					</label>
					<?php
				}
			}
		} //Ends color_blog_dark_Control_Toggle
		
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/		
		if ( ! class_exists( 'color_blog_dark_Control_Radio_Image' ) ) {
			
			/**
			 * Radio Image control (modified radio).
			*/
			class Color_Blog_Dark_Control_Radio_Image extends WP_Customize_Control {

				/**
				 * The control type.
				 *
				 * @access public
				 * @var string
				 */
				public $type = 'mt-radio-image';
				
				public $tooltip = '';
				
				public function to_json() {
					parent::to_json();
					
					if ( isset( $this->default ) ) {
						$this->json['default'] = $this->default;
					} else {
						$this->json['default'] = $this->setting->default;
					}
					
					$this->json['value']   = $this->value();
					$this->json['link']    = $this->get_link();
					$this->json['id']      = $this->id;
					$this->json['tooltip'] = $this->tooltip;
					$this->json['choices'] = $this->choices;
								
					$this->json['inputAttrs'] = '';
					foreach ( $this->input_attrs as $attr => $value ) {
						$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
					}
				}
	
				protected function content_template() {
					?>

					<# if ( data.tooltip ) { #>
						<a href="#" class="tooltip hint--left" data-hint="{{ data.tooltip }}"><span class='dashicons dashicons-info'></span></a>
					<# } #>
					<label class="customizer-text">
						<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
						<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
					</label>
					<div id="input_{{ data.id }}" class="image">
						<# for ( key in data.choices ) { #>
							<# dataAlt = ( _.isObject( data.choices[ key ] ) && ! _.isUndefined( data.choices[ key ].alt ) ) ? data.choices[ key ].alt : '' #>
							<input {{{ data.inputAttrs }}} class="image-select" type="radio" value="{{ key }}" name="_customize-radio-{{ data.id }}" id="{{ data.id }}{{ key }}" {{{ data.link }}}<# if ( data.value === key ) { #> checked="checked"<# } #> data-alt="{{ dataAlt }}">
								<label for="{{ data.id }}{{ key }}" {{{ data.labelStyle }}} class="{{{ data.id + key }}}">
									<# if ( _.isObject( data.choices[ key ] ) ) { #>
										<img src="{{ data.choices[ key ].src }}" alt="{{ data.choices[ key ].alt }}">
										<span class="image-label"><span class="inner">{{ data.choices[ key ].alt }}</span></span>
									<# } else { #>
										<img src="{{ data.choices[ key ] }}">
									<# } #>
									<span class="image-clickable"></span>
								</label>
							</input>
						<# } #>
					</div>
					<?php
				}
			}
		}

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/		
		if ( ! class_exists( 'color_blog_dark_Control_Repeater' ) ) {
    
			/**
			 * Repeater control
			*/
			class Color_Blog_Dark_Control_Repeater extends WP_Customize_Control {
		
				/**
				 * The control type.
				 *
				 * @access public
				 * @var string
				 */
				public $type = 'mt-repeater';
		
				public $color_blog_dark_box_label = '';
		
				public $color_blog_dark_box_add_control = '';
		
				/**
				 * The fields that each container row will contain.
				 *
				 * @access public
				 * @var array
				 */
				public $fields = array();
		
				/**
				 * Repeater drag and drop controller
				 *
				 * @since  1.0.0
				 */
				public function __construct( $manager, $id, $args = array(), $fields = array() ) {
					
					$this->fields = $fields;
					$this->color_blog_dark_box_label = $args['color_blog_dark_box_label_text'] ;
					$this->color_blog_dark_box_add_control = $args['color_blog_dark_box_add_control_text'];
					parent::__construct( $manager, $id, $args );
				}
		
				protected function render_content() {
		
					$values = json_decode( $this->value() );
					$repeater_id = $this->id;
					$field_count = count( $values );
				?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		
					<?php if ( $this->description ) { ?>
						<span class="description customize-control-description">
							<?php echo wp_kses_post( $this->description ); ?>
						</span>
					<?php } ?>
		
					<ul class="mt-repeater-field-control-wrap">
						<?php $this->color_blog_dark_get_fields(); ?>
					</ul>
		
					<input type="hidden" <?php $this->link(); ?> class="mt-repeater-collector" value="<?php echo esc_attr( $this->value() ); ?>" />
					<input type="hidden" name="<?php echo esc_attr( $repeater_id ).'_count'; ?>" class="field-count" value="<?php echo absint( $field_count ); ?>">
					<input type="hidden" name="field_limit" class="field-limit" value="6">
					<button type="button" class="button mt-repeater-add-control-field"><?php echo esc_html( $this->color_blog_dark_box_add_control ); ?></button>
			<?php
				}

				private function color_blog_dark_get_fields() {
					$fields = $this->fields;
					$values = json_decode( $this->value() );
		
					if ( is_array( $values ) ) {
						foreach( $values as $value ) {
				?>
						<li class="mt-repeater-field-control">
						<h3 class="mt-repeater-field-title"><?php echo esc_html( $this->color_blog_dark_box_label ); ?></h3>						
						<div class="mt-repeater-fields">
						<?php
							foreach ( $fields as $key => $field ) {
							$class = isset( $field['class'] ) ? $field['class'] : '';
						?>
							<div class="mt-repeater-field mt-repeater-type-<?php echo esc_attr( $field['type'] ).' '.esc_attr( $class ); ?>">
		
							<?php 
								$label = isset( $field['label'] ) ? $field['label'] : '';
								$description = isset( $field['description'] ) ? $field['description'] : '';
								if ( $field['type'] != 'checkbox' ) { 
							?>
									<span class="customize-control-title"><?php echo esc_html( $label ); ?></span>
									<span class="description customize-control-description"><?php echo esc_html( $description ); ?></span>
							<?php 
								}
		
								$new_value = isset( $value->$key ) ? $value->$key : '';
								$default = isset( $field['default'] ) ? $field['default'] : '';
		
								switch ( $field['type'] ) {
									/**
									 * Text field
									 */
									case 'text':
										echo '<input data-default="'.esc_attr( $default ).'" data-name="'.esc_attr( $key ).'" type="text" value="'.esc_attr( $new_value ).'"/>';
										break;
		
									/**
									 * Textarea field
									 */
									case 'textarea':
										echo '<textarea data-default="'.esc_attr( $default ).'" data-name="'.esc_attr( $key ).'">'.esc_attr( $new_value ).'</textarea>';
										break;
										
									/**
									 * URL field
									 */
									case 'url':
										echo '<input data-default="'.esc_attr( $default ).'" data-name="'.esc_attr( $key ).'" type="text" value="'.esc_url( $new_value ).'"/>';
										break;
		
									/**
									 * Icon field
									 */
									case 'icon':
										$color_blog_dark_font_awesome_icon_array = color_blog_dark_font_awesome_icon_array();
										echo '<div class="mt-repeater-selected-icon"><i class="'.esc_attr( $new_value ).'"></i><span><i class="fa fa-angle-down"></i></span></div><ul class="mt-repeater-icon-list mt-clearfix">';
										foreach ( $color_blog_dark_font_awesome_icon_array as $color_blog_dark_font_awesome_icon ) {
											$icon_class = $new_value == $color_blog_dark_font_awesome_icon ? 'icon-active' : '';
											echo '<li class='.esc_attr( $icon_class ).'><i class="'.esc_attr( $color_blog_dark_font_awesome_icon ).'"></i></li>';
										}
										echo '</ul><input data-default="'.esc_attr( $default ).'" type="hidden" value="'.esc_attr( $new_value ).'" data-name="'.esc_attr( $key ).'"/>';
										break;
		
									/**
									 * Social Icon field
									 */
									case 'social_icon':
										$color_blog_dark_font_awesome_social_icon_array = color_blog_dark_font_awesome_social_icon_array();
										echo '<div class="mt-repeater-selected-icon"><i class="'.esc_attr( $new_value ).'"></i><span><i class="fa fa-angle-down"></i></span></div><ul class="mt-repeater-icon-list mt-clearfix">';
										foreach ( $color_blog_dark_font_awesome_social_icon_array as $color_blog_dark_font_awesome_icon ) {
											$icon_class = $new_value == $color_blog_dark_font_awesome_icon ? 'icon-active' : '';
											echo '<li class='.esc_attr( $icon_class ).'><i class="'.esc_attr( $color_blog_dark_font_awesome_icon ).'"></i></li>';
										}
										echo '</ul><input data-default="'.esc_attr( $default ).'" type="hidden" value="'.esc_attr( $new_value ).'" data-name="'.esc_attr( $key ).'"/>';
										break;
		
									/**
									 * Select field
									 */
									case 'select':
										$options = $field['options'];
										echo '<select  data-default="'.esc_attr( $default ).'"  data-name="'.esc_attr( $key ).'">';
											foreach ( $options as $option => $val )
											{
												printf( '<option value="%1$s" %2$s>%3$s</option>', esc_attr( $option ), selected( $new_value, $option, false ), esc_html( $val ) );
											}
										echo '</select>';
										break;
		
									/**
									 * Dropdown field
									 */
									case 'dropdown_pages':
										$show_option_none = esc_html__( '&mdash; Select a page &mdash;', 'color-blog-dark' );
										$select_field ='data-default="'.esc_attr( $default ).'"  data-name="'.esc_attr( $key ).'"';
										$option_none_value = '';
										$dropdown = wp_dropdown_pages(
											array(
												'name'              => esc_attr( $key ),
												'echo'              => '',
												'show_option_none'  => esc_html( $show_option_none ),
												'option_none_value' => esc_attr( $option_none_value ),
												'selected'          => esc_attr( $new_value )
											)
										);
		
										if ( empty( $dropdown ) ) {
											$dropdown = sprintf( '<select id="%1$s" name="%1$s">', esc_attr( $key ) );
											$dropdown .= sprintf( '<option value="%1$s">%2$s</option>', esc_attr( $option_none_value ), esc_html( $show_option_none ) );
											$dropdown .= '</select>';
										}

										// Hackily add in the data link parameter.
										$dropdown = str_replace( '<select', '<select ' . $select_field, $dropdown );
										echo $dropdown;
										break;
		
									/**
									 * Upload field
									 */
									case 'upload':
										$image_class = "";
										$upload_btn_label = esc_html__( 'Select Image', 'color-blog-dark' );
										$remove_btn_label = esc_html__( 'Remove', 'color-blog-dark' );
										if ( $new_value ) { 
											$image_class = ' hidden';
										}
										echo '<div class="mt-fields-wrap"><div class="attachment-media-view"><div class="placeholder'. esc_attr( $image_class ).'">';
										esc_html_e( 'No image selected', 'color-blog-dark' );
										echo '</div><div class="thumbnail thumbnail-image"><img src="'.esc_url( $new_value ).'" style="max-width:100%;"/></div><div class="actions mt-clearfix"><button type="button" class="button mt-delete-button align-left">'. esc_html( $remove_btn_label ) .'</button><button type="button" class="button mt-upload-button alignright">'. esc_html( $upload_btn_label ) .'</button><input data-default="'.esc_attr( $default ).'" class="upload-id" data-name="'.esc_attr( $key ).'" type="hidden" value="'.esc_attr( $new_value ).'"/></div></div></div>';
										break;
									default:
										break;
								}
							?>
							</div>
					<?php
						}
					?>
							<div class="mt-clearfix mt-repeater-footer">
								<div class="alignright">
								<a class="mt-repeater-field-remove" href="#remove"><?php esc_html_e( 'Delete', 'color-blog-dark' ) ?></a> |
								<a class="mt-repeater-field-close" href="#close"><?php esc_html_e( 'Close', 'color-blog-dark' ) ?></a>
								</div>
							</div><!-- .mt-repeater-footer -->
						</div><!-- .mt-repeater-fields-->
						</li>
				<?php   
						}
					}
				}
			}
		}
    }// Ends color_blog_dark_register_custom_controls
endif;

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/		
if ( class_exists( 'WP_Customize_Section' ) ) {

	/**
     * Upsell customizer section.
     *
     * @since  1.0.6
     * @access public
     */
    class Color_Blog_Dark_Section_Upsell extends WP_Customize_Section {

        /**
         * The type of customize section being rendered.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $type = 'mt-upsell';

        /**
         * Custom button text to output.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $pro_text = '';

        /**
         * Custom pro button URL.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $pro_url = '';

        

        /**
         * Add custom parameters to pass to the JS via JSON.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        public function json() {
            $json = parent::json();
            
            $json['pro_text'] = $this->pro_text;
            $json['pro_url']  = esc_url( $this->pro_url );
            

            return $json;
        }

        /**
         * Outputs the Underscore.js template.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        protected function render_template() { ?>

            <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
                <h3 class="accordion-section-title">
                    {{ data.title }}

                    <# if ( data.pro_text && data.pro_url ) { #>
                        <a href="{{ data.pro_url }}" class="button button-secondary alignright" target="_blank">{{ data.pro_text }}</a>
                    <# } #>
                </h3>
            </li>
        <?php }

    }// end color_blog_dark_Section_Upsell

}