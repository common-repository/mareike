<?php
/**
 * File: uninstall.php
 *
 * DESCRIPTION
 *
 * @since 2024-07-19
 * @license GPL-3.0-or-later
 *
 * @package mareike/
 */

use Mareike\App\Models\CostUnit;
use Mareike\App\Models\Invoice;
use Mareike\App\Models\PageText;
use Mareike\FileAccess;

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

global $wpdb;

$file_access = new FileAccess();
$file_access->rmdir( get_option( 'mareike_receipt_uploaddir' ) );


$options = array(
	'mareike_receipt_uploaddir',
);

$page_text = new PageText();
$page_text->uninstall();

$cost_unit = new CostUnit();
$cost_unit->uninstall();

$invoice = new Invoice();
$invoice->uninstall();


$user_meta_keys = array(
	'account_owner',
	'iban',
);

foreach ( $options as $option ) {
	delete_option( $option );
}

$user_ids = get_users( array( 'fields' => 'ID' ) );
foreach ( $user_ids as $user_id ) {
	foreach ( $user_meta_keys as $meta_key ) {
		delete_user_meta( $user_id, $meta_key );
	}
}
