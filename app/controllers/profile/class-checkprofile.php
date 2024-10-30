<?php
/**
 * File class-checkprofile.php
 *
 * Checks if the profile of the loggedin user is complete and triggers a function to print a messagebox if not
 * If not, a reminder is printed
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
 *  Checks if the profile of the loggedin user is complete and triggers a function to print a messagebox if not
 *  If not, a reminder is printed
 */
class CheckProfile {

	/**
	 * Checks if the profile of the loggedin user is complete and triggers a function to print a messagebox if not
	 *
	 * @return void
	 */
	public static function execute() {
		$user = wp_get_current_user();

		if (
			'' === $user->first_name ||
			'' === $user->last_name ||
			'' === $user->iban ||
			'' === $user->account_owner
		) {
			add_action( 'admin_notices', array( 'Mareike\App\Controllers\profile\CheckProfile', 'print_infobox' ) );

		}
	}

	/**
	 * Prints the messagebox, that the profile of the loggedin user is not complete
	 *
	 * @return void
	 */
	public static function print_infobox() {
		require MAREIKE_TEMPLATE_DIR . '/profile/missing-settings.php';
	}
}
