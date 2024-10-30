<?php
/**
 * File: amount.php
 *
 * Library for converting a float value to an amount
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
 * Formats a float number to an amount
 *
 * @param float  $value The value of the new amount.
 * @param string $currency The currency that should be appended the amount.
 *
 * @return string
 */
function mareike_format_amount( float $value, string $currency = ' Euro' ): string {
	$value = number_format( round( $value, 2 ), 2, ',', '.' );
	return (string) $value . $currency;
}
