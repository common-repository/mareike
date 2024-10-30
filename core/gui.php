<?php
/**
 * Basic GUI functions
 *
 * @package mareike/Setup
 */

use Mareike\App\Controllers\profile\CheckProfile;
use Mareike\App\Routers\AjaxRouter;

/**
 * Loads Stylesheets and JavaScript to page
 *
 * @return void
 */
function mareike_enqueue_custom_scripts() {
	$plugin_data = get_plugin_data( MAREIKE_PLUGIN_STARTUP_FILE );

	wp_enqueue_style(
		'mareike-dashboard-style',
		MAREIKE_PLUGIN_URL . '/assets/stylesheets/dashboard.css',
		array(),
		$plugin_data['Version']
	);

	wp_enqueue_script(
		'mareike-ajax',
		MAREIKE_PLUGIN_URL . '/assets/javascripts/ajax.js',
		array(),
		$plugin_data['Version'],
		array( 'in_footer' => false )
	);

	wp_enqueue_script(
		'mareike-invoice-overview',
		MAREIKE_PLUGIN_URL . '/assets/javascripts/mareike-invoice-overview.js',
		array(),
		$plugin_data['Version'],
		array( 'in_footer' => false )
	);

	wp_enqueue_script(
		'mareike-seetings',
		MAREIKE_PLUGIN_URL . '/assets/javascripts/mareike-settings.js',
		array(),
		$plugin_data['Version'],
		array( 'in_footer' => false )
	);

	wp_enqueue_script(
		'mareike-deny-invoice',
		MAREIKE_PLUGIN_URL . '/assets/javascripts/mareike-deny-invoice.js',
		array(),
		$plugin_data['Version'],
		true
	);

	if ( isset( $_SESSION['mareike_nonce'] ) && wp_verify_nonce( sanitize_key( wp_unslash( $_SESSION['mareike_nonce'] ) ) ) ) {
		if ( isset( $_REQUEST['accept-invoice'] ) ) {
			$invoice_id = (int) sanitize_key( wp_unslash( $_REQUEST['accept-invoice'] ) );
			wp_enqueue_script(
				'mareike-print-invoice',
				MAREIKE_PLUGIN_URL . '/assets/javascripts/mareike-deny-invoice.js',
				array(),
				$plugin_data['Version'],
				true
			);
			wp_localize_script( 'mareike-print-invoice', 'mareike_data', array( 'invoice_id' => $invoice_id ) );
		}
	}

	CheckProfile::execute();
}

/**
 * Initiates the Ajax component
 *
 * @return void
 */
function mareike_load_ajax_content() {
	AjaxRouter::execute();
	exit;
}

/**
 * Initialize plugin for localization.
 *
 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
 *
 * Locales found in:
 *     - WP_LANG_DIR/rank-math/mareike-LOCALE.mo
 *     - WP_LANG_DIR/plugins/mareike-LOCALE.mo
 */
function mareike_localization_setup() {
	$locale = get_user_locale();

    $locale = apply_filters( 'plugin_locale', $locale, MAREIKE_PLUGIN_SLUG ); // phpcs:ignore

	unload_textdomain( MAREIKE_PLUGIN_SLUG );
	if ( false === load_textdomain( MAREIKE_PLUGIN_SLUG, WP_LANG_DIR . '/plugins/' . MAREIKE_PLUGIN_SLUG . '-' . $locale . '.mo' ) ) {
		load_textdomain( MAREIKE_PLUGIN_SLUG, WP_LANG_DIR . '/' . MAREIKE_PLUGIN_SLUG . '/' . MAREIKE_PLUGIN_SLUG . '-' . $locale . '.mo' );
	}

	load_textdomain( MAREIKE_PLUGIN_SLUG, MAREIKE_PLUGIN_DIR . '/languages/' . MAREIKE_PLUGIN_SLUG . '-' . $locale . '.mo', $locale );
}
