<?php
/**
 * File class-createcostunit.php
 *
 * Controller for creating cost units
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

use Mareike\App\Actions\AddCostUnit;
use Mareike\App\Models\CostUnit;
use Mareike\App\Routers\Dashboard\OpenEventsRouter;

/**
 * Controller for creating cost units
 */
class CreateCostUnit {

	/**
	 * Creates a new cost unit in database
	 *
	 * @param int    $cost_unit_typ Type of the cost unit, seee Models/CostUnit.
	 * @param string $costunit_name Name of the cost unit.
	 * @param bool   $mail_on_new Shall the treasurer be informed on  a new email.
	 * @param string $email E-Mail address of the treasurer.
	 * @param float  $distance_allowance Defined distance_allowance for cost center.
	 * @param string $costunit_begin Date when event begins.
	 * @param string $billing_deadline Date when deadline for invoices is reached.
	 * @return void
	 */
	public static function execute(
		int $cost_unit_typ,
		string $costunit_name,
		bool $mail_on_new,
		string $email,
		float $distance_allowance,
		string $costunit_begin,
		string $billing_deadline
	) {
		if ( CostUnit::COST_UNIT_TYPE_EVENT === $cost_unit_typ ) {

			$date          = explode( '-', $costunit_begin );
			$costunit_name = $date[0] . '-' . $date[1] . '_' . $costunit_name;
			$page          = 'mareike-current-events';

		} else {
			$page             = 'mareike-current-jobs';
			$billing_deadline = null;
		}

		AddCostUnit::execute( $costunit_name, $cost_unit_typ, $email, $distance_allowance, $mail_on_new, $billing_deadline );
		OpenEventsRouter::execute();
	}
}
