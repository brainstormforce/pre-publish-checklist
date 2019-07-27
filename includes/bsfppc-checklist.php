<?php
require_once BSF_PPC_ABSPATH . 'includes/bsfppc-save-data.php';
$bsfppc_radio_button = get_option('bsfppc_radio_button_option_data');
$bsfppc_checklist_item_data = get_option('bsfppc_checklist_data');
wp_enqueue_script('bsfppc_backend_itemlist_js');
wp_enqueue_style('bsfppc_backend_css');
?>
<html>
<body>
<table class="form-table">
	<tbody>
		<tr>
		<th scope="row"> <p>Create a custom checklist</p> </th>
	   			<td>
		    	<table id ="list_table">
		    	<tr>
					<div class="input_fields_wrap">
						<input type="text" id="add_item_text_feild" class="item_input" name="bsfppc_checklist_item[]" required>
					</div>
				</tr>
			</table>
				<a class="add_field_button button-secondary">Add item</a>
				<button type="button" id="Savelist" name="submit" class="button button-primary ppc_data" required   Value="Save List" />Save list </button>
			</td>
		</tr>
		<tr>
			<th scope="row"><p class="bsfppc_post"> Your List</p> </th>
			<td class="bsfppclistclass">	
				
				<?php
				if( !empty( $bsfppc_checklist_item_data)){?>
					<ul id="columns">
					<?php
					foreach( $bsfppc_checklist_item_data as $key ){
						?>
						<li class="column" draggable="true"><div class="drag-feild" ><div class="dashicons dashicons-menu-alt3"></div> <input type="text" readonly="true" class="drag-feilds" value="<?php echo esc_attr($key); ?>" name="bsfppc_checklist_item[]" >					
							<button type="button" id = "Delete" name="Delete" class="button button-primary bsfppcdelete" value="<?php echo esc_attr($key); ?>" formnovalidate >Delete</button> </div></li>
						<?php
					}
				}
				else{
					echo "You have do not have any list please add items in the list";
				} ?>

			</ul>


				<p> You can drag and drop the items to set the order</p>
				<button type="button" id = "Delete" name="Delete" class="button button-primary bsfppcedit" value="<?php echo esc_attr($key); ?>" formnovalidate >Edit Items</button>
				<button type="button" id = "Delete" name="Delete" class="button button-primary bsfppcsave" value="<?php echo esc_attr($key); ?>" formnovalidate >Save Changes </button>
				
			</td>
		</tr>
	</tbody>
</table>
</body>
</html>