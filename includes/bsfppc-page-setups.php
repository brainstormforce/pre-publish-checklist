<?php
/**
 * The Pre Publish Checklist Sub-menu Display.
 *
 * @since      1.0.0
 * @package    BSF
 * @author     Brainstorm Force.
 */

/**
 * 
 *
 * @since  1.0.0
 * @return void
 */
$bsfppc_radio_button_data = get_option( 'bsfppc_radio_button_option_data' );

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

function bsfppc_add_custom_meta_box()
    {
        $screens = ['post', 'page'];
        foreach ($screens as $screen) {
            add_meta_box(
                'bsfppc_custom_meta_box',           // Unique ID
                'Pre-Publish Checklist',  // Box title
                'bsfppc_custom_box_html',  // Content callback, must be of type callable
                $screen,
                'side'                  // Post type
            );
        }
    }
add_action('add_meta_boxes', 'bsfppc_add_custom_meta_box');

function bsfppc_custom_box_html($post) {
        wp_enqueue_script('bsfppc_backend_js');
        wp_enqueue_style('bsfppc_backend_css');

        $bsfppc_checklist_item_data = get_option('bsfppc_checklist_data');
            if(!empty($bsfppc_checklist_item_data)){
                    foreach( $bsfppc_checklist_item_data as $key) {
                    echo '<input type="checkbox" id="checkbox" value="'.$key.'" >';
                    echo $key;
                    echo "<br/>";                     
                }   
                ?>
                <div class="popup-overlay">
                    <!--Creates the popup content-->
                    <div class="popup-content">
                        <p> Please check all the checkboxes or you can publish anyway </p>
                        <!--popup's close button-->
                        <button id="close" class="components-button is-button is-default">Publish anyway !</button>    
                    </div>
                </div><?
            }
        else{
            echo "Please create a list to display here";
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
