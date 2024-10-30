<?php
/**
 * File setup.php
 *
 * Basic site setup for the Mareike plugin.
 *
 * This file includes various setup functions for the plugin,
 * including object setup, page setup, role setup, and menu setup.
 *
 * @package mareike/Setup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once MAREIKE_PLUGIN_DIR . '/install/setup-objects.php';
require_once MAREIKE_PLUGIN_DIR . '/install/setup-page.php';
require_once MAREIKE_PLUGIN_DIR . '/install/setup-roles.php';
require_once MAREIKE_PLUGIN_DIR . '/install/setup-menus.php';

/**
 * Basic setup calls
 *
 * @return void
 */
function mareike_admin_setup() {
	mareike_setup_objects();
	mareike_setup_page();
}
