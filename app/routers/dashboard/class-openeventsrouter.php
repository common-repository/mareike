<?php
/**
 * File class-openeventsrouter.php
 *
 * Router for all open events action
 *
 * @since 2024-07-15
 * @license GPL-3.0-or-later
 *
 * @package mareike/Routers
 */

namespace Mareike\App\Routers\Dashboard;

use Mareike\App\Actions\CopyAndDenyInvoice;
use Mareike\App\Actions\UpdateInvoice;
use Mareike\App\Controllers\CostUnit\CloseCostUnit;
use Mareike\App\Controllers\CostUnit\EditCostUnit;
use Mareike\App\Controllers\CostUnit\ListItemsController;
use Mareike\App\Controllers\CostUnit\UpdateCostUnit;
use Mareike\App\Controllers\Invoices\AcceptInvoice;
use Mareike\App\Controllers\Invoices\DenyInvoice;
use Mareike\App\Controllers\Invoices\EditInvoice;
use Mareike\App\Controllers\Invoices\InvoiceListForCostUnit;
use Mareike\App\Controllers\Invoices\OpenInvoice;
use Mareike\App\Controllers\Invoices\PrintReceipt;
use Mareike\App\Controllers\Invoices\ReopenInvoice;
use Mareike\App\Models\Invoice;

if ( session_status() !== PHP_SESSION_ACTIVE ) {
	session_start();
}

/**
 *  Router for all open events action
 */
class OpenEventsRouter {

	/**
	 * Action handler of the router
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

		if ( isset( $_REQUEST['update-invoice'] ) ) {
			if (
				! isset( $_REQUEST['update-invoice'] ) ||
				! isset( $_REQUEST['costtypes'] ) ||
				! isset( $_REQUEST['costunit'] ) ||
				! isset( $_REQUEST['reason'] ) ||
				! isset( $_REQUEST['amount'] ) ) {
				wp_die( 'Missing form params for updating invoice.' );
			}

			$invoice_id = (int) sanitize_key( wp_unslash( $_REQUEST['update-invoice'] ) );
			$costtype   = sanitize_key( wp_unslash( $_REQUEST['costtypes'] ) );
			$costunit   = (int) sanitize_key( wp_unslash( $_REQUEST['costunit'] ) );
			$amount     = floatval( str_replace( ',', '.', sanitize_text_field( wp_unslash( $_REQUEST['amount'] ) ) ) );

			$reason     = sanitize_text_field( wp_unslash( $_REQUEST['reason'] ) );
			$crate_copy = isset( $_REQUEST['copy_invoice'] );
			$invoice    = Invoice::load_with_permission_check( $invoice_id );
			if ( $crate_copy ) {
				$invoice_new = Invoice::load_with_permission_check( $invoice_id );
				$invoice_new->create_copy();
				$invoice_new->amount     = $invoice_new->amount - $amount;
				$invoice_new->created_at = $invoice->created_at;
				$invoice_new->save();
			}

			UpdateInvoice::execute( $invoice, $costtype, $costunit, $amount, $reason );
			if ( $crate_copy ) {
				EditInvoice::execute( $invoice_new->id, $page );
				return;
			}
			OpenInvoice::execute( $invoice_id, $page, 'open-invoices' );
			return;
		}

		if ( isset( $_REQUEST['copy-and-deny'] ) ) {
			$invoice_id     = (int) sanitize_key( wp_unslash( $_REQUEST['copy-and-deny'] ) );
			$new_invoice_id = CopyAndDenyInvoice::execute( $invoice_id );
			if ( false === $new_invoice_id ) {
				mareike_show_message( __( 'Error copying invoice', 'mareike' ), false );
				OpenInvoice::execute( $invoice_id, $page, $page );
				return;
			}

			EditInvoice::execute( $new_invoice_id, $page );
			return;
		}

		if ( isset( $_REQUEST['update-cost-unit'] ) ) {
			if ( ! isset( $_REQUEST['costunit-name'] ) ||
				! isset( $_REQUEST['costunit-email'] ) ) {
				wp_die( 'Missing form parameters.' );
			}

			$billing_deadline = null;
			if ( isset( $_REQUEST['costunit-end'] ) ) {
				$billing_deadline = sanitize_text_field( wp_unslash( $_REQUEST['costunit-end'] ) );
			}

			$cost_unit_id    = (int) sanitize_key( wp_unslash( $_REQUEST['update-cost-unit'] ) );
			$cost_unit_name  = sanitize_text_field( wp_unslash( $_REQUEST['costunit-name'] ) );
			$cost_unit_email = sanitize_email( wp_unslash( $_REQUEST['costunit-email'] ) );
			$mail_on_new     = isset( $_REQUEST['notify-on-new'] );

			UpdateCostUnit::execute( $cost_unit_id, $cost_unit_name, $cost_unit_email, $mail_on_new, $billing_deadline );
			exit;
		}

		if ( isset( $_REQUEST['edit-cost-unit'] ) ) {
			$cost_unit_id = (int) sanitize_key( wp_unslash( $_REQUEST['edit-cost-unit'] ) );

			EditCostUnit::execute( $cost_unit_id, $page );
			exit;
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
				wp_die( 'Missing parameter deny_reason' );
			}

			$invoice_id  = (int) sanitize_key( wp_unslash( $_REQUEST['deny-invoice'] ) );
			$deny_reason = sanitize_textarea_field( wp_unslash( $_REQUEST['deny_reason'] ) );

			DenyInvoice::execute( $invoice_id, $deny_reason, $page );
			exit;
		}

		if ( isset( $_REQUEST['close-cost-unit'] ) ) {
			$cost_unit_id = (int) sanitize_key( wp_unslash( $_REQUEST['close-cost-unit'] ) );

			CloseCostUnit::execute( $cost_unit_id, $page );
			exit;
		}

		if ( isset( $_REQUEST['reopen-invoice'] ) ) {
			$invoice_id = (int) sanitize_key( wp_unslash( $_REQUEST['reopen-invoice'] ) );

			ReopenInvoice::execute( $invoice_id, $page );
			exit;
		}

		if ( isset( $_REQUEST['accept-invoice'] ) ) {
			$invoice_id = (int) sanitize_key( wp_unslash( $_REQUEST['accept-invoice'] ) );

			$overview = null;
			if ( isset( $_REQUEST['back-to'] ) ) {
				$overview = sanitize_key( wp_unslash( $_REQUEST['back-to'] ) );
			}
			AcceptInvoice::execute( $invoice_id, $page, $overview );
			exit;
		}

		if ( isset( $_REQUEST['show'] ) ) {
			if ( ! isset( $_REQUEST['display-cost-unit'] ) ) {
				wp_die( 'Missing parameter display-cost-unit' );
			}
			$mode         = (int) sanitize_key( wp_unslash( $_REQUEST['show'] ) );
			$cost_unit_id = (int) sanitize_key( wp_unslash( $_REQUEST['display-cost-unit'] ) );
			InvoiceListForCostUnit::execute( $mode, $cost_unit_id, $page );
			exit;
		}

		ListItemsController::execute( ListItemsController::OPEN_EVENTS, $page, $nonce );
	}
}
