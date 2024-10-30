<?php
/**
 * File: class-getmycostunits.php
 *
 * @since 2024-07-18
 * @license GPL-3.0-or-later
 *
 * @package mareike/Requests
 */

namespace Mareike\App\Requests;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Mareike\App\Models\CostUnit;

/**
 * Only returns cost units where the current user is cost unit treasurer, or has the capabitlity edit_invoices
 */
class GetMyCostUnits {
	/**
	 * Returns a list of cost units
	 *
	 * @param int  $filtermode See @Invoice::Invoice_Type_* .
	 * @param bool $active_events Filter if only active cost units should be returned.
	 *
	 * @return mixed
	 */
	public static function execute( int $filtermode, bool $active_events ) {
		$condition_array = array(
			'cost_unit_type' => $filtermode,
			'archived'       => false,
			'allow_new'      => $active_events,
		);

		if ( ! current_user_can( 'edit_invoices' ) ) {
			$condition_array['treasurer_user_id'] = get_current_user_id();
		}
		return CostUnit::where( $condition_array )->get();
	}
}
