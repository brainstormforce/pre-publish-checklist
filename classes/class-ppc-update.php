<?php
/**
 * Pre-Publish Checklist.
 *
 * PHP version 7
 *
 * @category PHP
 * @package  Pre-Publish Checklist.
 * @author   Display Name <username@brainstormforce.com>
 * @license  http://brainstormforce.com
 * @link     http://brainstormforce.com
 * @since    1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
	/**
	 * PPC_Update initial setup
	 *
	 * @since 1.1.0
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
	 *
	 * @var instance
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

		// Plugin updates.
		if ( is_admin() ) {
			add_action( 'admin_init', array( $this, 'init' ), 5 );
		} else {
			add_action( 'wp', array( $this, 'init' ), 5 );
		}
	}

	/**
	 * Implement theme update logic.
	 *
	 * @since 1.1.0
	 */
	public function init() {
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
	 * @since 1.1.0
	 */
	public function update_options_table() {
		$ppc_default_checklist_data = array(
			'ppc_key2' => __( 'Featured Image Assigned', 'pre-publish-checklist' ),
			'ppc_key3' => __( 'Category Selected', 'pre-publish-checklist' ),
			'ppc_key4' => __( 'Formatting Done', 'pre-publish-checklist' ),
			'ppc_key5' => __( 'Title is Catchy', 'pre-publish-checklist' ),
			'ppc_key6' => __( 'Social Images Assigned', 'pre-publish-checklist' ),
			'ppc_key7' => __( 'Done SEO', 'pre-publish-checklist' ),
			'ppc_key8' => __( 'Spelling and Grammar Checked', 'pre-publish-checklist' ),
		);

		$ppc_checklist_item_data = get_option( 'ppc_checklist_data', $ppc_default_checklist_data );

		$default_list = array();

		$ppc_post_types = get_option( 'ppc_post_types_to_display', array( 'page', 'post' ) );

		foreach ( $ppc_post_types as $key => $post_type ) {
			$default_list[ $post_type ] = $ppc_checklist_item_data;
		}

		update_option( 'ppc_cpt_checklist_data', $default_list );
	}

	/**
	 * Check if db upgrade is required.
	 *
	 * @since 1.1.0
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
	 * @since 1.1.0
	 * @return void
	 */
	private function update_db_version() {
		update_option( '_ppc_db_version', PPC_VERSION );
	}

}
	PPC_Update::get_instance();
