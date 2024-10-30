<?php
/**
 * File: invoicedeniedmail.php
 *
 * Library that returns the mailtext for a denied invoice
 *
 * @since 2024-07-14
 * @license GPL-3.0-or-later
 *
 * @package mareike/Libs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns mailtext: An invoice was decnied
 *
 * @param string $recipient Name of the recipient.
 * @param string $amount Amount of the invoice.
 * @param string $event_name Name of the costunit.
 * @param string $denied_by NAME OF the person who has denied the invoice.
 * @param string $denied_by_email email for questions.
 * @param string $reason The reason why the invoice was denied.
 *
 * @return string
 */
function mareike_get_invoice_denied_mail_text(
	string $recipient,
	string $amount,
	string $event_name,
	string $denied_by,
	string $denied_by_email,
	string $reason
): string {
	return __( 'Hello', 'mareike' ) . ' ' . $recipient . PHP_EOL .
		wp_sprintf(
			/* translators: %1$s is the amount of the invoice, %2$s is the name of the cost center */
			__( 'Unfortunately, your request for a refund of %1$s was for the event "%2$s" has been rejected', 'mareike' ),
			$amount,
			$event_name,
		) . PHP_EOL .
		wp_sprintf(
		/* translators: %1$s is the name of the treasurer, %2$s is the contact mail address */
			__( 'Please contact %1$s (email: %2$s) in order to to clarify the matter.', 'mareike' ),
			$denied_by,
			$denied_by_email,
		) . PHP_EOL . PHP_EOL .
		__( 'Reason:', 'mareike' ) . PHP_EOL .
		$reason;
}
