<?php
/**
 * File class-printinvoice.php
 *
 * Controller for printing an invoice
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

use Mareike\App\Helpers\PdfCreationHelper;
use Mareike\App\Models\Invoice;
use Mareike\App\Requests\ContvertInvoiceToStringRequest;
use Mareike\FileAccess;

/**
 * Controller for printing an invoice
 */
class PrintInvoice {

	/**
	 * Converts an invoice to PDF and triggers the download. If a receipt is attended, it will be attended in the PDF file
	 *
	 * @param int $invoice_id ID of invoice you want to print.
	 *
	 * @return void
	 */
	public static function execute( int $invoice_id ) {
		$invoice      = Invoice::Where( array( 'id' => $invoice_id ) )->first();
		$invoice_text = ContvertInvoiceToStringRequest::execute( $invoice );
		$file         = PdfCreationHelper::create_abrechnung_pdf( $invoice_text, $invoice->lfd_nummer, $invoice->document_filename );

		header( 'Content-Type: application/pdf' );
		header( 'Content-Disposition: attachment; filename="' . basename( $file ) . '"' );
		header( 'Expires: 0' );
		header( 'Cache-Control: must-revalidate' );
		header( 'Pragma: public' );
		header( 'Content-Length: ' . filesize( $file ) );

		$file_reader = new FileAccess();
		$file_reader->output_file( $file );
		$file_reader->delete( $file );

		exit;
	}
}
