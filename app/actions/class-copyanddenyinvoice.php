<?php
/**
 * File: class-copyanddenyinvoice.php
 *
 * @since 2024-07-18
 * @license GPL-3.0-or-later
 *
 * @package mareike/Actions
 */

namespace Mareike\App\Actions;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Mareike\App\Models\Invoice;

/**
 * Copys and deny an invoice
 */
class CopyAndDenyInvoice {
	/**
	 * Creates a copy of an invoice and denies the original invoice.
	 *
	 * @param int $invoice_id Id of original invoice.
	 *
	 * @return int|false
	 */
	public static function execute( int $invoice_id ): int|false {
		$invoice_original = Invoice::load_with_permission_check( $invoice_id );
		if ( null === $invoice_original ) {
			return false;
		}

		if ( '' === $invoice_original ) {
			return false;
		}

		$invoice_copy = Invoice::load_with_permission_check( $invoice_id );
		$invoice_copy->create_copy();

		$invoice_copy->created_at = $invoice_original->created_at;
		$invoice_copy->save();

		$invoice_original->status        = 'DENIED';
		$invoice_original->denied_reason = __( 'Correction in Invoice number', 'mareike' ) . ' #' . $invoice_copy->lfd_nummer;
		$invoice_original->denied_by     = get_current_user_id();

		$invoice_original->save();
		return $invoice_copy->id;
	}
}
