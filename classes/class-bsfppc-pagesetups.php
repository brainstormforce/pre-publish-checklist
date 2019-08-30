<?php
/**
 * BSF Pre Publish Checklist page setups comment
 *
 * PHP version 7
 *
 * @category PHP
 * @package  Pre Publish Check-list.
 * @author   Display Name <username@ShubhamW.com>
 * @license  http://brainstormforce.com
 * @link     http://brainstormforce.com
 */

/*
 * Main Frontpage.
 *
 * @since  1.0.0
 * @return void
 */

if ( ! class_exists( 'BSFPPC_Pagesetups' ) ) :
	/**
	 * Pre Publish Checklist Loader Doc comment
	 *
	 * PHP version 7
	 *
	 * @category PHP
	 * @package  Pre Publish Check-list
	 * @author   Display Name <username@ShubhamW.com>
	 * @license  http://brainstormforce.com
	 * @link     http://brainstormforce.com
	 */
	class BSFPPC_Pagesetups {

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
			add_action( 'add_meta_boxes', array( $this, 'bsfppc_add_custom_meta_box' ) );
			add_action( 'admin_menu', array( $this, 'bsf_ppc_settings_page' ) );
			add_action( 'wp_ajax_bsfppc_ajax_add_change', array( $this, 'bsfppc_meta_box_ajax_add_handler' ), 1 );
			add_action( 'wp_ajax_nopriv_bsfppc_ajax_add_change', array( $this, 'bsfppc_meta_box_ajax_add_handler' ), 1 );
			add_action( 'wp_ajax_bsfppc_ajax_delete_change', array( $this, 'bsfppc_meta_box_ajax_delete_handler' ), 1 );
			add_action( 'wp_ajax_nopriv_bsfppc_ajax_delete_change', array( $this, 'bsfppc_meta_box_ajax_delete_handler' ), 1 );
			add_action( 'admin_footer', array( $this, 'bsfppc_markup' ) );
		}
		/**
		 * Function for HTML markup of notification.
		 *
		 * Shows the pop-up of warning a user or preventing a user.
		 *
		 * @since 1.0.0
		 */
		public function bsfppc_markup() {
			$bsfppc_screen = get_current_screen();

			// If not edit or add new page, post or custom post type window then return.
			if ( ! isset( $bsfppc_screen->parent_base ) && 'edit' !== $bsfppc_screen->parent_base ) {
				return;
			}
			if ( ( ! empty( $_GET['action'] ) && 'edit' === $_GET['action'] ) || 'edit.php' === $bsfppc_screen->parent_file || 'post-new.php' === $bsfppc_screen->parent_file || 'page' === $bsfppc_screen->post_type ){

			wp_enqueue_script( 'bsfppc_backend_checkbox_js' );
			wp_enqueue_style( 'bsfppc_backend_css' );
			}
			?>
			<div class = "bsfppc-modal-warn">
				<div id="bsfppc_notifications" class="bsfppc-popup-warn">
					<h2>Pre-Publish Checklist</h2>
					<p class="bsfppc-popup-description">Your Pre-Publish Checklist is still pending. What would you like to do?</p>
					<div class="bsfppc-button-wrapper">
						<div class="bsfppc-popup-option-dontpublish">Don't Publish</div>
						<div class="bsfppc-popup-options-publishanyway">Publish Anyway</div>
					</div>    
				</div>
			</div>
			<div class = "bsfppc-modal-prevent">
				<div id="bsfppc_notifications" class="bsfppc-popup-prevent">
					<h2>Pre-Publish Checklist</h2>
					<p class="bsfppc-popup-description"> Please check all the checklist items before publishing.</p>
					<ul class="bsfppc-buttons-prevent">
					<li><p class="bsfppc-popup-option-okay">Okay, Take Me to the List!</p></li>
					</ul>
				</div>
			</div>
			<?php
		}

		/**
		 * Function for adding settings page in admin area
		 *
		 * Displays our plugin settings page in the WordPress
		 *
		 * @since 1.0.0
		 */
		public function bsf_ppc_settings_page() {
			add_submenu_page(
				'options-general.php',
				'Pre-Publish Checklist',
				'Pre-Publish Checklist',
				'manage_options',
				'bsf_ppc',
				array( $this, 'bsf_ppc_page_html' )
			);
		}
		/**
		 * Tabs function
		 *
		 * All the tabs are managed in the file which is included.
		 *
		 * @since 1.0.0
		 */
		public function bsf_ppc_page_html() {
			include_once BSFPPC_ABSPATH . 'includes/bsfppc-tabs.php';
		}
		/**
		 * Add custom meta box
		 *
		 * Display plugin's custom meta box in the meta settings side bar
		 *
		 * @since 1.0.0
		 */
		public function bsfppc_add_custom_meta_box() {
			$bsfppc_post_types_to_display = get_option( 'bsfppc_post_types_to_display' );
			if ( ! empty( $bsfppc_post_types_to_display ) ) {
				foreach ( $bsfppc_post_types_to_display as $screen ) {
					add_meta_box(
						'bsfppc_custom_meta_box', // Unique ID.
						'Pre-Publish Checklist', // Box title.
						array( $this, 'bsfppc_custom_box_html' ), // Content callback, must be of type callable.
						$screen,
						'side',
						'high'
					);
				}
			}
		}

		/**
		 * Call back function for HTML markup of meta box.
		 *
		 * This functions contains the markup to be displayed or the information to be displayed in the custom meta box
		 *
		 * @since 1.0.0
		 */
		public function bsfppc_custom_box_html() {
			wp_enqueue_script( 'bsfppc_backend_checkbox_js' );
			wp_enqueue_script( 'bsfppc_backend_tooltip_js' );
			wp_enqueue_style( 'bsfppc_backend_css' );
			global $post;
			$bsfppc_checklist_item_data = get_option( 'bsfppc_checklist_data' );
			$value                      = get_post_meta( $post->ID, '_bsfppc_meta_key', true );
			if ( ! empty( $bsfppc_checklist_item_data ) ) {
				foreach ( $bsfppc_checklist_item_data as $key ) {
					?>
						<input type="checkbox" name="checkbox[]" id="checkbox" class="bsfppc_checkboxes" value= "<?php echo esc_attr( $key ); ?>"

					<?php
					if ( ! empty( $value ) ) {
						foreach ( $value as $keychecked ) {
							checked( $keychecked, $key );
						}
					}
					?>
						>
					<?php

					echo esc_attr( $key );
					echo '<br/>';
				}
			} else {
				echo 'Please create a list to display here from Settings->Pre-Publish-Checklist';
			}
		}

		/**
		 * Function for saving the meta box values
		 *
		 * Adds value from metabox chechbox to the wp_post_meta()
		 *
		 * @since 1.0.0
		 */
		public function bsfppc_meta_box_ajax_add_handler() {
			if ( isset( $_POST['bsfppc_field_value'] ) ) {//PHPCS:ignore:WordPress.Security.NonceVerification.Missing
				$bsfppcpost        = sanitize_text_field( $_POST['bsfppc_post_id'] );//PHPCS:ignore:WordPress.Security.NonceVerification.Missing
				$bsfppc_check_data = array( sanitize_text_field( $_POST['bsfppc_field_value'] ) );//PHPCS:ignore:WordPress.Security.NonceVerification.Missing
				$pre_data          = get_post_meta( $bsfppcpost, '_bsfppc_meta_key', true );
				if ( ! empty( $pre_data ) ) {
					$bsfppc_checklist_add_data = array_merge( $pre_data, $bsfppc_check_data );
				} else {
					$bsfppc_checklist_add_data = $bsfppc_check_data;
				}
				update_post_meta(
					$bsfppcpost,
					'_bsfppc_meta_key',
					$bsfppc_checklist_add_data
				);
				echo 'sucess';
			} else {
				echo 'failure';
			}
			die;
		}

		/**
		 * Function for deleting the meta box values
		 *
		 * Delete value from post meta using chechbox uncheck from wp_post_meta()
		 *
		 * @since 1.0.0
		 */
		public function bsfppc_meta_box_ajax_delete_handler() {
			if ( isset( $_POST['bsfppc_field_value'] ) ) {//PHPCS:ignore:WordPress.Security.NonceVerification.Missing
				$bsfppcpost    = sanitize_text_field( $_POST['bsfppc_post_id'] );//PHPCS:ignore:WordPress.Security.NonceVerification.Missing
				$bsfppc_delete = sanitize_text_field( $_POST['bsfppc_field_value'] );//PHPCS:ignore:WordPress.Security.NonceVerification.Missing
				$pre_data      = get_post_meta( $bsfppcpost, '_bsfppc_meta_key', true );
				$key           = array_search( $bsfppc_delete, $pre_data, true );
				if ( false !== $key ) {
					unset( $pre_data[ $key ] );
				}
				update_post_meta(
					$bsfppcpost,
					'_bsfppc_meta_key',
					$pre_data
				);
			} else {
				echo 'failure';
			}
			die;
		}

	}
	BSFPPC_Pagesetups::get_instance();
endif;
