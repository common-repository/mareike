<?php
/**
 * File: class-getlfdnumberrequest.php
 *
 * Request that returns the new Upcounting number for a new invoice for a cost center
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
 *  Request that returns the new Upcounting number for a new invoice for a cost center
 */
class GetLfdNumberRequest {

	/**
	 * Returns the next free upcounting number
	 *
	 * @param int $cost_unit_id Id of the cost unit you want to get the number.
	 *
	 * @return int
	 */
	public static function execute( int $cost_unit_id ): int {
		$line = Invoice::where( array( 'costunit_id' => $cost_unit_id ) )->OrderBy( 'lfd_nummer', 'desc' )->first();
		return null !== $line ? (int) $line->lfd_nummer + 1 : 1;
	}
}
