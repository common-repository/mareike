<?php
/**
 * File: class-updateinvoice.php
 *
 * Updates an existing invoice
 *
 * @since 2024-07-19
 * @license GPL-3.0-or-later
 *
 * @package mareike/Actions/
 */

namespace Mareike\App\Actions;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Mareike\App\Models\Invoice;

/**
 *  Updates an existing invoice
 */
class UpdateInvoice {
	/**
	 *  Updates an existing invoice
	 *
	 * @param Invoice $invoice Invoice to modify.
	 * @param string  $costtype the cost type to save.
	 * @param int     $costunit The cost unit to save.
	 * @param float   $amount The amount to save.
	 * @param string  $resaon Additional string printed on invoice if costtype or amount changes.
	 *
	 * @return void
	 */
	public static function execute(
		Invoice $invoice,
		string $costtype,
		int $costunit,
		float $amount,
		string $resaon
	) {
		$changes = array();

		if ( $invoice->type !== $costtype ) {
			$change_line = esc_html__( 'Type of invoice', 'mareike' ) . ' ';
			switch ( $invoice->type ) {
				case 'Travelling':
					$change_line .= esc_html__( 'Travelling', 'mareike' );
					break;

				case 'Program':
					$change_line .= esc_html__( 'Program', 'mareike' );
					break;

				case 'Other':
					$change_line .= esc_html__( 'Other', 'mareike' );
					break;

				case 'Accommodation':
					$change_line .= esc_html__( 'Accommodation', 'mareike' );
					break;

				case 'Catering':
					$change_line .= esc_html__( 'Catering', 'mareike' );
					break;
			}
			$change_line .= ' ' . esc_html__( 'changed to', 'mareike' ) . ' ';

			$cost_type_new = ucfirst( $costtype );
			switch ( $cost_type_new ) {
				case 'Travelling':
					$change_line .= esc_html__( 'Travelling', 'mareike' ) . '.';
					break;

				case 'Program':
					$change_line .= esc_html__( 'Program', 'mareike' ) . '.';
					break;

				case 'Other':
					$change_line .= esc_html__( 'Other', 'mareike' ) . '.';
					break;

				case 'Accommodation':
					$change_line .= esc_html__( 'Accommodation', 'mareike' ) . '.';
					break;

				case 'Catering':
					$change_line .= esc_html__( 'Catering', 'mareike' ) . '.';
					break;
			}

			$changes[]     = $change_line;
			$invoice->type = $cost_type_new;
		}

		if ( $amount !== $invoice->amount ) {
			$changes[] = esc_html__( 'Total amount', 'mareike' ) . ' '
							. esc_html( mareike_format_amount( $invoice->amount ) )
							. ' ' . esc_html__( 'changed to', 'mareike' ) . ' '
							. esc_html( mareike_format_amount( $amount ) ) . '.';

			$invoice->amount = $amount;
		}

		if ( count( $changes ) > 0 ) {
			$invoice->changes = implode( '<br />', $changes ) .
								'<br />' . esc_html__( 'Reason', 'mareike' ) . ': '
				. $resaon;
		}

		$now                  = new \DateTime();
		$invoice->status      = 'APPROVED';
		$invoice->approved_by = get_current_user_id();
		$invoice->approved_on = $now->format( 'Y-m-d H:i:s' );
		$invoice->costunit_id = $costunit;
		$invoice->save();
	}
}
