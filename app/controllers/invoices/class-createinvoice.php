<?php
/**
 * File class-createinvoice.php
 *
 * Controller for creating an invoice
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
use Mareike\App\Requests\GetLfdNumberRequest;
use Mareike\App\Requests\ListDistanceAllowanceRequest;
use Mareike\App\Requests\ListEventsRequest;

/**
 *  Controller for creating an invoice
 */
class CreateInvoice {

	/**
	 * Uploads a receipt for mareike if given to "mareike_receipt_uploaddir" and creates a new invoice
	 *
	 * @return void
	 */
	public static function execute() {
		if ( isset( $_POST['sent'] ) ) {
			if ( isset( $_POST['mareike_nonce'] ) && wp_verify_nonce( sanitize_key( wp_unslash( $_POST['mareike_nonce'] ) ) ) ) {
				if ( isset( $_SESSION['mareike_invoice_created'] ) && true === $_SESSION['mareike_invoice_created'] ) {
					wp_die( esc_html__( 'The URL cannot be requested two times. Please go back to main page and try again.', 'mareike' ) );
				}

				if ( ! isset( $_POST['veranstaltung'] ) ||
				! isset( $_POST['confirmation_radio'] ) ||
					! isset( $_POST['contact_name'] ) ||
					! isset( $_POST['contact_email'] ) ||
					! isset( $_POST['kilometer'] ) ||
					! isset( $_POST['oepnv_amount'] ) ||
					! isset( $_POST['amount'] ) ||
					! isset( $_POST['account_iban'] ) ||
					! isset( $_POST['account_owner'] )
						) {
					wp_die( 'Missing form parameters' );
				}

				$confirmation_payout = sanitize_text_field( wp_unslash( $_POST['confirmation_radio'] ) );
				$cost_unit_id        = (int) sanitize_key( wp_unslash( $_POST['veranstaltung'] ) );

					$cost_unit = CostUnit::Where( array( 'id' => $cost_unit_id ) )->first();
				if ( null === $cost_unit ) {
					return;
				}

				$original_upload_dir = get_option( 'upload_path' );
				update_option( 'upload_path', get_option( 'mareike_receipt_uploaddir', '' ) );

				$uploadedfile = null;
				if ( isset( $_FILES['oepnv_receipt'] ) && is_array( $_FILES['oepnv_receipt'] ) &&
					isset( $_FILES['oepnv_receipt']['name'] ) &&
					isset( $_FILES['oepnv_receipt']['full_path'] ) &&
					isset( $_FILES['oepnv_receipt']['type'] ) &&
					isset( $_FILES['oepnv_receipt']['tmp_name'] ) &&
					isset( $_FILES['oepnv_receipt']['error'] ) &&
					isset( $_FILES['oepnv_receipt']['size'] ) &&
					'' !== $_FILES['oepnv_receipt']['name']
				) {
					$uploadedfile = array(
						'name'      => sanitize_text_field( wp_unslash( $_FILES['oepnv_receipt']['name'] ) ),
						'full_path' => sanitize_text_field( wp_unslash( $_FILES['oepnv_receipt']['full_path'] ) ),
						'type'      => sanitize_text_field( wp_unslash( $_FILES['oepnv_receipt']['type'] ) ),
						'tmp_name'  => sanitize_text_field( wp_unslash( $_FILES['oepnv_receipt']['tmp_name'] ) ),
						'error'     => (int) sanitize_text_field( wp_unslash( $_FILES['oepnv_receipt']['error'] ) ),
						'size'      => (int) sanitize_text_field( wp_unslash( $_FILES['oepnv_receipt']['size'] ) ),
					);
				}

				if ( null === $uploadedfile ) {
					if ( isset( $_FILES['receipt'] ) &&
						is_array( $_FILES['receipt'] ) &&
						isset( $_FILES['receipt']['name'] ) &&
						isset( $_FILES['receipt']['full_path'] ) &&
						isset( $_FILES['receipt']['type'] ) &&
						isset( $_FILES['receipt']['tmp_name'] ) &&
						isset( $_FILES['receipt']['error'] ) &&
						isset( $_FILES['receipt']['size'] ) ) {
						$uploadedfile = array(
							'name'      => sanitize_text_field( wp_unslash( $_FILES['receipt']['name'] ) ),
							'full_path' => sanitize_text_field( wp_unslash( $_FILES['receipt']['full_path'] ) ),
							'type'      => sanitize_text_field( wp_unslash( $_FILES['receipt']['type'] ) ),
							'tmp_name'  => sanitize_text_field( wp_unslash( $_FILES['receipt']['tmp_name'] ) ),
							'error'     => (int) sanitize_text_field( wp_unslash( $_FILES['receipt']['error'] ) ),
							'size'      => (int) sanitize_text_field( wp_unslash( $_FILES['receipt']['size'] ) ),
						);
					}
				}

				if ( '' !== $uploadedfile['name'] && 0 !== $uploadedfile['error'] ) {
					wp_die( 'Error uploading invoice' );
				}

				$upload_overrides = array( 'test_form' => false );

				if ( null !== $uploadedfile && '' !== $uploadedfile['name'] ) {
					$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
				} else {
					$movefile = null;
				}

				update_option( 'upload_path', $original_upload_dir );

				$_SESSION['mareike_invoice_created'] = true;

				$lfd_number        = GetLfdNumberRequest::execute( $cost_unit->id );
				$document_filename = null;
				if ( is_array( $movefile ) && isset( $movefile['file'] ) ) {
					$document_filename = $movefile['file'];
				}

				$people_in_car    = null;
				$transport        = false;
				$amount           = null;
				$travel_direction = null;
				$oepnv_amount     = (float) sanitize_text_field( wp_unslash( $_POST['oepnv_amount'] ) );

				$cost_type = 'Travelling';
				if ( isset( $_POST['kostengruppe'] ) ) {
					$cost_type = sanitize_text_field( wp_unslash( $_POST['kostengruppe'] ) );
				}

				$distance = sanitize_text_field( wp_unslash( $_POST['kilometer'] ) );
				if ( 'Travelling' === $cost_type && '' !== $distance && 0 !== $distance ) {
					if ( ! isset( $_POST['people_in_car'] ) || ! isset( $_POST['reiseweg'] ) ) {
						wp_die( 'Missing form parameters' );
					}
					$people_in_car = (int) sanitize_text_field( wp_unslash( $_POST['people_in_car'] ) );
					--$people_in_car;
					$distance = (int) $distance;

					$transport        = isset( $_POST['materialtransport'] );
					$amount           = $cost_unit->distance_allowance * (int) $distance;
					$travel_direction = sanitize_text_field( wp_unslash( $_POST['reiseweg'] ) );

				}
				if ( 'Travelling' === $cost_type && 0 < $oepnv_amount ) {
					$travel_direction = sanitize_text_field( wp_unslash( $_POST['reiseweg'] ) );
					$amount           = $oepnv_amount;
					$distance         = 0;
					$people_in_car    = 0;
				}

				if ( 'Travelling' !== $cost_type ) {
					$distance = 0;
					$amount   = (float) sanitize_text_field( wp_unslash( $_POST['amount'] ) );
				}

				$invoice_type = 'NEW';
				if ( 'donation' === $confirmation_payout ) {
					$invoice_type  = 'NOPAYOUT';
					$iban          = '';
					$account_owner = '';
				} else {
					$iban          = sanitize_text_field( wp_unslash( $_POST['account_iban'] ) );
					$account_owner = sanitize_text_field( wp_unslash( $_POST['account_owner'] ) );
				}

				$email        = sanitize_text_field( wp_unslash( $_POST['contact_email'] ) );
				$contact_name = sanitize_text_field( wp_unslash( $_POST['contact_name'] ) );
				if ( '' === trim( $email ) ) {
					$email = 'N/A';
				}
				Invoice::Create(
					array(
						'lfd_nummer'         => $lfd_number,
						'contact_name'       => $contact_name,
						'contact_email'      => $email,
						'contact_bank_owner' => $iban,
						'contact_bank_iban'  => $account_owner,
						'costunit_id'        => $cost_unit->id,
						'amount'             => $amount,
						'type'               => $cost_type,
						'document_filename'  => $document_filename,
						'travel_direction'   => $travel_direction,
						'people_in_car'      => $people_in_car,
						'transport'          => $transport,
						'distance'           => $distance,
						'status'             => $invoice_type,
					)
				);

				if ( $cost_unit->mail_on_new ) {
					wp_mail(
						$cost_unit->contact_email,
						/* translators: %s is the name of the cost unit */
						wp_sprintf( __( 'A new invoice for cost center %s was created.', 'mareike' ), $cost_unit->cost_unit_name ),
						mareike_get_new_invoice_mailtext( $cost_unit )
					);
				}
			}
		}
	}
}
