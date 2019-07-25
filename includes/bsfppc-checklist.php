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
			<td>

				<p> You can drag and drop the items to set the order</p>
				
				
				<?php
				if( !empty( $bsfppc_checklist_item_data)){?>
					<ul id="columns" class="dragevent">
					<?php
					foreach( $bsfppc_checklist_item_data as $key ){
						?>
						<li class="column" draggable="true"><div class="drag-feild" > <input type="text" class="drag-feilds" readonly value="<?php echo esc_attr($key); ?>" name="bsfppc_checklist_item[]" >
							<button type="button" id = "Delete" name="Delete" class="button button-secondary bsfppcdelete" value="<?php echo esc_attr($key); ?>" formnovalidate >Delete</button> </div></li>
						<?php
					}
				}
				else{
					echo "You have do not have any list please add items in the list";
				} ?>

			</ul>


				
			</td>
		</tr>
	</tbody>
</table>
</body>
</html>