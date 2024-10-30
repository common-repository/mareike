<?php
/**
 * File: class-findinvoicebycontinuousnumber.php
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
use Mareike\App\Models\Invoice;

/**
 * Finds ian invoice by< its public number
 */
class FindInvoiceByContinuousNumber {
	/**
	 * Finds an invoice by its public number and the cost unit
	 *
	 * @param int $costunit_id If of the cost unit of the invoice.
	 * @param int $continuous_number Public receipt number if the invoice.
	 *
	 * @return Invoice|null
	 */
	public static function execute( int $costunit_id, int $continuous_number ): ?Invoice {
		$cost_unit = CostUnit::load_with_permission_check( $costunit_id );
		if ( null === $cost_unit ) {
			wp_die( 'Unauthorized' );
		}

		return Invoice::where(
			array(
				'costunit_id' => $costunit_id,
				'lfd_nummer'  => $continuous_number,
			)
		)->first();
	}
}
