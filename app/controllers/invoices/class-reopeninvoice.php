<?php
/**
 * File class-reopeninvoice.php
 *
 * Controller for reopening an invoice
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
 *  Controller for reopening an invoice
 */
class ReopenInvoice {

	/**
	 * Sets the status of an invoice with the status DENIED to NEW or NOPAYOUT, depending on the comment
	 *
	 * @param int    $invoice_id Id of the invoice, you want to accept.
	 * @param string $page current mareike page slug.
	 *
	 * @return void
	 */
	public static function execute( int $invoice_id, string $page ) {
		if ( '' === $page ) {
			wp_die( 'Invalid skript call.' );
		}

		$overview    = InvoiceListForCostUnit::NEW_INVOICE;
		$invoice     = Invoice::Where( array( 'id' => $invoice_id ) )->first();
		$cost_unit   = CostUnit::Where( array( 'id' => $invoice->costunit_id ) )->first();
		$plugin_data = get_plugin_data( MAREIKE_PLUGIN_STARTUP_FILE );

		if ( isset( $_SESSION['mareike_reopen_request_sent'] ) ) {
			wp_enqueue_script(
				'mareike-overview',
				MAREIKE_PLUGIN_URL . '/assets/javascripts/mareike-invoice-overview.js',
				array(),
				$plugin_data['Version'],
				true
			);

			require MAREIKE_TEMPLATE_DIR . '/invoices/overview.php';
			exit;
		}
		$_SESSION['mareike_reopen__sent'] = true;

		$invoice->status        = 'NEW';
		$invoice->denied_by     = null;
		$invoice->denied_reason = null;

		if ( 'NOPAYOUT' === $invoice->comment ) {
			$invoice->status = 'NOPAYOUT';
		}

		$invoice->save();
		wp_enqueue_script(
			'mareike-overview',
			MAREIKE_PLUGIN_URL . '/assets/javascripts/mareike-invoice-overview.js',
			array(),
			$plugin_data['Version'],
			true
		);

		require MAREIKE_TEMPLATE_DIR . '/invoices/overview.php';
	}
}
