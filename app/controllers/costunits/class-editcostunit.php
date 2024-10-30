<?php
/**
 * File class-editcostunit.php
 *
 * Controller for editing cost units
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

/**
 *  Controller for editing cost units
 */
class EditCostUnit {

	/**
	 * Displays a form to modify a cost unit
	 *
	 * @param int    $cost_unit_id Id of the costunit.
	 * @param string $page current mareike page slug.
	 *
	 * @return void
	 */
	public static function execute( int $cost_unit_id, string $page ) {
		if ( '' === $page ) {
			wp_die( 'Invalid skript call.' );
		}
		$cost_unit = CostUnit::where( 'id', $cost_unit_id )->first();
		require MAREIKE_TEMPLATE_DIR . '/costunits/updateitem.php';
	}
}
