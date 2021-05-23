<?php

class Rcl_EditPost {

	public $post_id; //идентификатор поста
	public $post	 = array();
	public $post_type; //тип записи
	public $update	 = false; //действие
	public $user_can = array(
		'publish'	 => false,
		'edit'		 => false,
		'upload'	 => false
	);

	function __construct() {

		if ( isset( $_FILES ) ) {
			require_once(ABSPATH . "wp-admin" . '/includes/image.php');
			require_once(ABSPATH . "wp-admin" . '/includes/file.php');
			require_once(ABSPATH . "wp-admin" . '/includes/media.php');
		}

		if ( isset( $_POST['post_type'] ) && $_POST['post_type'] ) {
			$this->post_type = sanitize_text_field( $_POST['post_type'] );
		}

		$post_id = isset( $_POST['post_ID'] ) && $_POST['post_ID'] ? $_POST['post_ID'] : (isset( $_POST['post_id'] ) && $_POST['post_id'] ? $_POST['post_id'] : 0);

		if ( $post_id ) {

			$this->post_id = intval( $post_id );

			$post = get_post( $this->post_id );

			$this->post = $post;

			$this->post_type = $post->post_type;

			$this->update = true;
		}

		$this->setup_user_can();

		if ( ! $this->user_can )
			$this->error( __( 'Error publishing!', 'wp-recall' ) . ' Error 100' );

		do_action( 'init_update_post_rcl', $this );

		add_filter( 'pre_update_postdata_rcl', array( &$this, 'add_data_post' ), 5, 2 );
	}

	function error( $error ) {
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			wp_send_json( array( 'error' => $error ) );
		} else {
			wp_die( $error );
		}
	}

	function setup_user_can() {
		global $user_ID;

		if ( $this->update ) {

			if ( $this->post_type == 'post-group' ) {

				if ( rcl_can_user_edit_post_group( $this->post_id ) )
					$this->user_can['edit'] = true;
			}else {

				if ( current_user_can( 'edit_post', $this->post_id ) )
					$this->user_can['edit'] = true;

				if ( rcl_is_user_role( $user_ID, array( 'administrator', 'editor' ) ) || ! rcl_is_limit_editing( $this->post->post_date ) )
					$this->user_can['edit'] = true;
			}
		}else {

			$this->user_can['publish'] = true;

			$user_can = rcl_get_option( 'user_public_access_recall' );

			if ( $user_can ) {

				if ( $user_ID ) {

					$userinfo = get_userdata( $user_ID );

					if ( $userinfo->user_level < $user_can )
						$this->user_can['publish'] = false;
				}else {

					$this->user_can['publish'] = false;
				}
			}
		}

		$this->user_can = apply_filters( 'rcl_public_update_user_can', $this->user_can, $this );
	}

	function update_thumbnail( $postdata ) {

		$thumbnail_id = (isset( $_POST['post_thumbnail'] )) ? $_POST['post_thumbnail'] : 0;

		if ( ! $this->update )
			return $this->rcl_add_attachments_in_temps( $postdata );

		$currentThID = get_post_meta( $this->post_id, '_thumbnail_id', 1 );

		if ( $thumbnail_id ) {

			if ( $currentThID == $thumbnail_id )
				return false;

			update_post_meta( $this->post_id, '_thumbnail_id', $thumbnail_id );
		}else {

			if ( $currentThID )
				delete_post_meta( $this->post_id, '_thumbnail_id' );
		}
	}

	function rcl_add_attachments_in_temps( $postdata ) {

		$user_id = $postdata['post_author'];

		$temps = rcl_get_temp_media( array(
			'user_id'			 => $user_id,
			'uploader_id__in'	 => array( 'post_uploader', 'post_thumbnail' )
			) );

		if ( $temps ) {

			$thumbnail_id = isset( $_POST['post_thumbnail'] ) ? $_POST['post_thumbnail'] : 0;

			foreach ( $temps as $temp ) {

				if ( $thumbnail_id && $thumbnail_id == $temp->media_id )
					add_post_meta( $this->post_id, '_thumbnail_id', $temp->media_id );

				$attachData = array(
					'ID'			 => $temp->media_id,
					'post_parent'	 => $this->post_id,
					'post_author'	 => $user_id
				);

				wp_update_post( $attachData );
			}
		}

		return $temps;
	}

	function update_post_gallery() {

		$postGallery = isset( $_POST['rcl-post-gallery'] ) ? $_POST['rcl-post-gallery'] : false;

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
			update_post_meta( $this->post_id, 'rcl_post_gallery', $gallery );
		} else {
			delete_post_meta( $this->post_id, 'rcl_post_gallery' );
		}

		delete_post_meta( $this->post_id, 'recall_slider' );
	}

	function get_status_post( $moderation ) {
		global $user_ID;

		if ( isset( $_POST['save-as-draft'] ) )
			return 'draft';

		if ( rcl_is_user_role( $user_ID, array( 'administrator', 'editor' ) ) )
			return 'publish';

		if ( $moderation == 1 ) {

			$types = rcl_get_option( 'post_types_moderation' );

			if ( $types ) {
				$post_status = in_array( $this->post_type, $types ) ? 'pending' : 'publish';
			} else {
				$post_status = 'pending';
			}
		} else {
			$post_status = 'publish';
		}

		$rating = rcl_get_option( 'rating_no_moderation' );

		if ( $rating ) {
			$all_r		 = rcl_get_user_rating( $user_ID );
			if ( $all_r >= $rating )
				$post_status = 'publish';
		}

		return $post_status;
	}

	function add_data_post( $postdata, $data ) {

		$postdata['post_status'] = $this->get_status_post( rcl_get_option( 'moderation_public_post' ) );

		return $postdata;
	}

	function update_post() {
		global $user_ID;

		$postdata = array(
			'post_type'		 => $this->post_type,
			'post_title'	 => (isset( $_POST['post_title'] )) ? sanitize_text_field( $_POST['post_title'] ) : '',
			'post_excerpt'	 => (isset( $_POST['post_excerpt'] )) ? $_POST['post_excerpt'] : '',
			'post_content'	 => (isset( $_POST['post_content'] )) ? $_POST['post_content'] : ''
		);

		if ( ! $post || ! $post->post_name ) {
			$postdata['post_name'] = sanitize_title( $postdata['post_title'] );
		}

		if ( $this->post_id ) {
			$postdata['ID']			 = $this->post_id;
			$postdata['post_author'] = $this->post->post_author;
		} else {
			$postdata['post_author'] = $user_ID;
		}

		$postdata = apply_filters( 'pre_update_postdata_rcl', $postdata, $this );

		if ( ! $postdata )
			return false;

		do_action( 'pre_update_post_rcl', $postdata );

		if ( isset( $_POST['form_id'] ) ) {
			$formID = intval( $_POST['form_id'] );
		}

		if ( ! $this->post_id ) {

			$this->post_id = wp_insert_post( $postdata );

			if ( ! $this->post_id ) {
				$this->error( __( 'Error publishing!', 'wp-recall' ) . ' Error 101' );
			} else {

				if ( $formID > 1 )
					add_post_meta( $this->post_id, 'publicform-id', $formID );

				$post_name = wp_unique_post_slug( $postdata['post_name'], $this->post_id, 'publish', $postdata['post_type'], 0 );

				wp_update_post( [
					'ID'		 => $this->post_id,
					'post_name'	 => $post_name
				] );
			}
		}else {
			wp_update_post( $postdata );
		}

		$this->update_thumbnail( $postdata );

		$this->update_post_gallery( $postdata );

		delete_post_meta( $this->post_id, 'recall_slider' );

		rcl_update_post_custom_fields( $this->post_id, $formID );

		rcl_delete_temp_media_by_args( array(
			'user_id'			 => $user_ID,
			'uploader_id__in'	 => array( 'post_uploader', 'post_thumbnail' )
		) );

		do_action( 'update_post_rcl', $this->post_id, $postdata, $this->update, $this );

		if ( isset( $_POST['save-as-draft'] ) ) {
			wp_redirect( get_permalink( rcl_get_option( 'public_form_page_rcl' ) ) . '?draft=saved&rcl-post-edit=' . $this->post_id );
			exit;
		}

		if ( $postdata['post_status'] == 'pending' ) {
			if ( $user_ID )
				$redirect_url	 = get_bloginfo( 'wpurl' ) . '/?p=' . $this->post_id . '&preview=true';
			else
				$redirect_url	 = get_permalink( rcl_get_option( 'guest_post_redirect' ) );
		}else {
			$redirect_url = get_permalink( $this->post_id );
		}

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			wp_send_json( array( 'redirect' => $redirect_url ) );
		}

		header( "Location: $redirect_url", true, 302 );
		exit;
	}

}
