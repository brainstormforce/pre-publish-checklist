<?php
var_dump( $_POST );
// for saving checlklist items
	if( isset($_POST['submit'])){
		$_POST['submit'] = filter_var($_POST['submit'], FILTER_SANITIZE_STRING);
			$bsf_ppc_checklist_item = array();
			foreach( $_POST['bsf_ppc_checklist_item'] as $checklist_items ) {
			    array_push( $bsf_ppc_checklist_item,$checklist_items );
		}
			update_option( 'bsf_ppc_checklist_data', $bsf_ppc_checklist_item );
			$bsf_ppc_checklist_item_data = get_option( 'bsf_ppc_checklist_data' );
			
		}
//for deleting the list item
if( isset( $_POST['delete'] ) ) {
			$bsf_ppc_checklist_item_data = get_option( 'bsf_ppc_checklist_data' );
			$bsf_ppc_checklist_item = array();
			$bsf_ppc_checklist_item = $bsf_ppc_checklist_item_data;
			unset( $bsf_ppc_checklist_item[] );
			update_option( 'bsf_ppc_checklist_data', $bsf_ppc_checklist_item);
		
		}
//for saving radio button
$bsf_ppc_checklist_item_data = get_option( 'bsf_ppc_checklist_data' );
	if( isset( $_POST['submit_radio'] ) ){ 
		$_POST['submit_radio'] = filter_var($_POST['submit_radio'], FILTER_SANITIZE_STRING);
		$bsf_ppc_radio =  $_POST['bsf_ppc_radio_button_option'] ;
		update_option( 'bsf_ppc_radio_button_option_data' , $bsf_ppc_radio);
		$bsf_ppc_radio_button_data = get_option( 'bsf_ppc_radio_button_option_data' );
	}


