<?php


if ( isset( $_POST['submit_radio'] ) ) {
	$_POST['submit_radio'] = sanitize_text_field( $_POST['submit_radio'] );
	if ( ! empty( $_POST['bsfppc_radio_button_option'] ) ) {

		$bsfppc_radio = sanitize_text_field( $_POST['bsfppc_radio_button_option'] );
		update_option( 'bsfppc_radio_button_option_data', $bsfppc_radio );
	}
	$bsfppc_radio_button_data = get_option( 'bsfppc_radio_button_option_data' );
}

if ( isset( $_POST['submit_radio'] ) ) {
		$_POST['submit_radio'] = sanitize_text_field( $_POST['submit_radio'] );
		$bsfppc_post_types     = array();
	if ( ! empty( $_POST['posts'] ) ) {
		$bsfppc_post_types = $_POST['posts'];
	}
	update_option( 'bsfppc_post_types_to_display', $bsfppc_post_types );

	$bsfppc_post_types_to_display = get_option( 'bsfppc_post_types_to_display' );
}


