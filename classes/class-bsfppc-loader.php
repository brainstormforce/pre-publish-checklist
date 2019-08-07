<?php
/**
 * BSF Pre Publish Check list.
 *
 * PHP version 7
 *
 * @category PHP
 * @package  Pre Publish Check-list.
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
			include_once BSF_PPC_ABSPATH . 'includes/class-bsfppc-pagesetups.php';
			add_action( 'admin_enqueue_scripts', array( $this, 'bsfppc_plugin_backend_js' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'bsfppc_metabox_scripts' ) );
			add_action( 'wp_ajax_bsfppc_checklistitem_add', array( $this, 'bsfppc_add_item' ), 1 );
			add_action( 'wp_ajax_nopriv_bsfppc_checklistitem_add', array( $this, 'bsfppc_add_item' ), 1 );
			add_action( 'wp_ajax_bsfppc_checklistitem_delete', array( $this, 'bsfppc_delete_item' ), 1 );
			add_action( 'wp_ajax_nopriv_bsfppc_checklistitem_delete', array( $this, 'bsfppc_delete_item' ), 1 );
			add_action( 'wp_ajax_bsfppc_checklistitem_drag', array( $this, 'bsfppc_drag_item' ), 1 );
			add_action( 'wp_ajax_nopriv_bsfppc_checklistitem_drag', array( $this, 'bsfppc_drag_item' ), 1 );
		}
		/**
		 * Plugin Styles for admin dashboard.
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function bsfppc_plugin_backend_js() {
			$bsfppc_radio_button        = get_option( 'bsfppc_radio_button_option_data' );
			$bsfppc_checklist_item_data = get_option( 'bsfppc_checklist_data' );
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'jQuery-ui-droppable' );
			wp_register_script( 'bsfppc_backend_checkbox_js', BSF_PPC_PLUGIN_URL . '/assets/js/bsfppc-checkbox.js', null, '1.0', false );
			wp_register_script( 'bsfppc_backend_itemlist_js', BSF_PPC_PLUGIN_URL . '/assets/js/bsfppc-itemlist.js', null, '1.0', false );
			wp_register_style( 'bsfppc_backend_css', BSF_PPC_PLUGIN_URL . '/assets/css/bsfppc-css.css', null, '1.0', false );
			wp_localize_script(
				'bsfppc_backend_checkbox_js',
				'bsfppc_radio_obj',
				array(
					'option' => $bsfppc_radio_button,
					'data'   => $bsfppc_checklist_item_data,
				)
			);
			wp_localize_script( 'bsfppc_backend_itemlist_js', 'bsfppc_add_delete_obj', array( 'url' => admin_url( 'admin-ajax.php' ) ) );

		}
		/**
		 * Localize script for ajax in the meta box
		 *
		 * @since 1.0.0
		 */
		public function bsfppc_metabox_scripts() {
			$screen                       = get_current_screen();
			$bsfppc_post_types_to_display = get_option( 'bsfppc_post_types_to_display' );
			if ( ! empty( $bsfppc_post_types_to_display ) ) {
				if ( is_object( $screen ) ) {
					if ( in_array( $screen->post_type, $bsfppc_post_types_to_display, true ) ) {
						wp_localize_script(
							'bsfppc_backend_checkbox_js',
							'bsfppc_meta_box_obj',
							array( 'url' => admin_url( 'admin-ajax.php' ) )
						);
					}
				}
			}
		}
		/**
		 * Save order of the list
		 *
		 * Saves the order of the drag and drop list and updates it in the post meta
		 *
		 * @since 1.0.0
		 */
		public function bsfppc_drag_item() {
			if ( ! empty( $_POST['item_drag_var'] ) ) {
				$bsfppc_new_drag_items = ( ! empty( $_POST['item_drag_var'] ) ? ( $_POST['item_drag_var'] ) : array() );
				$bsfppc_new_drag_items = array_map( 'sanitize_text_field', $bsfppc_new_drag_items );
				if ( empty( $bsfppc_item_drag_contents ) || false === $bsfppc_item_drag_contents ) {
					$bsfppc_item_drag_contents = array();
				}
				foreach ( $bsfppc_new_drag_items as $bsfppc_dragitems ) {
					array_push( $bsfppc_item_drag_contents, $bsfppc_dragitems );
				}
				update_option( 'bsfppc_checklist_data', $bsfppc_item_drag_contents );
				echo 'sucess';
			}
			die();
		}
		/**
		 * Function for adding checklist  via ajax.
		 *
		 * Saves the checkbox status as checked in the post meta
		 *
		 * @since 1.0.0
		 */
		public function bsfppc_add_item() {
			$bsfppc_checklist_item_data = array();
			$bsfppc_item_exists_key     = '';
			$bsfppc_checklist_item_data = get_option( 'bsfppc_checklist_data' );
			if ( ! empty( $_POST['item_content'] ) ) {
				$bsfppc_newitems = sanitize_text_field( $_POST['item_content'] );
				if ( ! empty( $bsfppc_checklist_item_data ) ) {
					$bsfppc_item_exists_key = array_search( $bsfppc_newitems, $bsfppc_checklist_item_data, true );
				}
				if ( empty( $bsfppc_item_exists_key ) && 0 !== $bsfppc_item_exists_key ) {

					$item_contents = get_option( 'bsfppc_checklist_data' );
					if ( empty( $item_contents ) || false === $item_contents ) {
						$bsfppc_checklist_item_data = array();
					}
					array_push( $bsfppc_checklist_item_data, $bsfppc_newitems );
					update_option( 'bsfppc_checklist_data', $bsfppc_checklist_item_data );
					$bsfppc_ispresent = 0;
				} else {
					$bsfppc_ispresent = 1;
				}
				?>
																																																																												<?php
																																																																												$bsfppc_checklist_item_data = get_option( 'bsfppc_checklist_data' );
																																																																												if ( ! empty( $bsfppc_checklist_item_data ) ) {
																																																																													if ( $bsfppc_ispresent == 1 ) {
																																																																														?>
						<p class="warning bsfppc-alreadyexists-waring-description">List item already exists</p>
																																																																														<?php
																																																																													}

																																																																													foreach ( $bsfppc_checklist_item_data as $key ) {
																																																																														?>
							<li class="bsfppc-li">
							<span class = "down"></span>
							<span class="dashicons dashicons-menu-alt3"></span> <input type="text" readonly="true" class="bsfppc-drag-feilds" value="<?php echo esc_attr( $key ); ?>" name="bsfppc_checklist_item[]" >
							<button type="button" id = "Delete" name="Delete" class="button button-primary bsfppcdelete" value="<?php echo esc_attr( $key ); ?>" formnovalidate >Delete</button>
																																																																														<?php
																																																																													}
																																																																												} else {
																																																																																																																																		 echo 'You have do not have any list please add items in the list';
																																																																												}
																																																																												?>
							</li>

											<?php

											die();
			}
		}

		/**
		 * Function for delete via ajax.
		 *
		 * Deletes the checklist item from the options table
		 *
		 * @since 1.0.0
		 */
		public function bsfppc_delete_item() {
			if ( isset( $_POST['delete'] ) ) {
				$bsfppc_checklist_item_data = get_option( 'bsfppc_checklist_data' );
				$bsfppc_delete_key          = array_search( $_POST['delete'], $bsfppc_checklist_item_data, true );
				unset( $bsfppc_checklist_item_data[ $bsfppc_delete_key ] );
				update_option( 'bsfppc_checklist_data', $bsfppc_checklist_item_data );
				echo 'sucess';
			}
			die();
		}
	}
	BSFPPC_Loader::get_instance();
endif;
