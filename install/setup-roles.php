<?php
/**
 * Contains Code for the mareike roles
 *
 * @package mareike/Setup
 */

/**
 * Installs the roles required
 *
 * @return void
 */
function mareike_setup_roles(): void {
	$role = get_role( 'user' );
	if ( null === $role ) {
		add_role(
			'user',
			__( 'Default user', 'mareike' ),
			mareike_get_capabilities_user()
		);
	} else {
		foreach ( mareike_get_capabilities_user() as $capability => $value ) {
			$role->add_cap( $capability );
		}
	}

	$role = get_role( 'director' );
	if ( null === $role ) {
		add_role(
			'director',
			true === (bool) get_option( 'page_used_for_state', false )
				? __( 'State director', 'mareike' )
				: __( 'Club director', 'mareike' ),
			mareike_get_capabilities_director()
		);
	} else {
		$role = get_role( 'director' );
		foreach ( mareike_get_capabilities_director() as $capability => $value ) {
			$role->add_cap( $capability );
		}
	}

	$role = get_role( 'administrator' );
	foreach ( mareike_get_capabilities_director() as $capability => $value ) {
		$role->add_cap( $capability );
	}

	$role = get_role( 'treasurer' );
	if ( null === $role ) {
		add_role( 'treasurer', __( 'Treasurer', 'mareike' ), mareike_get_capabilities_treasurer() );
	} else {
		$role = get_role( 'treasurer' );
		foreach ( mareike_get_capabilities_treasurer() as $capability => $value ) {
			$role->add_cap( $capability );
		}
	}
}
