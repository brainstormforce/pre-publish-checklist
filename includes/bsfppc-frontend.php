<?php
/**
 * BSF Pre Publish Check list php for Displaying the contents in the general tab in the plugin settings
 * PHP version 7
 *
 * @category PHP
 * @package  Pre Publish Check-list.
 * @author   Display Name <username@ShubhamW.com>
 * @license  http://brainstormforce.com
 * @link     http://brainstormforce.com
 */

// Displaying the contents in the general tab in the plugin settings.
$bsfppc_radio_button        = get_option( 'bsfppc_radio_button_option_data' );
$bsfppc_radio_button        = ( ! empty( $bsfppc_radio_button ) ? $bsfppc_radio_button : 3 );
$bsfppc_checklist_item_data = get_option( 'bsfppc_checklist_data' );
wp_enqueue_script( 'bsfppc_backend_itemlist_js' );
wp_enqueue_style( 'bsfppc_backend_css' );
$bsfppc_post_types = get_option( 'bsfppc_post_types_to_display' );
$args              = array(
	'public' => true,

);
$exclude = array( 'attachment', 'elementor_library', 'Media', 'My Templates' );
?>
<!DOCTYPE html>
<html>
<body>
<table class="form-table bsfppc-form-table">
	<tbody>
		<tr><th scope="row"><p class="bsfppc-setting-name">On Publish Attempt </p></th>
			<td>
			<form method ="POST" class="bsfppc-frontend-form">
				<input type="radio" name="bsfppc_radio_button_option" value="1" <?php checked( $bsfppc_radio_button, 1 ); ?> > <div class="bsfppc_radio_options"><?php esc_html_e( 'Prevent User from Publishing', 'bsf-pre-publish-checklist' ); ?></div>
				<p class="description"><?php esc_html_e( 'The user will not be able to publish until he checks all the checkboxes.', 'bsf-pre-publish-checklist' ); ?></p><br>
				<input type="radio" name="bsfppc_radio_button_option" value="2" <?php checked( $bsfppc_radio_button, 2 ); ?> > <div class="bsfppc_radio_options"><?php esc_html_e( 'Warn User Before Publishing', 'bsf-pre-publish-checklist' ); ?></div>
				<p class="description"><?php esc_html_e( 'The user will be warned before publishing or he can publish anyway.', 'bsf-pre-publish-checklist' ); ?></p><br>
				<input type="radio" name="bsfppc_radio_button_option" value="3" <?php checked( $bsfppc_radio_button, 3 ); ?> > <div class="bsfppc_radio_options"><?php esc_html_e( 'Do Nothing.', 'bsf-pre-publish-checklist' ); ?></div>
				<p class="description"><?php esc_html_e( 'The user will be allowed to publish without any warning.', 'bsf-pre-publish-checklist' ); ?></p><br>
				<br/>
		</td>
		</tr>
		<tr>
			<th scope="row"><p class="bsfppc-setting-name"><?php esc_html_e( 'Post Types', 'bsf-pre-publish-checklist' ); ?></p></th>
			<td class = "bsfppc-posttypes">
	<?php
	foreach ( get_post_types( $args, 'objects' ) as $bsfppc_post_type ) {
		if ( in_array( $bsfppc_post_type->labels->name, $exclude, true ) ) {
			continue;
		}
		if ( 'post' !== $bsfppc_post_types ) {
			if ( ! empty( $bsfppc_post_types ) ) {
				if ( false !== $bsfppc_post_types ) {
					if ( in_array( $bsfppc_post_type->name, $bsfppc_post_types, true ) ) {
						echo '<label for="ForPostType">
	                     <input type="checkbox" checked name="posts[]" value="' . esc_attr( $bsfppc_post_type->name ) . '" >
	                     ' . esc_attr( $bsfppc_post_type->labels->name ) . '</label><br> ';
					} else {
						echo '<label for="ForPostType">
	                     <input type="checkbox"  name="posts[]" value="' . esc_attr( $bsfppc_post_type->name ) . '">
	                     ' . esc_attr( $bsfppc_post_type->labels->name ) . '</label><br> ';
					}
				}
			} else {
				echo '<label for="ForPostType">
	                     <input type="checkbox"  name="posts[]" value="' . esc_attr( $bsfppc_post_type->name ) . '">
	                     ' . esc_attr( $bsfppc_post_type->labels->name ) . '</label><br> ';
			}
		} else {
			if ( 'post' === $bsfppc_post_type->name ) {
				echo '<label for="ForPostType">
	                 <input type="checkbox" checked name="posts[]" value="' . esc_attr( $bsfppc_post_type->name ) . '">
	                 ' . esc_attr( $bsfppc_post_type->labels->name ) . '</label><br> ';
			}
			echo '<label for="ForPostType">
	                 <input type="checkbox"  name="posts[]" value="' . esc_attr( $bsfppc_post_type->name ) . '">
	                 ' . esc_attr( $bsfppc_post_type->labels->name ) . '</label><br> ';
		}
	}
	$bsfppc_checklist_item_data = get_option( 'bsfppc_checklist_data' );
	?>
				<br>
				<p class="description"><?php esc_html_e( 'Select the post types to have your check list on.', 'bsf-pre-publish-checklist' ); ?></p> <br>

				<?php wp_nonce_field( 'bsfppc-form-nonce', 'bsfppc-form' ); ?>
			<br><input type="submit" class="button button-primary bsfppc-savesetting"  name="submit_radio" Value="Save Setting"/>
			</form>
			</td>
		</tr>
		</tbody>
	</table>
</body>
</html>
<?php
