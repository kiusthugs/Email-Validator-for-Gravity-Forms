<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/kiusthugs
 * @since             1.0.0
 * @package           Elvgf
 *
 * @wordpress-plugin
 * Plugin Name:       ELV for Gravity Forms
 * Plugin URI:        https://github.com/kiusthugs
 * Description:       This plugin validates emails with the Email List Verify API to work through Gravity Forms.
 * Version:           1.0.0
 * Author:            Kirt Perez, BTV Marketing/ Tom Madrid, MixTape Las Vegas
 * Author URI:        https://github.com/kiusthugs
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       elvgf
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ELVGF_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-elvgf-activator.php
 */
function activate_elvgf() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-elvgf-activator.php';
	Elvgf_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-elvgf-deactivator.php
 */
function deactivate_elvgf() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-elvgf-deactivator.php';
	Elvgf_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_elvgf' );
register_deactivation_hook( __FILE__, 'deactivate_elvgf' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-elvgf.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_elvgf() {

	$plugin = new Elvgf();
	$plugin->run();

}
run_elvgf();
