<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://stoln.com
 * @since             1.0.0
 * @package           Cont_Ed
 *
 * @wordpress-plugin
 * Plugin Name:       Landscape Architect Mandatory Continuing Education
 * Plugin URI:        http://stoln.com/cont-ed-uri/
 * Description:       Allows members to enter continuing education hours.
 * Version:           1.0.0
 * Author:            1304713 Ont Inc.
 * Author URI:        http://stoln.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cont-ed
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cont-ed-activator.php
 */
function activate_cont_ed() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cont-ed-activator.php';
	Cont_Ed_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cont-ed-deactivator.php
 */
function deactivate_cont_ed() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cont-ed-deactivator.php';
	Cont_Ed_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_cont_ed' );
register_deactivation_hook( __FILE__, 'deactivate_cont_ed' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cont-ed.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_cont_ed() {

	$plugin = new Cont_Ed();
	$plugin->run();

}
run_cont_ed();
