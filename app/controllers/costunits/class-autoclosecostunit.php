<?php
/**
 * File class-autoclosecostunit.php
 *
 * Controller for autoclosing cost units
 *
 * @since 2024-07-14
 * @license GPL-3.0-or-later
 *
 * @package mareike/Controllers/CostUnit
 */

namespace Mareike\App\Controllers\CostUnit;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Mareike\App\Models\CostUnit;
use Mareike\App\Routers\Dashboard\OpenEventsRouter;
use Mareike\FileAccess;

/**
 * Controller for autoclosing cost units
 */
class AutocloseCostUnit {

	/**
	 * Triggered by cronjob and sets all cost units to reject new invoices if the billing deadline is exceeded
	 *
	 * @return void
	 */
	public static function execute() {
		foreach ( CostUnit::where(
			array(
				'cost_unit_type' => CostUnit::COST_UNIT_TYPE_EVENT,
				'allow_new'      => true,
				'archived'       => false,
			)
		)->get() as $cost_unit ) {
			$billing_deadline = \DateTime::createFromFormat( 'Y-m-d', $cost_unit->billing_deadline );
			if ( $billing_deadline->getTimestamp() < time() ) {
				$cost_unit->allow_new = false;
				$cost_unit->save();
				wp_mail(
					$cost_unit->contact_email,
					/* translators: %s is used for name of the cost center. */
					wp_sprintf( __( 'The cost center %s was closed', 'mareike' ), $cost_unit->cost_unit_name ),
					mareike_get_cost_unit_closed_mail_text( $cost_unit )
				);
			}
		}

		if ( is_multisite() ) {
			$sites = get_sites();

			foreach ( $sites as $site ) {
				$blog_id = $site->blog_id;
				switch_to_blog( $blog_id );
				foreach ( CostUnit::where(
					array(
						'cost_unit_type' => CostUnit::COST_UNIT_TYPE_EVENT,
						'allow_new'      => true,
						'archived'       => false,
					)
				)->get() as $cost_unit ) {
					$billing_deadline = \DateTime::createFromFormat( 'Y-m-d', $cost_unit->billing_deadline );
					if ( $billing_deadline->getTimestamp() < time() ) {
						$cost_unit->allow_new = false;
						$cost_unit->save();
						wp_mail(
							$cost_unit->contact_email,
							/* translators: %s is used for name of the cost center. */
							wp_sprintf( __( 'The cost center %s was closed', 'mareike' ), $cost_unit->cost_unit_name ),
							mareike_get_cost_unit_closed_mail_text( $cost_unit )
						);
					}
				}

				restore_current_blog();

			}
		}
	}
}
