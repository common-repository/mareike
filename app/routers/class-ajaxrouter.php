<?php
/**
 * File class-ajaxrouter.php
 *
 * Central router for all ajax requests.
 *
 * @since 2024-07-15
 * @license GPL-3.0-or-later
 *
 * @package mareike/Routers
 */

namespace Mareike\App\Routers;

use Controllers\ActionPrintInvoice;
use Mareike\App\Controllers\CostUnit\ExportInvoices;
use Mareike\App\Controllers\Invoices\PrintInvoice;
use Mareike\App\Controllers\Invoices\PrintReceipt;

if ( session_status() !== PHP_SESSION_ACTIVE ) {
	session_start();
}

/**
 * Common router for all ajax requests
 */
class AjaxRouter {
	/**
	 * Handles the ajax requests
	 *
	 * @return void
	 */
	public static function execute() {
		if ( ! isset( $_SESSION['mareike_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_SESSION['mareike_nonce'] ) ) ) ) {
			wp_die( 'Missing nonce value' );
		}

		$nonce = sanitize_key( wp_unslash( $_SESSION['mareike_nonce'] ) );

		if ( ! isset( $_REQUEST['method'] ) ) {
			wp_die( 'Invalid Router call' );
		}

		switch ( $_REQUEST['method'] ) {
			case 'show-receipt':
				if ( ! isset( $_REQUEST['invoice-id'] ) ) {
					wp_die( 'Missing parameter invoice-id' );
				}

				$invoice_id = (int) sanitize_key( wp_unslash( $_REQUEST['invoice-id'] ) );
				PrintReceipt::execute( $invoice_id );
				break;

			case 'print-invoice':
				if ( ! isset( $_REQUEST['invoice-id'] ) ) {
					wp_die( 'Missing parameter invoice-id' );
				}

				$invoice_id = (int) sanitize_key( wp_unslash( $_REQUEST['invoice-id'] ) );
				PrintInvoice::execute( $invoice_id );
				break;

			case 'export-invoices':
				if ( ! isset( $_REQUEST['costunit-id'] ) ) {
					wp_die( 'Missing parameter export-invoices' );
				}

				$cost_unit_id = (int) sanitize_key( wp_unslash( $_REQUEST['costunit-id'] ) );
				ExportInvoices::execute( $cost_unit_id );
				break;
		}
	}
}
