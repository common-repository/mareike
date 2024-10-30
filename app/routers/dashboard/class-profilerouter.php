<?php
/**
 * File class-profilerouter.php
 *
 * Router for all profile action
 *
 * @since 2024-07-15
 * @license GPL-3.0-or-later
 *
 * @package mareike/Routers
 */

namespace Mareike\App\Routers\Dashboard;

use Mareike\App\Controllers\CostUnit\ArchiveCostUnit;
use Mareike\App\Controllers\CostUnit\CloseCostUnit;
use Mareike\App\Controllers\CostUnit\ListItemsController;
use Mareike\App\Controllers\CostUnit\ReopenCostUnit;
use Mareike\App\Controllers\Invoices\AcceptInvoice;
use Mareike\App\Controllers\Invoices\DenyInvoice;
use Mareike\App\Controllers\Invoices\InvoiceListForCostUnit;
use Mareike\App\Controllers\Invoices\OpenInvoice;
use Mareike\App\Controllers\Invoices\PrintReceipt;
use Mareike\App\Controllers\Invoices\ReopenInvoice;
use Mareike\App\Controllers\profile\ExtendProfile;
use Mareike\App\Controllers\profile\UpdateProfile;

if ( session_status() !== PHP_SESSION_ACTIVE ) {
	session_start();
}

/**
 *  Router for all profile action
 */
class ProfileRouter {

	/**
	 * Starts routing
	 *
	 * @return void
	 */
	public static function execute() {
		if ( ! isset( $_SESSION['mareike_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_SESSION['mareike_nonce'] ) ) ) ) {
			wp_die( 'Invalid Router call' );
		}

		$nonce = sanitize_key( wp_unslash( $_SESSION['mareike_nonce'] ) );

		if ( isset( $_POST['sent'] ) ) {
			if (
				! isset( $_POST['first_name'] ) ||
				! isset( $_POST['last_name'] ) ||
				! isset( $_POST['email'] ) ||
				! isset( $_POST['iban'] ) ||
				! isset( $_POST['account_owner'] )
			) {
				wp_die( 'Missing form arguments' );
			}

			$firstname     = sanitize_text_field( wp_unslash( $_POST['first_name'] ) );
			$lastname      = sanitize_text_field( wp_unslash( $_POST['last_name'] ) );
			$email         = sanitize_text_field( wp_unslash( $_POST['email'] ) );
			$iban          = sanitize_text_field( wp_unslash( $_POST['iban'] ) );
			$account_owner = sanitize_text_field( wp_unslash( $_POST['account_owner'] ) );

			UpdateProfile::execute( $firstname, $lastname, $email, $iban, $account_owner );
			exit;
		}

		ExtendProfile::execute();
	}
}
