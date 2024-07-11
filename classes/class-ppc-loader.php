<?php
/**
 * Pre-Publish Checklist.
 *
 * PHP version 7
 *
 * @category PHP
 * @package  Pre-Publish Checklist.
 * @author   Pratik Chaskar
 * @license  https://pratikchaskar.com/
 * @link     https://pratikchaskar.com/
 */

if ( ! class_exists( 'PPC_Loader' ) ) :
	/**
	 * Pre-Publish Checklist doc comment.
	 *
	 * PHP version 7
	 *
	 * @category PHP
	 * @package  Pre-Publish Checklist.
	 * @author   Pratik Chaskar
	 * @license  https://pratikchaskar.com/
	 * @link     https://pratikchaskar.com/
	 */
	class PPC_Loader {

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
			// Activation hook.
			register_activation_hook( PPC_PATH, array( $this, 'ppc_default_list_data_install' ) );
			$this->ppc_load();
			$this->ppc_update();
			add_action( 'admin_enqueue_scripts', array( $this, 'ppc_plugin_backend_js' ) );
			add_action( 'init', array( $this, 'ppc_save_data' ) );
			add_action( 'wp_ajax_ppc_checklistitem_add', array( $this, 'ppc_add_item' ), 1 );
			add_action( 'wp_ajax_ppc_checklistitem_delete', array( $this, 'ppc_delete_item' ), 1 );
			add_action( 'wp_ajax_ppc_checklistitem_drag', array( $this, 'ppc_drag_item' ), 1 );
			add_action( 'wp_ajax_ppc_checklistitem_edit', array( $this, 'ppc_edit_item' ), 1 );
		}

		/**
		 * Check for default list if present with a default parameter.
		 *
		 * @param string $post_type Post type.
		 */
		public function get_list_by_post_type( $post_type = '' ) {
			$ppc_cpt_checklist       = self::get_instance()->get_list();
			$ppc_checklist_item_data = array();
			if ( ! empty( $ppc_cpt_checklist ) && ! empty( $post_type ) && isset( $ppc_cpt_checklist[ $post_type ] ) ) {
				$ppc_checklist_item_data = $ppc_cpt_checklist[ $post_type ];
			}
			return $ppc_checklist_item_data;
		}

		/**
		 * Stores default checklist in the database.
		 */
		public function get_list() {
			return get_option( 'ppc_cpt_checklist_data', array() );
		}

		/**
		 * Stores default list in the database.
		 *
		 * @since 1.0
		 * @return void
		 */
		public function ppc_default_list_data_install() {
			if ( ! get_option( 'ppc_post_types_to_display', false ) ) {
				$default_post_types = array( 'post', 'page' );
				add_option( 'ppc_post_types_to_display', $default_post_types );
			}
		}

		/**
		 * Loads classes and includes.
		 *
		 * @since 1.0
		 * @return void
		 */
		public function ppc_load() {
			require_once PPC_ABSPATH . 'classes/class-ppc-pagesetups.php';
		}

		/**
		 * Loads classes and includes.
		 *
		 * @since 1.1.0
		 * @return void
		 */
		public function ppc_update() {
			require_once PPC_ABSPATH . 'classes/class-ppc-update.php';
		}
		/**
		 * Plugin Styles for admin dashboard.
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function ppc_plugin_backend_js() {
			$ppc_radio_button        = get_option( 'ppc_error_level', 3 );
			$ppc_checklist_item_data = $this->get_list();

			wp_register_script( 'ppc_backend_checkbox_js', PPC_PLUGIN_URL . '/assets/js/ppc-checkbox.js', null, PPC_VERSION, false );
			wp_register_script( 'ppc_backend_itemlist_js', PPC_PLUGIN_URL . '/assets/js/ppc-itemlist.js', null, PPC_VERSION, false );
			wp_register_style( 'ppc_backend_css', PPC_PLUGIN_URL . '/assets/css/ppc-css.css', null, PPC_VERSION, false );
			if ( false !== $ppc_radio_button && false !== $ppc_checklist_item_data ) {
				wp_localize_script(
					'ppc_backend_checkbox_js',
					'ppc_error_level',
					array(
						'option'   => $ppc_radio_button,
						'data'     => $ppc_checklist_item_data,
						'security' => wp_create_nonce( 'ppc-security-nonce' ),
					)
				);
			}
			wp_localize_script(
				'ppc_backend_itemlist_js',
				'ppc_add_delete_obj',
				array(
					'url'      => admin_url( 'admin-ajax.php' ),
					'security' => wp_create_nonce( 'ppc-security-nonce' ),
				)
			);

			// Localize scripts for meta box.
			$ppc_screen                = get_current_screen();
			$ppc_post_types_to_display = get_option( 'ppc_post_types_to_display' );
			if ( ! empty( $ppc_post_types_to_display ) ) {
				if ( is_object( $ppc_screen ) ) {
					if ( in_array( $ppc_screen->post_type, $ppc_post_types_to_display, true ) ) {
						wp_localize_script(
							'ppc_backend_checkbox_js',
							'ppc_meta_box_obj',
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
		public function ppc_drag_item() {
			check_ajax_referer( 'ppc-security-nonce', 'ppc_security' );
			if ( ! empty( $_POST['ppc_order'] ) && current_user_can( 'manage_options' ) ) {
					$ppc_current_type                             = isset( $_POST['ppc_current_type'] ) ? sanitize_text_field( wp_unslash( $_POST['ppc_current_type'] ) ) : '';
					$ppc_item_drag_contents                       = array_map( 'sanitize_text_field', wp_unslash( $_POST['ppc_order'] ) );
					$ppc_checklist_item_data                      = $this->get_list();
					$ppc_checklist_item_data[ $ppc_current_type ] = $ppc_item_drag_contents;
				update_option( 'ppc_cpt_checklist_data', $ppc_checklist_item_data );
				wp_send_json_success( __( 'sucess', 'pre-publish-checklist' ) );
			} else {
				wp_send_json_error( __( 'Sorry, you are not allowed to perform this action', 'pre-publish-checklist' ) );
			}
		}

		/**
		 * Function for adding checklist  via ajax.
		 *
		 * Saves the checklist item in the database.
		 *
		 * @since 1.0.0
		 */
		public function ppc_add_item() {
			check_ajax_referer( 'ppc-security-nonce', 'ppc_security' );
			if ( ! empty( $_POST['ppc_item_content'] ) && current_user_can( 'manage_options' ) ) {
				$ppc_newitems            = sanitize_text_field( wp_unslash( $_POST['ppc_item_content'] ) );
				$ppc_current_type        = isset( $_POST['ppc_current_type'] ) ? sanitize_text_field( wp_unslash( $_POST['ppc_current_type'] ) ) : '';
				$ppc_newitem_key         = uniqid( 'ppc_key' );
				$ppc_checklist_item_data = $this->get_list();
				if ( empty( $ppc_checklist_item_data ) || false === $ppc_checklist_item_data ) {
					$ppc_checklist_item_data = array();
				}

				$ppc_checklist_item_data[ $ppc_current_type ][ $ppc_newitem_key ] = $ppc_newitems;

				update_option( 'ppc_cpt_checklist_data', $ppc_checklist_item_data );
				?>
				<?php
				if ( ! empty( $ppc_checklist_item_data ) ) {
					foreach ( $ppc_checklist_item_data[ $ppc_current_type ] as $ppc_key => $ppc_value ) {
						?>
								<li class="ppc-li">
								<span class="dashicons dashicons-menu-alt2 ppc-move-dashicon"></span> <input type="text" readonly="true" class="ppc-drag-feilds" $ppc_item_key ="<?php echo esc_attr( $ppc_key ); ?>" value="<?php echo esc_attr( $ppc_value ); ?>" name="ppc_checklist_item[]" >
								<button type="button" id = "edit" name="Edit" class="ppcedit" value="<?php echo esc_attr( $ppc_key ); ?>"> <span class="dashicons dashicons-edit"></span>Edit</button>
										<button type="button" id = "Delete" name="Delete" class="ppcdelete" value="<?php echo esc_attr( $ppc_key ); ?>"> <span class="dashicons dashicons-trash ppc-delete-dashicon"></span>Delete</button>
								<?php
					}
				} else {
					esc_html_e( 'No items in the checklist', 'pre-publish-checklist' );
				}
				?>
							</li>
							<?php
							wp_die();
			} else {
				wp_send_json_error( __( 'Sorry, you are not allowed to perform this action', 'pre-publish-checklist' ) );
			}
		}

		/**
		 * Function for delete via ajax.
		 *
		 * Deletes the checklist item from the options table as well as post meta.
		 *
		 * @since 1.0.0
		 */
		public function ppc_delete_item() {
			check_ajax_referer( 'ppc-security-nonce', 'ppc_security' );
			if ( isset( $_POST['delete'] ) && current_user_can( 'manage_options' ) ) {
				$ppc_post_types_to_display = get_option( 'ppc_post_types_to_display' );
				$ppc_checklist_item_data   = $this->get_list();
				$ppc_delete_value          = sanitize_text_field( wp_unslash( $_POST['delete'] ) );
				$ppc_current_type          = isset( $_POST['ppc_current_type'] ) ? sanitize_text_field( wp_unslash( $_POST['ppc_current_type'] ) ) : '';

				if ( false !== $ppc_checklist_item_data ) {
					unset( $ppc_checklist_item_data[ $ppc_current_type ][ $ppc_delete_value ] );
					update_option( 'ppc_cpt_checklist_data', $ppc_checklist_item_data );
				}
				wp_send_json_success( __( 'sucess', 'pre-publish-checklist' ) );
			} else {
				wp_send_json_error( __( 'Sorry, you are not allowed to perform this action', 'pre-publish-checklist' ) );
			}
		}

		/**
		 * Function for editing checklist  via ajax.
		 *
		 * Edits the checklist item in the database as well as post meta.
		 *
		 * @since 1.0.0
		 */
		public function ppc_edit_item() {
			check_ajax_referer( 'ppc-security-nonce', 'ppc_security' );
			if ( isset( $_POST['ppc_edit_value'] ) && isset( $_POST['ppc_edit_key'] ) && current_user_can( 'manage_options' ) ) {
				$ppc_post_types_to_display = get_option( 'ppc_post_types_to_display' );
				$ppc_checklist_item_data   = $this->get_list();
				$ppc_current_type          = isset( $_POST['ppc_current_type'] ) ? sanitize_text_field( wp_unslash( $_POST['ppc_current_type'] ) ) : '';

				if ( ! empty( $ppc_checklist_item_data ) ) {
					$ppc_edit_value = sanitize_text_field( wp_unslash( $_POST['ppc_edit_value'] ) );
					$ppc_edit_key   = sanitize_text_field( wp_unslash( $_POST['ppc_edit_key'] ) );
					$ppc_checklist_item_data[ $ppc_current_type ][ $ppc_edit_key ] = $ppc_edit_value;
					update_option( 'ppc_cpt_checklist_data', $ppc_checklist_item_data );
				}
				wp_send_json_success( __( 'sucess', 'pre-publish-checklist' ) );
			} else {
				wp_send_json_error( __( 'Sorry, you are not allowed to perform this action', 'pre-publish-checklist' ) );
			}
		}

		/**
		 * Function for saving the Form data.
		 *
		 * Saves value from general settings page to the database.
		 *
		 * @since 1.0.0
		 */
		public function ppc_save_data() {
			$page = ! empty( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : null;
			if ( 'ppc' !== $page ) {
				return;
			}

			if ( ! empty( $_POST['ppc-form'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ppc-form'] ) ), 'ppc-form-nonce' ) && current_user_can( 'manage_options' ) ) {
				if ( isset( $_POST['submit_radio'] ) ) {

					// saves the radio button option.
					if ( ! empty( $_POST['ppc_radio_button_option'] ) ) {
						$ppc_radio = sanitize_text_field( wp_unslash( $_POST['ppc_radio_button_option'] ) );
						update_option( 'ppc_error_level', $ppc_radio );
					}
					// saves the posts types to have our meta box on.
					$ppc_post_types = array();
					if ( ! empty( $_POST['posts'] ) ) {
						$ppc_post_types = array_map( 'sanitize_text_field', wp_unslash( $_POST['posts'] ) );
					}
					update_option( 'ppc_post_types_to_display', $ppc_post_types );
				}
			}
		}
	}
	PPC_Loader::get_instance();
endif;


