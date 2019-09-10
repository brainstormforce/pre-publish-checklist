<?php
/**
 * Plugin Name:  Pre-Publish Checklist
 * Description:  Pre-Publish Checklist ensures that you don't skip anything from the essential list of things before you publish a post.
 * Version:     1.0.0
 * Author:      Brainstorm Force
 * Author URI:  https://brainstormforce.com
 * Text Domain: bsf-pre-publish-checklist
 * Main
 *
 * PHP version 7
 *
 * @category PHP
 * @package  Pre-Publish Checklist.
 * @author   Display Name <username@brainstormforce.com>
 * @license  https://brainstormforce.com
 * @link     https://brainstormforce.com
 */

define( 'PPC_ABSPATH', plugin_dir_path( __FILE__ ) );

define( 'PPC_PLUGIN_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );

define( 'PPC_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

define( 'PPC_VERSION' , '1.0.0');

require_once 'classes/class-ppc-loader.php';

