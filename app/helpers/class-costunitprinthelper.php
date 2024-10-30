<?php
/**
 * File: class-costunitprinthelper.php
 *
 * Helper library: Returns invoice lists and the printable headline
 *
 * @since 2024-07-14
 * @license GPL-3.0-or-later
 *
 * @package mareike/Libs
 */

namespace Mareike\App\Helpers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Mareike\App\Models\CostUnit;
use Mareike\App\Requests\ListEventsRequest;

/**
 * Helper library: Returns invoice lists and the printable headline
 */
class CostUnitPrintHelper {

	/**
	 * Prefills the eventlist with filtered data and also returns the corresponding  display_type-string
	 *
	 * @return array
	 */
	public static function get_active_events(): array {
		return array(
			'events'       => ListEventsRequest::execute(),
			'display_type' => __( 'Current events', 'mareike' ),
		);
	}

	/**
	 * Prefills the eventlist with filtered data and also returns the corresponding  display_type-string
	 *
	 * @return array
	 */
	public static function get_closed_events(): array {
		return array(
			'events'       => ListEventsRequest::execute( false, false ),
			'display_type' => __( 'Closed events', 'mareike' ),
		);
	}

	/**
	 * Prefills the eventlist with filtered data and also returns the corresponding  display_type-string
	 *
	 * @return array
	 */
	public static function get_archived_events(): array {
		return array(
			'events'       => ListEventsRequest::execute( false, true ),
			'display_type' => __( 'Archived events', 'mareike' ),
		);
	}

	/**
	 * Prefills the eventlist with filtered data and also returns the corresponding  display_type-string
	 *
	 * @return array
	 */
	public static function get_active_jobs(): array {
		return array(
			'events'       => ListEventsRequest::execute( true, false, CostUnit::COST_UNIT_TYPE_JOB ),
			'display_type' => __( 'Current jobs', 'mareike' ),
		);
	}
}
