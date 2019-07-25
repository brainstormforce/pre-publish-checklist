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
        add_action('wp_ajax_bsfppc_checklistitem_drag', array( $this,'bsfppc_drag_item') , 1 );
        add_action('wp_ajax_nopriv_bsfppc_checklistitem_drag',array( $this,'bsfppc_drag_item'), 1 );
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
		wp_register_style( 'bsfppc_backend_css', BSF_PPC_PLUGIN_URL . '/assets/css/bsfppc-css.css', null,'1.0', false );
		wp_localize_script( 'bsfppc_backend_checkbox_js', 'bsfppc_radio_obj', array( 'option' => $bsfppc_radio_button , 'data' => $bsfppc_checklist_item_data  ) );
	    wp_localize_script('bsfppc_backend_itemlist_js','bsfppc_add_delete_obj', ['url' => admin_url('admin-ajax.php'),]);
        
	}

	public function bsfppc_metabox_scripts(){
	    $screen = get_current_screen();
	    $bsfppc_post_types_to_display= get_option('bsfppc_post_types_to_display');
	    if (is_object($screen)) {	
	        if (in_array($screen->post_type, $bsfppc_post_types_to_display)) {
	            // wp_enqueue_script('bsfppc_backend_checkbox_js', BSF_PPC_PLUGIN_URL . '/assets/js/bsfppc-checkbox.js', ['jquery']);
	            wp_localize_script(
	                'bsfppc_backend_checkbox_js',
	                'bsfppc_meta_box_obj', ['url' => admin_url('admin-ajax.php'),]
	            );	
	        }
	    }
	}	
// Drag and drop
	public function bsfppc_drag_item() { 
			if( isset( $_POST['item_drag_var'] ) ){
				var_dump($_POST['item_drag_var']);
					$new_drag_items = array();
					$new_drag_items = $_POST['item_drag_var'];
					if(empty($item_drag_contents) || false === $item_drag_contents) {
						$item_drag_contents = array();
					}	
					foreach( $new_drag_items as $dragitems ) {
						array_push( $item_drag_contents , $dragitems  );
				}
				var_dump($new_drag_items);
					update_option( 'bsfppc_checklist_data', $item_drag_contents );
					echo"sucess";
			}
	            die();     
	    }    
// function for adding via ajax
	public function bsfppc_add_item() { 
		if( isset( $_POST['item_content'] ) ){
			 $newitems = array();
				$newitems = $_POST['item_content'];
				$item_contents= get_option( 'bsfppc_checklist_data' );
				if(empty($item_contents) || false === $item_contents) {
					$item_contents = array();

				}	
					foreach( $newitems as $items ) {
					array_push( $item_contents , $items  );
			}
				update_option( 'bsfppc_checklist_data', $item_contents );
				echo"sucess";
		}
            die(); 
    }     

// function for deleting via ajax
    public function bsfppc_delete_item() { 
	    if( isset( $_POST['delete'] ) ){
	     	var_dump( $_POST['delete'] );
						$bsfppc_checklist_item_data = get_option( 'bsfppc_checklist_data' );
					var_dump($bsfppc_checklist_item_data);
						 $key = array_search($_POST['delete'], $bsfppc_checklist_item_data );
						 var_dump($key);
						
							    unset($bsfppc_checklist_item_data[$key]);
						
						var_dump($bsfppc_checklist_item_data);
						update_option( 'bsfppc_checklist_data', $bsfppc_checklist_item_data );					
	        echo"sucess";
	    }
            die();    
    }             
}

		BSFPPC_Loader::get_instance();
endif;