<?php
/**
 * Pre-Publish Checklist.
 *
 * PHP version 7
 *
 * @category PHP
 * @package  Pre-Publish Checklist.
 * @author   Display Name <username@ShubhamW.com>
 * @license  http://brainstormforce.com
 * @link     http://brainstormforce.com
 */

if ( ! class_exists( 'PPC_Update' ) ) :
	/**
	 * Pre-Publish Checklist doc comment.
	 *
	 * PHP version 7
	 *
	 * @category PHP
	 * @package  Pre-Publish Checklist.
	 * @author   Display Name <username@ShubhamW.com>
	 * @license  http://brainstormforce.com
	 * @link     http://brainstormforce.com
	 */
	class PPC_Update {
		/**
		 * Member Variable
		 *
		 * @var instance
		 */
		private static $instance;
		
		/**
		 * Option key for stored version number.
		 */
		private $db_version_key = '_ppc_db_version';
		
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

			//Plugin updates.
			if ( is_admin() ) {
				add_action( 'admin_init', array( $this, 'init' ), 5 );
			} else {
				add_action( 'wp', array( $this, 'init' ), 5 );
			}
		}

		/**
		 * Implement theme update logic.
		 *
		 * @since 1.1.4
		 */
		public function init(){
			do_action( 'ppc_update_before' );

			if ( ! $this->needs_db_update() ) {
				return;
			}

			$db_version = get_option( $this->db_version_key, false );

			if ( version_compare( $db_version, '1.0.2', '<' ) ) {
				$this->update_options_table();
			}

			$this->update_db_version();

			do_action( 'ppc_update_after' );

		}

		/**
		 * Moves the option values from ppc_checklist_data to ppc_cpt_checklist_data.
		 *
		 */
		public function update_options_table(){
			echo "insider";
			$ppc_default_checklist_data = array(
				'ppc_key2' => 'Featured Image Assigned',
				'ppc_key3' => 'Category Selected',
				'ppc_key4' => 'Formatting Done',
				'ppc_key5' => 'Title is Catchy',
				'ppc_key6' => 'Social Images Assigned',
				'ppc_key7' => 'Done SEO',
				'ppc_key8' => 'Spelling and Grammar Checked',
			);

			$ppc_checklist_item_data    = get_option( 'ppc_checklist_data', $ppc_default_checklist_data);
			var_dump($ppc_checklist_item_data);
			update_option( 'ppc_cpt_checklist_data', $ppc_checklist_item_data );

			$default_list = array();

			$ppc_post_types = get_option( 'ppc_post_types_to_display', array( 'page', 'post' ) );

			foreach ( $ppc_post_types as $key => $post_type ) {
				$default_list[ $post_type ] = $ppc_checklist_item_data;
			}

			return get_option( 'ppc_cpt_checklist_data', $ppc_checklist_item_data );

		}

		/**
		 * Check if db upgrade is required.
		 *
		 * @since 1.1.4
		 * @return true|false True if stored database version is lower than constant; false if otherwise.
		 */
		private function needs_db_update() {
			
			$db_version = get_option( $this->db_version_key, false );

			if ( false === $db_version || version_compare( $db_version, PPC_VERSION ) ) {
				return true;
			}

			return false;
		}

		/**
		 * Update DB version.
		 *
		 * @since 1.1.4
		 * @return void
		 */
		private function update_db_version() {
			update_option( '_ppc_db_version', PPC_VERSION );
			// update_option( $this->$db_version_key, PPC_VERSION );
		}

	}
	PPC_Update::get_instance();
endif;
