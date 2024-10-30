<?php
/**
 * File class-fileaccess.php
 *
 * Helper Class for file access
 *
 * @since 2024-07-16
 * @license GPL-3.0-or-later
 *
 * @package mareike/Setup
 */

declare(strict_types=1);

namespace Mareike;

/**
 * Helper Class for file access
 */
class FileAccess extends \WP_Filesystem_Direct {

	/**
	 * Constructor of class
	 *
	 * @param array $arg Permissions for new files  / directories.
	 */
	public function __construct( $arg = null ) {
	}

	/**
	 * Prohibits access to a directory throug .htaccess
	 *
	 * @param string $directory name of the directory you want to protect.
	 *
	 * @return bool
	 */
	public function write_htaccess( string $directory ): bool {
		$data = 'Order Allow,Deny
Deny from all';

		if ( $this->htaccess_contains( $data, $directory ) ) {
			return true;
		}
		$htaccess_file  = $this->read_htaccess_from_directory( $directory );
		$htaccess_file .= PHP_EOL . $data . PHP_EOL;
		return $this->put_contents( $directory . '/.htaccess', $htaccess_file, MAREIKE_WP_FS_CHMOD_FILE );
	}


	/**
	 * Returns if .htaccess file  specified a special sting
	 *
	 * @param string $needle String to look for.
	 * @param string $directory directory to look for file.
	 *
	 * @return bool
	 */
	public function htaccess_contains( string $needle, string $directory ): bool {
		return str_contains( $this->read_htaccess_from_directory( $directory ), $needle );
	}

	/**
	 * Returns content of a .htaccess file
	 *
	 * @param string $directory directory to look for file.
	 *
	 * @return string
	 */
	public function read_htaccess_from_directory( string $directory ): string {
		if ( ! $this->exists( $directory . '/.htaccess' ) ) {
			return '';
		}

		return $this->get_contents( $directory . '/.htaccess' );
	}

	/**
	 * Displays the content of a file for downloading
	 *
	 * @param string $filename Filename to download.
	 *
	 * @return void
	 */
	public function output_file( string $filename ) {
		print_r( $this->get_contents( $filename ) );
	}
}
