<?php
/**
 * File: interfaces.php
 *
 * Peovides interfaces throug add filters for other plugins
 *
 * @since 2024-07-20
 * @license GPL-3.0-or-later
 *
 * @package mareike/Interfaces
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Mareike\App\Actions\AddCostUnit;

/**
 * Filtetr to add a new cost center
 *
 * @param string      $costcenter_name Name of the cost center.
 * @param int         $cost_center_type Type of the Cost Center (1 = Type_Event | 2 = Type_LongTermJob).
 * @param string      $cost_center_email Mail address for notifications.
 * @param float       $distance_allowance Distance allowance for travel costs accounting.
 * @param bool        $notify_on_new_invoices Also notify on new invoice.
 * @param string|null $billing_deadline Required for type = Type_Event, Deadline until when invoices are accepted.
 * @param int|null    $additional_treasurer_id Normally all users with permission edit_invoices see this unit, you can add one user with permissions to this cost center.
 *
 * @return void
 */
function mareike_add_cost_center(
	string $costcenter_name,
	int $cost_center_type,
	string $cost_center_email,
	float $distance_allowance,
	bool $notify_on_new_invoices,
	?string $billing_deadline,
	?int $additional_treasurer_id
) {
	AddCostUnit::execute(
		$costcenter_name,
		$cost_center_type,
		$cost_center_email,
		$distance_allowance,
		$notify_on_new_invoices,
		$billing_deadline,
		$additional_treasurer_id
	);
}


add_filter(
	'mareike_add_cost_center',
	'mareike_add_cost_center',
	10,
	7
);
