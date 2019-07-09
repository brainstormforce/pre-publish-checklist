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
			add_action( 'wp_enqueue_scripts', array( $this, 'bsfppc_plugin_frontend_js' ) );
		
		}
		/**
		 * Plugin Styles for admin dashboard.
		 *
		 * @since  1.0.0
		 * @return void
		 */

		public function bsfppc_plugin_backend_js() {
			wp_register_script( 'bsfppc_backend', BSF_PPC_PLUGIN_URL . '/assets/js/bsfppc-checkbox.js', null,'1.0', false );

		}
		public function bsfppc_plugin_frontend_js(){
			wp_register_script( 'bsfppc_backend', BSF_PPC_PLUGIN_URL . '/assets/js/bsfppc-checkbox.js', null,'1.0', false );
		}

	}

		BSFPPC_Loader::get_instance();
endif;


