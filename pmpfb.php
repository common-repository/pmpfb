<?php

/**
 * The plugin bootstrap file
 *
 * @link              https://figarts.co
 * @since             1.0.0
 * @package           Pmpfb
 *
 * @wordpress-plugin
 * Plugin Name:       Paid Memberships Pro - Form Builder
 * Plugin URI:        https://figarts.co
 * Description:       Drag and Drop Form Builder for creating fields in Paid Memberships Pro
 * Version:           1.0.0
 * Author:            Figarts
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pmpfb
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PMPFB_VERSION', '1.0.0' );
define( 'PMPFB_DIR', plugin_dir_path( __FILE__ ) );
define( 'PMPFB_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'PMPFB_BASE', plugin_basename( __FILE__ ) );
define( 'PMPFB_ADMIN_PARTIALS', PMPFB_DIR . 'admin/partials' );

/**
 * The code that runs during plugin activation.
 */
function activate_pmpfb() {
  if(!defined('PMPRO_VERSION'))
		wp_die( __( 'Sorry, Paid Memberships Pro must be active', 'pmpfb' ) );
}

/**
 * If PMPro was active at activation nbut later deactivated
*/
function pmpfb_auto_deactivate() {
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	if(is_plugin_inactive('paid-memberships-pro/paid-memberships-pro.php')) {
		deactivate_plugins( plugin_basename( __FILE__ ) );
	}
}

register_activation_hook( __FILE__, 'activate_pmpfb' );
pmpfb_auto_deactivate();	

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pmpfb.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_pmpfb() {

	$plugin = new Pmpfb();
	$plugin->run();

}
run_pmpfb();
