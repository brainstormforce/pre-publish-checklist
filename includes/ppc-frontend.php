<?php
/**
 * Pre-Publish Checklist php for Displaying the contents in the general tab in the plugin settings
 * PHP version 7
 *
 * @category PHP
 * @package  Pre-Publish Checklist.
 * @author   Pratik Chaskar
 * @license  https://pratikchaskar.com/
 * @link     https://pratikchaskar.com/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Displaying the contents in the general tab in the plugin settings.
$ppc_radio_button = get_option( 'ppc_error_level', 3 );
wp_enqueue_style( 'ppc_backend_css' );
$ppc_checklist_item_data = get_option( 'ppc_cpt_checklist_data' );
$ppc_post_types          = get_option( 'ppc_post_types_to_display' );

$ppc_args = array(
	'public' => true,
);

$ppc_exclude = array( 'attachment', 'elementor_library', 'Media', 'My Templates' );

?>

<form method ="POST" class="ppc-frontend-form">
<table class="form-table ppc-form-table">
	<tbody>
		<tr><th scope="row"><p class="ppc-setting-name"><?php esc_html_e( 'Publish Button Action If Checklist Is Incomplete', 'pre-publish-checklist' ); ?></p></th>
			<td class="ppc-publish-attempt-options">
				<label for="ppc_prevent_user">
				<input type="radio" id="ppc_prevent_user" name="ppc_radio_button_option" value="1" <?php checked( $ppc_radio_button, 1 ); ?> > <div class="ppc_radio_options"><?php esc_html_e( 'Prevent User from Publishing Page/Post', 'pre-publish-checklist' ); ?></div>
				<p class="description"><?php esc_html_e( 'User will not be able to publish the page or post until all the points in the checklist are covered.', 'pre-publish-checklist' ); ?></p><br></label>
				<label for="ppc_warn_user">
				<input type="radio" id="ppc_warn_user" name="ppc_radio_button_option" value="2" <?php checked( $ppc_radio_button, 2 ); ?> > <div class="ppc_radio_options"><?php esc_html_e( 'Warn User Before Publishing', 'pre-publish-checklist' ); ?></div>
				<p class="description">
				<?php esc_html_e( 'A warning message will be displayed when the user clicks on the publish button.', 'pre-publish-checklist' ); ?>
				</p><br></label>
				<label for="ppc_do_nothing">
				<input type="radio" id="ppc_do_nothing" name="ppc_radio_button_option" value="3" <?php checked( $ppc_radio_button, 3 ); ?> > <div class="ppc_radio_options"><?php esc_html_e( 'Do Nothing and Publish', 'pre-publish-checklist' ); ?></div>
				<p class="description"><?php esc_html_e( 'The user will be allowed to publish the page or post without a warning.', 'pre-publish-checklist' ); ?></p>
			</label>
		</td>
		</tr>
		<tr>
			<th scope="row"><p class="ppc-setting-name"><?php esc_html_e( 'Post Types', 'pre-publish-checklist' ); ?></p></th>
			<td class = "ppc-posttypes">
	<?php
	foreach ( get_post_types( $ppc_args, 'objects' ) as $ppc_post_type ) {
		if ( in_array( $ppc_post_type->labels->name, $ppc_exclude, true ) ) {
			continue;
		}
		if ( 'post' !== $ppc_post_types && post_type_supports( '' . $ppc_post_type->name . '', 'editor' ) === true ) {
			if ( ! empty( $ppc_post_types ) ) {
				if ( false !== $ppc_post_types ) {
					if ( in_array( $ppc_post_type->name, $ppc_post_types, true ) ) {
						echo '<label for="' . esc_attr( $ppc_post_type->name ) . '">
	                     <input type="checkbox" checked name="posts[]"  id="' . esc_attr( $ppc_post_type->name ) . '" value="' . esc_attr( $ppc_post_type->name ) . '" >
	                     ' . esc_attr( $ppc_post_type->labels->name ) . '</label><br> ';
					} else {
						echo '<label for="<?php echo esc_attr( $ppc_post_type->name ); ?>">
	                     <input type="checkbox"  name="posts[]" id="' . esc_attr( $ppc_post_type->name ) . '" value="' . esc_attr( $ppc_post_type->name ) . '">
	                     ' . esc_attr( $ppc_post_type->labels->name ) . '</label><br> ';
					}
				}
			} else {
				echo '<label for="' . esc_attr( $ppc_post_type->name ) . '">
	                     <input type="checkbox"  name="posts[]" id="' . esc_attr( $ppc_post_type->name ) . '" value="' . esc_attr( $ppc_post_type->name ) . '">
	                     ' . esc_attr( $ppc_post_type->labels->name ) . '</label><br> ';
			}
		} else {
			if ( 'post' === $ppc_post_type->name && post_type_supports( '' . $ppc_post_type->name . '', 'editor' ) === true ) {
				echo '<label for="<?php echo esc_attr( $ppc_post_type->name ); ?>">
	                 <input type="checkbox" checked name="posts[]" id="' . esc_attr( $ppc_post_type->name ) . '" value="' . esc_attr( $ppc_post_type->name ) . '">
	                 ' . esc_attr( $ppc_post_type->labels->name ) . '</label><br> ';
			}
			echo '<label for="' . esc_attr( $ppc_post_type->name ) . '">
	                 <input type="checkbox"  name="posts[]" id="' . esc_attr( $ppc_post_type->name ) . '" value="' . esc_attr( $ppc_post_type->name ) . '">
	                 ' . esc_attr( $ppc_post_type->labels->name ) . '</label><br> ';
		}
	}
	?>
				<br>
				<p class="description"><?php esc_html_e( 'Select the post types where you wish to display the Pre-Publish Checklist.', 'pre-publish-checklist' ); ?></p> <br>

				<?php wp_nonce_field( 'ppc-form-nonce', 'ppc-form' ); ?>
			<br>
			<input type="submit" class="button button-primary ppc-savesetting"  name="submit_radio" Value="Save Settings"/>		
			</td>
		</tr>
		</tbody>
	</table>
	</form>

