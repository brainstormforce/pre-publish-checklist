<?php
/**
 * The Pre Publish Checklist User Manual tab
 *
 * @since   1.0.0
 * @package BSF
 * @author  Brainstorm Force.
 */

wp_enqueue_style( 'bsfppc_backend_css' );
?>
<!DOCTYPE html>
<html>
<body>
<table class="form-table bsfppc-form-table">
	<tbody>
		<tr>
			<td>
		<div class="bsfppc_user_manual">
		<br><label class="bsfppc_page_title" for="howtouse"> How to Use? </label> <br><br>
		<?php
		echo '
		<b>Step 1</b> : Under the <i>General Settings</i> Tab, Select the option you want that is what you want to do on publish attempt and click save settings. Select post types to display the meta box in the meta settings.<br><br>
		<b>Step 2</b> : Go to the <i>Checklist</i> Tab, Add the required items in the list that you want to check while publishing or updating a post. <br><br>
		<b>Step 3</b> : Go to the <i>Edit Post</i>  or <i>Add new</i> Post/Page. You will see a meta box in the meta settings.<br><br>
		<b>Step 4</b> : That' . "'" . 's it! Edit your pages and post without being feared about an accidental publish or update.  <br><br><br>';

		?>
		</div>
	</td>
		</tr>
	</tbody>
</table>
</body>
</html>
