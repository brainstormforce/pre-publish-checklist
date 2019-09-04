<?php
/**
 * Settings page of Pre Publish CHecklist
 *
 * @since   1.0.0
 * @package Pre-Publish Checklist.
 * @author  Brainstorm Force.
 */

echo '<h1 class="ppc_main_title">';
esc_attr_e( 'Pre-Publish Checklist', 'bsf-pre-publish-checklist' );
echo '</h1>';
?>



<?php
// Navigation.

// To get the tab value from URL and store in $ppc_active_tab variable.
$ppc_active_tab = 'ppc_general_settings';

if ( isset( $_GET['tab'] ) ) {  //PHPCS:ignore:WordPress.Security.NonceVerification.Recommended

	if ( 'ppc_general_settings' === $_GET['tab'] ) { //PHPCS:ignore:WordPress.Security.NonceVerification.Recommended

		$ppc_active_tab = 'ppc_general_settings';
	} elseif ( 'ppc-checklist' === $_GET['tab'] ) { //PHPCS:ignore:WordPress.Security.NonceVerification.Recommended

		$ppc_active_tab = 'ppc-checklist';
	} elseif ( 'ppc-user-manual' === $_GET['tab'] ) {//PHPCS:ignore:WordPress.Security.NonceVerification.Recommended

		$ppc_active_tab = 'ppc-user-manual';
	}
}

?>
<!-- WordPress provides the styling for tabs. -->

<!-- when tab buttons are clicked we jump back to the same page but with a new parameter that represents the clicked tab. accordingly we make it active -->
<h2 class="nav-tab-wrapper ppc-nav-tab-wrapper">
<a href="?page=bsf_ppc&tab=ppc_general_settings" class="nav-tab tb 
	<?php
	if ( 'ppc_general_settings' === $ppc_active_tab ) {
		echo 'nav-tab-active ppc-active-tab';
	}
	?>
	"><?php esc_attr_e( 'General Settings', 'bsf-pre-publish-checklist' ); ?></a>


		<a href="?page=bsf_ppc&tab=ppc-checklist" class="nav-tab tb 
	<?php
	if ( 'ppc-checklist' === $ppc_active_tab ) {
		echo 'nav-tab-active ppc-active-tab';
	}
	?>
		"><?php esc_attr_e( 'Checklist', 'bsf-pre-publish-checklist' ); ?></a>

		<a href="?page=bsf_ppc&tab=ppc-user-manual" class="nav-tab tb 
	<?php
	if ( 'ppc-user-manual' === $ppc_active_tab ) {
		echo 'nav-tab-active ppc-active-tab';
	}
	?>
		"><?php esc_attr_e( 'Getting Started', 'bsf-pre-publish-checklist' ); ?></a>
</h2>

<?php
// here we display the sections and options in the settings page based on the active tab.
if ( isset( $_GET['tab'] ) ) { //PHPCS:ignore:WordPress.Security.NonceVerification.Recommended

	if ( 'ppc_general_settings' === $_GET['tab'] ) { //PHPCS:ignore:WordPress.Security.NonceVerification.Recommended

		include_once 'ppc-frontend.php';
	} elseif ( 'ppc-checklist' === $_GET['tab'] ) { //PHPCS:ignore:WordPress.Security.NonceVerification.Recommended
		include_once 'ppc-checklist.php';
	} elseif ( 'ppc-user-manual' === $_GET['tab'] ) { //PHPCS:ignore:WordPress.Security.NonceVerification.Recommended
		include_once 'ppc-user-manual.php';
	}
} else {
	include_once 'ppc-frontend.php';
}

