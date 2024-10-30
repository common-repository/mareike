<?php
/**
 * Contains installation code which should be run only once
 *
 * @package mareike/Setup
 */

use Mareike\App\Actions\SetReceiptDirctory;
use Mareike\App\Models\CostUnit;
use Mareike\App\Models\Invoice;
use Mareike\App\Models\PageText;

/**
 * Installs (if required) the objects as database
 *
 * @return void
 */
function mareike_setup_objects() {
	if ( null === get_option( 'mareike_receipt_uploaddir', null ) ) {
		$create_receipt_upload_dir = WP_CONTENT_DIR . '/mareike-receipts';
		SetReceiptDirctory::execute( $create_receipt_upload_dir );
	}

	$page_text = new PageText();
	$page_text->setup();

	$cost_unit = new CostUnit();
	$cost_unit->setup();

	$invoice = new Invoice();
	$invoice->setup();
}
