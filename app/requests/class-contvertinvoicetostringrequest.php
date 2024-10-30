<?php
/**
 * File: class-contvertinvoicetostringrequest.php
 *
 * Request that converts an invoice to a printable page
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

use Mareike\App\Helpers\PageTextReplacementHelper;
use Mareike\App\Models\CostUnit;
use Mareike\App\Models\Invoice;

/**
 *  Request that converts an invoice to a printable page
 */
class ContvertInvoiceToStringRequest {

	/**
	 * Returns the rendered html output
	 *
	 * @param Invoice $invoice Invoice to be rendered.
	 *
	 * @return string
	 */
	public static function execute( Invoice $invoice ): string {

		$costunit = CostUnit::where( 'id', $invoice->costunit_id )->first();

		$output  = '<html><body style="margin-left: 20mm; margin-top: 17mm">';
		$output .= '<h3>' . esc_html__( 'Type of invoice', 'mareike' ) . ' ';

		switch ( $invoice->type ) {
			case 'Travelling':
				$output .= esc_html__( 'Travelling', 'mareike' );
				break;

			case 'Program':
				$output .= esc_html__( 'Program', 'mareike' );
				break;

			case 'Other':
				$output .= esc_html__( 'Other', 'mareike' );
				break;

			case 'Accommodation':
				$output .= esc_html__( 'Accommodation', 'mareike' );
				break;

			case 'Catering':
				$output .= esc_html__( 'Catering', 'mareike' );
				break;
		}

		$output .= '</h3><br /><br />';
		$output .= '<table style="width: 100%;"><tr><td>' . esc_html__( 'Invoice number', 'mareike' ) . ':</td><td>' . $invoice->lfd_nummer . '</td></tr>';
		if ( 'N/A' !== $invoice->contact_name ) {
			$output .= '<tr><td>' . esc_html__( 'Name', 'mareike' ) . ':</td><td>' . $invoice->contact_name . '</td></tr>';
		}
		if ( 'N/A' !== $invoice->contact_email ) {
			$output .= '<tr><td>' . esc_html__( 'E-mail address', 'mareike' ) . ':</td><td>' . $invoice->contact_email . '</td></tr>';
		}
		$output .= '<tr><td>' . esc_html__( 'Cost center name', 'mareike' ) . ':</td><td>' . $costunit->cost_unit_name . '</td></tr>';
		$output .= '<tr><td>' . esc_html__( 'Reason for payment', 'mareike' ) . ':</td><td>';
		switch ( $invoice->type ) {
			case 'Travelling':
				$output .= esc_html__( 'Travelling', 'mareike' );
				break;

			case 'Program':
				$output .= esc_html__( 'Program', 'mareike' );
				break;

			case 'Other':
				$output .= esc_html__( 'Other', 'mareike' );
				break;

			case 'Accommodation':
				$output .= esc_html__( 'Accommodation', 'mareike' );
				break;

			case 'Catering':
				$output .= esc_html__( 'Catering', 'mareike' );
				break;
		}
		$output .= '</td></tr>';

		if ( 'Travelling' === $invoice->type && ( null !== $invoice->distance && 0 !== $invoice->distance ) ) {
			$output .= '<tr><td>' . esc_html__( 'Tour', 'mareike' ) . ':</td><td>' . $invoice->travel_direction . '</td></tr>';
			$output .= '<tr><td>' . esc_html__( 'Driven distance', 'mareike' ) . ':</td><td>' . $invoice->distance . 'km x ' . $costunit->distance_allowance . ' Euro / km</td></tr>';
			$output .= '<tr><td>' . esc_html__( 'Material transportation', 'mareike' ) . ':</td><td>' . ( $invoice->material ? esc_html__( 'Yes' ) : esc_html__( 'No' ) ) . '</td></tr>';

			$output .= '<tr><td>' . esc_html__( 'Passengers', 'mareike' ) . ':</td><td>' . $invoice->people_in_car . '</td></tr>';
		}

		if ( ( null === $invoice->distance || 0 === $invoice->distance ) && 'Travelling' === $invoice->type ) {
			$output .= '<tr><td>' . esc_html__( 'Costs for public transport', 'mareike' ) . ':</td><td>' . mareike_format_amount( $invoice->amount ) . '</td></tr>';
		}

		if ( 'Travelling' !== $invoice->type ) {
			$output .= '<tr><td>' . esc_html__( 'Costs for expenses', 'mareike' ) . ':</td><td>' . mareike_format_amount( $invoice->amount ) . '</td></tr>';
		}

		$user        = get_user_by( 'id', $invoice->approved_by );
		$approved_by = trim( $user->first_name . ' ' . $user->last_name );
		if ( '' === $approved_by ) {
			$approved_by = $user->user_email;
		}

		$output .= '<tr style="font-weight: bold;"><td style="border-bottom-width: 1px; border-bottom-style: double;">' . esc_html__( 'Total amount', 'mareike' ) . ':</td><td style="border-bottom-width: 1px; border-bottom-style: double;">' . $invoice->amount . ' Euro</td></tr>';
		$output .= '<tr><td colspan="2"><br /><br /></td></tr>';
		if ( 'NOPAYOUT' !== $invoice->status ) {
			$output .= '<tr><td colspan="2">' . PageTextReplacementHelper::get_single_text( 'CONFIRMATION_PAYMENT' ) . '<br /><br /></td></tr>';
		} else {
			$output .= '<tr><td colspan="2">' . PageTextReplacementHelper::get_single_text( 'CONFIRMATION_DONATE' ) . '<br /><br /></td></tr>';
		}

		if ( 'NOPAYOUT' !== $invoice->status ) {
			$output .= '<tr><td>' . esc_html__( 'Account Owner', 'mareike' ) . ':</td><td>' . $invoice->contact_bank_owner . '</td></tr>';
			$output .= '<tr><td>' . esc_html__( 'IBAN', 'mareike' ) . ':</td><td>' . $invoice->contact_bank_iban . '</td></tr>';
			$output .= '<tr><td colspan="2"><br /><br /></td></tr>';
		}
		$output .= '<tr><td>' . esc_html__( 'Receipt submitted digitally on', 'mareike' ) . ':</td><td>' . \DateTime::createFromFormat( 'Y-m-d H:i:s', (string) $invoice->created_at )->format( 'd.m.Y H:i' ) . '</td></tr>';
		if ( 'NOPAYOUT' !== $invoice->status ) {
			$output .= '<tr><td>' . esc_html__( 'Receipt confirmed on', 'mareike' ) . ':</td><td>' . \DateTime::createFromFormat( 'Y-m-d H:i:s', (string) $invoice->approved_on )->format( 'd.m.Y H:i' ) . '</td></tr>';
			$output .= '<tr><td>' . esc_html__( 'Receipt confirmed by', 'mareike' ) . ':</td><td>' . $approved_by . '</td></tr></table>';
		}

		if ( null !== $invoice->changes ) {
			$output .= '<p>' . $invoice->changes . '</p>';
		}

		$output .= '</body></html>';
		return $output;
	}
}
