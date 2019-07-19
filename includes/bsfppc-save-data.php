<?php
		
//for saving radio button
if( isset( $_POST['submit_radio'] ) ){ 
		$_POST['submit_radio'] = filter_var($_POST['submit_radio'], FILTER_SANITIZE_STRING);
		$bsfppc_radio =  $_POST['bsfppc_radio_button_option'] ;
		update_option( 'bsfppc_radio_button_option_data' , $bsfppc_radio );
		$bsfppc_radio_button_data = get_option( 'bsfppc_radio_button_option_data' );
	}

