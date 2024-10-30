<?php
/**
 * File class-dashboardrouter.php
 *
 * Main router for all dashboard requests
 *
 * @since 2024-07-15
 * @license GPL-3.0-or-later
 *
 * @package mareike/Routers
 */

namespace Mareike\App\Routers;

use Mareike\App\Controllers\dashboard\WelcomeController;
use Mareike\App\Controllers\Invoices\NewInvoice;
use Mareike\App\Controllers\Invoices\OpenInvoice;
use Mareike\App\Models\Invoice;
use Mareike\App\Requests\FindInvoiceByContinuousNumber;
use Mareike\App\Routers\Dashboard\ArchivedEventsRouter;
use Mareike\App\Routers\Dashboard\ClosedEventsRouter;
use Mareike\App\Routers\Dashboard\NewEventRouter;
use Mareike\App\Routers\Dashboard\OpenEventsRouter;
use Mareike\App\Routers\Dashboard\OpenJobsRouter;
use Mareike\App\Routers\Dashboard\ProfileRouter;
use Mareike\App\Routers\Dashboard\SettingsRouter;

if ( session_status() !== PHP_SESSION_ACTIVE ) {
	session_start();
}

/**
 * The controller of the router
 */
class DashboardRouter {

	/**
	 * Executes a multisite operation if a valid nonce is present in the session.
	 *
	 * This method checks if the 'mareike_nonce' key is set in the $_SESSION array and verifies its validity using the wp_verify_nonce() function. If the nonce is not present or is invalid
	 * , it terminates the execution by calling wp_die() with a message indicating an invalid router call.
	 *
	 * If the nonce is valid, it retrieves the sanitized version of the nonce using sanitize_key() and wp_unslash(). Then, it calls the execute() method of the SettingsRouter class, passing
	 * the boolean value `true` as an argument.
	 *
	 * @return void
	 */
	public static function execute_multisite() {

		if ( ! isset( $_SESSION['mareike_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_SESSION['mareike_nonce'] ) ) ) ) {

			wp_die( 'Invalid Router call' );
		}

		$nonce = sanitize_key( wp_unslash( $_SESSION['mareike_nonce'] ) );
		SettingsRouter::execute( true );
	}


	/**
	 * Detects the mareike slug and calls the corresponding router
	 *
	 * @return void
	 */
	public static function execute() {
		$plugin_data = get_plugin_data( MAREIKE_PLUGIN_STARTUP_FILE );

		wp_enqueue_script(
			'mareike-datatyp-check',
			MAREIKE_PLUGIN_URL . '/assets/javascripts/mareike-datatype-check.js',
			array(),
			$plugin_data['Version'],
			true
		);

		if ( ! isset( $_SESSION['mareike_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_SESSION['mareike_nonce'] ) ) ) ) {
			wp_die( 'Invalid Router call' );
		}

		$nonce = sanitize_key( wp_unslash( $_SESSION['mareike_nonce'] ) );

		if ( isset( $_REQUEST['page'] ) ) {
			$page = sanitize_key( $_REQUEST['page'] );
			switch ( $page ) {
				case 'mareike-new-invoice':
					NewInvoice::execute_from_dashboard();
					break;

				case 'mareike-settings':
					SettingsRouter::execute();
					break;

				case 'mareike-profile':
					ProfileRouter::execute();
					break;

				case 'mareike-current-events':
					OpenEventsRouter::execute();
					break;

				case 'mareike-current-jobs':
					OpenJobsRouter::execute();
					break;

				case 'mareike-closed-events':
					ClosedEventsRouter::execute();
					break;

				case 'mareike-archived-events':
					ArchivedEventsRouter::execute();
					break;

				case 'mareike-create-event':
					NewEventRouter::execute();
					break;

				case 'mareike-get-invoice':
					if (
						isset( $_REQUEST['search'] ) &&
						isset( $_REQUEST['event'] ) &&
						isset( $_REQUEST['continuous_cost_number'] ) ) {
						$costunit_id      = (int) sanitize_text_field( wp_unslash( $_REQUEST['event'] ) );
						$continuos_number = (int) sanitize_text_field( wp_unslash( $_REQUEST['continuous_cost_number'] ) );
						$invoice          = FindInvoiceByContinuousNumber::execute( $costunit_id, $continuos_number );
						if ( null !== $invoice ) {
							OpenInvoice::execute( $invoice->id, 'mareike-get-invoice', 'no-return' );
							return;
						}

						ddd( $invoice );
					}

					if ( isset( $_REQUEST['invoice-id'] ) ) {
						$invoice_id = (int) sanitize_text_field( wp_unslash( $_REQUEST['invoice-id'] ) );
						OpenInvoice::execute( $invoice_id, 'mareike-get-invoice', 'no-return' );
					} else {
						WelcomeController::execute();
					}
					break;
			}

			return;
		}
		wp_die( 'Invalid URL given' );
	}
}
