<?php
$bsf_ppc_checklist_item_data = get_option('bsf_ppc_checklist_data');
echo'<h2>Please create a custom checklist </h2>
      <form method="POST">
		Checklist item <input type="text" name="bsf_ppc_checklist_item[]" required> 
		<input type="submit" name="submit" Value="add item"/>';
    	// if (
    	if( isset($_POST['submit'])){
			$bsf_ppc_checklist_item = array();
			foreach( $_POST['bsf_ppc_checklist_item'] as $checklist_items ) {
			    array_push( $bsf_ppc_checklist_item,$checklist_items );
			}
			update_option( 'bsf_ppc_checklist_data', $bsf_ppc_checklist_item);
			$bsf_ppc_checklist_item_data = get_option( 'bsf_ppc_checklist_data' );
		}
		echo'<h2>Your List</h2>
		<form method="POST">';
		foreach($bsf_ppc_checklist_item_data as $key){
		echo'<input type="text"  readonly value="'.$key.'" name="bsf_ppc_checklist_item[]" required> <br/>';
		}
		echo'</form>';
			echo'<h2>Settings</h2>
				<form method ="POST">';

				 $bsf_ppc_radio_button = get_option('bsf_ppc_radio_button_option_data');
				?>
					<input type="radio" name="bsf_ppc_radio_button_option" value="1" <?php checked($bsf_ppc_radio_button , 1 ); ?> > Warn User before publishing<br>
					<input type="radio" name="bsf_ppc_radio_button_option" value="2" <?php checked($bsf_ppc_radio_button , 2 ); ?> > Prevent user from publishing.<br>
					<input type="radio" name="bsf_ppc_radio_button_option" value="3" <?php checked($bsf_ppc_radio_button , 3 ); ?> > Do Nothing <br/>
					<input type="submit" name="submit_radio" Value="Submit Setting"/>
				</form>
				<?php
				if( isset($_POST['submit_radio'])){ 
					$bsf_ppc_radio =  $_POST['bsf_ppc_radio_button_option'] ;
					update_option( 'bsf_ppc_radio_button_option_data' , $bsf_ppc_radio);
					$bsf_ppc_radio_button_data = get_option( 'bsf_ppc_radio_button_option_data' );
				}
				if( !empty( $bsf_ppc_radio_button_data ) ){
					echo "Value is present " .$bsf_ppc_radio_button_data;
				}