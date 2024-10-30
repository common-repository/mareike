<?php
/**
 * File: class-pagetextreplacementhelper.php
 *
 * Helper library: Reads Elements from Database to replace given keys by content
 *
 * @since 2024-07-14
 * @license GPL-3.0-or-later
 *
 * @package mareike/Libs
 */

namespace Mareike\App\Helpers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Mareike\App\Models\PageText;

/**
 * Helper library: Reads Elements from Database to replace given keys by content
 */
class PageTextReplacementHelper {

	/**
	 * Returns the value of a special text key from DB or the key itself, if not found in DB
	 *
	 * @param string $key Key to return its value.
	 *
	 * @return string
	 */
	public static function get_single_text( string $key ): string {
		$page_text = PageText::load_by_identifier( $key );
		return $page_text->pagetext_content;
	}
}
