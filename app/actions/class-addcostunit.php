<?php
/**
 * File: class-addcostunit.php
 *
 * @since 2024-07-20
 * @license GPL-3.0-or-later
 *
 * @package mareike/Actions
 */

namespace Mareike\App\Actions;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Mareike\App\Models\CostUnit;

/**
 * Adds a cost unit
 */
class AddCostUnit {

	/**
	 * Adds the cost unit
	 *
	 * @param string      $costunit_name Name of the new cost unit.
	 * @param int         $costunit_type Type of the cost unit (@See CostUnit::* ).
	 * @param string      $costunit_email E-mail address for notifications.
	 * @param float       $distance_allowance Distance allowance for cost_type = Travelling.
	 * @param bool        $notify_on_new   Also send an email when a new invoice is created.
	 * @param string|null $billing_deadline equired for type = CostUnit::Event, Deadline until when invoices are accepted.
	 * @param int|null    $additional_treasurer Normally all users with permission edit_invoices see this unit, you can add one user with permissions to this cost center.
	 *
	 * @return void
	 */
	public static function execute(
		string $costunit_name,
		int $costunit_type,
		string $costunit_email,
		float $distance_allowance,
		bool $notify_on_new,
		?string $billing_deadline = null,
		?int $additional_treasurer = null
	) {
		$existing_test = CostUnit::where(
			array(
				'cost_unit_name' => $costunit_name,
				'allow_new'      => true,
				'archived'       => false,
			)
		)->first();
		if ( null !== $existing_test ) {
			return;
		}

		$creation_array =
			array(
				'cost_unit_type'     => $costunit_type,
				'cost_unit_name'     => $costunit_name,
				'billing_deadline'   => $billing_deadline,
				'distance_allowance' => $distance_allowance,
				'contact_email'      => $costunit_email,
				'mail_on_new'        => $notify_on_new,

			);

		if ( null !== $additional_treasurer ) {
			$creation_array['treasurer_user_id'] = $additional_treasurer;
		}

		CostUnit::create( $creation_array );
	}
}
