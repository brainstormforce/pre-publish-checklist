<?php
/**
 * BSF Pre Publish Check list php for displaying the contents on the
 * general settings tab.
 * PHP version 7
 *
 * @category PHP
 * @package  Pre Publish Check-list.
 * @author   Display Name <username@ShubhamW.com>
 * @license  http://brainstormforce.com
 * @link     http://brainstormforce.com
 */

$bsfppc_checklist_item_data = get_option( 'bsfppc_checklist_data' );
wp_enqueue_script( 'bsfppc_backend_itemlist_js' );
wp_enqueue_style( 'bsfppc_backend_css' );
?>
<html>
<body>
<table class="form-table bsfppc-form-table">
	<tbody>
		<tr>
			<th scope="row"> <p class="bsfppc-post"><?php esc_html_e( 'Create a Custom Checklist', 'bsf-pre-publish-checklist' ); ?></p> </th>
			<td class="bsfppc-table">
				<table id ="list_table">
					<tr><div class="bsfppc_input_feild">
						<input type="text" id="add_item_text_feild" class="bsfppc-item-input" name="bsfppc_checklist_item[]" minlength= 1 >
						<button type="button" id="bsfppc-Savelist" name="submit" class="button button-primary bsfppc_data"   Value="Save List" /><?php esc_html_e( 'Add to list', 'bsf-pre-publish-checklist' ); ?></button>
						<br>
						<div class="bsfppc-warning-div">
							<div class="bsfppc-hide-empty-warning">
							<p class="warning bsfppc-list-waring-description"><?php esc_html_e( 'List item cannot be blank', 'bsf-pre-publish-checklist' ); ?></p>
							</div>
						</div>
					</div>
					</tr>
				</table>					
			</td>
		</tr>
		<tr>
			<th scope="row"><p class="bsfppc-post"><span class="spinner is-active"></span><?php esc_html_e( 'Your List', 'bsf-pre-publish-checklist' ); ?></p> </th>
			<td class="bsfppc-list-table">

				<div id="columns" class="bsfppcdragdrop">
		<?php
		if ( ! empty( $bsfppc_checklist_item_data ) ) {
			?>
						<ul id="bsfppc-ul" class="bsfppc-ul">
			<?php
			foreach ( $bsfppc_checklist_item_data as $key ) {
				?>
									<li class="bsfppc-li">
										<!-- <span class = "down"></span> -->
										<span class="dashicons dashicons-menu-alt2"></span> <input type="text" readonly="true" class="bsfppc-drag-feilds" value="<?php echo esc_attr( $key ); ?>" name="bsfppc_checklist_item[]" >
										<button type="button" id = "edit" name="Delete" class="bsfppcedit" value="<?php echo esc_attr( $key ); ?>"> <span class="dashicons dashicons-edit"></span>Edit</button>
										<button type="button" id = "Delete" name="Delete" class="bsfppcdelete" value="<?php echo esc_attr( $key ); ?>"> <span class="dashicons dashicons-trash bsfppc-delete-dashicon"></span>Delete</button>

									</li>
				<?php
			}
		} ?>
						</ul>
				</div>
				<p class="bsfppc-empty-list"><?php esc_html_e( 'You do not have any items in the list please add items in the list.', 'bsf-pre-publish-checklist' ); ?></p>
			</td>
		</tr>
	</tbody>
</table>
</body>
</html>


