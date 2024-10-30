<?php
/**
 * File: class-editinvoice.php
 * *
 *
 * @since 2024-07-18
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
 * Class to print the form for editing an existing invoice
 */
class EditInvoice {
	/**
	 * Prints the edit form
	 *
	 * @param int    $invoice_id Id of the invoice to edit.
	 * @param string $page Page slug of current request.
	 *
	 * @return void
	 */
	public static function execute( int $invoice_id, string $page ) {
		if ( '' === $page ) {
			wp_die( 'Invalid skript call' );
		}

		$plugin_data = get_plugin_data( MAREIKE_PLUGIN_STARTUP_FILE );
		wp_enqueue_script(
			'mareike-new-invoice',
			MAREIKE_PLUGIN_URL . '/assets/javascripts/mareike.js',
			array(),
			$plugin_data['Version'],
			true
		);

		$invoice    = Invoice::load_with_permission_check( $invoice_id );
		$cost_unit  = CostUnit::load_with_permission_check( $invoice->costunit_id );
		$cost_types = array( 'Travelling', 'Program', 'Accommodation', 'Catering', 'Other' );
		require MAREIKE_TEMPLATE_DIR . '/invoices/editinvoice.php';
	}
}
