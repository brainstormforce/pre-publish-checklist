<?php
/**
 * Settings page of Pre-Publish Checklist
 *
 * @since   1.0.0
 * @package Pre-Publish Checklist.
 * @author  Brainstorm Force.
 */

echo '<h1 class="ppc_main_title">';
esc_attr_e( 'Pre-Publish Checklist', 'pre-publish-checklist' );
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
<a href="?page=ppc&tab=ppc_general_settings" class="nav-tab tb 
	<?php
	if ( 'ppc_general_settings' === $ppc_active_tab ) {
		echo 'nav-tab-active ppc-active-tab';
	}
	?>
	">
	<?php esc_attr_e( 'General Settings', 'pre-publish-checklist' ); ?></a>
		<?php
		$ppc_post_types       = get_option( 'ppc_post_types_to_display' );
		$ppc_type             = isset( $ppc_post_types[0] ) ? $ppc_post_types[0] : '';
		$ppc_active_checkpost = ! empty( $ppc_post_types ) ? $ppc_type : 'post';
		?>
		<a href="?page=ppc&tab=ppc-checklist&type=<?php echo esc_attr( $ppc_active_checkpost ); ?>" class="nav-tab tb 
	<?php
	if ( 'ppc-checklist' === $ppc_active_tab ) {
		echo 'nav-tab-active ppc-active-tab';
	}
	?>
		"><?php esc_attr_e( 'Checklist', 'pre-publish-checklist' ); ?></a>

		<a href="?page=ppc&tab=ppc-user-manual" class="nav-tab tb 
	<?php
	if ( 'ppc-user-manual' === $ppc_active_tab ) {
		echo 'nav-tab-active ppc-active-tab';
	}
	?>
		"><?php esc_attr_e( 'Getting Started', 'pre-publish-checklist' ); ?></a>
</h2>

<?php
// here we display the sections and options in the settings page based on the active tab.
if ( isset( $_GET['tab'] ) ) { //PHPCS:ignore:WordPress.Security.NonceVerification.Recommended

	if ( 'ppc_general_settings' === $_GET['tab'] ) { //PHPCS:ignore:WordPress.Security.NonceVerification.Recommended

		require_once 'ppc-frontend.php';
	} elseif ( 'ppc-checklist' === $_GET['tab'] ) { //PHPCS:ignore:WordPress.Security.NonceVerification.Recommended
		require_once 'ppc-checklist.php';
	} elseif ( 'ppc-user-manual' === $_GET['tab'] ) { //PHPCS:ignore:WordPress.Security.NonceVerification.Recommended
		require_once 'ppc-user-manual.php';
	}
} else {
	require_once 'ppc-frontend.php';
}
