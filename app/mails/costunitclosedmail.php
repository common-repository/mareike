<?php
/**
 * File: costunitclosedmail.php
 *
 * Library that returns the mailtext for autoclosed cost units
 *
 * @since 2024-07-14
 * @license GPL-3.0-or-later
 *
 * @package mareike/Libs
 */

use Mareike\App\Models\CostUnit;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns mailtext: A cost unit was autoclosed
 *
 * @param CostUnit $cost_unit The cost unit.
 *
 * @return string
 */
function mareike_get_cost_unit_closed_mail_text( CostUnit $cost_unit ): string {
	return __( 'Hello', 'mareike' ) . ',' . PHP_EOL .
		wp_sprintf(
		/* translators: %s is the name of the cost center */
			__( 'The cost center %s was closed today because the expiration date for submitting documents was reached.', 'mareike' ),
			$cost_unit->cost_unit_name
		) . PHP_EOL .
		__( 'You can now start processing the invoices.', 'mareike' );
}
