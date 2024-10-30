<?php
/**
 * File class-openinvoice.php
 *
 * Controller for opening an invoice
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
 * Controller for opening an invoice
 */
class OpenInvoice {

	/**
	 * Displays a specific invoice
	 *
	 * @param int         $invoice_id ID of the invoice to display.
	 * @param string|null $page Content of param $page for creating links.
	 * @param string|null $overview The target for a "back" - link.
	 *
	 * @return void
	 */
	public static function execute( int $invoice_id, ?string $page = null, ?string $overview = null ) {
		if ( '' === $page || '' === $overview ) {
			wp_die( 'Invalid skript call' );
		}
		unset( $_SESSION['mareike_request_sent'] );

		$invoice   = Invoice::Where( array( 'id' => $invoice_id ) )->first();
		$cost_unit = CostUnit::Where( array( 'id' => $invoice->costunit_id ) )->first();

		require MAREIKE_TEMPLATE_DIR . '/invoices/overview.php';
	}
}
