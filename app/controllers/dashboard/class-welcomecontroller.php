<?php
/**
 * File: class-hwelcomecontroller.php
 *
 * Contains controller for the welcome page
 *
 * @since 2024-07-18
 * @license GPL-3.0-or-later
 *
 * @package mareike/Controllers/Dashboard
 */

namespace Mareike\App\Controllers\dashboard;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Contains controller for the welcome page
 */
class WelcomeController {
	/**
	 * Renders the welcome page
	 *
	 * @return void
	 */
	public static function execute() {
		require MAREIKE_TEMPLATE_DIR . '/dashboard/quicksearch.php';
		require MAREIKE_TEMPLATE_DIR . '/dashboard/welcome.php';
	}
}
