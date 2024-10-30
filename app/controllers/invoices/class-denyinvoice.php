<?php
/**
 * File class-denyinvoice.php
 *
 * Controller for denying an invoice
 *
 * @since 2024-07-15
 * @license GPL-3.0-or-later
 *
 * @package mareike/Controllers/Invoice
 */

namespace Mareike\App\Controllers\Invoices;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Mareike\App\Models\CostUnit;
use Mareike\App\Models\Invoice;

/**
 *  Controller for denying an invoice
 */
class DenyInvoice {

	/**
	 * Sets the status of a specific invoice to DECLINED, stores the reason  and informs the invoice owner
	 *
	 * @param int    $invoice_id Costunit to display for.
	 * @param string $deny_reason Reason why the invoice was denied.
	 * @param string $page Slug of mareike-page.
	 *
	 * @return void
	 */
	public static function execute( int $invoice_id, string $deny_reason, $page ) {
		$invoice = Invoice::Where( array( 'id' => $invoice_id ) )->first();

		if ( isset( $_SESSION['mareike_request_sent'] ) ) {
			InvoiceListForCostUnit::execute( InvoiceListForCostUnit::NEW_INVOICE, $invoice_id, $page );
			exit;
		}
		$_SESSION['mareike_request_sent'] = true;

		$invoice->denied_reason = $deny_reason;
		if ( 'NOPAYOUT' === $invoice->status ) {
			$invoice->comment = 'NOPAYOUT';
		}
		$invoice->status    = 'DENIED';
		$invoice->denied_by = get_current_user_id();

		$invoice->save();

		if ( '' !== $invoice->contact_email && str_contains( $invoice->contact_email, '@' ) ) {
			$event     = CostUnit::Where( array( 'id' => $invoice->costunit_id ) )->first();
			$user      = get_user_by( 'id', get_current_user_id() );
			$denied_by = trim( $user->first_name . ' ' . $user->last_name );
			if ( '' === $denied_by ) {
				$denied_by = $user->user_nicename;
				if ( '' === $denied_by ) {
					$denied_by = $user->user_email;
				}
			}
			wp_mail(
				$invoice->contact_email,
				'[mareike] ' . __( 'Your request for refund has been rejected', 'mareike' ),
				mareike_get_invoice_denied_mail_text(
					$invoice->contact_name,
					$invoice->amount,
					$event->cost_unit_name,
					$denied_by,
					$user->user_email,
					$invoice->denied_reason
				)
			);
		}

		InvoiceListForCostUnit::execute( InvoiceListForCostUnit::NEW_INVOICE, $invoice->costunit_id, $page );
	}
}
