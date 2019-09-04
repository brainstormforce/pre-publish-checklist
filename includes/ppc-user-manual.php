<?php
/**
 * The Pre Publish Checklist User Manual tab
 *
 * @since   1.0.0
 * @package Pre-Publish Checklist.
 * @author  Brainstorm Force.
 */

wp_enqueue_style( 'ppc_backend_css' );
?>
<!DOCTYPE html>
<html>
<body>
<table class="form-table ppc-form-table">
	<tbody>
		<tr>
			<td>
		<div class="ppc_user_manual">
		<h4><label class="ppc_page_title" for="howtouse"> How to Use? </label> </h4>
		<?php
		echo '
		<b>Step 1</b> : Under the <i>General Settings</i> tab, select the appropriate option to decide what to do on publish attempt.<br><br>
		<b>Step 2</b> : Select the <i>Post Types</i> on which you want to display the meta box having the Pre-Publish checklist.<br><br>
		<b>Step 3</b> : Go to the <i>Checklist</i> tab, Add the required items in the list that you want to check while publishing or updating a post. <br><br>
		<b>Step 4</b> : Go to the <i>Edit Post</i>  or <i>Add new</i> Post/Page. You will see a meta box in the meta settings.<br><br>
		<b>Step 5</b> : That' . "'" . 's it! Edit your pages and post without being feared about an accidental publish or update.  <br><br><br>';
		?>
		</div>
	</td>
		</tr>
	</tbody>
</table>
</body>
</html>
