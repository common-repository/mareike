<?php
/**
 * File class-invoicelistforcostunit.php
 *
 * Controller for listing all invoices for a cost unit
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
 *  Controller for listing all invoices for a cost unit
 */
class InvoiceListForCostUnit {

	public const NEW_INVOICE      = 0;
	public const ACCEPTED_INVOICE = 1;
	public const NOPAYOUT_INVOICE = 2;
	public const DENIED_INVOICE   = 3;
	public const EXPORTED_INVOICE = 4;

	/**
	 * Displays invoices for a specific cost unit
	 *
	 * @param int    $invoice_type Filter for the type of the invoices.
	 * @param int    $costunit_id Costunit to display for.
	 * @param string $page Slug of mareike-page.
	 *
	 * @return void
	 */
	public static function execute( int $invoice_type, int $costunit_id, string $page ) {
		if ( '' === $page ) {
			wp_die( 'Invalid skript call.' );
		}
		$cost_unit = CostUnit::Where( array( 'id' => $costunit_id ) )->first();
		switch ( $invoice_type ) {
			case self::NEW_INVOICE:
				$invoices = Invoice::Where(
					array(
						'costunit_id' => $cost_unit->id,
						'status'      => 'NEW',
					)
				)->get();
				$headline = 'Unbearbeitete Abrechnungen';
				break;
			case self::ACCEPTED_INVOICE:
				$invoices = Invoice::Where(
					array(
						'costunit_id' => $cost_unit->id,
						'status'      => 'APPROVED',
					)
				)->get();
				$headline = 'Freigegebene, nichtexportierte Abrechnungen';
				break;
			case self::NOPAYOUT_INVOICE:
				$invoices = Invoice::Where(
					array(
						'costunit_id' => $cost_unit->id,
						'status'      => 'NOPAYOUT',
					)
				)->get();
				$headline = 'Belege ohne Abrechnung / Spenden';
				break;
			case self::DENIED_INVOICE:
				$invoices = Invoice::Where(
					array(
						'costunit_id' => $cost_unit->id,
						'status'      => 'DENIED',
					)
				)->get();
				$headline = 'Abgelehnte Abrechnungen';
				break;
			case self::EXPORTED_INVOICE:
				$invoices = Invoice::Where(
					array(
						'costunit_id' => $cost_unit->id,
						'status'      => 'EXPORTED',
					)
				)->get();
				$headline = 'Exportierte Abrechnungen';
				break;
		}

		require MAREIKE_TEMPLATE_DIR . '/invoices/listinvoices.php';
	}
}
