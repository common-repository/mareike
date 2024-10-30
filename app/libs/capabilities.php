<?php
/**
 * File: capabilities.php
 *
 * Library for Generating the capabilities for new roles
 *
 * @since 2024-07-14
 * @license GPL-3.0-or-later
 *
 * @package mareike/Setup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the capabilites for role treasurer
 *
 * @return array
 */
function mareike_get_capabilities_treasurer(): array {
	return array_merge(
		array(
			'edit_invoices' => true,
		),
		mareike_get_capabilities_user()
	);
}
/**
 * Returns the capabilites for role default user
 *
 * @return array
 */
function mareike_get_capabilities_user(): array {
	return array(
		'add_invoice'  => true,
		'edit_profile' => true,
		'read'         => true,
	);
}

/**
 * Returns the capabilites for role director
 *
 * @return array
 */
function mareike_get_capabilities_director(): array {
	return array_merge(
		array(
			'edit_mareike_settings' => true,
			'create_users'          => true,
			'edit_users'            => true,
			'delete_users'          => true,
		),
		mareike_get_capabilities_treasurer()
	);
}
