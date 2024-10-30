<?php
/**
 * File class-neweventrouter.php
 *
 * Router for all new events action
 *
 * @since 2024-07-15
 * @license GPL-3.0-or-later
 *
 * @package mareike/Routers
 */

namespace Mareike\App\Routers\Dashboard;

use Mareike\App\Controllers\CostUnit\CreateCostUnit;
use Mareike\App\Controllers\CostUnit\NewCostUnit;

/**
 *  Router for all new events action
 */
class NewEventRouter {

	/**
	 * Handler for routing action
	 *
	 * @return void
	 */
	public static function execute() {
		if ( ! isset( $_SESSION['mareike_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_SESSION['mareike_nonce'] ) ) ) ) {
			wp_die( 'Invalid Router call' );
		}

		$nonce = sanitize_key( wp_unslash( $_SESSION['mareike_nonce'] ) );

		if ( isset( $_POST['costunit-type'] ) ) {
			$cost_unit_type = (int) sanitize_text_field( wp_unslash( $_POST['costunit-type'] ) );

			if (
				! isset( $_REQUEST['costunit-distance'] ) ||
				! isset( $_REQUEST['costunit-name'] ) ||
				! isset( $_REQUEST['costunit-type'] ) ||
				! isset( $_REQUEST['costunit-end'] ) ||
				! isset( $_REQUEST['costunit-begin'] ) ||
				! isset( $_REQUEST['costunit-email'] ) ) {
				wp_die( 'Missing form parameters!' );
			}

			$costunit_name      = sanitize_text_field( wp_unslash( $_REQUEST['costunit-name'] ) );
			$costunit_begin     = sanitize_text_field( wp_unslash( $_REQUEST['costunit-begin'] ) );
			$costunit_email     = sanitize_email( wp_unslash( $_REQUEST['costunit-email'] ) );
			$billing_deadline   = sanitize_text_field( wp_unslash( $_REQUEST['costunit-end'] ) );
			$mail_on_new        = isset( $_REQUEST['notify-on-new'] );
			$page               = 'mareike-current-jobs';
			$distance_allowance = (float) str_replace( ',', '.', sanitize_text_field( wp_unslash( $_REQUEST['costunit-distance'] ) ) );

			CreateCostUnit::execute( $cost_unit_type, $costunit_name, $mail_on_new, $costunit_email, $distance_allowance, $costunit_begin, $billing_deadline );

			exit;
		}

		NewCostUnit::execute();
	}
}
