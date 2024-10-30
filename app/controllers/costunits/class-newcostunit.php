<?php
/**
 * File class-newcostunit.php
 *
 * Controller for printing  the form for new cost units
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

/**
 *  Controller for printing  the form for new cost units
 */
class NewCostUnit {

	/**
	 * Displaysa form for creating a new cost unit
	 *
	 * @return void
	 */
	public static function execute() {
		$plugin_data = get_plugin_data( MAREIKE_PLUGIN_STARTUP_FILE );
		wp_enqueue_script(
			'mareike-new-costunit',
			MAREIKE_PLUGIN_URL . '/assets/javascripts/mareike-new-cost-unit.js',
			array(),
			$plugin_data['Version'],
			true
		);
		require MAREIKE_TEMPLATE_DIR . '/costunits/newitem.php';
	}
}
