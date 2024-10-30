<?php
/**
 * File: class-listdistanceallowancerequest.php
 *
 * Request that returns the distance allowances for all active cost units
 *
 * @since 2024-07-14
 * @license GPL-3.0-or-later
 *
 * @package mareike/Requests
 */

namespace Mareike\App\Requests;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Mareike\App\Models\CostUnit;
use Mareike\App\Models\Invoice;

/**
 * Request that returns the distance allowances for all active cost units
 */
class ListDistanceAllowanceRequest {

	/**
	 * Returns the distance allowances for the active cost units.
	 *
	 * @return array
	 */
	public static function execute(): array {
		$events = array();
		foreach ( \Mareike\App\Models\CostUnit::where(
			array(
				'archived'  => false,
				'allow_new' => true,
			)
		)->get() as $current_event ) {
			$events[ $current_event->id ] = $current_event->distance_allowance;
		}
		return $events;
	}
}
