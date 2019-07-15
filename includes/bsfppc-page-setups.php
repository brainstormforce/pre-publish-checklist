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
/**
 * Main Frontpage.
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
                'side',
                'high'
            );
        }
    }
add_action('add_meta_boxes', 'bsfppc_add_custom_meta_box');

function bsfppc_custom_box_html($post) { 

        wp_enqueue_script( 'bsfppc_backend_checkbox_js' );
        wp_enqueue_style( 'bsfppc_backend_css' );
        global $post;        
        $bsfppc_checklist_item_data = get_option( 'bsfppc_checklist_data' );
            if( !empty( $bsfppc_checklist_item_data ) ) {
                  $value = get_post_meta($post->ID, '_bsfppc_meta_key', true);

                    foreach( $bsfppc_checklist_item_data as $key) { ?>
                    <input type="checkbox" name="checkbox[]" id="checkbox" value= "<?php echo $key; ?>" <?php
                    foreach( $value as $keyy) {
                    checked($keyy, $key);
                } ?> >
                    <?php
                    echo $key;
                    echo "<br/>";                     
                }   
        
              ?>
                <div class="thickbox">
                    <div class="popup-overlay">
                        Creates the popup content
                        <div class="popup-content">
                            <p> Please check all the checkboxes before publishing or you can publish anyway </p>
                            <button id="close" class="components-button is-button is-default">Publish anyway !</button>    
                        </div>
                    </div>
                </div><?php
             }
         else{
            echo "Please create a list to display here from Settings->Pre-Publish-Checklist";
         }
    }


function bsfppc_save_postdata($post_id)
{  
   
        if (array_key_exists('checkbox', $_POST)) {

            update_post_meta(
                $post_id,
                '_bsfppc_meta_key',
                $_POST['checkbox']
            );
        }    
}
add_action('save_post', 'bsfppc_save_postdata');




function bsf_ppc_page_html() {
    require_once BSF_PPC_ABSPATH.'includes/bsfppc-frontend.php';
}


