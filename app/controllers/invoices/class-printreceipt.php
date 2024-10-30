<?php
/**
 * File class-printreceipt.php
 *
 * Controller for printing the receipt of an invoice
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

use Mareike\App\Models\Invoice;
use Mareike\FileAccess;

if ( session_status() !== PHP_SESSION_ACTIVE ) {
	session_start();
}

/**
 * Controller for printing the receipt of an invoice
 */
class PrintReceipt {

	/**
	 * Prints the PDF file of the receipt and triggers a download
	 *
	 * @param int $invoice_id Id of invoice you want to prin t the receipt for.
	 *
	 * @return void
	 */
	public static function execute( int $invoice_id ) {
		$invoice = Invoice::Where( array( 'id' => $invoice_id ) )->first();

		header( 'Content-Description: File Transfer' );
		header( 'Content-Type: application/pdf' );
		header( 'Content-Disposition: attachment; filename="' . basename( $invoice->document_filename ) . '"' );
		header( 'Expires: 0' );
		header( 'Cache-Control: must-revalidate' );
		header( 'Pragma: public' );
		header( 'Content-Length: ' . filesize( $invoice->document_filename ) );

		$file_reader = new FileAccess();
		$file_reader->output_file( $invoice->document_filename );
		exit;
	}
}
