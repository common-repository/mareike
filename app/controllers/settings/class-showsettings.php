<?php
/**
 * File class-showsettings.php
 *
 * Contains controller for profile page
 *
 * @since 2024-07-15
 * @license GPL-3.0-or-later
 *
 * @package mareike/Controllers/Profile
 */

namespace Mareike\App\Controllers\settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Mareike\App\Actions\SetReceiptDirctory;
use Mareike\App\Models\CostUnit;
use Mareike\App\Models\Invoice;
use Mareike\App\Models\PageText;

/**
 *  Controller for profile page
 */
class ShowSettings {


	/**
	 * Execute method.
	 *
	 * This method performs certain actions based on the provided parameters. It determines the URL of the admin page based on whether the site is multisite or not, validates the script
	 * call, includes the tab header file, and includes the appropriate form file based on the active tab.
	 *
	 * @param string $active_tab The active tab.
	 * @param array  $possible_textressources The possible text resources.
	 * @param bool   $comes_from_network_admin Whether the script call comes from the network admin. Default is false.
	 *
	 * @return void
	 */
	public static function execute( string $active_tab, array $possible_textressources, bool $comes_from_network_admin = false ) {
		$page = admin_url( 'options-general.php' );
		if ( is_multisite() ) {
			$page = network_admin_url( 'settings.php' );
		}

		if ( null === $comes_from_network_admin ) {
			wp_die( 'Invalid script call' );
		}

		require MAREIKE_TEMPLATE_DIR . '/settings/tab-header.php';

		switch ( $active_tab ) {
			case 'tab1':
				$receipt_directory = get_option( 'mareike_receipt_uploaddir', null );
				require MAREIKE_TEMPLATE_DIR . '/settings/settings-form.php';
				break;

			case 'tab2':
				if ( count( $possible_textressources ) === 0 ) {
					wp_die( 'Something went wrong :(' );
				}

				require MAREIKE_TEMPLATE_DIR . '/settings/textresources-form.php';
				break;

		}
	}
}
