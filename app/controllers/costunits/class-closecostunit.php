<?php
/**
 * File class-closecostunit.php
 *
 * Controller for closing cost units
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
use Mareike\App\Models\CostUnit;

/**
 * Controller for closing cost units
 */
class CloseCostUnit {

	/**
	 * Sets the flag allow_new = false on a special cost unit
	 *
	 * @param int    $cost_unit_id Id of the costunit.
	 * @param string $page current mareike page slug.
	 *
	 * @return void
	 */
	public static function execute( int $cost_unit_id, string $page ) {
		if ( '' === $page ) {
			wp_die( 'Invalid skript call.' );
		}

		$cost_unit = CostUnit::Where( array( 'id' => $cost_unit_id ) )->first();

		$cost_unit->allow_new = false;
		$cost_unit->save();

		$data               = CostUnitPrintHelper::get_active_events();
		$events             = $data['events'];
		$display_type       = $data['display_type'];
		$mareike_event_mode = ListItemsController::OPEN_EVENTS;

		require MAREIKE_TEMPLATE_DIR . '/costunits/listitems.php';
	}
}
