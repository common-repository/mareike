<?php
/**
 * File: class-gettotalamountsrequest.php
 *
 * Request that returns the total amounts
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

use Mareike\App\Controllers\Invoices\InvoiceListForCostUnit;
use Mareike\App\Models\Invoice;

/**
 *  Request that returns the total amounts
 */
class GetTotalAmountsRequest {

	/**
	 * Gets the total amounts f the invoices with special status od a cost unit
	 *
	 * @param int $cost_unit_id Id of the cost unit.
	 * @param int $mode See @Invoice::status.
	 *
	 * @return float
	 */
	public static function execute( int $cost_unit_id, int $mode ): float {
		$amount       = 0;
		$invoice_type = null;

		switch ( $mode ) {
			case InvoiceListForCostUnit::NEW_INVOICE:
				$invoice_type = 'NEW';
				break;
			case InvoiceListForCostUnit::ACCEPTED_INVOICE:
				$invoice_type = 'APPROVED';
				break;
			case InvoiceListForCostUnit::NOPAYOUT_INVOICE:
				$amount = self::get_donated_amount( $cost_unit_id );
				break;
			case InvoiceListForCostUnit::DENIED_INVOICE:
				$invoice_type = 'DENIDED';
				break;
			case InvoiceListForCostUnit::EXPORTED_INVOICE:
				$amount = self::get_exported_amount( $cost_unit_id );
				break;
		}

		if ( null !== $invoice_type ) {
			foreach ( \Mareike\App\Models\Invoice::where(
				array(
					'costunit_id' => $cost_unit_id,
					'status'      => $invoice_type,
				)
			)->get() as $current_event ) {
				$amount += $current_event->amount;
			}
		}

		return $amount;
	}

	/**
	 * Internal use, gets the amount of all exported invoices
	 *
	 * @param int $cost_unit_id Identifier of the cost unit.
	 *
	 * @return float
	 */
	public static function get_exported_amount( int $cost_unit_id ): float {
		$amount = 0;
		foreach ( Invoice::where(
			array(
				'costunit_id' => $cost_unit_id,
				'status'      => 'EXPORTED',
			)
		)->get() as $invoice ) {
			if ( 'NOPAYOUT' !== $invoice->comment ) {
				$amount += $invoice->amount;
			}
		}
		return $amount;
	}

	/**
	 * Internal use, gets the total amount of all donations for a cost unit
	 *
	 * @param int $cost_unit_id Identifier of the cost unit.
	 *
	 * @return float
	 */
	public static function get_donated_amount( int $cost_unit_id ): float {
		$amount = 0;
		foreach ( Invoice::where(
			function ( $query ) {
				$query->where( 'status', 'EXPORTED' )
				->orwhere( 'status', 'NOPAYOUT' );
			}
		)->where( 'costunit_id', $cost_unit_id )->get() as $invoice ) {
			if ( 'NOPAYOUT' === $invoice->status || ( 'EXPORTED' === $invoice->status && 'NOPAYOUT' === $invoice->comment ) ) {
				$amount += $invoice->amount;
			}
		}
		return $amount;
	}
}
