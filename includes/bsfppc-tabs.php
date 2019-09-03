<?php
/**
 * Settings page of Pre Publish CHecklist
 *
 * @since   1.0.0
 * @package Pre-Publish Checklist.
 * @author  Brainstorm Force.
 */

echo '<h1 class="bsfppc_main_title">';
esc_attr_e( 'Pre-Publish Checklist', 'bsf-pre-publish-checklist' );
echo '</h1>';
?>



<?php
// Navigation.

// To get the tab value from URL and store in $bsfppc_active_tab variable.
$bsfppc_active_tab = 'bsfppc_general_settings';

if ( isset( $_GET['tab'] ) ) {  //PHPCS:ignore:WordPress.Security.NonceVerification.Recommended

	if ( 'bsfppc_general_settings' === $_GET['tab'] ) { //PHPCS:ignore:WordPress.Security.NonceVerification.Recommended

		$bsfppc_active_tab = 'bsfppc_general_settings';
	} elseif ( 'bsfppc-checklist' === $_GET['tab'] ) { //PHPCS:ignore:WordPress.Security.NonceVerification.Recommended

		$bsfppc_active_tab = 'bsfppc-checklist';
	} elseif ( 'bsfppc-user-manual' === $_GET['tab'] ) {//PHPCS:ignore:WordPress.Security.NonceVerification.Recommended

		$bsfppc_active_tab = 'bsfppc-user-manual';
	}
}

?>
<!-- WordPress provides the styling for tabs. -->

<!-- when tab buttons are clicked we jump back to the same page but with a new parameter that represents the clicked tab. accordingly we make it active -->
<h2 class="nav-tab-wrapper bsfppc-nav-tab-wrapper">
<a href="?page=bsf_ppc&tab=bsfppc_general_settings" class="nav-tab tb 
	<?php
	if ( 'bsfppc_general_settings' === $bsfppc_active_tab ) {
		echo 'nav-tab-active bsfppc-active-tab';
	}
	?>
	"><?php esc_attr_e( 'General Settings', 'bsf-pre-publish-checklist' ); ?></a>


		<a href="?page=bsf_ppc&tab=bsfppc-checklist" class="nav-tab tb 
	<?php
	if ( 'bsfppc-checklist' === $bsfppc_active_tab ) {
		echo 'nav-tab-active bsfppc-active-tab';
	}
	?>
		"><?php esc_attr_e( 'Checklist', 'bsf-pre-publish-checklist' ); ?></a>

		<a href="?page=bsf_ppc&tab=bsfppc-user-manual" class="nav-tab tb 
	<?php
	if ( 'bsfppc-user-manual' === $bsfppc_active_tab ) {
		echo 'nav-tab-active bsfppc-active-tab';
	}
	?>
		"><?php esc_attr_e( 'Getting Started', 'bsf-pre-publish-checklist' ); ?></a>
</h2>

<?php
// here we display the sections and options in the settings page based on the active tab.
if ( isset( $_GET['tab'] ) ) { //PHPCS:ignore:WordPress.Security.NonceVerification.Recommended

	if ( 'bsfppc_general_settings' === $_GET['tab'] ) { //PHPCS:ignore:WordPress.Security.NonceVerification.Recommended

		include_once 'bsfppc-frontend.php';
	} elseif ( 'bsfppc-checklist' === $_GET['tab'] ) { //PHPCS:ignore:WordPress.Security.NonceVerification.Recommended
		include_once 'bsfppc-checklist.php';
	} elseif ( 'bsfppc-user-manual' === $_GET['tab'] ) { //PHPCS:ignore:WordPress.Security.NonceVerification.Recommended
		include_once 'bsfppc-user-manual.php';
	}
} else {
	include_once 'bsfppc-frontend.php';
}

