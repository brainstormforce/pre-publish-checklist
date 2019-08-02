<?php
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
								<input type="text" id="add_item_text_feild" class="bsfppc-item-input" name="bsfppc_checklist_item[]" >
						</tr>
					</table>
					<button type="button" id="bsfppc-Savelist" name="submit" class="button button-primary bsfppc_data"   Value="Save List" />Add to list</button>
					<div class="bsfppc-hide-cover">
						<p class="warning bsfppc-edit-waring-description">List item cannot be blank</p>
					</div>
				</td>
		</tr>
		<tr>
			<th scope="row"><p class="bsfppc_post"> Your List</p> </th>
			<td class="bsfppclistclass">	
				
				<div id="columns" class="ui-droppable ui-sortable bsfppcdragdrop">
					<?php
					if( !empty( $bsfppc_checklist_item_data)){?>
						<ul id="bsfppc-ul" class="bsfppc-ul">
								<?php
								foreach( $bsfppc_checklist_item_data as $key ){
									?>
									<li class="bsfppc-li">
										<span class = "down"></span> 
										<span class="dashicons dashicons-menu-alt3"></span> <input type="text" readonly="true" class="bsfppc-drag-feilds" value="<?php echo esc_attr($key); ?>" name="bsfppc_checklist_item[]" >			
										<button type="button" id = "Delete" name="Delete" class="button button-primary bsfppcdelete" value="<?php echo esc_attr($key); ?>" formnovalidate >Delete</button> 
										<?php
								}
					}
							else{
							echo "You have do not have any list please add items in the list";
							} ?>
									</li> 
						</ul>
				</div>
				<p class="bsfppc-description"> You can drag and drop the items to set the order</p>
				<button type="button" id = "Delete" name="Delete" class="button button-primary bsfppcedit" value="bsfppc_edit_items" formnovalidate >Edit Items</button>
				<button type="button" id = "saveitemlist" name="savelist" class="button button-primary bsfppcsave" value="bsfppc_save_items" formnovalidate >Save Changes </button>
				<div class="edit-warning">
					<p class="warning bsfppc-edit-waring-description">List item cannot be blank</p></div>
			</td>
		</tr>
	</tbody>
</table>
</body>
</html>