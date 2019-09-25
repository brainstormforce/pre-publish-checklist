<?php
/**
 * The Pre-Publish Checklist User Manual tab
 *
 * @since   1.0.0
 * @package Pre-Publish Checklist.
 * @author  Brainstorm Force.
 */

wp_enqueue_style( 'ppc_backend_css' );
?>

<table class="form-table ppc-form-table">
	<tbody>
		<tr>
			<td>
		<div class="ppc_user_manual">	
		<p>
		<?php esc_html_e( 'The Pre-Publish Checklist plugin allows you to manage the way your posts and pages are published on your website.', 'pre-publish-checklist' ); ?>
		</p>
		<p><?php esc_html_e( 'Have some prerequisites that you wish to fulfill before publishing anything? The Pre-Publish Checklist plugin reminds you of those just when you mistakenly click the publish button.', 'pre-publish-checklist' ); ?></p>
		<h4><label class="ppc_page_title" for="howtouse"> 
			<?php esc_html_e( 'Set this up in 3 easy steps-', 'pre-publish-checklist' ); ?>
		</label> </h4>
		<b><?php esc_attr_e( 'Step 1 ', 'pre-publish-checklist' ); ?><?php esc_attr_e( ': Select the action to be taken on a Publish attempt.', 'pre-publish-checklist' ); ?></b>
		<p><?php esc_html_e( 'The general settings tab allows you to select an appropriate action that you wish to trigger when a user attempts to publish the page or post.', 'pre-publish-checklist' ); ?></p><br>
	<b><?php esc_attr_e( 'Step 2 ', 'pre-publish-checklist' ); ?><?php esc_attr_e( ': Select the post types you wish to add the pre-publish checklist meta box to.', 'pre-publish-checklist' ); ?></b>
	<p><?php esc_html_e( 'You can select any post type available on your website. This too can be done in the general settings tab.', 'pre-publish-checklist' ); ?></p><br>
		<b><?php esc_attr_e( 'Step 3 ', 'pre-publish-checklist' ); ?><?php esc_attr_e( ': Create a Checklist.', 'pre-publish-checklist' ); ?></b>
	<p><?php esc_html_e( 'Open the Checklist tab and add as many items as you want into the checklist. You can drag and drop the list items as per the priority you wish to give them.', 'pre-publish-checklist' ); ?></p><br><br>
	<b><?php esc_html_e( 'Where will this Pre-publish checklist be added?', 'pre-publish-checklist' ); ?></b>
	<p><?php esc_html_e( 'The pre-publish checklist gets added as a meta box in the post or page meta settings where you’ve enabled it on.', 'pre-publish-checklist' ); ?></p>

		</div>
	</td>
		</tr>
	</tbody>
</table>

