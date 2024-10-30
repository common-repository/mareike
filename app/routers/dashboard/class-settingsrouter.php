<?php
/**
 * File class-settingsrouter.php
 *
 * Router for all profile action
 *
 * @since 2024-07-15
 * @license GPL-3.0-or-later
 *
 * @package mareike/Routers
 */

namespace Mareike\App\Routers\Dashboard;

use Mareike\App\Actions\SaveTextResource;
use Mareike\App\Actions\SetReceiptDirctory;
use Mareike\App\Controllers\settings\ShowSettings;

if ( session_status() !== PHP_SESSION_ACTIVE ) {
	session_start();
}

/**
 *  Router for all profile action
 */
class SettingsRouter {

	/**
	 * Retrieves an array of text resources.
	 *
	 * This method retrieves an array of text resources used in the application.
	 *
	 * @return array An array of text resources. Each resource is represented by a key-value pair, with the key representing the resource name and the value representing the text resource
	 * itself.
	 */
	public static function get_text_ressources(): array {
		return array(
			'CONFIRMATION_DONATE'            => __( 'Text ressource for ', 'mareike' ) . 'CONFIRMATION_DONATE',
			'CONFIRMATION_PAYMENT'           => __( 'Text ressource for ', 'mareike' ) . 'CONFIRMATION_PAYMENT',
			'INFO_ACCOMMODATION'             => __( 'Text ressource for ', 'mareike' ) . 'INFO_ACCOMMODATION',
			'INFO_CATERING'                  => __( 'Text ressource for ', 'mareike' ) . 'INFO_CATERING',
			'INFO_PROGRAM'                   => __( 'Text ressource for ', 'mareike' ) . 'INFO_PROGRAM',
			'INFO_OTHER'                     => __( 'Text ressource for ', 'mareike' ) . 'INFO_OTHER',
			'INFO_EXPENSE_ACCOUNTING_AMOUNT' => __( 'Text ressource for ', 'mareike' ) . 'INFO_EXPENSE_ACCOUNTING_AMOUNT',
			'INFO_TOUR'                      => __( 'Text ressource for ', 'mareike' ) . 'INFO_TOUR',
			'INFO_RENTAL_CAR'                => __( 'Text ressource for ', 'mareike' ) . 'INFO_RENTAL_CAR',
			'INFO_PEOPLE_IN_CAR'             => __( 'Text ressource for ', 'mareike' ) . 'INFO_PEOPLE_IN_CAR',
			'INFO_TOTAL_DISTANCE'            => __( 'Text ressource for ', 'mareike' ) . 'INFO_TOTAL_DISTANCE',
			'INFO_EXPENSE_ACCOUNTING'        => __( 'Text ressource for ', 'mareike' ) . 'INFO_EXPENSE_ACCOUNTING',
			'INFO_TRAVEL_EXPENSE_ACCOUNTING' => __( 'Text ressource for ', 'mareike' ) . 'INFO_TRAVEL_EXPENSE_ACCOUNTING',
			'INFO_NEW_INVOICE'               => __( 'Text ressource for ', 'mareike' ) . 'INFO_NEW_INVOICE',
		);
	}


	/**
	 * Executes the given code snippet.
	 *
	 * @param bool $comes_from_network_admin Whether the execution is coming from the network admin or not.
	 * @return void
	 */
	public static function execute( bool $comes_from_network_admin = false ) {
		if ( ! isset( $_SESSION['mareike_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_SESSION['mareike_nonce'] ) ) ) ) {
			wp_die( 'Invalid Router call' );
		}

		$possible_textressources = self::get_text_ressources();

		$nonce = sanitize_key( wp_unslash( $_SESSION['mareike_nonce'] ) );
		if ( '' === $nonce ) {
			wp_die( 'Invalid page request sent.' );
		}

		$active_tab = 'tab2';
		if ( isset( $_REQUEST['tab'] ) ) {
			$active_tab = sanitize_key( wp_unslash( $_REQUEST['tab'] ) );
		}

		if ( isset( $_POST['sent'] ) && 'true' === $_POST['sent'] ) {
			switch ( $active_tab ) {
				case 'tab1':
					if ( ! isset( $_POST['receipt_directory'] ) ) {
						wp_die( 'Missing required form params' );
					}

					$receipt_directory_new = sanitize_text_field( wp_unslash( $_POST['receipt_directory'] ) );
					if ( SetReceiptDirctory::execute( $receipt_directory_new ) ) {
						mareike_show_message( __( 'The settings were saved.', 'mareike' ) );
					} else {
						mareike_show_message( __( 'Could not create directory or .htaccess protection', 'mareike' ), false );
					}
					break;

				case 'tab2':
					SaveTextResource::execute( $possible_textressources );

					mareike_show_message( __( 'The text ressources were updated.', 'mareike' ) );
					break;
			}
		}

		ShowSettings::execute( $active_tab, $possible_textressources, $comes_from_network_admin );
	}
}
