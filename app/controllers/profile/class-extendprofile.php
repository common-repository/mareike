<?php
/**
 * File class-extendprofile.php
 *
 * Contains controller for profile page
 *
 * @since 2024-07-15
 * @license GPL-3.0-or-later
 *
 * @package mareike/Controllers/Profile
 */

namespace Mareike\App\Controllers\profile;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Mareike\App\Models\CostUnit;
use Mareike\App\Models\Invoice;

/**
 *  Controller for profile page
 */
class ExtendProfile {

	/**
	 * Display the form to enter additional profile data
	 *
	 * @return void
	 */
	public static function execute() {
		$user = wp_get_current_user();

		$name          = $user->first_name . ' ' . $user->last_name;
		$account_owner = get_the_author_meta( 'account_owner', $user->ID );
		if ( '' === $account_owner ) {
			$account_owner = $name;
		}

		$plugin_data = get_plugin_data( MAREIKE_PLUGIN_STARTUP_FILE );
		wp_enqueue_script(
			'mareike-profile',
			MAREIKE_PLUGIN_URL . '/assets/javascripts/mareike-profile.js',
			array(),
			$plugin_data['Version'],
			true
		);

		require MAREIKE_TEMPLATE_DIR . '/profile/mareike-profile.php';
	}
}
