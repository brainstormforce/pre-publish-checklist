<?php
/**
 * The Pre Publish Checklist Sub-menu Display.
 *
 * @since      1.0.0
 * @package    BSF
 * @author     Brainstorm Force.
 */

/**
 * Add submenu of Global settings Page to admin menu.
 *
 * @since  1.0.0
 * @return void
 */
function bsf_ppc_settings_page() {
	add_submenu_page(
		'options-general.php',
		'Pre-publish Checklist',
		'Pre-publish Checklist',
		'manage_options',
		'bsf_ppc',
		'bsf_ppc_page_html'
	);
}
add_action( 'admin_menu', 'bsf_ppc_settings_page' );

/**
 * Main Frontpage.
 *
 * @since  1.0.0
 * @return void
 */
function bsf_ppc_page_html() {
	require_once BSF_PPC_ABSPATH . 'includes/bsfppc-frontend.php';
}
