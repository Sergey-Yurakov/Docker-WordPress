<?php

function rcl_ajax_action( $function_name, $guest_access = false ) {

	add_action( 'wp_ajax_' . $function_name, $function_name );

	if ( $guest_access )
		add_action( 'wp_ajax_nopriv_' . $function_name, $function_name );
}

function rcl_is_ajax() {
	return (defined( 'DOING_AJAX' ) && DOING_AJAX || isset( $GLOBALS['wp']->query_vars['rest_route'] ));
}

//загрузка вкладки ЛК через AJAX
rcl_ajax_action( 'rcl_ajax_tab', true );
function rcl_ajax_tab() {
	global $user_LK;

	rcl_verify_ajax_nonce();

	$post = rcl_decode_post( $_POST['post'] );

	do_action( 'rcl_init_ajax_tab', $post->tab_id );

	$tab = rcl_get_tab( $post->tab_id );

	if ( ! $tab ) {
		wp_send_json( array( 'error' => __( 'Data of the requested tab was not found.', 'wp-recall' ) ) );
	}

	$ajax = (in_array( 'ajax', $tab['supports'] ) || in_array( 'dialog', $tab['supports'] )) ? 1 : 0;

	if ( ! $ajax ) {
		wp_send_json( array( 'error' => __( 'Perhaps this add-on does not support ajax loading', 'wp-recall' ) ) );
	}

	$user_LK = intval( $post->master_id );

	$content = rcl_get_tab_content( $post->tab_id, $post->master_id, isset( $post->subtab_id ) ? $post->subtab_id : ''  );

	if ( ! $content ) {
		wp_send_json( array( 'error' => __( 'Unable to obtain content of the requested tab', 'wp-recall' ) ) );
	}

	$content = apply_filters( 'rcl_ajax_tab_content', $content );

	$result = apply_filters( 'rcl_ajax_tab_result', array(
		'result' => $content,
		'post'	 => array(
			'tab_id'	 => $post->tab_id,
			'subtab_id'	 => isset( $post->subtab_id ) ? $post->subtab_id : '',
			'tab_url'	 => (isset( $_POST['tab'] )) ? $_POST['tab_url'] . '&tab=' . $_POST['tab'] : $_POST['tab_url'],
			'supports'	 => $tab['supports'],
			'master_id'	 => $post->master_id
		)
		) );

	wp_send_json( $result );
}

//регистрируем биение плагина
rcl_ajax_action( 'rcl_beat', true );
function rcl_beat() {

	rcl_verify_ajax_nonce();

	$databeat	 = json_decode( wp_unslash( $_POST['databeat'] ) );
	$return		 = array();

	if ( $databeat ) {
		foreach ( $databeat as $data ) {

			$result = array();

			$callback			 = $data->action;
			$result['result']	 = $callback( $data->data );
			$result['success']	 = $data->success;
			$result['beat_name'] = $data->beat_name;
			$return[]			 = $result;
		}
	}

	wp_send_json( $return );
}

rcl_ajax_action( 'rcl_manage_user_black_list', false );
function rcl_manage_user_black_list() {
	global $user_ID;

	rcl_verify_ajax_nonce();

	$user_id = intval( $_POST['user_id'] );

	if ( ! $user_id ) {
		wp_send_json( array(
			'error' => __( 'Error', 'wp-recall' )
		) );
	}

	$user_block = get_user_meta( $user_ID, 'rcl_black_list:' . $user_id );

	if ( $user_block ) {
		delete_user_meta( $user_ID, 'rcl_black_list:' . $user_id );
		do_action( 'remove_user_blacklist', $user_id );
	} else {
		add_user_meta( $user_ID, 'rcl_black_list:' . $user_id, 1 );
		do_action( 'add_user_blacklist', $user_id );
	}

	$new_status = $user_block ? 0 : 1;

	wp_send_json( array(
		'label' => ($new_status) ? __( 'Unblock', 'wp-recall' ) : __( 'Blacklist', 'wp-recall' )
	) );
}

rcl_ajax_action( 'rcl_get_smiles_ajax', false );
function rcl_get_smiles_ajax() {
	global $wpsmiliestrans;

	rcl_verify_ajax_nonce();

	$content = array();

	$smilies = array();
	foreach ( $wpsmiliestrans as $emo => $smilie ) {
		$smilies[$smilie] = $emo;
	}

	foreach ( $smilies as $smilie => $emo ) {
		if ( ! $emo )
			continue;
		$content[] = str_replace( 'style="height: 1em; max-height: 1em;"', '', convert_smilies( $emo ) );
	}

	if ( ! $content ) {
		wp_send_json( array(
			'error' => __( 'Failed to load emoticons', 'wp-recall' )
		) );
	}

	wp_send_json( array(
		'content' => implode( '', $content )
	) );
}

/* new uploader */
rcl_ajax_action( 'rcl_upload', true );
function rcl_upload() {

	rcl_verify_ajax_nonce();

	$options = ( array ) json_decode( wp_unslash( $_POST['options'] ) );

	if ( ! isset( $options['class_name'] ) || ! $options['class_name'] )
		wp_send_json( [
			'error' => __( 'Error', 'wp-recall' )
		] );

	$className = $options['class_name'];

	if ( $className == 'Rcl_Uploader' )
		$uploader	 = new $className( $options['uploader_id'], $options );
	else
		$uploader	 = new $className( $options );

	if ( md5( json_encode( $uploader ) . rcl_get_option( 'security-key' ) ) != $_POST['sk'] )
		wp_send_json( [
			'error' => __( 'Error of security', 'wp-recall' )
		] );

	$files = $uploader->upload();

	if ( $files ) {
		wp_send_json( $files );
	} else {
		wp_send_json( array(
			'error' => __( 'Something has been wrong', 'wp-recall' )
		) );
	}
}

//удаление фото приложенных к публикации через загрузчик плагина
rcl_ajax_action( 'rcl_ajax_delete_attachment', true );
function rcl_ajax_delete_attachment() {
	global $user_ID;

	rcl_verify_ajax_nonce();

	$attachment_id	 = intval( $_POST['attach_id'] );
	$post_id		 = intval( $_POST['post_id'] );

	if ( ! $attachment_id ) {
		wp_send_json( array(
			'error' => __( 'The data has been wrong!', 'wp-recall' )
		) );
	}

	if ( $post_id ) {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			wp_send_json( array(
				'error' => __( 'You can`t delete this file!', 'wp-recall' )
			) );
		}
	} else {

		$media = RQ::tbl( new Rcl_Temp_Media() )->where( ['media_id' => $attachment_id ] )->get_row();

		if ( ! $user_ID ) {
			if ( $media->session_id != $_COOKIE['PHPSESSID'] ) {
				wp_send_json( array(
					'error' => __( 'You can`t delete this file!', 'wp-recall' )
				) );
			}
		} else {
			if ( ! current_user_can( 'edit_post', $attachment_id ) ) {
				wp_send_json( array(
					'error' => __( 'You can`t delete this file!', 'wp-recall' )
				) );
			}
		}

		rcl_delete_temp_media( $attachment_id );
	}

	wp_delete_attachment( $attachment_id, true );

	wp_send_json( array(
		'success' => __( 'The file has been successfully deleted!', 'wp-recall' )
	) );
}

/* new uploader end */
