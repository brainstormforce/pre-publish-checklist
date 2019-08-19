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
			add_action( 'init', array( $this, 'bsfppc_save_data' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'bsfppc_metabox_scripts' ) );
			add_action( 'wp_ajax_bsfppc_checklistitem_add', array( $this, 'bsfppc_add_item' ), 1 );
			add_action( 'wp_ajax_nopriv_bsfppc_checklistitem_add', array( $this, 'bsfppc_add_item' ), 1 );
			add_action( 'wp_ajax_bsfppc_checklistitem_delete', array( $this, 'bsfppc_delete_item' ), 1 );
			add_action( 'wp_ajax_nopriv_bsfppc_checklistitem_delete', array( $this, 'bsfppc_delete_item' ), 1 );
			add_action( 'wp_ajax_bsfppc_checklistitem_drag', array( $this, 'bsfppc_drag_item' ), 1 );
			add_action( 'wp_ajax_nopriv_bsfppc_checklistitem_drag', array( $this, 'bsfppc_drag_item' ), 1 );
			add_action( 'wp_ajax_bsfppc_checklistitem_edit', array( $this, 'bsfppc_edit_item' ), 1 );
			add_action( 'wp_ajax_nopriv_bsfppc_checklistitem_edit', array( $this, 'bsfppc_edit_item' ), 1 );
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
			$bsfppc_screen                = get_current_screen();
			$bsfppc_post_types_to_display = get_option( 'bsfppc_post_types_to_display' );
			if ( ! empty( $bsfppc_post_types_to_display ) ) {
				if ( is_object( $bsfppc_screen ) ) {
					if ( in_array( $bsfppc_screen->post_type, $bsfppc_post_types_to_display, true ) ) {
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
		 * Saves the order of the drag and drop list and updates it in the database
		 *
		 * @since 1.0.0
		 */
		public function bsfppc_drag_item() {
			if ( ! empty( $_POST['bsfppc_item_drag_var'] ) ) {//PHPCS:ignore:WordPress.Security.NonceVerification.Missing
				var_dump($_POST['bsfppc_item_drag_var']);
				$bsfppc_new_drag_items = ( ! empty( $_POST['bsfppc_item_drag_var'] ) ? ( $_POST['bsfppc_item_drag_var'] ) : array() );//PHPCS:ignore:WordPress.Security.NonceVerification.Missing
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
		 * Saves the checklist item in the database.
		 *
		 * @since 1.0.0
		 */
		public function bsfppc_add_item() {
			$bsfppc_checklist_item_data = array();
			$bsfppc_item_exists_key     = '';
			$bsfppc_checklist_item_data = get_option( 'bsfppc_checklist_data' );
			if ( ! empty( $_POST['bsfppc_item_content'] ) ) {//PHPCS:ignore:WordPress.Security.NonceVerification.Missing
				$bsfppc_newitems = sanitize_text_field( $_POST['bsfppc_item_content'] );//PHPCS:ignore:WordPress.Security.NonceVerification.Missing
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
					if ( 1 === $bsfppc_ispresent ) {
						?>
							<p class="warning bsfppc-alreadyexists-waring-description">List item already exists</p>
							<?php
					}
					foreach ( $bsfppc_checklist_item_data as $bsfppc_checklist_item_data_key ) {
						?>
								<li class="bsfppc-li">
								<!-- <span class = "down"></span> -->
								<span class="dashicons dashicons-menu-alt2"></span> <input type="text" readonly="true" class="bsfppc-drag-feilds" value="<?php echo esc_attr( $bsfppc_checklist_item_data_key ); ?>" name="bsfppc_checklist_item[]" >
								<button type="button" id = "Delete" name="Delete" class="button button-primary bsfppcdelete" value="<?php echo esc_attr( $bsfppc_checklist_item_data_key ); ?>">Delete</button>
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
		 * Deletes the checklist item from the options table as well as post meta.
		 *
		 * @since 1.0.0
		 */
		public function bsfppc_delete_item() {
			if ( isset( $_POST['delete'] ) ) {//PHPCS:ignore:WordPress.Security.NonceVerification.Missing
				global $wpdb;
				$bsfppc_checklist_item_data = get_option( 'bsfppc_checklist_data' );
				$bsfppc_delete_value        = $_POST['delete'];//PHPCS:ignore:WordPress.Security.NonceVerification.Missing
				$bsfppc_delete_key          = array_search( $_POST['delete'], $bsfppc_checklist_item_data, true );//PHPCS:ignore:WordPress.Security.NonceVerification.Missing
				unset( $bsfppc_checklist_item_data[ $bsfppc_delete_key ] );
				update_option( 'bsfppc_checklist_data', $bsfppc_checklist_item_data );
				echo 'sucess';
				$bsfppc_all_post_ids = get_posts(
					array(
						'posts_per_page' => -1,
						'post_status'    => array( 'publish', 'pending', 'draft' ),
						'fields'         => 'ids',
					)
				);
				if ( ! empty( $bsfppc_all_post_ids ) ) {
					foreach ( $bsfppc_all_post_ids as $bsfppc_postid ) {
						$bsfppc_pre_value       = get_post_meta( $bsfppc_postid, '_bsfppc_meta_key', true );
						$bsfppc_post_delete_key = array_search( $bsfppc_delete_value, $bsfppc_pre_value, true );
						if ( false !== $bsfppc_post_delete_key ) {
							unset( $bsfppc_pre_value[ $bsfppc_post_delete_key ] );//PHPCS:ignore:WordPress.Security.NonceVerification.Missing
							update_post_meta(
								$bsfppc_postid,
								'_bsfppc_meta_key',
								$bsfppc_pre_value
							);
						}
					}
				}
				echo 'sucess';
			}
			die();
		}

		public function bsfppc_edit_item() {
			if ( isset( $_POST['bsfppc_edit_value'] ) && isset($_POST['bsfppc_prev_value']) ) {//PHPCS:ignore:WordPress.Security.NonceVerification.Missing
				global $wpdb;
				$bsfppc_checklist_item_data = get_option( 'bsfppc_checklist_data' );
				$bsfppc_prev_value		= $_POST['bsfppc_prev_value'];
				$bsfppc_edit_value        = $_POST['bsfppc_edit_value'];//PHPCS:ignore:WordPress.Security.NonceVerification.Missing
				$bsfppc_edit_key          = array_search( $_POST['bsfppc_prev_value'], $bsfppc_checklist_item_data, true );//PHPCS:ignore:WordPress.Security.NonceVerification.Missing
				$bsfppc_checklist_item_data[$bsfppc_edit_key] = $bsfppc_edit_value ;
				update_option( 'bsfppc_checklist_data', $bsfppc_checklist_item_data );
				echo 'sucess';
				$bsfppc_all_post_ids = get_posts(
					array(
						'posts_per_page' => -1,
						'post_status'    => array( 'publish', 'pending', 'draft' ),
						'fields'         => 'ids',
					)
				);
				if ( ! empty( $bsfppc_all_post_ids ) ) {
					foreach ( $bsfppc_all_post_ids as $bsfppc_postid ) {
						$bsfppc_prev_value		= $_POST['bsfppc_prev_value'];
						$bsfppc_edit_value        = $_POST['bsfppc_edit_value'];//PHPCS:ignore:WordPress.Security.NonceVerification.Missing
						$bsfppc_pre_checklist_values       = get_post_meta( $bsfppc_postid, '_bsfppc_meta_key', true );
						$bsfppc_post_edit_key          = array_search( $_POST['bsfppc_prev_value'], $bsfppc_pre_checklist_values, true );
						if ( false !== $bsfppc_post_edit_key ) {
							 $bsfppc_pre_checklist_values[$bsfppc_post_edit_key] = $bsfppc_edit_value ;//PHPCS:ignore:WordPress.Security.NonceVerification.Missing
							update_post_meta(
								$bsfppc_postid,
								'_bsfppc_meta_key',
								$bsfppc_pre_checklist_values
							);
						}
					}
				}
				echo 'sucess';
			}
			die();
			
		}

		/**
		 * Function for saving the Form data.
		 *
		 * Adds value from general settings page to the database.
		 *
		 * @since 1.0.0
		 */
		public function bsfppc_save_data() {
			$page = ! empty( $_GET['page'] ) ? sanitize_text_field( $_GET['page'] ) : null;
			if ( 'bsf_ppc' !== $page ) {
				return;
			}

			if ( ! empty( $_POST['bsfppc-form'] ) && wp_verify_nonce( sanitize_text_field( $_POST['bsfppc-form'] ), 'bsfppc-form-nonce' ) ) {

				if ( isset( $_POST['submit_radio'] ) ) {
					$_POST['submit_radio'] = sanitize_text_field( $_POST['submit_radio'] );
					if ( ! empty( $_POST['bsfppc_radio_button_option'] ) ) {
						$bsfppc_radio = sanitize_text_field( $_POST['bsfppc_radio_button_option'] );
						update_option( 'bsfppc_radio_button_option_data', $bsfppc_radio );
					}
					$bsfppc_radio_button_data = get_option( 'bsfppc_radio_button_option_data' );
				}

				if ( isset( $_POST['submit_radio'] ) ) {
					$_POST['submit_radio'] = sanitize_text_field( $_POST['submit_radio'] );
					$bsfppc_post_types     = array();
					if ( ! empty( $_POST['posts'] ) ) {
						$bsfppc_post_types = $_POST['posts'];
					}
					update_option( 'bsfppc_post_types_to_display', $bsfppc_post_types );
					$bsfppc_post_types_to_display = get_option( 'bsfppc_post_types_to_display' );
				}
			}

		}
	}
	BSFPPC_Loader::get_instance();
endif;


