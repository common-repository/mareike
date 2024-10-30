<?php
/**
 * File: class-getcsvdatarequest.php
 *
 * Request that converts APPROVED invoices and DONATIONS of a cost unit to a csv file
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
 *  Request that converts APPROVED invoices and DONATIONS of a cost unit to a csv file
 */
class GetCsvDataRequest {

	/**
	 * Returns the CSV-Date for a cost unit for manual preparing bank transcations
	 *
	 * @param CostUnit $costunit Cost unit you want to create a  download.
	 *
	 * @return string
	 */
	public static function execute( CostUnit $costunit ): string {
		$csv_array   = array();
		$csv_array[] = implode(
			',',
			array(
				'"' . __( 'Invoice number', 'mareike' ) . '"',
				'"' . __( 'Date of receipt', 'mareike' ) . '"',
				'"' . __( 'Reason for payment', 'mareike' ) . '"',
				'"' . __( 'Name', 'mareike' ) . '"',
				'"' . __( 'IBAN', 'mareike' ) . '"',
				'"' . __( 'Amount', 'mareike' ) . '"',
				'"' . __( 'Billing URL', 'mareike' ) . '"',
			)
		);

		$invoices = Invoice::where(
			function ( $query ) {
				$query->where( 'status', 'APPROVED' )
				->orwhere( 'status', 'NOPAYOUT' );
			}
		)->where( 'costunit_id', $costunit->id )->orderBy( 'lfd_nummer', 'asc' )->get();

		foreach ( $invoices as $invoice ) {
			$csv_array[] =
				'"' . $invoice->lfd_nummer . '",' .
				'"' . \DateTime::createFromFormat( 'Y-m-d H:i:s', (string) $invoice->created_at )->format( 'd.m.Y H:i:s' ) . '",' .
				'"' . $invoice->type . '",' .
				'"' . trim( $invoice->contact_bank_owner ) . '",' .
				'"' . ( 'APPROVED' === $invoice->status ? trim( $invoice->contact_bank_iban ) : 'NOPAYOUT' ) . '",' .
				'"' . mareike_format_amount( $invoice->amount ) . '",' .
				'"' . GetInvoiceLinkRequest::execute( $invoice->id ) . '"';

			if ( 'NOPAYOUT' === $invoice->status ) {
				$invoice->comment = 'NOPAYOUT';
			}

			$invoice->status = 'EXPORTED';
			$invoice->save();
		}

		return implode( PHP_EOL, $csv_array );
	}
}
