<?php

/**
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.getomnify.com/about-us/
 * @since             1.0.0
 * @package           Omnify_Widget
 *
 * @wordpress-plugin
 * Plugin Name:       Omnify Widget
 * Plugin URI:        https://www.getomnify.com/plugins/wordpress
 * Description:       Easily embed Omnify buttons and iframes onto your existing WordPress website and start selling right from there.
 * Version:           2.0.0
 * Author:            Omnify Team
 * Author URI:        https://www.getomnify.com/about-us/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       omnify-widget
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-omnify-widget-activator.php
 */
function activate_omnify_widget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-omnify-widget-activator.php';
	Omnify_Widget_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-omnify-widget-deactivator.php
 */
function deactivate_omnify_widget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-omnify-widget-deactivator.php';
	Omnify_Widget_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_omnify_widget' );
register_deactivation_hook( __FILE__, 'deactivate_omnify_widget' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-omnify-widget.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_omnify_widget() {

	$plugin = new Omnify_Widget();
	$plugin->run();

}

run_omnify_widget();
