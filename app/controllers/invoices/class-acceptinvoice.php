<?php
/**
 * File class-acceptinvoice.php
 *
 * Controller for accepting an invoice
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
 * Controller for accepting an invoice
 */
class AcceptInvoice {

	/**
	 * Sets the status of a specific invoice to APPROVED and triggers a download
	 *
	 * @param int    $invoice_id Id of the invoice, you want to accept.
	 * @param string $page current mareike page slug.
	 * @param string $overview Link for Back-button.
	 *
	 * @return void
	 */
	public static function execute( int $invoice_id, string $page, ?string $overview ) {
		if ( '' === $page || '' === $overview ) {
			wp_die( 'Invalid skript call.' );
		}
		$invoice     = Invoice::Where( array( 'id' => $invoice_id ) )->first();
		$cost_unit   = CostUnit::Where( array( 'id' => $invoice->costunit_id ) )->first();
		$plugin_data = get_plugin_data( MAREIKE_PLUGIN_STARTUP_FILE );
		if ( isset( $_SESSION['mareike_request_sent'] ) ) {
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
		$_SESSION['mareike_request_sent'] = true;

		$now = new \DateTime();

		$invoice->status      = 'APPROVED';
		$invoice->approved_on = $now->format( 'Y-m-d H:i:s' );
		$invoice->approved_by = get_current_user_id();

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
