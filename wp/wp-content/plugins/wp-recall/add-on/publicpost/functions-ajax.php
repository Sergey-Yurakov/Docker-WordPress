<?php

//удаление фото приложенных к публикации через загрузчик плагина
rcl_ajax_action( 'rcl_ajax_delete_post', true );
function rcl_ajax_delete_post() {
	global $user_ID;

	rcl_verify_ajax_nonce();

	$user_id = ($user_ID) ? $user_ID : $_COOKIE['PHPSESSID'];

	$temps		 = get_site_option( 'rcl_tempgallery' );
	$temp_gal	 = $temps[$user_id];

	if ( $temp_gal ) {

		foreach ( ( array ) $temp_gal as $key => $gal ) {
			if ( $gal['ID'] == $_POST['post_id'] )
				unset( $temp_gal[$key] );
		}
		foreach ( ( array ) $temp_gal as $t ) {
			$new_temp[] = $t;
		}

		if ( $new_temp )
			$temps[$user_id] = $new_temp;
		else
			unset( $temps[$user_id] );
	}

	update_site_option( 'rcl_tempgallery', $temps );

	$post = get_post( intval( $_POST['post_id'] ) );

	if ( ! $post ) {
		$log['success']		 = __( 'Material successfully removed!', 'wp-recall' );
		$log['post_type']	 = 'attachment';
	} else {

		$res = wp_delete_post( $post->ID );

		if ( $res ) {
			$log['success']		 = __( 'Material successfully removed!', 'wp-recall' );
			$log['post_type']	 = $post->post_type;
		} else {
			$log['error'] = __( 'Deletion failed!', 'wp-recall' );
		}
	}

	wp_send_json( $log );
}

//вызов быстрой формы редактирования публикации
rcl_ajax_action( 'rcl_get_edit_postdata', false );
function rcl_get_edit_postdata() {
	global $user_ID;

	rcl_verify_ajax_nonce();

	$post_id = intval( $_POST['post_id'] );
	$post	 = get_post( $post_id );

	if ( $user_ID ) {
		$log['result']	 = 100;
		$log['content']	 = "
        <form id='rcl-edit-form' method='post'>
                <label>" . __( "Name", 'wp-recall' ) . ":</label>
                 <input type='text' name='post_title' value='$post->post_title'>
                 <label>" . __( "Description", 'wp-recall' ) . ":</label>
                 <textarea name='post_content' rows='10'>$post->post_content</textarea>
                 <input type='hidden' name='post_id' value='$post_id'>
        </form>";
	} else {
		$log['error'] = __( 'Failed to get the data', 'wp-recall' );
	}

	wp_send_json( $log );
}

//сохранение изменений в быстрой форме редактирования
rcl_ajax_action( 'rcl_edit_postdata', false );
function rcl_edit_postdata() {
	global $wpdb;

	rcl_verify_ajax_nonce();

	$post_array					 = array();
	$post_array['post_title']	 = sanitize_text_field( $_POST['post_title'] );
	$post_array['post_content']	 = esc_textarea( $_POST['post_content'] );

	$post_array = apply_filters( 'rcl_pre_edit_post', $post_array );

	$result = $wpdb->update(
		$wpdb->posts, $post_array, array( 'ID' => intval( $_POST['post_id'] ) )
	);

	if ( ! $result ) {
		wp_send_json( array( 'error' => __( 'Changes to be saved not found', 'wp-recall' ) ) );
	}

	wp_send_json( array(
		'success'	 => __( 'Publication updated', 'wp-recall' ),
		'dialog'	 => array( 'close' )
	) );
}

function rcl_edit_post() {
	$edit = new Rcl_EditPost();
	$edit->update_post();
}

//выборка меток по введенным значениям
rcl_ajax_action( 'rcl_get_like_tags', true );
function rcl_get_like_tags() {
	global $wpdb;

	rcl_verify_ajax_nonce();

	if ( ! $_POST['query'] ) {
		wp_send_json( array( array( 'id' => '' ) ) );
	};

	$query		 = $_POST['query'];
	$taxonomy	 = $_POST['taxonomy'];

	$terms = get_terms( $taxonomy, array( 'hide_empty' => false, 'name__like' => $query ) );

	$tags = array();
	foreach ( $terms as $key => $term ) {
		$tags[$key]['id']	 = $term->name;
		$tags[$key]['name']	 = $term->name;
	}

	wp_send_json( $tags );
}

add_filter( 'rcl_preview_post_content', 'rcl_add_registered_scripts' );
rcl_ajax_action( 'rcl_preview_post', true );
function rcl_preview_post() {
	global $user_ID;

	rcl_verify_ajax_nonce();
	rcl_reset_wp_dependencies();

	$log		 = array();
	$postdata	 = $_POST;

	if ( ! rcl_get_option( 'public_access' ) && ! $user_ID ) {

		$email_new_user	 = sanitize_email( $postdata['email-user'] );
		$name_new_user	 = $postdata['name-user'];

		if ( ! $email_new_user ) {
			$log['error'] = __( 'Enter your e-mail!', 'wp-recall' );
		}
		if ( ! $name_new_user ) {
			$log['error'] = __( 'Enter your name!', 'wp-recall' );
		}

		$res_email		 = email_exists( $email_new_user );
		$res_login		 = username_exists( $email_new_user );
		$correctemail	 = is_email( $email_new_user );
		$valid			 = validate_username( $email_new_user );

		if ( $res_login || $res_email || ! $correctemail || ! $valid ) {

			if ( ! $valid || ! $correctemail ) {
				$log['error'] .= __( 'You have entered an invalid email!', 'wp-recall' );
			}
			if ( $res_login || $res_email ) {
				$log['error'] .= __( 'This email is already used!', 'wp-recall' ) . '<br>'
					. __( 'If this is your email, then log in and publish your post', 'wp-recall' );
			}
		}

		if ( $log['error'] ) {
			wp_send_json( $log );
		}
	}

	$formFields = new Rcl_Public_Form_Fields( $postdata['post_type'], array(
		'form_id' => isset( $postdata['form_id'] ) ? $postdata['form_id'] : 1
		) );

	foreach ( $formFields->fields as $field ) {

		if ( in_array( $field->type, array( 'runner' ) ) ) {

			$value	 = isset( $postdata[$field->id] ) ? $postdata[$field->id] : 0;
			$min	 = $field->value_min;
			$max	 = $field->value_max;

			if ( $value < $min || $value > $max ) {
				wp_send_json( array( 'error' => __( 'Incorrect values of some fields, enter the correct values!', 'wp-recall' ) ) );
			}
		}
	}

	if ( $formFields->is_active_field( 'post_thumbnail' ) ) {

		$thumbnail_id = (isset( $postdata['post-thumbnail'] )) ? $postdata['post-thumbnail'] : 0;

		$field = $formFields->get_field( 'post_thumbnail' );

		if ( $field->get_prop( 'required' ) && ! $thumbnail_id ) {
			wp_send_json( array( 'error' => __( 'Upload or specify an image as a thumbnail', 'wp-recall' ) ) );
		}
	}

	$post_content = '';

	if ( $formFields->is_active_field( 'post_content' ) ) {

		$postContent = $postdata['post_content'];

		$field = $formFields->get_field( 'post_content' );

		if ( $field->get_prop( 'required' ) && ! $postContent ) {
			wp_send_json( array( 'error' => __( 'Add contents of the publication!', 'wp-recall' ) ) );
		}

		$post_content = wpautop( do_shortcode( stripslashes_deep( $postContent ) ) );
	}

	if ( $postdata['publish'] ) {
		wp_send_json( [
			'submit' => true
		] );
	}

	if ( rcl_get_option( 'pm_rcl' ) && $customFields = $formFields->get_custom_fields() ) {

		$types = rcl_get_option( 'pm_post_types' );

		if ( ! $types || in_array( $postdata['post_type'], $types ) ) {

			$fieldsBox = '<div class="rcl-custom-fields">';

			foreach ( $customFields as $field_id => $field ) {
				$field->set_prop( 'value', isset( $_POST[$field_id] ) ? $_POST[$field_id] : false  );
				$fieldsBox .= $field->get_field_value( true );
			}

			$fieldsBox .= '</div>';

			if ( rcl_get_option( 'pm_place' ) == 1 )
				$post_content .= $fieldsBox;
			else
				$post_content = $fieldsBox . $post_content;
		}
	}

	if ( isset( $_POST['rcl-post-gallery'] ) && $postGallery = $_POST['rcl-post-gallery'] ) {

		$gallery = array();

		if ( $postGallery ) {
			$postGallery = array_unique( $postGallery );
			foreach ( $postGallery as $attachment_id ) {
				$attachment_id	 = intval( $attachment_id );
				if ( $attachment_id )
					$gallery[]		 = $attachment_id;
			}
		}

		if ( $gallery ) {
			$post_content = '<div id="primary-preview-gallery">' . rcl_get_post_gallery( 'preview', $gallery ) . '</div>' . $post_content;
		}
	}

	do_action( 'rcl_preview_post', $postdata );

	$preview = apply_filters( 'rcl_preview_post_content', $post_content );

	$preview .= rcl_get_notice( [
		'text' => __( 'If everything is correct – publish it! If not, you can go back to editing.', 'wp-recall' )
		] );

	wp_send_json( array(
		'title'		 => $postdata['post_title'],
		'content'	 => $preview
	) );
}

rcl_ajax_action( 'rcl_set_post_thumbnail', true );
function rcl_set_post_thumbnail() {

	$thumbnail_id	 = intval( $_POST['thumbnail_id'] );
	$parent_id		 = intval( $_POST['parent_id'] );
	$form_id		 = intval( $_POST['form_id'] );
	$post_type		 = $_POST['post_type'];

	$formFields = new Rcl_Public_Form_Fields( $post_type, array(
		'form_id' => $form_id ? $form_id : 1
		) );

	if ( ! $formFields->is_active_field( 'post_thumbnail' ) )
		wp_send_json( [
			'error' => __( 'The field of the thumbnail is inactive!', 'wp-recall' )
		] );

	if ( $parent_id ) {
		update_post_meta( $parent_id, '_thumbnail_id', $thumbnail_id );
	}

	$field = $formFields->get_field( 'post_thumbnail' );

	$field->set_prop( 'uploader_props', array(
		'post_parent'	 => $parent_id,
		'form_id'		 => $form_id,
		'post_type'		 => $post_type,
		'multiple'		 => 0,
		'crop'			 => 1
	) );

	$result = array(
		'html'	 => $field->get_uploader()->gallery_attachment( $thumbnail_id ),
		'id'	 => $thumbnail_id
	);

	wp_send_json( $result );
}

add_action( 'rcl_upload', 'rcl_upload_post_thumbnail', 10, 2 );
function rcl_upload_post_thumbnail( $uploads, $uploader ) {

	if ( $uploader->uploader_id != 'post_thumbnail' )
		return false;

	$thumbnail_id = $uploads['id'];

	if ( $uploader->post_parent ) {

		update_post_meta( $uploader->post_parent, '_thumbnail_id', $thumbnail_id );
	} else {

		rcl_add_temp_media( array(
			'media_id'		 => $thumbnail_id,
			'uploader_id'	 => $uploader->uploader_id
		) );
	}

	do_action( 'rcl_upload_post_thumbnail', $thumbnail_id, $uploader );

	$uploader->uploader_id	 = 'post_uploader';
	$uploader->input_attach	 = 'post_uploader';
	$uploader->multiple		 = 1;

	wp_send_json( [
		'thumbnail'	 => $uploads,
		'postmedia'	 => $uploader->gallery_attachment( $thumbnail_id )
	] );
}
