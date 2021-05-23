<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class-rcl-file-uploader
 *
 * @author Андрей
 */
class Rcl_Uploader {

	public $uploader_id		 = '';
	public $fix_editor		 = false;
	public $action			 = 'rcl_upload';
	public $temp_media		 = false;
	public $input_attach	 = false;
	public $auto_upload		 = true;
	public $user_id			 = 0;
	public $post_parent		 = 0;
	public $input_name		 = 'rcl-upload';
	public $dropzone		 = false;
	public $max_files		 = 10;
	public $max_size		 = 512;
	public $min_width		 = false;
	public $min_height		 = false;
	public $resize			 = array();
	public $file_types		 = array( 'jpg', 'png', 'jpeg' );
	public $multiple		 = false;
	public $crop			 = false;
	public $image_sizes		 = true;
	public $mode_output		 = 'grid';
	public $manager_balloon	 = false;
	public $class_name		 = '';
	public $filename		 = '';
	public $filetitle		 = '';
	public $dir				 = '';
	protected $accept		 = array( 'image/*' );

	function __construct( $uploader_id, $args = false ) {

		//rcl_sortable_scripts();
		//rcl_fileupload_scripts();

		if ( ! isset( $args['user_id'] ) ) {

			global $user_ID;

			$args['user_id'] = $user_ID;
		}

		$args['class_name'] = get_class( $this );

		$this->uploader_id = $uploader_id;

		if ( $args )
			$this->init_properties( $args );

		if ( ! is_array( $this->file_types ) ) {
			$this->file_types = array_map( 'trim', explode( ',', $this->file_types ) );
		}

		if ( ! $this->file_types )
			$this->file_types = array( 'jpg', 'png', 'jpeg' );

		if ( $this->resize && ! is_array( $this->resize ) ) {
			$this->resize = array_map( 'trim', explode( ',', $this->resize ) );
		}

		$this->accept = $this->get_accept();

		$this->init_scripts();
	}

	function init_scripts() {

		rcl_fileupload_scripts();
		rcl_dialog_scripts();
		rcl_crop_scripts();

		if ( $this->crop ) {
			//rcl_dialog_scripts();
			//rcl_crop_scripts();
		}
	}

	function init_properties( $args ) {

		$properties = get_class_vars( get_class( $this ) );

		foreach ( $args as $name => $value ) {
			//if(isset($args[$name])){
			//$value = $args[$name];

			if ( is_array( $value ) ) {

				foreach ( $value as $k => $v ) {
					if ( is_object( $v ) )
						$value[$k] = ( array ) $v;
				}
				$value = ( array ) $value;
			}else if ( is_object( $value ) ) {
				$value = ( array ) $value;
			}

			$this->$name = $value;
			//}
		}
	}

	function filter_attachment_manager_items( $items, $attach_id ) {
		return $items;
	}

	function after_upload( $uploads ) {
		return false;
	}

	function get_attachment_title( $attach_id ) {
		return basename( get_post_field( 'guid', $attach_id ) );
	}

	function get_progress_bar() {
		return '<div class="rcl-uploader-progress"></div>';
	}

	function get_uploader( $args = false ) {

		$defaults = array(
			'allowed_types' => true
		);

		$args = wp_parse_args( $args, $defaults );

		$content = '<div id="rcl-uploader-' . $this->uploader_id . '" class="rcl-uploader">';

		if ( $this->dropzone )
			$content .= $this->get_dropzone();

		$content .= '<div class="rcl-uploader-button-box">';

		$content .= $this->get_progress_bar();

		$content .= $this->get_button( $args );

		if ( $args['allowed_types'] )
			$content .= '<small class="notice">' . __( 'Types of files', 'wp-recall' ) . ': ' . implode( ', ', $this->file_types ) . '</small>';

		$content .= '</div>';

		$content .= '</div>';

		return $content;
	}

	function get_input() {

		$json = json_encode( $this );

		$content = '<input id="rcl-uploader-input-' . $this->uploader_id . '" class="uploader-input" '
			. 'data-uploader_id="' . $this->uploader_id . '" name="' . ($this->multiple ? $this->input_name . '[]' : $this->input_name) . '" '
			. 'type="file" accept="' . implode( ', ', $this->accept ) . '" ' . ($this->multiple ? 'multiple' : '') . '>'
			. '<script>rcl_init_uploader(' . $json . ', "' . md5( $json . rcl_get_option( 'security-key' ) ) . '");</script>';

		if ( rcl_is_ajax() ) {
			$content .= '<script>RclUploaders.init();</script>';
		}

		return $content;
	}

	function get_button( $args ) {

		$defaults = array(
			'button_label'	 => __( 'Upload file', 'wp-recall' ),
			'button_icon'	 => 'fa-upload',
			'button_type'	 => 'simple'
		);

		$args = wp_parse_args( $args, $defaults );

		$bttnArgs = array(
			'icon'		 => $args['button_icon'],
			'type'		 => $args['button_type'],
			'label'		 => $args['button_label'],
			'class'		 => array( 'rcl-uploader-button', 'rcl-uploader-button-' . $this->uploader_id ),
			'content'	 => $this->get_input()
		);

		return rcl_get_button( $bttnArgs );
	}

	function get_dropzone() {

		$content = '<div id="rcl-dropzone-' . $this->uploader_id . '" class="rcl-dropzone">
				<div class="dropzone-upload-area">
					' . __( 'Add files in a queue of downloads', 'wp-recall' ) . '
				</div>
			</div>';

		return $content;
	}

	private function get_mime_type_by_ext( $file_ext ) {

		if ( ! $file_ext )
			return false;

		$mimes = get_allowed_mime_types();

		foreach ( $mimes as $type => $mime ) {
			if ( strpos( $type, $file_ext ) !== false ) {
				return $mime;
			}
		}

		return false;
	}

	private function get_accept() {

		if ( ! $this->file_types )
			return false;

		$accept = array();

		foreach ( $this->file_types as $type ) {
			if ( ! $type )
				continue;
			$accept[] = $this->get_mime_type_by_ext( $type );
		}

		return $accept;
	}

	function get_gallery( $imagIds = false, $getTemps = false ) {

		if ( ! $imagIds && $getTemps ) {

			$imagIds = RQ::tbl( new Rcl_Temp_Media() )->select( ['media_id' ] )
				->where( [
					'uploader_id'	 => $this->uploader_id,
					'user_id'		 => $this->user_id ? $this->user_id : 0,
					'session_id'	 => $this->user_id ? '' : $_COOKIE['PHPSESSID'],
				] )
				->get_col();
		}

		$content = '<div id="rcl-upload-gallery-' . $this->uploader_id . '" class="rcl-upload-gallery mode-' . $this->mode_output . ' ' . ($this->manager_balloon ? 'balloon-manager' : 'simple-manager') . '">';

		if ( $imagIds ) {
			//$content .= '<div class="ui-sortable-placeholder"></div>';
			if ( is_array( $imagIds ) ) {
				foreach ( $imagIds as $imagId ) {
					$content .= $this->gallery_attachment( $imagId );
				}
			} else {
				$content .= $this->gallery_attachment( $imagIds );
			}
		}

		$content .= '</div>';

		return $content;
	}

	function gallery_attachment( $attach_id ) {

		$attach = get_post( $attach_id );

		if ( ! $attach )
			return false;

		$is_image = wp_attachment_is( 'image', $attach ) ? true : false;

		if ( $is_image ) {

			$image = wp_get_attachment_image( $attach_id, 'thumbnail' );
		} else {

			$image = wp_get_attachment_image( $attach_id, array( 100, 100 ), true );
		}

		if ( ! $image )
			return false;

		$content = '<div class="gallery-attachment gallery-attachment-' . $attach_id . ' ' . ($is_image ? 'type-image' : 'type-file') . '" id="gallery-' . $this->uploader_id . '-attachment-' . $attach_id . '">';

		$content .= $image;

		$content .= '<div class="attachment-title">';
		$content .= $this->get_attachment_title( $attach_id );
		$content .= '</div>';

		$content .= $this->get_attachment_manager( $attach_id );

		if ( $this->input_attach ) {
			$input_attach = $this->multiple ? $this->input_attach . '[]' : $this->input_attach;
			$content .= '<input type="hidden" name="' . $input_attach . '" value="' . $attach_id . '">';
		}

		$content .= '</div>';

		return $content;
	}

	function get_src( $attachment_id, $size = 'attachment' ) {

		$isImage = wp_attachment_is_image( $attachment_id );

		$fileSrc = 0;

		if ( $isImage ) {

			$fullSrc = wp_get_attachment_image_src( $attachment_id, $size );

			$fileSrc = $fullSrc[0];
		} else {
			$fileSrc = wp_get_attachment_url( $attachment_id );
		}

		return $fileSrc;
	}

	function add_fix_editor_buttons( $items, $attachment_id ) {

		$isImage = wp_attachment_is_image( $attachment_id );

		$fileSrc = 0;

		if ( $isImage ) {

			$size	 = ($default = rcl_get_option( 'public_form_thumb' )) ? $default : 'large';

			$fileHtml = wp_get_attachment_image( $attachment_id, $size, false, array( 'srcset' => ' ' ) );

			$fullSrc = wp_get_attachment_image_src( $attachment_id, 'full' );
			$fileSrc = $fullSrc[0];
		} else {

			$_post = get_post( $attachment_id );

			$fileHtml = $_post->post_title;

			$fileSrc = wp_get_attachment_url( $attachment_id );
		}

		$items[] = array(
			'icon'		 => 'fa-newspaper-o',
			'title'		 => __( 'Add to the editor', 'wp-recall' ),
			'onclick'	 => 'rcl_add_attachment_in_editor(' . $attachment_id . ',"' . $this->fix_editor . '",this);return false;',
			'data'		 => array(
				'html'	 => $fileHtml,
				'src'	 => $fileSrc
			)
		);

		return $items;
	}

	function filter_manager_items( $items, $attach_id ) {
		return $items;
	}

	function get_attachment_manager( $attach_id ) {

		$items = array(
			array(
				'icon'		 => 'fa-trash',
				'title'		 => __( 'Delete the file', 'wp-recall' ),
				'onclick'	 => 'rcl_delete_attachment(' . $attach_id . ',' . $this->post_parent . ',this);return false;'
			)
		);

		$items = $this->filter_attachment_manager_items( $items, $attach_id );

		if ( $this->fix_editor ) {
			$items = $this->add_fix_editor_buttons( $items, $attach_id );
		}

		$manager_items = apply_filters( 'rcl_uploader_manager_items', $items, $attach_id, $this );

		$manager_items = $this->filter_manager_items( $manager_items, $attach_id );

		if ( ! $manager_items )
			return false;

		$content = '<div class="attachment-manager ' . ($this->manager_balloon ? 'rcl-balloon' : '') . '">';

		foreach ( $manager_items as $item ) {
			$item['type'] = 'simple';
			$content .= rcl_get_button( $item );
		}

		$content .= '</div>';

		if ( $this->manager_balloon ) {
			$content = '<div class="attachment-manager-balloon rcl-balloon-hover"><i class="rcli fa-cogs" aria-hidden="true"></i>' . $content . '</div>';
		}

		return $content;
	}

	function upload() {

		rcl_verify_ajax_nonce();

		if ( ! $_FILES[$this->input_name] ) {
			return false;
		}

		require_once( ABSPATH . 'wp-admin/includes/image.php' );

		do_action( 'rcl_pre_upload', $this );

		if ( $this->dir ) {
			add_filter( 'upload_dir', [$this, 'edit_upload_dir' ], 10 );
		}

		if ( $this->multiple ) {

			$files = array();
			foreach ( $_FILES[$this->input_name] as $nameProp => $values ) {
				foreach ( $values as $k => $value ) {
					$files[$k][$nameProp] = $value;
				}
			}

			$uploads = array();
			foreach ( $files as $file ) {
				$uploads[] = $this->file_upload_process( $file );
			}
		} else {

			/* if ( $this->temp_media ) {
			  rcl_delete_temp_media_by_args( array(
			  'uploader_id'	 => $this->uploader_id,
			  'user_id'		 => $this->user_id ? $this->user_id : 0,
			  'session_id'	 => $this->user_id ? '' : $_COOKIE['PHPSESSID'],
			  ) );
			  } */

			$uploads = $this->file_upload_process( $_FILES[$this->input_name] );
		}

		$this->after_upload( $uploads );

		do_action( 'rcl_upload', $uploads, $this );

		return $uploads;
	}

	function file_upload_process( $file ) {

		$filetype = wp_check_filetype_and_ext( $file['tmp_name'], $file['name'] );

		if ( ! in_array( $filetype['ext'], $this->file_types ) ) {
			wp_send_json( array( 'error' => __( 'Forbidden file extension. Allowed:', 'wp-recall' ) . ' ' . implode( ', ', $this->file_types ) ) );
		}

		$pathInfo = pathinfo( basename( $file['name'] ) );

		$file['name'] = $this->filename ? $this->filename . '.' . $filetype['ext'] : rcl_sanitize_string( $pathInfo['filename'] ) . '.' . $filetype['ext'];

		$file = apply_filters( 'rcl_pre_upload_file_data', $file );

		$image = wp_handle_upload( $file, array( 'test_form' => FALSE ) );

		if ( ! $image['file'] )
			return false;

		$this->setup_image_sizes( $image['file'] );

		if ( $this->crop ) {

			$this->crop_image( $image['file'] );
		}

		if ( $this->resize ) {

			$this->resize_image( $image['file'] );
		}

		$attachment = array(
			'post_mime_type' => $image['type'],
			'post_title'	 => $this->filetitle ? $this->filetitle : $pathInfo['filename'],
			'post_content'	 => '',
			'post_excerpt'	 => 'rcl-uploader:' . $this->uploader_id,
			'guid'			 => $image['url'],
			'post_parent'	 => $this->post_parent,
			'post_author'	 => $this->user_id,
			'post_status'	 => 'inherit'
		);

		if ( ! $this->user_id ) {
			$attachment['post_content'] = $_COOKIE['PHPSESSID'];
		}

		$attach_id = wp_insert_attachment( $attachment, $image['file'], $this->post_parent );

		$attach_data = wp_generate_attachment_metadata( $attach_id, $image['file'] );

		wp_update_attachment_metadata( $attach_id, $attach_data );

		if ( $this->temp_media ) {
			rcl_add_temp_media( array(
				'media_id'		 => $attach_id,
				'uploader_id'	 => $this->uploader_id
			) );
		}

		return array(
			'id'	 => $attach_id,
			'src'	 => [
				'full'		 => $this->get_src( $attach_id, 'full' ) . '?ver=' . current_time( 'timestamp' ),
				'thumbnail'	 => $this->get_src( $attach_id, 'thumbnail' ) . '?ver=' . current_time( 'timestamp' ),
			],
			'html'	 => $this->gallery_attachment( $attach_id )
		);
	}

	function setup_image_sizes( $image_src ) {

		if ( ! $this->image_sizes || is_array( $this->image_sizes ) ) {

			$thumbSizes = wp_get_additional_image_sizes();

			foreach ( $thumbSizes as $thumbName => $sizes ) {
				remove_image_size( $thumbName );
			}

			if ( is_array( $this->image_sizes ) ) {

				list($width, $height) = getimagesize( $image_src );

				foreach ( $this->image_sizes as $k => $thumbData ) {

					$thumbData = wp_parse_args( $thumbData, array(
						'width'	 => $width,
						'height' => $height,
						'crop'	 => 1
						) );

					add_image_size( $k . '-' . current_time( 'mysql' ), $thumbData['width'], $thumbData['height'], $thumbData['crop'] );
				}
			}
		}
	}

	function crop_image( $image_src ) {

		list($width, $height) = getimagesize( $image_src );

		$crop	 = isset( $_POST['crop_data'] ) ? $_POST['crop_data'] : false;
		$size	 = isset( $_POST['image_size'] ) ? $_POST['image_size'] : false;

		if ( ! $crop )
			return false;

		list($crop_x, $crop_y, $crop_w, $crop_h) = explode( ',', $crop );
		list($viewWidth, $viewHeight) = explode( ',', $size );

		$cf = 1;
		if ( $viewWidth < $width ) {
			$cf = $width / $viewWidth;
		}

		$crop_x *= $cf;
		$crop_y *= $cf;
		$crop_w *= $cf;
		$crop_h *= $cf;


		$image = wp_get_image_editor( $image_src );

		if ( ! is_wp_error( $image ) ) {
			$image->crop( $crop_x, $crop_y, $crop_w, $crop_h );
			$image->save( $image_src );
		}
	}

	function resize_image( $image_src ) {

		if ( ! $this->resize )
			return false;

		$image = wp_get_image_editor( $image_src );

		if ( ! is_wp_error( $image ) ) {
			$image->resize( $this->resize[0], $this->resize[1], false );
			$image->save( $image_src );
		}
	}

	function edit_upload_dir( $param ) {
		$param['path']	 = WP_CONTENT_DIR . untrailingslashit( $this->dir );
		$param['url']	 = WP_CONTENT_URL . untrailingslashit( $this->dir );
		return $param;
	}

}
