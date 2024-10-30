<?php
/**
 * Contains the code for the frontend setup
 *
 * @package  mareike/Setup
 */

/**
 * Installs a "Capture invoice" page in frontend
 *
 * @return void
 */
function mareike_setup_page() {
	$page_name   = __( 'Capture invoice', 'mareike' );
	$page_exists = get_page_by_path( $page_name, OBJECT, 'page' );

	if ( ! $page_exists ) {
		$page_id = wp_insert_post(
			array(
				'post_title'   => $page_name,
				'post_content' =>
					'<!-- wp:shortcode -->' . PHP_EOL .
					'[mareike-new-invoice]' . PHP_EOL .
					'<!-- /wp:shortcode -->',
				'post_status'  => 'publish',
				'post_type'    => 'page',
			)
		);
	}

	if ( get_option( 'permalink_structure' ) === '' ) {
		update_option( 'permalink_structure', '/%postname%/' );
		flush_rewrite_rules();
	}
}
