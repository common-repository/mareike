<?php
/**
 * File: newinvoicemail.php
 *
 * Library that returns the mailtext for a new created invoice
 *
 * @since 2024-07-14
 * @license GPL-3.0-or-later
 *
 * @package mareike/Libs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Mareike\App\Models\CostUnit;
use Mareike\App\Requests\GetCostUnitLinkRequest;

/**
 * Returns mailtext: A new invoice was created
 *
 * @param CostUnit $costunit Cost unit where the invoice was created.
 *
 * @return string
 */
function mareike_get_new_invoice_mailtext( CostUnit $costunit ): string {
	$url = GetCostUnitLinkRequest::execute( $costunit );
	return __( 'Hello', 'mareike' ) . ',' . PHP_EOL .
		wp_sprintf(
			/* translators: %s is the name of the cost center */
			__( 'A new invoice for cost center %s was created.', 'mareike' ),
			$costunit->cost_unit_name
		) . PHP_EOL .
		wp_sprintf(
		/* translators: %s is the direct url to the cost center */
			__( 'Please log in to %s in order to to check it.', 'mareike' ),
			$url
		);
}
