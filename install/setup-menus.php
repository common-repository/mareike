<?php
/**
 * File setup-menus.php
 *
 * Basic site setup for the Mareike plugin.
 *
 * This file includes various setup functions for the plugin,
 * including object setup, page setup, role setup, and menu setup.
 *
 * @package mareike/Setup
 */

/**
 * Adds the 'mareike settings' submenu page under the 'Settings' menu in a multisite network
 *
 * @return void
 */
function mareike_network_add_menu() {
	$_SESSION['mareike_nonce'] = esc_html( wp_create_nonce() );
	add_submenu_page(
		'settings.php',
		__( 'mareike settings', 'mareike' ),
		__( 'mareike settings', 'mareike' ),
		'edit_mareike_settings',
		'mareike-settings',
		array( 'Mareike\App\Routers\DashboardRouter', 'execute_multisite' ),
	);
}

/**
 * Adds the menu structure in dashboard
 *
 * @return void
 */
function mareike_add_menu() {
	$_SESSION['mareike_nonce'] = esc_html( wp_create_nonce() );
	add_submenu_page(
		'users.php',
		__( 'Billing information', 'mareike' ),
		__( 'Billing information', 'mareike' ),
		'read',
		'mareike-profile',
		array( 'Mareike\App\Routers\DashboardRouter', 'execute' ),
	);

	if ( ! is_multisite() ) {
		add_submenu_page(
			'options-general.php',
			__( 'mareike settings', 'mareike' ),
			__( 'mareike settings', 'mareike' ),
			'edit_mareike_settings',
			'mareike-settings',
			array( 'Mareike\App\Routers\DashboardRouter', 'execute' ),
		);
	}
	add_menu_page(
		__( 'Capture invoice', 'mareike' ),
		__( 'Capture invoice', 'mareike' ),
		'read',
		'mareike-new-invoice',
		array( 'Mareike\App\Routers\DashboardRouter', 'execute' ),
		'dashicons-plus-alt',
		3
	);

	add_menu_page(
		__( 'Invoices', 'mareike' ),
		__( 'Invoices', 'mareike' ),
		'edit_invoices',
		'mareike-get-invoice',
		array( 'Mareike\App\Routers\DashboardRouter', 'execute' ),
		'dashicons-calculator',
		3
	);

	add_submenu_page(
		'mareike-get-invoice',
		__( 'Current events', 'mareike' ),
		__( 'Current events', 'mareike' ),
		'edit_invoices',
		'mareike-current-events',
		array( 'Mareike\App\Routers\DashboardRouter', 'execute' ),
	);

	add_submenu_page(
		'mareike-get-invoice',
		__( 'Current jobs', 'mareike' ),
		__( 'Current jobs', 'mareike' ),
		'edit_invoices',
		'mareike-current-jobs',
		array( 'Mareike\App\Routers\DashboardRouter', 'execute' ),
	);

	add_submenu_page(
		'mareike-get-invoice',
		__( 'Closed events', 'mareike' ),
		__( 'Closed events', 'mareike' ),
		'edit_invoices',
		'mareike-closed-events',
		array( 'Mareike\App\Routers\DashboardRouter', 'execute' ),
	);

	add_submenu_page(
		'mareike-get-invoice',
		__( 'Archived events', 'mareike' ),
		__( 'Archived events', 'mareike' ),
		'edit_invoices',
		'mareike-archived-events',
		array( 'Mareike\App\Routers\DashboardRouter', 'execute' ),
	);

	add_submenu_page(
		'mareike-get-invoice',
		__( 'Add cost center', 'mareike' ),
		__( 'Add cost center', 'mareike' ),
		'edit_invoices',
		'mareike-create-event',
		array( 'Mareike\App\Routers\DashboardRouter', 'execute' ),
	);
}
