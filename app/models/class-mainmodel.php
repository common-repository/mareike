<?php
/**
 * File class-mainmodel.php
 *
 * Contains common model
 * Please do never use directly
 *
 * @since 2024-07-15
 * @license GPL-3.0-or-later
 *
 * @package mareike/models
 */

namespace Mareike\App\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Illuminate\Database\Eloquent\Model;
use Mareike\FileAccess;

/**
 * Contains common model
 *  Please do never use directly
 */
class MainModel extends Model {

	/**
	 * Namr of the SQL table
	 *
	 * @var string
	 */
	protected $table;

	/**
	 * Name of the class
	 *
	 * @var string
	 */
	protected $plainname;

	/**
	 * Enables information about cration and last update date
	 *
	 * @var bool
	 */
	public $timestamps = true;

	/**
	 * Constructor of the class
	 *
	 * @param string $classname Plain name of the calling class.
	 */
	public function __construct( string $classname ) {
		parent::__construct();
		$this->table     = $this->get_table_name( $classname );
		$this->plainname = $this->parse_class_name( $classname );
	}

	/**
	 * Helper function, removes namespace information
	 *
	 * @param string $classname_full Classname with namespaces.
	 *
	 * @return string
	 */
	private function parse_class_name( string $classname_full ): string {
		if ( str_contains( $classname_full, '\\' ) ) {
			$name_arr       = explode( '\\', $classname_full );
			$classname_full = $name_arr[ count( $name_arr ) - 1 ];
		}

		return strtolower( $classname_full );
	}

	/**
	 * Returns the sql table name with wp - prefix
	 *
	 * @param string $name The plain table name.
	 *
	 * @return string
	 */
	protected function get_table_name( string $name ) {

		global $wpdb;
		return $wpdb->prefix . 'mareike_' . $this->parse_class_name( $name );
	}

	/**
	 * Installs the table in database
	 *
	 * @return void
	 */
	public function setup(): void {
		global $wpdb;

		$charset     = $wpdb->get_charset_collate();
		$file_access = new FileAccess();
		$sql         = "SHOW TABLES LIKE '$this->table'";

		$sql_setup = str_replace(
			'%tablename%',
			$this->table,
			$file_access->get_contents( MAREIKE_PLUGIN_DIR . '/install/database/' . $this->plainname . '.sql' )
		);

		$sql_setup = str_replace( '%charset%', $charset, $sql_setup );
		$sql_setup = str_replace( '%prefix%', $wpdb->prefix, $sql_setup );

		dbDelta( $sql_setup );
	}

	/**
	 * Uninstalls a model from the database.
	 * ATTENTION: This also removes all data of the model.
	 *
	 * @return void
	 */
	public function uninstall() {
		$sql_uninstall = 'DROP TABLE IF EXISTS ' . $this->table;
		dbDelta( $sql_uninstall );
	}
}
