<?php
/**
 * Contains all cronjob related functions
 *
 * @package mareike/Setup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'cron_schedules', 'mareike_add_cron_interval_daily' );

/**
 * Adds a cron interval every 24 hours
 *
 * @param array $schedules already existing schedules.
 *
 * @return mixed
 */
function mareike_add_cron_interval_daily( $schedules ) {
	$schedules['mareike_daily'] = array(
		'interval' => 86400,
		'display'  => esc_html__( 'Every 24 hours', 'mareike' ),
	);
	return $schedules;
}

/**
 * Registers the cronjobs for mareike
 *
 * @return void
 */
function mareike_register_cron() {
	if ( ! wp_next_scheduled( 'mareike/costunit/autoclose' ) ) {
		$timestamp = strtotime( 'Tomorrow 02:15' );
		wp_schedule_event( $timestamp, 'mareike_daily', 'mareike/costunit/autoclose' );
	}
}

mareike_register_cron();
add_action( 'mareike/costunit/autoclose', array( '\Mareike\App\Controllers\CostUnit\AutocloseCostUnit', 'execute' ) );
