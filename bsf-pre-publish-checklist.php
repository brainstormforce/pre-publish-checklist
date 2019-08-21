<?php
/**
 * Plugin Name:  Pre Publish Checklist
 * Description:  With Pre-Publish Checklist, you’ll never have to be worried about accidentally publishing a post.
 * Version:     1.0.0
 * Author:      Brainstorm Force
 * Author URI:  https://brainstormforce.com
 * Text Domain: bsf-pre-publish-checklist.
 * Main
 *
 * PHP version 7
 *
 * @category PHP
 * @package  BSF Pre Publish Checklist
 * @author   Display Name <username@brainstormforce.com>
 * @license  https://brainstormforce.com
 * @link     https://brainstormforce.com
 */

define( 'BSF_PPC_ABSPATH', plugin_dir_path( __FILE__ ) );

define( 'BSF_PPC_PLUGIN_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );

define( 'BSF_PPC_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

require_once 'classes/class-bsfppc-loader.php';
require_once 'classes/class-bsfppc-pagesetups.php';
