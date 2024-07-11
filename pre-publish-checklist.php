<?php
/**
 * Plugin Name:  Pre-Publish Checklist
 * Description:  The Pre-Publish Checklist plugin is a handy plugin that will help you finalize all posts and pages on your website before you click on the publish button.
 * Version:     1.1.4
 * Author:      Pratik Chaskar
 * Author URI:  https://pratikchaskar.com/
 * Text Domain: bsf-pre-publish-checklist
 * Main
 *
 * PHP version 7
 *
 * @category PHP
 * @package  Pre-Publish Checklist.
 * @author   Pratik Chaskar
 * @license  https://pratikchaskar.com/
 * @link     https://pratikchaskar.com/
 */

define( 'PPC_PATH', __FILE__ );
define( 'PPC_ABSPATH', plugin_dir_path( __FILE__ ) );
define( 'PPC_PLUGIN_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );
define( 'PPC_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'PPC_VERSION', '1.1.4' );

require_once 'classes/class-ppc-loader.php';
