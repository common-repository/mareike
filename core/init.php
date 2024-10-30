<?php
/**
 * File init.php
 *
 * Contains initial setup functions for mareike
 *
 * @since 2024-07-14
 * @license GPL-3.0-or-later
 *
 * @package mareike/Setup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use mareike\Libs\UpdateChecker;

require_once __DIR__ . '/defines.php';
require_once ABSPATH . '/wp-admin/includes/plugin.php';
require_once ABSPATH . '/wp-admin/includes/class-wp-filesystem-base.php';
require_once ABSPATH . '/wp-admin/includes/class-wp-filesystem-direct.php';
require_once ABSPATH . '/wp-includes/pluggable.php';
require_once ABSPATH . '/wp-includes/capabilities.php';
require_once ABSPATH . '/wp-admin/includes/template.php';
require_once ABSPATH . '/wp-admin/includes/file.php';
require_once ABSPATH . '/wp-admin/includes/upgrade.php';

require MAREIKE_PLUGIN_DIR . '/vendor/autoload.php';
require_once MAREIKE_PLUGIN_DIR . '/interfaces.php';
require_once MAREIKE_PLUGIN_DIR . '/core/multisite.php';

$directories = array(
	'models/',
	'routers/',
	'routers/dashboard/',
	'controllers/',
	'controllers/costunits/',
	'controllers/invoices/',
	'controllers/profile/',
	'controllers/settings/',
	'controllers/dashboard/',
	'helpers/',
	'actions/',
	'requests/',
	'mails/',
	'libs/',
);

require_once MAREIKE_PLUGIN_DIR . '/app/' . $directories[0] . '/class-mainmodel.php';
require_once MAREIKE_PLUGIN_DIR . '/app/views/statusmessage.php';

foreach ( $directories as $directory ) {
	$directory = MAREIKE_PLUGIN_DIR . '/app/' . $directory;

	$handle = opendir( $directory );
	while ( $entry = readdir( $handle ) ) {
		if ( '.' !== $entry && '..' !== $entry ) {
			$file_path = $directory . DIRECTORY_SEPARATOR . $entry;
			if ( is_file( $file_path ) && pathinfo( $file_path, PATHINFO_EXTENSION ) === 'php' ) {
				require_once $file_path;
			}
		}
	}

	closedir( $handle );
}

require_once MAREIKE_PLUGIN_DIR . 'core/class-fileaccess.php';
require_once MAREIKE_PLUGIN_DIR . 'core/sqlsetup.php';
require_once MAREIKE_PLUGIN_DIR . 'core/cronjob.php';
require_once MAREIKE_PLUGIN_DIR . 'install/setup.php';
require_once MAREIKE_PLUGIN_DIR . 'core/gui.php';
