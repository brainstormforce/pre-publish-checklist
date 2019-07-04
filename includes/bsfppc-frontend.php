<?php
require_once( BSF_PPC_ABSPATH . 'includes/bsfppc-save-data.php');
$bsf_ppc_radio_button = get_option('bsf_ppc_radio_button_option_data');
$bsf_ppc_checklist_item_data = get_option('bsf_ppc_checklist_data');?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h2>Please create a custom checklist </h2>
    <form method="POST">
		Checklist item <input type="text" name="bsf_ppc_checklist_item[]" required> 
		<input type="submit" name="submit" class="button button-primary"  Value="add item"/>
   
	<form method="POST">
		<h2>Your List</h2>
		<?php
		if(!empty($bsf_ppc_checklist_item_data)){
			foreach( $bsf_ppc_checklist_item_data as $key ){
			$arrIndex = array_search($key,$bsf_ppc_checklist_item_data);
			?>	 	
			<input type="text" readonly value="<?php echo esc_attr($key); ?>" name="bsf_ppc_checklist_item[]" >
			<?php
			echo'<input type="submit" name="delete" class="button button-secondary"  Value="delete"></br>
			';
			}
		}
		else{
			echo "You have do not have any list please add items in the list";
		}?>
	</form>
	<h2>Settings</h2> 
		<form method ="POST">
			<input type="radio" name="bsf_ppc_radio_button_option" value="1" <?php checked($bsf_ppc_radio_button,1 ); ?> > Warn User before publishing<br>
			<input type="radio" name="bsf_ppc_radio_button_option" value="2" <?php checked($bsf_ppc_radio_button,2 ); ?> > Prevent user from publishing.<br>
			<input type="radio" name="bsf_ppc_radio_button_option" value="3" <?php checked($bsf_ppc_radio_button,3 ); ?> > Do Nothing <br/>
			<br/>
			<input type="submit" class="button button-primary"  name="submit_radio" Value="Save Setting"/>
		</form>
				
</body>
</html>
