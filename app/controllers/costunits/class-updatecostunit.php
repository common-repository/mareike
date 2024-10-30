<?php
/**
 * File class-updatecostunit.php
 *
 * Controller for updating cost units
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

use Mareike\App\Models\CostUnit;
use Mareike\App\Routers\Dashboard\OpenEventsRouter;
use Mareike\App\Routers\DashboardRouter;

/**
 *  Controller for updating cost units
 */
class UpdateCostUnit {

	/**
	 *  Saves updates to a specific cost unit in database
	 *
	 * @param int     $cost_unit_id Id of the cost unit which should be updated.
	 * @param string  $costunit_name New cost unit name.
	 * @param string  $costunit_email New cost unit email.
	 * @param bool    $notifiy Shall the treasurer be informed on new invoices.
	 * @param ?string $costunit_end Deadline for invoices for an event.
	 *
	 * @return void
	 */
	public static function execute( int $cost_unit_id, string $costunit_name, string $costunit_email, bool $notifiy, string $costunit_end = null ) {
		$cost_unit = CostUnit::where( 'id', $cost_unit_id )->first();

		if ( CostUnit::COST_UNIT_TYPE_EVENT !== $cost_unit->cost_unit_type ) {
			$costunit_end = null;
		}

		$cost_unit->cost_unit_name   = $costunit_name;
		$cost_unit->billing_deadline = $costunit_end;
		$cost_unit->contact_email    = $costunit_email;
		$cost_unit->mail_on_new      = $notifiy;
		$cost_unit->save();

		DashboardRouter::execute();
	}
}
