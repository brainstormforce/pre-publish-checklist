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


function bsf_ppc_add_custom_meta_box()
    {
        $screens = ['post', 'page'];
        foreach ($screens as $screen) {
            add_meta_box(
                'wporg_box_id',           // Unique ID
                'Pre-publish checklist',  // Box title
                'bsf_ppc_custom_box_html',  // Content callback, must be of type callable
                $screen,
                'side'                  // Post type
            );
        }
    }
add_action('add_meta_boxes', 'bsf_ppc_add_custom_meta_box');


function bsf_ppc_custom_box_html($post)
    {
        $bsf_ppc_checklist_item_data = get_option('bsf_ppc_checklist_data');
            if(!empty($bsf_ppc_checklist_item_data)){
                    foreach( $bsf_ppc_checklist_item_data as $key) {
                    echo '<input type="checkbox" value="'.$key.'" >';
                    echo $key;
                    echo "<br/>";
                }
            }
        else{
            echo "create a list to display here";
        }
    }
/**
 * Main Frontpage.
 *
 * @since  1.0.0
 * @return void
 */
function bsf_ppc_page_html() {
	require_once BSF_PPC_ABSPATH . 'includes/bsfppc-frontend.php';
}
