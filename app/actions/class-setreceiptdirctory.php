<?php
/**
 * File class-setreceiptdirctory.php
 *
 * Action to update the upload directory
 *
 * @since 2024-07-17
 * @license GPL-3.0-or-later
 *
 * @package mareike/Actions/
 */

namespace Mareike\App\Actions;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Mareike\FileAccess;

/**
 * Action to update the upload directory
 */
class SetReceiptDirctory {

	/**
	 * Saves a single resource by updating the directory and creating a .htaccess file.
	 *
	 * @param string $receipt_directory Absolute path to the new directory.
	 *
	 * @return bool Returns true if the resource was successfully saved, false otherwise.
	 */
	public static function save_single_resource( string $receipt_directory ): bool {
		$file_access = new FileAccess();

		if ( $file_access->is_dir( $receipt_directory ) ) {
			return $file_access->write_htaccess( $receipt_directory );
		}

		if ( ! $file_access->mkdir( $receipt_directory, MAREIKE_WP_FS_CHMOD_DIRECTORY ) ) {
			return false;
		}

		if ( $file_access->write_htaccess( $receipt_directory ) ) {
			return update_option( 'mareike_receipt_uploaddir', $receipt_directory );
		}
	}

	/**
	 * Updates the directory if possible and creates a .htaccess file
	 *
	 * @param string $upload_directory Absolute path to new directory.
	 *
	 * @return bool
	 */
	public static function execute( string $upload_directory ): bool {
		if ( is_multisite() ) {
			$sites = get_sites();

			$no_errors = true;
			foreach ( $sites as $site ) {
				$blog_id = $site->blog_id;
				switch_to_blog( $blog_id );
				$sub_directory = $upload_directory . '/' . $site->blog_id;
				$no_errors     = $no_errors && self::save_single_resource( $sub_directory );
				restore_current_blog();

			}
			return $no_errors;
		} else {
			return self::save_single_resource( $upload_directory );
		}
	}
}
