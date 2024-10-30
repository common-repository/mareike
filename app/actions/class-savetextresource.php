<?php
/**
 * File: class-savetextresource.php
 *
 * @since 2024-08-17
 * @license GPL-3.0-or-later
 *
 * @package mareike/Actions/
 */

namespace Mareike\App\Actions;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Mareike\App\Models\PageText;


/**
 * Class SaveTextResource
 *
 * This class handles the saving of text resources.
 */
class SaveTextResource {

	/**
	 * Executes a given set of operations on possible text resources.
	 *
	 * @param array $possible_textressources An associative array where the keys represent the identifiers of text resources
	 *                                      and the values represent the labels associated with the text resources.
	 *
	 * @return void
	 */
	public static function execute( array $possible_textressources ) {
		if ( ! isset( $_SESSION['mareike_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_SESSION['mareike_nonce'] ) ) ) ) {
			wp_die( 'Invalid Router call' );
		}

		if ( is_multisite() ) {
			$sites = get_sites();

			foreach ( $sites as $site ) {
				$blog_id = $site->blog_id;
				switch_to_blog( $blog_id );
				foreach ( $possible_textressources as $key => $label ) {
					if ( isset( $_REQUEST[ $key ] ) ) {
						$value                       = sanitize_textarea_field( wp_unslash( $_REQUEST[ $key ] ) );
						$page_text                   = PageText::load_by_identifier( $key );
						$page_text->pagetext_content = $value;
						$page_text->save();
					}
				}
				restore_current_blog();

			}
		} else {
			foreach ( $possible_textressources as $key => $label ) {
				if ( isset( $_REQUEST[ $key ] ) ) {
					$value                       = sanitize_textarea_field( wp_unslash( $_REQUEST[ $key ] ) );
					$page_text                   = PageText::load_by_identifier( $key );
					$page_text->pagetext_content = $value;
					$page_text->save();
				}
			}
		}
	}
}
