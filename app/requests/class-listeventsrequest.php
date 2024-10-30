<?php
/**
 * File: class-listeventsrequest.php
 *
 * Requests that returns Cost centers by filter options
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
use Mareike\App\Models\CostUnit;
use Mareike\App\Models\Invoice;

/**
 *  Requests that returns Cost centers by filter options
 */
class ListEventsRequest {

	/**
	 * Lists events by a special filter
	 *
	 * @param bool $allow_new Filter for cost units you can create invoices.
	 * @param bool $archived Filter for archived invoices.
	 * @param int  $cost_unit_type Filter if events or jobs.
	 * @param bool $public_mode Show all possible invoices without check (Required for new invoices).
	 *
	 * @return array
	 */
	public static function execute( bool $allow_new = true, bool $archived = false, int $cost_unit_type = CostUnit::COST_UNIT_TYPE_EVENT, bool $public_mode = false ): array {
		$events = array();

		$cost_unit_filter = array(
			'cost_unit_type' => $cost_unit_type,
			'archived'       => $archived,
			'allow_new'      => $allow_new,
		);
		if ( ! current_user_can( 'edit_invoices' ) && ! $public_mode ) {
			$cost_unit_filter['treasurer_user_id'] = get_current_user_id();
		}

		foreach ( \Mareike\App\Models\CostUnit::where( $cost_unit_filter )->get() as $current_event ) {
			$current_event->open_invoice_count = Invoice::where(
				array(
					'status'      => 'NEW',
					'costunit_id' => $current_event->id,
				)
			)->count();

			$current_event->unexported_invoice_count = Invoice::where(
				array(
					'status'      => 'APPROVED',
					'costunit_id' => $current_event->id,
				)
			)->count();

			$current_event->nopayout_invoice_count = Invoice::where(
				array(
					'status'      => 'NOPAYOUT',
					'costunit_id' => $current_event->id,
				)
			)->count();

			$current_event->denied_invoice_count = Invoice::where(
				array(
					'status'      => 'DENIED',
					'costunit_id' => $current_event->id,
				)
			)->count();

			$current_event->open_invoice_amount = GetTotalAmountsRequest::execute(
				$current_event->id,
				InvoiceListForCostUnit::NEW_INVOICE
			);

			$current_event->unexported_invoice_amount = GetTotalAmountsRequest::execute(
				$current_event->id,
				InvoiceListForCostUnit::ACCEPTED_INVOICE
			);

			$current_event->nopayout_invoice_amount = GetTotalAmountsRequest::execute(
				$current_event->id,
				InvoiceListForCostUnit::NOPAYOUT_INVOICE
			);

			$current_event->denied_invoice_amount = GetTotalAmountsRequest::execute(
				$current_event->id,
				InvoiceListForCostUnit::DENIED_INVOICE
			);

			$current_event->exported_invoice_amount = GetTotalAmountsRequest::execute(
				$current_event->id,
				InvoiceListForCostUnit::EXPORTED_INVOICE
			);

			$current_event->total_amount =
				$current_event->open_invoice_amount +
				$current_event->unexported_invoice_amount +
				$current_event->open_invoice_amount +
				$current_event->exported_invoice_amount;

			$current_event->donated_amount = $current_event->nopayout_invoice_amount;

			$events[] = $current_event;
		}
		return $events;
	}
}
