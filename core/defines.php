<?php
/**
 * Basic plugin defines
 *
 * @package mareike/Setup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MAREIKE_PLUGIN_SLUG', 'mareike' );
define( 'MAREIKE_PLUGIN_STARTUP_FILE', WP_PLUGIN_DIR . '/' . MAREIKE_PLUGIN_SLUG . '/' . MAREIKE_PLUGIN_SLUG . '.php' );

define( 'MAREIKE_PLUGIN_DIR', plugin_dir_path( MAREIKE_PLUGIN_STARTUP_FILE ) );
define( 'MAREIKE_PLUGIN_URL', plugin_dir_url( MAREIKE_PLUGIN_STARTUP_FILE ) );
define( 'MAREIKE_TEMPLATE_DIR', MAREIKE_PLUGIN_DIR . '/app/views/' );

define( 'MAREIKE_WP_FS_CHMOD_FILE', ( fileperms( ABSPATH . 'index.php' ) & 0777 | 0644 ) );
define( 'MAREIKE_WP_FS_CHMOD_DIRECTORY', ( fileperms( ABSPATH . 'index.php' ) & 0777 | 0755 ) );

$mareike_transportation_text = array(
	false => __( 'No' ),
	true  => __( 'Yes' ),
);
