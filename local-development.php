<?php
/**
 * Plugin Name:       Local Development
 * Plugin URI:        https://wordpress.org/plugins/local-development
 * Author:            Andy Fragen
 * Author URI:        http://thefragens.com/
 * Description:       Places development notice for plugins or themes that are in local development. Prevents updating of selected plugins and themes. Allows for using a local file server.
 * Version:           1.6.0.7
 * Domain Path:       /languages
 * Text Domain:       local-development
 * License:           GNU General Public License v2
 * License URI:       http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Network:           true
 * GitHub Plugin URI: https://github.com/afragen/local-development
 * Requires PHP:      5.3
 */

/*
 * Exit if called directly.
 * PHP version check and exit.
 */
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( version_compare( '5.6.0', PHP_VERSION, '>=' ) ) {
	echo '<div class="error notice is-dismissible"><p>';
	printf(
		/* translators: 1: minimum PHP version required, 2: Upgrade PHP URL */
		wp_kses_post( __( 'Local Development cannot run on PHP versions older than %1$s. <a href="%2$s">Learn about upgrading your PHP.</a>', 'local-development' ) ),
		'5.6.0',
		esc_url( __( 'https://wordpress.org/support/upgrade-php/' ) )
	);
	echo '</p></div>';

	return false;
}

// Load textdomain.
load_plugin_textdomain( 'local-development', false, basename( __DIR__ ) . '/languages' );

// Plugin namespace root.
$local_development['root'] = array( 'Fragen\\Local_Development' => __DIR__ . '/src/Local_Development' );

// Plugin extra classes.
$local_development['extra_classes'] = array( 'Fragen\Singleton' => __DIR__ . '/src/Singleton.php' );

// Load Autoloader.
require_once __DIR__ . '/src/Autoloader.php';
$local_development['loader'] = 'Fragen\\Autoloader';
new $local_development['loader']($local_development['root'], $local_development['extra_classes']);

// Instantiate.
$local_development['instantiate'] = 'Fragen\\Local_Development\\Init';
new $local_development['instantiate']();
