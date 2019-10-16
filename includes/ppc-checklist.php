<?php
/**
 * Pre-Publish Check list php for displaying the contents on the
 * general settings tab.
 * PHP version 7
 *
 * @category PHP
 * @package  Pre-Publish Checklist.
 * @author   Display Name <username@ShubhamW.com>
 * @license  http://brainstormforce.com
 * @link     http://brainstormforce.com
 */

$ppc_checklist_item_data = get_option( 'ppc_checklist_data' );
wp_enqueue_script( 'ppc_backend_itemlist_js' );
wp_enqueue_style( 'ppc_backend_css' );
wp_enqueue_script( 'jquery' );
wp_enqueue_script( 'jquery-ui-core' );
wp_enqueue_script( 'jquery-ui-sortable' );
wp_enqueue_script( 'jQuery-ui-droppable' );
?>

<div class="ppc-table-wrapper">
<table class="form-table ppc-form-table">
	<tbody>
		<tr>
			<th scope="row"><p class="ppc-list-label"><span class=""></span><?php esc_html_e( 'Set a checklist for', 'pre-publish-checklist' ); ?></p> </th>
			<td class="">
				<?php
				$ppc_post_types = get_option( 'ppc_post_types_to_display' );
				// var_dump($ppc_post_types);
				?>
				<select>
				<?php
				foreach ($ppc_post_types as $ppc_post ) {
					?><option value= "<?php echo $ppc_post;?>"><?php echo $ppc_post; ?></option> <?php
				}
				?>	
				</select>

			</td>
		</tr>
		<tr>
			<th scope="row"><p class="ppc-list-label"><span class="spinner ppc-spinner"></span><?php esc_html_e( 'Pre-Publish Checklist', 'pre-publish-checklist' ); ?></p> </th>
			<td class="ppc-list-table">

				<div id="columns" class="ppcdragdrop">
		<?php
		if ( ! empty( $ppc_checklist_item_data ) ) {
			?>
						<ul id="ppc-ul" class="ppc-ul"> 
			<?php
			// print_r($ppc_checklist_item_data);
			foreach ( $ppc_checklist_item_data['post'] as $ppc_key  ) {
				?>
									<li class="ppc-li">
										<span class="dashicons dashicons-menu-alt2 ppc-move-dashicon"></span> <input type="text" readonly="true" class="ppc-drag-feilds" $ppc_item_key ="<?php echo esc_attr( $ppc_key ); ?>" value="<?php echo esc_attr( $ppc_key ); ?>" name="ppc_checklist_item[]" >
										<button type="button" id = "edit" name="Delete" class="ppcedit" value="<?php echo esc_attr( $ppc_key ); ?>"> <span class="dashicons dashicons-edit"></span>Edit</button>
										<button type="button" id = "Delete" name="Delete" class="ppcdelete" value="<?php echo esc_attr( $ppc_value ); ?>"> <span class="dashicons dashicons-trash ppc-delete-dashicon"></span>Delete</button>

									</li>
				<?php
		}
		}
		?>
						</ul>
				</div>
				<p class="ppc-empty-list"><?php esc_html_e( 'You do not have any items in the list please add items in the list.', 'pre-publish-checklist' ); ?></p>
			</td>
		</tr>
		<tr>
			<th scope="row"> <p class="ppc-label"><?php esc_html_e( 'Add New Item in Checklist', 'pre-publish-checklist' ); ?></p> </th>
			<td class="ppc-table">
				<table id ="list_table">
					<tr><div class="ppc_input_feild">
						<input type="text" id="add_item_text_feild" class="ppc-item-input" name="ppc_checklist_item[]" minlength= 1 >
						<button type="button" id="ppc-Savelist" name="submit" class="button button-primary ppc_data"   Value="Save List" /><?php esc_html_e( 'Add to List', 'pre-publish-checklist' ); ?></button>
						<br>

						<div class="ppc-warning-div">
							<div class="ppc-hide-empty-warning">
							<p class="warning ppc-list-waring-description"><?php esc_html_e( 'List item cannot be blank', 'pre-publish-checklist' ); ?></p>
							</div>
						</div>
					</div>
					</tr>
				</table>					
			</td>
		</tr>

	</tbody>
</table>
</div>


