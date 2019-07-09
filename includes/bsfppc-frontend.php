<?php
require_once( BSF_PPC_ABSPATH . 'includes/bsfppc-save-data.php');
$bsfppc_radio_button = get_option('bsfppc_radio_button_option_data');
$bsfppc_checklist_item_data = get_option('bsfppc_checklist_data');?>

<!DOCTYPE html>
<html>
<body>

	<h2>Please create a custom checklist </h2>
    <form method="POST">
		Checklist item <input type="text" name="bsfppc_checklist_item[]" required > 
		<input type="submit" id="form1" name="submit" class="button button-primary ppc_data"  Value="add item"/>

	<form method="POST">
		<h2>Your List</h2>
		<?php
		if(!empty($bsfppc_checklist_item_data)){
			foreach( $bsfppc_checklist_item_data as $key ){
			?>	 	
			<input type="text" readonly value="<?php echo esc_attr($key); ?>" name="bsfppc_checklist_item[]" ></br>
			<?php
			}
			echo'</br> <input type="submit" name="delete" class="button button-secondary"  Value="Delete a item " formnovalidate>
			';
		}
		else{
			echo "You have do not have any list please add items in the list";
		}?>
	</form>
	<h2>Settings</h2> 
		<form method ="POST">
			<input type="radio" name="bsfppc_radio_button_option" value="1" <?php checked($bsfppc_radio_button,1 ); ?> > Prevent user from publishing. <br>
			<input type="radio" name="bsfppc_radio_button_option" value="2" <?php checked($bsfppc_radio_button,2 ); ?> > Warn User before publishing.   <br>
			<input type="radio" name="bsfppc_radio_button_option" value="3" <?php checked($bsfppc_radio_button,3 ); ?> > Do Nothing <br/>
			<br/>
			<input type="submit" class="button button-primary"  name="submit_radio" Value="Save Setting"/>
		</form>
</body>
</html>



    
