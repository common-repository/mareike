<?php
/**
 * File class-exportinvoices.php
 *
 * Controller for exporting cost units
 *
 * @since 2024-07-14
 * @license GPL-3.0-or-later
 *
 * @package mareike/Controllers/CostUnit
 */

namespace Mareike\App\Controllers\CostUnit;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Mareike\App\Models\CostUnit;
use Mareike\App\Requests\GetCsvDataRequest;
use Mareike\FileAccess;

/**
 *  Controller for exporting cost units
 */
class ExportInvoices {

	/**
	 * Generates and downloads CSV - file ogf all invoices having status = APPROVED ||status  NOPAYOUT
	 *
	 * @param int $cost_unit_id Id of the costunit.
	 *
	 * @return void
	 */
	public static function execute( int $cost_unit_id ) {
		$costunit = CostUnit::where( 'id', $cost_unit_id )->first();

		$csv_data = GetCsvDataRequest::execute( $costunit );
		header( 'Content-Type: text/csv' );
		header( 'Content-Disposition: attachment; filename="' . $costunit->cost_unit_name . '_' . current_time( 'Y-m-d' ) . '.csv"' );

		$file_access = new FileAccess();

		$file_access->put_contents( get_option( 'mareike_receipt_uploaddir' ) . '/export.csv', $csv_data, MAREIKE_WP_FS_CHMOD_FILE );
		$file_access->output_file( get_option( 'mareike_receipt_uploaddir' ) . '/export.csv' );
		$file_access->delete( get_option( 'mareike_receipt_uploaddir' ) . '/export.csv' );

		exit;
	}
}
