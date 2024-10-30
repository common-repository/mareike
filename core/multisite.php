<?php
/**
 * File: multisite.php
 *
 * @since 2024-08-17
 * @license GPL-3.0-or-later
 *
 * @package mareike/Setup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Mareike\App\Actions\SetReceiptDirctory;
use Mareike\App\Models\CostUnit;
use Mareike\App\Models\Invoice;
use Mareike\App\Models\PageText;
use Mareike\App\Routers\Dashboard\SettingsRouter;

/**
 * This function sets up a new blog with default options and resources.
 *
 * @param object $new_site The object representing the new blog.
 * @param array  $args Additional arguments (unused).
 *
 * @return void
 */
function mareike_new_blog_setup( $new_site, $args ) {
	$blog_id         = $new_site->id;
	$text_ressources = SettingsRouter::get_text_ressources();
	$default_options = array();
	foreach ( $text_ressources as $key => $value ) {
		$page_text               = PageText::load_by_identifier( $key );
		$default_options[ $key ] = $page_text->pagetext_content;
	}

	$upload_dir = get_option( 'mareike_receipt_uploaddir', '' );
	switch_to_blog( $blog_id );

	$page_text = new PageText();
	$page_text->setup();

	$cost_unit = new CostUnit();
	$cost_unit->setup();

	$invoice = new Invoice();
	$invoice->setup();

	foreach ( $default_options as $key => $value ) {
		$page_text                   = PageText::load_by_identifier( $key );
		$page_text->pagetext_content = $value;
		$page_text->save();
	}

	SetReceiptDirctory::save_single_resource( $upload_dir );

	restore_current_blog();
}
