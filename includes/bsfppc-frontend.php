<?php
$bsfppc_radio_button = get_option('bsfppc_radio_button_option_data');
$bsfppc_checklist_item_data = get_option('bsfppc_checklist_data');
wp_enqueue_script('bsfppc_backend_itemlist_js');
wp_enqueue_style('bsfppc_backend_css');
wp_enqueue_script('bsfppc_backend_settings_delete_js');
wp_enqueue_script('bsfppc_backend_settings_add_js');?>

<!DOCTYPE html>
<html>
<body>

	<h1>Please create a custom checklist </h1>
   
    	<table id ="list_table"><tr><td>
		<div class="input_fields_wrap">
			<div><input type="text" id="add_item_text_feild" class="item_input" name="bsfppc_checklist_item[]" required></div>
		</div></td></tr>
	</table>
		<a class="add_field_button button-secondary">Add item</a>
		<button type="button" id="Savelist" name="submit" class="button button-primary ppc_data" required   Value="Save List" />Save list </button>
	
		<h2>Your List</h2>
		<?php
		if( !empty( $bsfppc_checklist_item_data)){
			foreach( $bsfppc_checklist_item_data as $key ){
			?><div>
							<input type="text" readonly value="<?php echo esc_attr($key); ?>" name="bsfppc_checklist_item[]" >
				<button type="button" id = "Delete" name="Delete" class="button button-secondary bsfppcdelete" value="<?php echo esc_attr($key); ?>" formnovalidate >Delete</button>
			</div>
			<?php
			}
		}
		else{
			echo "You have do not have any list please add items in the list";
		}?>
	
	
	<h2>Settings</h2> 
	<p>On publish attempt </p>
		<form method ="POST">
			<input type="radio" name="bsfppc_radio_button_option" value="1" <?php checked($bsfppc_radio_button,1 ); ?> > <div class="bsfppc_radio_options">Prevent user from publishing.</div> 
			<p>The user will not be able to publish untill he checks all the checkboxes</p>
			<input type="radio" name="bsfppc_radio_button_option" value="2" <?php checked($bsfppc_radio_button,2 ); ?> > <div class="bsfppc_radio_options">Warn User before publishing. </div>  
			<p>The user will be warned before publishing </p>
			<input type="radio" name="bsfppc_radio_button_option" value="3" <?php checked($bsfppc_radio_button,3 ); ?> > <div class="bsfppc_radio_options">Do Nothing </div>
			<p>The user will be allowed to publish without any warning </p>
			<br/>
			<input type="submit" class="button button-primary"  name="submit_radio" Value="Save Setting"/>
		</form>
</body>
</html>



    
