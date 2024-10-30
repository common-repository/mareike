<?php
/**
 * File class-updateprofile.php
 *
 * Contains the controller for updating the userprofile
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
 *  Controller for updating the userprofile
 */
class UpdateProfile {

	/**
	 *  Updates the profile of the logged in user
	 *
	 * @param string $firstname Firstname of the user.
	 * @param string $lastname Last name of the user.
	 * @param string $email Email-address of the user.
	 * @param string $iban IBAN of the user.
	 * @param string $account_owner Account owner, usually the user itself.
	 * @return void
	 */
	public static function execute( string $firstname, string $lastname, string $email, string $iban, string $account_owner ) {

		$user_id = get_current_user_id();
		update_user_meta( $user_id, 'first_name', $firstname );
		update_user_meta( $user_id, 'last_name', $lastname );
		update_user_meta( $user_id, 'iban', $iban );
		update_user_meta( $user_id, 'account_owner', $account_owner );
		wp_update_user(
			array(
				'ID'         => $user_id,
				'user_email' => $email,
			)
		);
		$user        = wp_get_current_user();
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
