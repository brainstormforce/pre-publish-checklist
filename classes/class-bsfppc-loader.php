<?php
/**
 * BSF Pre Publish Check list.
 *
 * PHP version 7
 *
 * @category PHP
 * @package  Pre Publish Check list.
 * @author   Display Name <username@ShubhamW.com>
 * @license  http://brainstormforce.com
 * @link     http://brainstormforce.com
 */

if ( ! class_exists( 'BSFPPC_Loader' ) ) :
	/**
	 * Pre Publish Check list doc comment.
	 *
	 * PHP version 7
	 *
	 * @category PHP
	 * @package  Pre Publish Check list
	 * @author   Display Name <username@ShubhamW.com>
	 * @license  http://brainstormforce.com
	 * @link     http://brainstormforce.com
	 */
class BSFPPC_Loader {
	/**
	 * Member Variable
	 *
	 * @var instance
	 */
	private static $instance;
	
	
	/**
	 *  Initiator
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	/**
	 * Constructor
	 */
	public function __construct() {
	
		require_once BSF_PPC_ABSPATH . 'includes/bsfppc-page-setups.php';
		add_action( 'admin_enqueue_scripts', array( $this, 'bsfppc_plugin_backend_js' ) );	
		add_action('admin_enqueue_scripts',array( $this, 'bsfppc_metabox_scripts' ) );
		add_action('wp_ajax_bsfppc_checklistitem_add', array( $this,'bsfppc_add_item') , 1 );
        add_action('wp_ajax_nopriv_bsfppc_checklistitem_add',array( $this,'bsfppc_add_item'), 1 );
        add_action('wp_ajax_bsfppc_checklistitem_delete', array( $this,'bsfppc_delete_item') , 1 );
        add_action('wp_ajax_nopriv_bsfppc_checklistitem_delete',array( $this,'bsfppc_delete_item'), 1 );
	}
	/**
	 * Plugin Styles for admin dashboard.
	 *
	 * @since  1.0.0
	 * @return void
	 */

	public function bsfppc_plugin_backend_js() {
		$bsfppc_radio_button = get_option('bsfppc_radio_button_option_data');
		$bsfppc_checklist_item_data = get_option('bsfppc_checklist_data');
		wp_register_script( 'bsfppc_backend_checkbox_js', BSF_PPC_PLUGIN_URL . '/assets/js/bsfppc-checkbox.js', null,'1.0', false );
		wp_register_script( 'bsfppc_backend_itemlist_js', BSF_PPC_PLUGIN_URL . '/assets/js/bsfppc-itemlist.js', null,'1.0', false );
		wp_register_script( 'bsfppc_backend_tooltip_js', BSF_PPC_PLUGIN_URL . '/assets/js/bsfppc-hover-tooltip.js', null,'1.0', false );
		wp_register_script( 'bsfppc_backend_settings_page_js', BSF_PPC_PLUGIN_URL . '/assets/js/bsfppc-hover-tooltip.js', null,'1.0', false );
		wp_register_style( 'bsfppc_backend_css', BSF_PPC_PLUGIN_URL . '/assets/css/bsfppc-css.css', null,'1.0', false );
		wp_localize_script( 'bsfppc_backend_checkbox_js', 'bsfppc_radio_obj', array( 'option' => $bsfppc_radio_button , 'data' => $bsfppc_checklist_item_data  ) );
		
	    wp_localize_script('bsfppc_backend_itemlist_js','bsfppc_add_delete_obj', ['url' => admin_url('admin-ajax.php'),]);
        
	}

	public function bsfppc_metabox_scripts(){
	    $screen = get_current_screen();
	    if (is_object($screen)) {
	        if (in_array($screen->post_type, ['post', 'page'])) {
	            wp_enqueue_script('bsfppc_backend_checkbox_js', BSF_PPC_PLUGIN_URL . '/assets/js/bsfppc-checkbox.js', ['jquery']);
	            wp_localize_script(
	                'bsfppc_backend_checkbox_js',
	                'bsfppc_meta_box_obj', ['url' => admin_url('admin-ajax.php'),]
	            );
	        }
	    }
	}
	



// function for adding via ajax
	public function bsfppc_add_item() { 
		if( isset( $_POST['item_content'] ) ){
			// var_dump($_POST['item_content']);
				$newitems = $_POST['item_content'];
				
				$item_contents= get_option('bsfppc_checklist_data');
				if(false === $item_contents) {
					$item_contents = array();

				}
				
				foreach( $newitems as $items ) {
					array_push( $item_contents , $items  );
			}

				update_option( 'bsfppc_checklist_data', $item_contents );
				// $bsfppc_checklist_item_data = get_option( 'bsfppc_checklist_data' );
				echo"sucess";
		}
            die();
        
    }             

// function for deleting via ajax
    public function bsfppc_delete_item() { 
	    if( isset( $_POST['delete'] ) ){
	     	var_dump($_POST['delete']);
						$bsfppc_checklist_item_data = get_option( 'bsfppc_checklist_data' );
						if (($key = array_search($_POST['delete'], $bsfppc_checklist_item_data)) !== false) {
							    unset($bsfppc_checklist_item_data[$key]);
						}
						update_option( 'bsfppc_checklist_data', $bsfppc_checklist_item_data );
					
	        echo"sucess";
	    }
            die();    
    }             
	
}

		BSFPPC_Loader::get_instance();
endif;