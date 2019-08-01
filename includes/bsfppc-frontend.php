<?php

require_once BSF_PPC_ABSPATH . 'includes/bsfppc-save-data.php';
$bsfppc_radio_button = get_option('bsfppc_radio_button_option_data');

$bsfppc_radio_button = (!empty($bsfppc_radio_button) ? $bsfppc_radio_button : 3); 

$bsfppc_checklist_item_data = get_option('bsfppc_checklist_data');
wp_enqueue_script('bsfppc_backend_itemlist_js');
wp_enqueue_style('bsfppc_backend_css');
$bsfppc_post_types = get_option('bsfppc_post_types_to_display');
// $bsfppc_post_types = (!empty($bsfppc_post_types) ? $bsfppc_post_types : array('post')); 
// get_option('bsfppc_post_types_to_display');
 
$args = array(
	'public' => true,

);

$exclude = array( 'attachment', 'elementor_library', 'Media', 'My Templates' );



?>

<!DOCTYPE html>
<html>
<body>
<table class="form-table">
	<tbody>
		
		<tr><th scope="row"><p class="bsfppc-setting-name">On publish attempt </p></th>
			<td>
			<form method ="POST">
				<input type="radio" name="bsfppc_radio_button_option" value="1" <?php checked($bsfppc_radio_button,1 ); ?> > <div class="bsfppc_radio_options">Prevent user from publishing.</div> 
				<p class="bsfppc-description">The user will not be able to publish untill he checks all the checkboxes</p>
				<input type="radio" name="bsfppc_radio_button_option" value="2" <?php checked($bsfppc_radio_button,2 ); ?> > <div class="bsfppc_radio_options">Warn User before publishing. </div>  
				<p class="bsfppc-description">The user will be warned before publishing </p>
				<input type="radio" name="bsfppc_radio_button_option" value="3" <?php checked($bsfppc_radio_button,3 ); ?> > <div class="bsfppc_radio_options">Do Nothing </div>
				<p class="bsfppc-description" >The user will be allowed to publish without any warning </p>
				<br/>	
		</td>
		</tr>
		<tr>
			<th scope="row"><p class="bsfppc-setting-name">Post Types </p></th>
			<td><?php
				foreach ( get_post_types( $args, 'objects' ) as $bsfppc_post_type ) {
					if ( in_array( $bsfppc_post_type->labels->name, $exclude ) ) {
						continue;
					}
					if ( 'post' !== $bsfppc_post_types ) {
						if(!empty($bsfppc_post_types)) {
						if(false !== $bsfppc_post_types) {
							if ( in_array( $bsfppc_post_type->name, $bsfppc_post_types ) ) {
								echo '<label for="ForPostType">
	                     <input type="checkbox" checked name="posts[]" value="' . esc_attr( $bsfppc_post_type->name ) . '" >
	                     ' . esc_attr( $bsfppc_post_type->labels->name ) . '</label><br> ';
							} else {
								echo '<label for="ForPostType">
	                     <input type="checkbox"  name="posts[]" value="' . esc_attr( $bsfppc_post_type->name ) . '">
	                     ' . esc_attr( $bsfppc_post_type->labels->name ) . '</label><br> ';
							}
						} } else {
							echo '<label for="ForPostType">
	                     <input type="checkbox"  name="posts[]" value="' . esc_attr( $bsfppc_post_type->name ) . '">
	                     ' . esc_attr( $bsfppc_post_type->labels->name ) . '</label><br> ';
						}
					} else {
						if ( 'post' == $bsfppc_post_type->name ) {
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
				<p class="bsfppc-description">Select the post types to have your check list on</p>			
				
			<input type="submit" class="button button-primary bsfppc-savesetting"  name="submit_radio" Value="Save Setting"/>
			<div class="edit-warning">
					<p class="warning bsfppc-description">    List item cannot be blank</p>
			</div>
			</form>
			</td>
		</tr>		
		</tbody>
	</table>
</body>
</html><?php




    
