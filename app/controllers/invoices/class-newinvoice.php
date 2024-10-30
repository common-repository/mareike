<?php
/**
 * File class-newinvoice.php
 *
 * Controller for adding a new invoice
 *
 * @since 2024-07-15
 * @license GPL-3.0-or-later
 *
 * @package mareike/Controllers/Invoice
 */

namespace Mareike\App\Controllers\Invoices;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Mareike\App\Models\CostUnit;
use Mareike\App\Requests\ListDistanceAllowanceRequest;
use Mareike\App\Requests\ListEventsRequest;

/**
 *  Controller for adding a new invoice
 */
class NewInvoice {

	/**
	 * Special endpoint for requesrs from public web, loads more scripts and returns the rendered new invoice page
	 *
	 * @return false|string
	 */
	public static function execute_from_public() {
		$plugin_data = get_plugin_data( MAREIKE_PLUGIN_STARTUP_FILE );

		ob_start();
		$events = ListEventsRequest::execute( true, false, CostUnit::COST_UNIT_TYPE_EVENT, true );
		$jobs   = ListEventsRequest::execute( true, false, CostUnit::COST_UNIT_TYPE_JOB, true );

		if ( count( $events ) === 0 && count( $jobs ) === 0 ) {
			require MAREIKE_TEMPLATE_DIR . '/newinvoice-form/no-cost-units.php';
			return ob_get_clean();
		}

		wp_enqueue_style(
			'mareike-common-css',
			MAREIKE_PLUGIN_URL . '/assets/common.css',
			array(),
			$plugin_data['Version']
		);
		wp_enqueue_style(
			'mareike-public-css',
			MAREIKE_PLUGIN_URL . '/assets/public.css',
			array(),
			$plugin_data['Version']
		);

		wp_enqueue_script(
			'mareike-datatyp-check',
			MAREIKE_PLUGIN_URL . '/assets/javascripts/mareike-datatype-check.js',
			array(),
			$plugin_data['Version'],
			true
		);

		self::render();
		return ob_get_clean();
	}

	/**
	 * Special endpoint for requests from /wp-admin, loads more scripts and displays the rendered new invoice page
	 *
	 * @return void
	 */
	public static function execute_from_dashboard() {
		$events = ListEventsRequest::execute( true, false, CostUnit::COST_UNIT_TYPE_EVENT, true );
		$jobs   = ListEventsRequest::execute( true, false, CostUnit::COST_UNIT_TYPE_JOB, true );

		if ( count( $events ) === 0 && count( $jobs ) === 0 ) {
			require MAREIKE_TEMPLATE_DIR . '/newinvoice-form/no-cost-units.php';
			return;
		}

		$plugin_data = get_plugin_data( MAREIKE_PLUGIN_STARTUP_FILE );
		wp_enqueue_style(
			'mareike-common-css',
			MAREIKE_PLUGIN_URL . '/assets/common.css',
			array(),
			$plugin_data['Version']
		);
		wp_enqueue_style(
			'mareike-internal-css',
			MAREIKE_PLUGIN_URL . '/assets/internal.css',
			array(),
			$plugin_data['Version']
		);
		self::render();
	}

	/**
	 * Renders the outputs
	 *
	 * @return string|void
	 */
	public static function render() {
		$events = ListEventsRequest::execute( true, false, CostUnit::COST_UNIT_TYPE_EVENT, true );
		$jobs   = ListEventsRequest::execute( true, false, CostUnit::COST_UNIT_TYPE_JOB, true );

		$plugin_data = get_plugin_data( MAREIKE_PLUGIN_STARTUP_FILE );
		wp_enqueue_script(
			'mareike-new-invoice',
			MAREIKE_PLUGIN_URL . '/assets/javascripts/mareike.js',
			array(),
			$plugin_data['Version'],
			true
		);

		wp_localize_script(
			'mareike-new-invoice',
			'mareikeData',
			array(
				'kilometerpauschale' => ListDistanceAllowanceRequest::execute(),
				'max_size_mb'        => 16,
			)
		);
		if ( isset( $_POST['mareike_nonce'] ) && wp_verify_nonce( sanitize_key( wp_unslash( $_POST['mareike_nonce'] ) ) ) && isset( $_POST['sent'] ) ) {
			require MAREIKE_TEMPLATE_DIR . '/newinvoice-form/done.php';
			return;
		}

		unset( $_SESSION['mareike_invoice_created'] );

		$name          = '';
		$email         = '';
		$account_owner = '';
		$iban          = '';

		if ( is_user_logged_in() ) {
			$user          = wp_get_current_user();
			$name          = $user->first_name . ' ' . $user->last_name;
			$email         = $user->user_email;
			$account_owner = get_the_author_meta( 'account_owner', $user->ID );
			$iban          = get_the_author_meta( 'iban', $user->ID );
			if ( '' === $account_owner ) {
				$account_owner = $name;
			}
		}

		require MAREIKE_TEMPLATE_DIR . '/newinvoice-form/index.php';
		return '';
	}
}
