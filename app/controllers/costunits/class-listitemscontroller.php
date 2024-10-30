<?php
/**
 * File class-listitemscontroller.php
 *
 * Controller for Listing invoices of cost units
 *
 * @since 2024-07-14
 * @license GPL-3.0-or-later
 *
 * @package mareike/Controllers/CostUnit
 */

namespace Mareike\App\Controllers\CostUnit;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Mareike\App\Helpers\CostUnitPrintHelper;

if ( session_status() !== PHP_SESSION_ACTIVE ) {
	session_start();
}

/**
 *  Controller for Listing invoices of cost units
 */
class ListItemsController {

	public const  OPEN_EVENTS    = 0;
	public const CLOSED_EVENTS   = 1;
	public const ARCHIVED_EVENTS = 2;
	public const JOBS            = 3;

	/**
	 * Prints the costunits having a special status
	 *
	 * @param int    $mareike_event_mode Which cost units shall be printed.
	 * @param string $page current mareike page slug.
	 * @param string $nonce The nonce value of the current session.
	 *
	 * @return void
	 */
	public static function execute( int $mareike_event_mode, string $page, string $nonce ) {
		if ( '' === $page ) {
			wp_die( 'Invalid skript call.' );
		}

		if ( '' === $nonce ) {
			wp_die( 'Skript call not allowed,' );
		}
		switch ( $mareike_event_mode ) {
			case self::OPEN_EVENTS:
				$data = CostUnitPrintHelper::get_active_events();
				break;

			case self::CLOSED_EVENTS:
				$data = CostUnitPrintHelper::get_closed_events();
				break;

			case self::ARCHIVED_EVENTS:
				$data = CostUnitPrintHelper::get_archived_events();
				break;

			case self::JOBS:
				$data = CostUnitPrintHelper::get_active_jobs();
				break;

		}

		$events       = $data['events'];
		$display_type = $data['display_type'];

		require MAREIKE_TEMPLATE_DIR . '/costunits/listitems.php';
	}
}
