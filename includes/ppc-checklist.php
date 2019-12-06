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

// phpcs:ignore WordPress.Security.NonceVerification
$ppc_type                = isset( $_GET['type'] ) ? sanitize_key( $_GET['type'] ) : '';
$ppc_checklist_item_data = PPC_Loader::get_instance()->get_list_by_post_type( $ppc_type );

wp_enqueue_script( 'ppc_backend_itemlist_js' );
wp_enqueue_style( 'ppc_backend_css' );
wp_enqueue_script( 'jquery' );
wp_enqueue_script( 'jquery-ui-core' );
wp_enqueue_script( 'jquery-ui-sortable' );
wp_enqueue_script( 'jQuery-ui-droppable' );
?>

<div>
	<ul id="pts" class="pts" name ="post-type-selected">
		<?php
		$ppc_post_types = get_option( 'ppc_post_types_to_display' );
		foreach ( get_post_types( array( 'public' => true ), 'objects' ) as $ppc_post_type_slug => $ppc_post_type_obj ) {
			if ( in_array( $ppc_post_type_slug, $ppc_post_types, true ) ) {
				$ppc_active_class = ( $ppc_type === $ppc_post_type_slug ) ? 'ppc-active' : '';
				echo '<li class="' . esc_attr( $ppc_active_class ) . '"><a href="' . esc_url( admin_url( 'options-general.php?page=ppc&tab=ppc-checklist&type=' ) . $ppc_post_type_slug ) . ' "> ' . esc_attr( $ppc_post_type_obj->label ) . '  </a></li>';
			}
		}
		?>
	</ul>
</div>
<?php
if ( ! empty( $ppc_post_types ) ) {
	?>
	<div class="ppc-table-wrapper">
		<table class="form-table ppc-form-table">
			<tbody>
				<tr>
					<th scope="row"><p class="ppc-list-label"><span class="spinner ppc-spinner"></span><?php esc_html_e( 'Pre-Publish Checklist', 'pre-publish-checklist' ); ?></p> </th>
					<td class="ppc-list-table">
						<div id="columns" class="ppcdragdrop">
							<?php
							if ( ! empty( $ppc_checklist_item_data ) ) {
								?>
								<ul id="ppc-ul" class="ppc-ul"> 
									<?php
									foreach ( $ppc_checklist_item_data as $ppc_key => $ppc_value ) {
										?>
										<li class="ppc-li">
											<span class="dashicons dashicons-menu-alt2 ppc-move-dashicon"></span> <input type="text" readonly="true" class="ppc-drag-feilds" $ppc_item_key ="<?php echo esc_attr( $ppc_key ); ?>" value="<?php echo esc_attr( $ppc_value ); ?>" name="ppc_checklist_item[]" >
											<button type="button" id = "edit" name="Edit" class="ppcedit" value="<?php echo esc_attr( $ppc_key ); ?>"> <span class="dashicons dashicons-edit"></span>Edit</button>
											<button type="button" id ="Delete" name="Delete" class="ppcdelete" value="<?php echo esc_attr( $ppc_key ); ?>"> <span class="dashicons dashicons-trash ppc-delete-dashicon"></span>Delete</button>
										</li>
										<?php
									}
							}
							?>
							</ul>
						</div>
						<p class="ppc-empty-list"><?php esc_html_e( 'You do not have any items in the list. Please add items in the list.', 'pre-publish-checklist' ); ?></p>
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
	<?php
} else {
	?>
	<div class="ppc-table-wrapper">
		<table class="form-table ppc-form-table">
			<tbody>
				<tr>
					<th scope="row"><p class="ppc-list-label"><span class="spinner ppc-spinner"></span><?php esc_html_e( 'Pre-Publish Checklist', 'pre-publish-checklist' ); ?></p> </th>
					<td class="ppc-list-table">
						<p class="ppc-empty-list"><?php esc_html_e( 'Please select the post type to display the list.', 'pre-publish-checklist' ); ?></p>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php
}


