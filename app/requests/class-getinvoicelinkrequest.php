<?php
/**
 * File: class-getinvoicelinkrequest.php
 *
 * Request that returns a direct link to a new invoice
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
 * Request that returns a direct link to a new invoice
 */
class GetInvoiceLinkRequest {

	/**
	 * Returns a direct link for opening an invoice
	 *
	 * @param int $invoice_id ID of the ínvoice you want to open.
	 *
	 * @return string
	 */
	public static function execute( int $invoice_id ): string {
		return admin_url( 'admin.php?page=mareike-get-invoice&invoice-id=' . $invoice_id );
	}
}
