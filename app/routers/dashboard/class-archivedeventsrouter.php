<?php
/**
 * File class-archivedeventsrouter.php
 *
 * Router for all archived events action
 *
 * @since 2024-07-15
 * @license GPL-3.0-or-later
 *
 * @package mareike/Routers
 */

namespace Mareike\App\Routers\Dashboard;

use Mareike\App\Controllers\CostUnit\ArchiveCostUnit;
use Mareike\App\Controllers\CostUnit\CloseCostUnit;
use Mareike\App\Controllers\CostUnit\ListItemsController;
use Mareike\App\Controllers\CostUnit\ReopenCostUnit;
use Mareike\App\Controllers\Invoices\AcceptInvoice;
use Mareike\App\Controllers\Invoices\DenyInvoice;
use Mareike\App\Controllers\Invoices\InvoiceListForCostUnit;
use Mareike\App\Controllers\Invoices\OpenInvoice;
use Mareike\App\Controllers\Invoices\PrintReceipt;
use Mareike\App\Controllers\Invoices\ReopenInvoice;

if ( session_status() !== PHP_SESSION_ACTIVE ) {
	session_start();
}

/**
 *  Router for all archived events action
 */
class ArchivedEventsRouter {

	/**
	 * Handler for routing action
	 *
	 * @return void
	 */
	public static function execute() {
		if ( ! isset( $_SESSION['mareike_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_SESSION['mareike_nonce'] ) ) ) ) {
			wp_die( 'Invalid Router call' );
		}

		$nonce = sanitize_key( wp_unslash( $_SESSION['mareike_nonce'] ) );

		$page = null;
		if ( isset( $_REQUEST['page'] ) ) {
			$page = sanitize_key( wp_unslash( $_REQUEST['page'] ) );
		}

		if ( isset( $_REQUEST['open-invoice'] ) ) {
			$invoice_id = (int) sanitize_key( wp_unslash( $_REQUEST['open-invoice'] ) );
			OpenInvoice::execute( $invoice_id, $page, $page );
			exit;
		}

		if ( isset( $_REQUEST['receipt-for-invoice'] ) ) {
			$invoice_id = (int) sanitize_key( wp_unslash( $_REQUEST['receipt-for-invoice'] ) );
			PrintReceipt::execute( $invoice_id );
			exit;
		}

		if ( isset( $_REQUEST['deny-invoice'] ) ) {
			if ( ! isset( $_REQUEST['deny_reason'] ) ) {
				wp_die( 'Missing param deny_reason' );
			}
			$cost_unit_id = (int) sanitize_key( wp_unslash( $_REQUEST['deny-invoice'] ) );
			$deny_reason  = (int) sanitize_key( wp_unslash( $_REQUEST['deny_reason'] ) );

			DenyInvoice::execute( $cost_unit_id, $deny_reason, $page );
			exit;
		}

		if ( isset( $_REQUEST['reopen-cost-unit'] ) ) {
			$cost_unit_id = (int) sanitize_key( wp_unslash( $_REQUEST['reopen-cost-unit'] ) );

			ReopenCostUnit::execute( $cost_unit_id, $page );
			exit;
		}

		if ( isset( $_REQUEST['archive-cost-unit'] ) ) {
			$cost_unit_id = (int) sanitize_key( wp_unslash( $_REQUEST['archive-cost-unit'] ) );

			ArchiveCostUnit::execute( $cost_unit_id, $page );
			exit;
		}

		if ( isset( $_REQUEST['reopen-invoice'] ) ) {
			$invoice_id = (int) sanitize_key( wp_unslash( $_REQUEST['reopen-invoice'] ) );

			ReopenInvoice::execute( $invoice_id, $page );
			exit;
		}

		if ( isset( $_REQUEST['accept-invoice'] ) ) {
			$invoice_id = (int) sanitize_key( wp_unslash( $_REQUEST['accept-invoice'] ) );
			$overview   = null;
			if ( isset( $_REQUEST['back-to'] ) ) {
				$overview = sanitize_key( wp_unslash( $_REQUEST['back-to'] ) );
			}

			AcceptInvoice::execute( $invoice_id, $page, $overview );
			exit;
		}

		if ( isset( $_REQUEST['show'] ) ) {
			if ( ! isset( $_REQUEST['show'] ) || ! isset( $_REQUEST['display-cost-unit'] ) ) {
				wp_die( 'Invalid URL call' );
			}

			$mode         = (int) sanitize_key( wp_unslash( $_REQUEST['show'] ) );
			$cost_unit_id = (int) sanitize_key( wp_unslash( $_REQUEST['display-cost-unit'] ) );
			InvoiceListForCostUnit::execute( $mode, $cost_unit_id, $page );
			exit;
		}

		ListItemsController::execute( ListItemsController::ARCHIVED_EVENTS, $page, $nonce );
	}
}
