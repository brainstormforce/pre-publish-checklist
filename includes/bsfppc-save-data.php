<?php

// for saving checlklist items
	if( isset( $_POST['submit'] ) ){
			$_POST['submit'] = filter_var( $_POST['submit'], FILTER_SANITIZE_STRING );
				$bsfppc_checklist_item = array();
				foreach( $_POST['bsfppc_checklist_item'] as $checklist_items ) {
				    array_push( $bsfppc_checklist_item,$checklist_items );
			}
				update_option( 'bsfppc_checklist_data', $bsfppc_checklist_item );
				$bsfppc_checklist_item_data = get_option( 'bsfppc_checklist_data' );	
		}

//for deleting the list item	
if( isset( $_POST['Delete'] ) ) {
			$bsfppc_checklist_item_data = get_option( 'bsfppc_checklist_data' );
			if (($key = array_search($_POST['Delete'], $bsfppc_checklist_item_data)) !== false) {
				    unset($bsfppc_checklist_item_data[$key]);
			}
			update_option( 'bsfppc_checklist_data', $bsfppc_checklist_item_data );
		}
		
//for saving radio button
$bsfppc_checklist_item_data = get_option( 'bsfppc_checklist_data' );
	if( isset( $_POST['submit_radio'] ) ){ 
		$_POST['submit_radio'] = filter_var($_POST['submit_radio'], FILTER_SANITIZE_STRING);
		$bsfppc_radio =  $_POST['bsfppc_radio_button_option'] ;
		update_option( 'bsfppc_radio_button_option_data' , $bsfppc_radio );
		$bsfppc_radio_button_data = get_option( 'bsfppc_radio_button_option_data' );
	}


