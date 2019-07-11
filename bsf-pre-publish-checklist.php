<?php
/**
 * Plugin Name: Pre-Publish Checklist
 * Plugin URI: 
 * Description: With Pre-Publish Checklist, you’ll never have to be worried about accidentally publishing a post.
 * Version: 1.0
 * Author: Brainstormforce.
 * Author URI: 
 * License: GPL2
 */



define( 'BSF_PPC_ABSPATH', plugin_dir_path( __FILE__ ) );

define( 'BSF_PPC_PLUGIN_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );

define( 'BSF_PPC_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

require_once('classes/class-bsfppc-loader.php');
require_once('includes/bsfppc-page-setups.php');
